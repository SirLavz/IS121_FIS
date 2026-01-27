 <?php
include "db.php";

if(!isset($_GET['result_id'])) die("Invalid access.");

$id = intval($_GET['result_id']);

$sql = "SELECT r.score,r.total_questions,r.taken_at,
s.full_name,s.course,s.section
FROM results r JOIN students s ON r.student_id=s.id
WHERE r.id=$id";

$res = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);
if(!$data) die("Record not found.");
?>
<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>
<link rel="stylesheet" href="assets/bootstrap.min.css">
<style>
.certificate{
max-width:900px;margin:40px auto;padding:50px;
border:12px solid #0d6efd;text-align:center;background:#fff}
.name{font-size:30px;font-weight:bold;margin:20px 0}
@media print{.noprint{display:none}}
</style>
</head>
<body>

<div class="certificate">
<h2>CERTIFICATE OF COMPLETION</h2>
<p>This certifies that</p>

<div class="name"><?= $data['full_name'] ?></div>

<p>
has successfully completed the examination in<br><br>
<strong>IS 121 – Fundamentals of Information Systems</strong><br><br>
Course: <?= $data['course'] ?><br>
Section: <?= $data['section'] ?><br><br>
Score: <?= $data['score'] ?>/<?= $data['total_questions'] ?><br>
Date Taken: <?= date("F d, Y h:i A", strtotime($data['taken_at'])) ?>
</p>

<br><br>
<strong>RONALD T. LAVA, MSIT</strong><br>
Instructor

<div class="noprint mt-4">
<button onclick="window.print()" class="btn btn-primary">Print</button>
<a href="all_results.php" class="btn btn-secondary">Back</a>
</div>
</div>

</body>
</html>
