<?php
require_once '../../core/checklogin.php';
require_once '../../core/conn.php';
require_once '../../core/model.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$model = new Model($db, 'products');

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($model->readOne(['id' => $_GET['id']]));
        } else {
            $joins = [];
            $conditions = [];
            if (isset($_GET['search'])) {
                $conditions['name'] = ['like', '%'.$_GET['search'].'%'];
            }
            $products = $model->read($conditions, null, $joins);

            foreach ($products as &$product) {
                $cat = (new Model($db, 'cat'))->readOne(['id' => $product['cat_id']]);
                $product['cat'] = $cat;
            }
            echo json_encode($products);
        }
        break;

    case 'POST':
        $image = NULL;
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "../../uploads/";
            $image_name = time() . "_".basename($_FILES['image']['name']);
            $target_file = $target_dir. $image_name; // Unique filename
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Validate the image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false && in_array($image_file_type, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $image_name;
                }
            }
        }

        if (!empty($_POST['id'])) {
            $data = [
                'id' => $_POST['id'],
                'cat_id' => $_POST['cat_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price']
            ];

            if ($image) {
                $data['image'] = $image;
            }

            // อัปเดทข้อมูล
            $model->update($data, ['id' => $_POST['id']]);
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            // เพิ่มข้อมูล
            $model->create([
                'cat_id' => $_POST['cat_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image' => $image
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
