<?php
session_start();
include 'db.php';

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, balance FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แดชบอร์ดผู้ใช้</title>
  <style>
    body { font-family: sans-serif; background: #f5f5f5; padding: 20px; }
    .card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
    h2 { color: #333; }
    .info { margin-top: 20px; }
  </style>
</head>
<body>

<div class="card">
  <h2>สวัสดีคุณ <?php echo htmlspecialchars($user['username']); ?> 🎉</h2>

  <div class="info">
    <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>ยอดเงินในบัญชี:</strong> <?php echo number_format($user['balance'], 2); ?> บาท</p>
  </div>

  <a href="logout.php">ออกจากระบบ</a>
</div>

</body>
</html>
