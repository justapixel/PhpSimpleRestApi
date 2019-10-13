<?php
  header('Acces-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Acces-Control-Allow-Methods: POST');
  header('Acces-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

if ($category->create()) {
  echo json_encode(
    array('message' => 'category Created')
  );
}else {
  echo json_encode(
    array('message' => 'category Not Created')
  );
}