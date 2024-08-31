<?php
include 'config/db.php';
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Fetch a specific transaction or product details
            $stmt = $pdo->prepare('SELECT * FROM sales_transactions WHERE id = :id');
            $stmt->execute(['id' => $_GET['id']]);
            $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($transaction) {
                // Add product name to the response
                $productStmt = $pdo->prepare('SELECT name FROM products WHERE id = :product_id');
                $productStmt->execute(['product_id' => $transaction['product_id']]);
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);
                $transaction['product_name'] = $product['name'];
                echo json_encode($transaction);
            } else {
                echo json_encode(['message' => 'Transaction not found.']);
            }
        } elseif (isset($_GET['type']) && $_GET['type'] == 'products') {
            // Fetch products for dropdown
            $stmt = $pdo->query('SELECT id, name FROM products');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            // Fetch all transactions
            $stmt = $pdo->query('SELECT * FROM sales_transactions');
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($transactions as &$transaction) {
                $productStmt = $pdo->prepare('SELECT name FROM products WHERE id = :product_id');
                $productStmt->execute(['product_id' => $transaction['product_id']]);
                $product = $productStmt->fetch(PDO::FETCH_ASSOC);
                $transaction['product_name'] = $product['name'];
            }

            echo json_encode($transactions);
        }
        break;
    case 'POST':
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Update transaction
            $stmt = $pdo->prepare('UPDATE sales_transactions SET product_id = :product_id, quantity = :quantity, total = :total WHERE id = :id');
            $stmt->execute([
                'id' => $_POST['id'],
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'total' => $_POST['total']
            ]);
            echo json_encode(['message' => 'Transaction updated successfully.']);
        } else {
            // Insert new transaction
            $stmt = $pdo->prepare('INSERT INTO sales_transactions (product_id, quantity, total) VALUES (:product_id, :quantity, :total)');
            $stmt->execute([
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'total' => $_POST['total']
            ]);
            echo json_encode(['message' => 'Transaction added successfully.']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents('php://input'), $_DELETE);
        if (isset($_DELETE['id'])) {
            $stmt = $pdo->prepare('DELETE FROM sales_transactions WHERE id = :id');
            $stmt->execute(['id' => $_DELETE['id']]);
            echo json_encode(['message' => 'Transaction deleted successfully.']);
        }
        break;

    default:
        echo json_encode(['message' => 'Invalid request.']);
        break;
}
