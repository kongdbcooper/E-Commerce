<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน']);
    exit();
}

$username = trim($data['username']);
$password = $data['password'];

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน']);
    exit();
}

// ดึงข้อมูลแอดมิน
$stmt = $conn->prepare("SELECT id, username, password, full_name FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'ไม่พบผู้ใช้แอดมินหรือรหัสผ่านไม่ถูกต้อง']);
    exit();
}

$admin = $result->fetch_assoc();

if (!password_verify($password, $admin['password'])) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'ไม่พบผู้ใช้แอดมินหรือรหัสผ่านไม่ถูกต้อง']);
    exit();
}

// สร้าง session แอดมิน
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];
$_SESSION['admin_full_name'] = $admin['full_name'];

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true,
    'message' => 'เข้าสู่ระบบแอดมินสำเร็จ',
    'admin' => [
        'id' => $admin['id'],
        'username' => $admin['username'],
        'full_name' => $admin['full_name']
    ]
]);
