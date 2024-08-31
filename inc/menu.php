<div class="flex-grow-1 d-flex flex-column pt-4 ">
  <a href="/" class="btn btn-dark col-md-2">⬅️ Go back</a>
  <div class="flex-grow-1 d-flex flex-column justify-content-center">
    <h1 class="h1 text-center text-white fw-semibold">...Menu...</h1>
    <table class="table table-bordered table-primary table-striped">
      <thead>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Is spicy</th>
      </tr>
      </thead>
      <?php foreach ($dish_data as $dish): ?>
        <tr>
          <td><?= $dish->dish_name ?></td>
          <td>$<?= $dish->price ?></td>
          <td><?= $dish->is_spicy ? 'Yes' : 'No' ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

