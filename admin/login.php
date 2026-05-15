<?php
// admin/login.php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = mysqli_prepare($conn, "SELECT id, username, password_hash, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-container {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.2);
        margin: 1rem;
    }
    .login-container h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e40af;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .login-container label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1e293b;
    }
    .login-container input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        transition: border-color 0.2s;
    }
    .login-container input:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30,64,175,0.2);
    }
    .login-container button {
        width: 100%;
        background: #1e40af;
        color: white;
        border: none;
        padding: 0.9rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .login-container button:hover {
        background: #1e3a8a;
    }
    .error {
        background: #fee2e2;
        color: #dc2626;
        padding: 0.75rem;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        text-align: center;
        font-size: 0.9rem;
    }
    .logo-text {
        text-align: center;
        font-size: 1.2rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 1rem;
    }
</style>
</body>
</html>