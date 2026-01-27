 <?php
session_start();
include "db.php";

$student_id = $_SESSION['student_id'];
$answers = $_POST['answer'] ?? [];

$score = 0;

$q = mysqli_query($conn, "SELECT id, correct FROM questions");
$total = mysqli_num_rows($q);

while($row=mysqli_fetch_assoc($q)){
    if(isset($answers[$row['id']]) && $answers[$row['id']] == $row['correct']){
        $score++;
    }
}

$taken_at = date("Y-m-d H:i:s");

mysqli_query($conn,
"INSERT INTO results (student_id,score,total_questions,taken_at)
VALUES ($student_id,$score,$total,'$taken_at')");

$result_id = mysqli_insert_id($conn);

header("Location: certificate.php?result_id=$result_id");
exit();
