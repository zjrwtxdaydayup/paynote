<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 连接数据库并查询用户信息
    $conn = new mysqli('localhost', 'root', 'zjrwtx', 'paynote');
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // 登录成功后跳转到记账页面
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: expenses.php');
            exit;
        }
    }

    // 登录失败，显示错误消息
    $error = '用户名或密码错误';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>登录</title>
</head>
<body>
    <h1>登录</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <label>用户名：</label>
        <input type="text" name="username" required>
        <br>
        <label>密码：</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="登录">
    </form>
</body>
</html>
