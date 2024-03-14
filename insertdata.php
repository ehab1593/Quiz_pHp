<?php
  function insertAnswer($data, $link) {

    $stmt = $link->prepare("INSERT INTO student_question (student_id, question_id, answer_id) VALUES (?,?,?)");

    foreach($data as $question_id => $answer_id) {
      $stmt->bind_param("iii", $_SESSION['student_id'], $question_id, $answer_id);
      $stmt->execute();
    }
    $stmt->close();
    $link->close();
  }

function insertScore($score, $link) {
  $stmt = $link->prepare("INSERT INTO student_quiz (student_id, quiz_id, score) VALUES (?, ?, ?)");
  $stmt->bind_param("iii", $_SESSION['student_id'], $_SESSION['selected_quiz'], $score);
  $stmt->execute();
  $stmt->close();
  $link->close();
}

function insertNewUser($id, $fname, $lname, $pass_hash, $is_admin, $link) {
  $stmt = $link->prepare("INSERT INTO student (id, firstname, lastname, pass_hash, is_admin) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isssi", $id, $fname, $lname, $pass_hash, $is_admin);
  if ($stmt->execute()) {
    $stmt->close();
    $link->close();
    return true;
  } else {
    $stmt->close();
    $link->close();
    return false;
  }
}
?>
