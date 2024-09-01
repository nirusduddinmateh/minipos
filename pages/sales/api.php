<?php
require_once '../../core/checklogin.php';
require_once '../../core/conn.php';
require_once '../../core/model.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$model = new Model($db, 'sales_transactions');

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Fetch a specific transaction or product details
            $sale = $model->readOne(['id' => $_GET['id']]);

            if ($sale) {
                // Add product name to the response
                $sale['product'] = (new Model($db, 'products'))->readOne(['id' => $sale['product_id']]);
                echo json_encode($sale);
            } else {
                echo json_encode(['message' => 'Transaction not found.']);
            }
        } else {
            $joins = [
                [
                    'type' => 'INNER',
                    'table' => 'products',
                    'on' => 'products.id = sales_transactions.product_id'
                ]
            ];

            $conditions = [];
            if (isset($_GET['search'])) {
                $conditions['name'] = ['like', '%'.$_GET['search'].'%'];
            }
            $sales = $model->read($conditions, 'transaction_date desc', $joins);

            foreach ($sales as &$sale) {
                $product = (new Model($db, 'products'))->readOne(['id' => $sale['product_id']]);
                $sale['product'] = $product;
            }

            echo json_encode($sales);
        }
        break;

    case 'POST':
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // อัปเดทข้อมูล
            $model->update(
                [
                    'id' => $_POST['id'],
                    'product_id' => $_POST['product_id'],
                    'quantity' => $_POST['quantity'],
                    'total' => $_POST['total']
                ],
                ['id' => $_POST['id']]
            );
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            // เพิ่มข้อมูล
            $model->create([
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'total' => $_POST['total']
            ]);
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents('php://input'), $_DELETE);
        if (isset($_DELETE['id'])) {
            $model->delete(['id' => $_DELETE['id']]);
            echo json_encode(['message' => 'ลบสำเร็จ']);
        }
        break;

    default:
        echo json_encode(['message' => 'Invalid request.']);
        break;
}
?>
