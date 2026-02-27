<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบแอดมิน']);
    exit();
}

// แสดงรายการสินค้า
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT id, name, price, stock, type, image FROM products ORDER BY id DESC");
    $products = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    echo json_encode(['success' => true, 'products' => $products]);
    exit();
}

// จัดการ create/update/delete ผ่าน POST + JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['action'])) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบ action']);
        exit();
    }

    $action = $data['action'];

    if ($action === 'create') {
        $name = trim($data['name'] ?? '');
        $price = floatval($data['price'] ?? 0);
        $stock = intval($data['stock'] ?? 0);
        $type = trim($data['type'] ?? '');
        $image = trim($data['image'] ?? '');

        if ($name === '' || $type === '' || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO products (name, price, stock, type, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiss", $name, $price, $stock, $type, $image);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'บันทึกไม่สำเร็จ: ' . $conn->error]);
        }
        $stmt->close();
        exit();
    }

    if ($action === 'update') {
        $id = intval($data['id'] ?? 0);
        $name = trim($data['name'] ?? '');
        $price = floatval($data['price'] ?? 0);
        $stock = intval($data['stock'] ?? 0);
        $type = trim($data['type'] ?? '');
        $image = trim($data['image'] ?? '');

        if ($id <= 0 || $name === '' || $type === '' || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
            exit();
        }

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, stock = ?, type = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sdissi", $name, $price, $stock, $type, $image, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'อัปเดตไม่สำเร็จ: ' . $conn->error]);
        }
        $stmt->close();
        exit();
    }

    if ($action === 'delete') {
        $id = intval($data['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ไม่พบสินค้า']);
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ลบไม่สำเร็จ: ' . $conn->error]);
        }
        $stmt->close();
        exit();
    }

    echo json_encode(['success' => false, 'message' => 'action ไม่ถูกต้อง']);
    exit();
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);

