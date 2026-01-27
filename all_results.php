 <?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>IS 121 Exam Results</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
}
.container {
    margin-top: 50px;
}
.card {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.table th {
    background-color: #0d6efd;
    color: white;
}
.table td, .table th {
    vertical-align: middle;
}
h3 {
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}
.btn-primary, .btn-success {
    border-radius: 6px;
}
</style>
</head>
<body>

<div class="container">
    <h3>All Exam Results</h3>

    <div class="card p-4">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Course</th>
                <th>Section</th>
                <th>Score</th>
                <th>Date Taken</th>
                <th>Certificate</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT r.id,r.score,r.total_questions,r.taken_at,
                s.full_name,s.course,s.section
                FROM results r 
                JOIN students s ON r.student_id=s.id
                ORDER BY r.taken_at DESC";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){
            while($row = mysqli_fetch_assoc($res)){
        ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= htmlspecialchars($row['section']) ?></td>
                <td><?= $row['score'] ?>/<?= $row['total_questions'] ?></td>
                <td><?= date("F d, Y h:i A", strtotime($row['taken_at'])) ?></td>
                <td>
                    <a href="certificate.php?result_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">View Certificate</a>
                </td>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No results found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>
