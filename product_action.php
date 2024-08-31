<?php
// Include the database configuration file
include 'config/db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
            $stmt->execute(['id' => $_GET['id']]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $pdo->query('SELECT * FROM products');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;
    case 'POST':
        if (isset($_POST['id'])) {
            // Update product
            $stmt = $pdo->prepare('UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id');
            $stmt->execute([
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price']
            ]);
            echo json_encode(['message' => 'Product updated successfully.']);
        } else {
            // Insert new product
            $stmt = $pdo->prepare('INSERT INTO products (name, description, price) VALUES (:name, :description, :price)');
            $stmt->execute([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price']
            ]);
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ.']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents('php://input'), $_DELETE);
        if (isset($_DELETE['id'])) {
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute(['id' => $_DELETE['id']]);
            echo json_encode(['message' => 'Product deleted successfully.']);
        }
        break;

    default:
        echo json_encode(['message' => 'Invalid request.']);
        break;
}
