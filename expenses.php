<?php
// 连接数据库
$conn = new mysqli('localhost', 'root', 'zjrwtx', 'paynote');

// 检查数据库连接是否成功
if ($conn->connect_error) {
    die('数据库连接失败：' . $conn->connect_error);
}

session_start();

// 检查用户是否已登录
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // 插入新的记账记录
    $query = "INSERT INTO expenses (user_id, amount, category, description) VALUES ($user_id, $amount, '$category', '$description')";
    if ($conn->query($query) === FALSE) {
        die('新建记账记录失败：' . $conn->error);
    }
}

// 查询用户的记账记录
$query = "SELECT * FROM expenses WHERE user_id=$user_id ORDER BY created_at DESC";
$result = $conn->query($query);

// 检查查询结果是否成功
if ($result === FALSE) {
    die('查询记账记录失败：' . $conn->error);
}

$expenses = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>记账</title>
</head>
<body>
    <h1>记账</h1>
    <form method="POST" action="">
        <label>金额：</label>
        <input type="text" name="amount" required>
        <br>
        <label>类别：</label>
        <input type="text" name="category" required>
        <br>
        <label>描述：</label>
        <textarea name="description" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="保存">
    </form>
    <h2>记账记录</h2>
    <table>
        <tr>
            <th>金额</th>
            <th>类别</th>
            <th>描述</th>
            <th>时间</th>
        </tr>
        <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?php echo $expense['amount']; ?></td>
                <td><?php echo $expense['category']; ?></td>
                <td><?php echo $expense['description']; ?></td>
                <td><?php echo $expense['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
