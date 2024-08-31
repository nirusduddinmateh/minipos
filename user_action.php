<?php
// Include the database configuration file
include 'config/db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute(['id' => $_GET['id']]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $pdo->query('SELECT * FROM users');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;
    case 'POST':
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Update User
            $stmt = $pdo->prepare('UPDATE users SET password = :password, username = :username WHERE id = :id');
            $stmt->execute([
                'id' => $_POST['id'],
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ]);
            echo json_encode(['message' => 'User updated successfully.']);
        } else {
            // Insert new User
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
            $stmt->execute([
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ]);
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ.']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents('php://input'), $_DELETE);
        if (isset($_DELETE['id'])) {
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute(['id' => $_DELETE['id']]);
            echo json_encode(['message' => 'User deleted successfully.']);
        }
        break;

    default:
        echo json_encode(['message' => 'Invalid request.']);
        break;
}
