<?php
require_once '../../core/checklogin.php';
require_once '../../core/conn.php';
require_once '../../core/model.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$model = new Model($db, 'users');

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($model->readOne(['id' => $_GET['id']]));
        } else {
            $conditions = [];
            if (isset($_GET['search'])) {
                $conditions['username'] = ['like', '%'.$_GET['search'].'%'];
            }
            echo json_encode($model->read($conditions));
        }
        break;

    case 'POST':
        if (!empty($_POST['id'])) {
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'username' => $_POST['username']
            ];
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            // อัปเดทข้อมูล
            $model->update(
                $data,
                ['id' => $_POST['id']]
            );
            echo json_encode(['message' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            // เพิ่มข้อมูล
            $model->create([
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
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
