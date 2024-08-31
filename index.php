<?php

require_once "config.php";

require "inc/header.php";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
  $db = new PDO($dsn, $db_username, $db_password);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch(PDOException $exception) {
  print "can not connect to db: {$exception->getMessage()}";
  die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  ['input' => $input, 'errors' => $errors] = validate_form();
  if ($errors) {
    show_form($errors);
  } else {
    try {
      $dish_data = process_form($input);
      if ($dish_data) {
        include "inc/menu.php";
      } else {
        include "inc/alert.php";
        show_form();
      }
    } catch (Exception $e) {
      print "db error in process form";
      die;
    }
  }
} else {
  show_form();
}


require "inc/footer.php";

function show_form(array $errors = []): void
{
  include "inc/form.php";
}

function validate_form(): array
{
  $input = array();
  $errors = array();

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');
  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT, [
    'options' => ['min_range' => 0.1]
  ]);
  $input['is_spicy'] = (int)($_POST['is_spicy'] ?? '0');

  if (!strlen($input['dish_name'])) {
    $errors['dish_name'] = 'Please provide a proper name for a dish';
  }
  if (is_null($input['price']) or $input['price'] === false) {
    $errors['price'] = 'Please provide a proper price for dish you are looking for (min = 0.1)';
  }
  return ['errors' => $errors, 'input' => $input];
}

function process_form(array $input): array
{
  global $db;
  $sql = "select dish_name, price, is_spicy from dishes where dish_name like :dish_name and price <= :price and is_spicy = :is_spicy";
  $input['dish_name'] = "%" . $input['dish_name'] . "%";

  try {
    $stmt = $db->prepare($sql);
    $stmt->execute($input);
  } catch (PDOException $exception) {
    throw new Exception($exception->getMessage());
  }
  return $stmt->fetchAll();
}
