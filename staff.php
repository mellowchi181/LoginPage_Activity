
<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "staff") {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm border-0 p-4">
        <h2 class="text-info">Staff Dashboard</h2>

        <p>
            Welcome, <?= htmlspecialchars($_SESSION["email"]) ?>!
        </p>

        <p>You are logged in as a staff member.</p>

        <a href="logout.php" class="btn btn-danger">
            Log Out
        </a>
    </div>
</div>

</body>
</html>
