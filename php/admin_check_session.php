<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$logged_in = isset($_SESSION['admin_id']);

if ($logged_in) {
    echo json_encode([
        'success' => true,
        'logged_in' => true,
        'admin' => [
            'id' => $_SESSION['admin_id'],
            'username' => $_SESSION['admin_username'],
            'full_name' => $_SESSION['admin_full_name'] ?? null
        ]
    ]);
} else {
    echo json_encode([
        'success' => true,
        'logged_in' => false
    ]);
}

