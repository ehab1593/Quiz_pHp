<?php
  function resetStudentScore($quiz_id, $student_id, $link) {
    $stmt1 = $link->prepare("DELETE s FROM student_question s LEFT JOIN question q ON q.id = s.question_id WHERE s.student_id = ? AND q.quiz_id = ?");
    $stmt1->bind_param("ii", $student_id, $quiz_id);
    
    $stmt2 = $link->prepare("DELETE FROM student_quiz WHERE quiz_id = ? AND student_id = ?");
    $stmt2->bind_param("ii", $quiz_id, $student_id);
    
    try {
      $link->autocommit(FALSE);
      
      if ($stmt1->execute() === false) {
        throw new Exception('Wrong SQL: ' . $link->error);
      }
      $stmt1->close();
      
      if ($stmt2->execute() === false) {
        throw new Exception('Wrong SQL: ' . $link->error);
      }
      $stmt2->close();
    } catch (Exception $e) {
      echo 'Transaction failed: ' . $e.getMessage();
      $link->rollback();
    }
    $link->autocommit(TRUE);
    $link->close();
  }
?>