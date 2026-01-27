 <?php
session_start();
include "db.php";

// Save student info if new
if (!isset($_SESSION['student_id'])) {
    $name = $_POST['full_name'];
    $course = $_POST['course'];
    $section = $_POST['section'];

    mysqli_query($conn, "INSERT INTO students (full_name,course,section) VALUES ('$name','$course','$section')");
    $_SESSION['student_id'] = mysqli_insert_id($conn);
}

$student_id = $_SESSION['student_id'];

// Get random questions
$q = mysqli_query($conn, "SELECT * FROM questions ORDER BY RAND()");
$questions = mysqli_fetch_all($q, MYSQLI_ASSOC);
$total = count($questions);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>IS 121 Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f5f5f5; }
.modal-header { background-color:#0d6efd; color:white; }
.modal-content { border-radius:12px; }
.timer { font-weight:bold; font-size:1.2rem; text-align:center; margin-bottom:15px; }
</style>
</head>
<body>

<div class="container mt-4 text-center">
<div class="timer">Time Remaining: <span id="timer">60:00</span></div>
<form id="examForm" method="POST" action="submit_exam.php">

<?php foreach($questions as $i=>$q): ?>
<div class="modal fade" id="q<?= $i ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title">Question <?= $i+1 ?> / <?= $total ?></h5>
      </div>
      <div class="modal-body">
        <p><?= $q['question'] ?></p>
        <?php foreach(['a','b','c','d'] as $opt): ?>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="answer[<?= $q['id'] ?>]" value="<?= strtoupper($opt) ?>" id="<?= $q['id'].$opt ?>">
          <label class="form-check-label" for="<?= $q['id'].$opt ?>"><?= $q[$opt] ?></label>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <?php if($i>0): ?>
        <button type="button" class="btn btn-secondary" data-bs-target="#q<?= $i-1 ?>" data-bs-toggle="modal">Previous</button>
        <?php endif; ?>
        <?php if($i<$total-1): ?>
        <button type="button" class="btn btn-primary" data-bs-target="#q<?= $i+1 ?>" data-bs-toggle="modal">Next</button>
        <?php else: ?>
        <button type="submit" class="btn btn-success">Submit Exam</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Show first question modal
new bootstrap.Modal(document.getElementById("q0")).show();

// Countdown Timer 60 min
let time = 60*60;
function countdown(){
    if(time<=0){ document.getElementById("examForm").submit(); return; }
    let m = Math.floor(time/60);
    let s = time%60;
    document.getElementById("timer").innerText = m + ":" + (s<10?'0'+s:s);
    time--;
}
setInterval(countdown,1000);
</script>
</body>
</html>
