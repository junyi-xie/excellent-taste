<form class="container" action="reservation.php?view=completed" method="post">
        
    <?php foreach ($getAllMenuItems as $key => $value): ?>

        <label><?= $value['menuname']; ?></label>
        <input class="form-check-input" type="checkbox" name="orders[<?= $value['id']; ?>][menu_id]" value="<?= $value['id']; ?>">
        <input class="form-control" type="number" name="orders[<?= $value['id']; ?>][quantity]" placeholder="Hoeveel wil je...">

    <?php endforeach; ?>

    <div class="mt-3">
        <a class="btn btn-primary" href="reservation.php?view=reservation">Terug</a>
        <input class="btn btn-primary" type="submit" value="Bestelling plaatsen">
    </div>
</form>