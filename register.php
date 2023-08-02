<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 连接数据库并插入新用户
    $conn = new mysqli('localhost', 'root', 'zjrwtx', 'paynote');
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $conn->query($query);

    // 注册成功后跳转到登录页面
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
</head>
<body>
    <h1>注册</h1>
    <form method="POST" action="">
        <label>用户名：</label>
        <input type="text" name="username" required>
        <br>
        <label>密码：</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="注册">
    </form>
</body>
</html>
