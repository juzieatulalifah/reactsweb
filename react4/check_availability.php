<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $value = trim($_POST['value'] ?? '');

    $response = ['status' => 'error', 'message' => 'Invalid request'];

    if ($type === 'signuser') {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $response = ['status' => 'unavailable', 'message' => 'Username sudah digunakan'];
        } else {
            $response = ['status' => 'available', 'message' => ''];
        }
    } elseif ($type === 'email') {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $response = ['status' => 'unavailable', 'message' => 'Email sudah digunakan'];
        } else {
            $response = ['status' => 'available', 'message' => ''];
        }
    } elseif ($type === 'username') {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count <= 0) {
            $response = ['status' => 'unavailable', 'message' => 'Username tidak ditemukan'];
        } else {
            $response = ['status' => 'available', 'message' => ''];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>