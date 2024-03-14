<?php
  function getOverviewData($link) {
    $stmt = $link->prepare("SELECT * FROM quiz LEFT OUTER JOIN student_quiz ON quiz.id = student_quiz.quiz_id AND student_id = ?");
    $stmt->bind_param("i", $_SESSION['student_id']);
    $stmt->execute();
    $stmt->bind_result($id, $name, $n_questions, $student_id, $quiz_id, $score);

    $result = resultToKeyValPairs($stmt);
    $stmt->close();
    $link->close();
    return $result;
  }

  function getQuizData($id, $link) {
    $stmt = $link->prepare("SELECT answer.id AS a_id, answer.answer, answer.question_id, question.question, question.quiz_id, question.answer_id AS correct_answer_id
                            FROM answer
                            LEFT OUTER JOIN question ON answer.question_id = question.id
                            WHERE question.quiz_id = ?
                            ORDER BY question_id, a_id ASC");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($a_id, $answer, $question_id, $question, $quiz_id, $correct_answer_id);

    $result = resultToKeyValPairs($stmt);
    $stmt->close();
    $link->close();
    return $result;
  }

  function getAllStudentScores($link) {
    $stmt = $link->prepare("SELECT student_quiz.student_id, student_quiz.quiz_id, student_quiz.score, quiz.name, quiz.n_questions, student.firstname, student.lastname
                            FROM student_quiz
                            JOIN student ON student_quiz.student_id = student.id
                            JOIN quiz ON student_quiz.quiz_id = quiz.id
                            ORDER BY student_id, quiz_id ASC");
    $stmt->execute();
    $stmt->bind_result($student_id, $quiz_id, $score, $name, $n_questions, $firstname, $lastname);
    $result = resultToKeyValPairs($stmt);
    $stmt->close();
    $link->close();
    return $result;
  }

  function getScore($student_id, $quiz_id, $link) {
    $stmt = $link->prepare("SELECT COUNT(student_question.student_id) FROM student_question JOIN question ON question_id = question.id WHERE student_question.answer_id = question.answer_id AND student_question.student_id = ? AND question.quiz_id = ?");
    $stmt->bind_param("ii", $student_id, $quiz_id);
    $stmt->execute();
    $stmt->bind_result($score);
    $stmt->fetch();
    $stmt->close();
    $link->close();
    return $score;
  }

  function getUserCredentials($student_id, $link) {
    $stmt = $link->prepare("SELECT id, pass_hash, is_admin, firstname, lastname FROM student WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($id, $pass_hash, $is_admin, $firstname, $lastname);
      $stmt->fetch();
      $user = array("id"=>$id, "pass_hash"=>$pass_hash, "is_admin"=>$is_admin, "firstname"=>$firstname, "lastname"=>$lastname);
      $stmt->close();
      $link->close();
      return $user;
    } else {
      $stmt->close();
      $link->close();
      return false;
    }
  }

  //To check in register, whether user already exists, returns true or false
  function getUserByID($student_id, $link) {
    $stmt = $link->prepare("SELECT id FROM student WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->close();
      $link->close();
      return true;
    } else {
      $stmt->close();
      $link->close();
      return false;
    }
  }

  //Found from Stackoverflow
  function resultToKeyValPairs($statement) {
    $meta = $statement->result_metadata();
    while ($field = $meta->fetch_field()) {
      $params[] = &$row[$field->name];
    }

    call_user_func_array(array($statement, 'bind_result'), $params);

    while($statement->fetch()){
      foreach($row as $key => $val) {
        $c[$key] = $val;
      }
      $result[] = $c;
    }
    return $result;
  }
?>

<!-- SELECT answer.id AS a_id, answer.answer, answer.question_id, question.question, question.quiz_id, question.answer_id AS correct_answer_id FROM answer LEFT OUTER JOIN question ON answer.question_id = question.id WHERE question.quiz_id = ? ORDER BY question_id ASC -->
