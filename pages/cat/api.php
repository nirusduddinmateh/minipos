<?php
require_once '../../core/checklogin.php';
require_once '../../core/conn.php';
require_once '../../core/model.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$model = new Model($db, 'cat');

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($model->readOne(['id' => $_GET['id']]));
        } else {
            $conditions = [];
            if (isset($_GET['search'])) {
                $conditions['name'] = ['like', '%'.$_GET['search'].'%'];
            }
            echo json_encode($model->read($conditions));
        }
        break;

    case 'POST':
        if (!empty($_POST['id'])) {
            // อัปเดทข้อมูล
            $model->update(
                [
                    'id' => $_POST['id'],
                    'name' => $_POST['name']
                ],
                ['id' => $_POST['id']]
            );
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            // เพิ่มข้อมูล
            $model->create([
                'name' => $_POST['name']
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
