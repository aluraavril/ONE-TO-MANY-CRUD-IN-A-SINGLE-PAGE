<?php
session_start();
include 'database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE username='$u'");
    $user = $res->fetch_assoc();
    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $u;
        header("Location: index.php");
    } else {
        $error = "Invalid login!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - Music Library</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0ebf8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 320px;
        }

        h2 {
            margin-bottom: 25px;
            color: #6a4bc9;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        input,
        button {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            border-radius: 8px;
            box-sizing: border-box;
        }

        input {
            border: 1px solid #ddd;
        }

        button {
            background: #6a4bc9;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #573baf;
        }

        .error {
            color: red;
            font-size: 0.9em;
            text-align: center;
            margin-top: 10px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
        }

        .register-link a {
            color: #6a4bc9;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>🎵 Login</h2>
        <form method="POST">
            <div class="form-group">
                <input name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input name="password" type="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <div class="register-link">
            Not registered? <a href="register.php">Create an account</a>
        </div>
    </div>
</body>

</html>