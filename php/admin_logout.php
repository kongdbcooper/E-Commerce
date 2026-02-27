<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// เคลียร์ session เฉพาะของแอดมิน
unset($_SESSION['admin_id'], $_SESSION['admin_username'], $_SESSION['admin_full_name']);

echo json_encode(['success' => true]);

