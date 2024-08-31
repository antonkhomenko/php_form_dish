<?php
global $input;
function get_input_class(string $name): string
{
  global $errors;
  if (isset($errors[$name])) {
    return "form-control is-invalid";
  } else {
    return "form-control";
  }
}

function get_value(string $name): string
{
  global $errors;
  global $input;
  if (isset($errors)) {
    if ($name == 'is_spicy') {
      return $input['is_spicy'] ? 'checked' : '';
    }
    return htmlentities($_POST[$name]);
  } else {
    return "";
  }

}

?>


<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="col-md-6 offset-3 text-white">

  <div class="mb-3">
    <h1 class="h1 fw-semibold">Search your dish ! 🍚</h1>
  </div>

  <div class="mb-3">
    <label for="dish_name" class="form-label">Dish name:</label>
    <input
      type="text" name="dish_name" id="dish_name" value="<?= get_value('dish_name') ?>"
      class="<?= get_input_class('dish_name') ?>" placeholder="Enter your dish name">
    <div class="invalid-feedback">
      <?= $errors['dish_name'] ?? '' ?>
    </div>
  </div>

  <div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input
      type="text" id="price" name="price" value="<?= get_value('price') ?>"
      class="<?= get_input_class('price') ?>" placeholder="Enter price for your dish">
    <div class="invalid-feedback">
      <?= $errors['price'] ?? '' ?>
    </div>
  </div>

  <div class="mb-3 form-check form-check-reverse form-switch d-flex gap-3">
    <label for="is_spicy" class="form-check-label">Is spicy:</label>
    <input
      type="checkbox" id="is_spicy" name="is_spicy" <?= get_value('is_spicy') ?>
      class="form-check-input spicy-switcher" role="switch" value="1">
  </div>

  <button class="btn btn-success col-3">Search</button>
</form>
