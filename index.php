
<?php
session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, email, password, role
         FROM users
         WHERE email = ?"
    );
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: staff.php");
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin.php");
    } else {
        header("Location: staff.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Pastel Blue</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf5fc;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(105, 160, 195, 0.15);
        }

        .login-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border-radius: 20px;
            background: #d9edfa;
            color: #548fbd;
            font-size: 32px;
        }

        .login-title {
            color: #315b78;
            font-weight: 700;
        }

        .login-subtitle, .footer-text {
            color: #849aaa;
            font-size: 14px;
        }

        .form-label {
            color: #46677f;
            font-size: 14px;
            font-weight: 600;
        }

        .form-control {
            padding: 12px 14px;
            border-color: #d9e8f1;
            background: #f9fcfe;
        }

        .form-control:focus {
            border-color: #94c8e8;
            box-shadow: 0 0 0 0.2rem rgba(148, 200, 232, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #9bcbea;
            color: #234b68;
            font-weight: 700;
        }

        .btn-login:hover {
            background: #7fb8df;
            color: #fff;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-icon">
        <i class="bi bi-cloud-fill"></i>
    </div>

    <div class="text-center mb-4">
        <h2 class="login-title">Welcome!</h2>
        <p class="login-subtitle">
            Sign in to continue to your account.
        </p>
    </div>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       placeholder="Enter your email"
                       autocomplete="username"
                       required>
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Enter your password"
                       autocomplete="current-password"
                       required>
                <button class="btn btn-outline-secondary"
                        type="button"
                        id="togglePassword"
                        aria-label="Show password">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-login">
            Log In <i class="bi bi-arrow-right ms-1"></i>
        </button>
    </form>

    <div class="text-center mt-4">
        <p class="footer-text mb-0">
            Please use your registered account.
        </p>
    </div>
</div>

<script>
const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const eyeIcon = document.getElementById("eyeIcon");

togglePassword.addEventListener("click", function () {
    const isHidden = passwordInput.type === "password";

    passwordInput.type = isHidden ? "text" : "password";
    eyeIcon.className = isHidden
        ? "bi bi-eye-slash"
        : "bi bi-eye";

    togglePassword.setAttribute(
        "aria-label",
        isHidden ? "Hide password" : "Show password"
    );
});
</script>

</body>
</html>
