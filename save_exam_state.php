<?php
session_start();
if(isset($_POST['answers'])) $_SESSION['exam_answers'] = $_POST['answers'];
if(isset($_POST['current'])) $_SESSION['exam_current'] = $_POST['current'];
?>
