<h1>Bestellingen voor drank</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Klantnaam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoon</th>
                <th scope="col">Dranknaam</th>
                <th scope="col">Dranktype</th>
                <th scope="col">Drankcategorie</th>
                <th scope="col">Aantal</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php if ( !empty($getDrinkItemsWhere) && is_array($getDrinkItemsWhere) ): ?>

        <?php foreach ($getDrinkItemsWhere as $key => $value): ?>
            <tr>
                <th scope="row"><?= $value['orderid']; ?></th>
                <td>
                    <a href="list.php?action=view&id=<?= $value['reservation_id']; ?>"><?= $value['name']; ?></a>
                </td>
                <td><?= $value['email']; ?></td>
                <td><?= $value['phone']; ?></td>
                <td><?= $value['menuname']; ?></td>
                <td><?= $value['typename']; ?></td>
                <td><?= $value['categoryname']; ?></td>
                <td><?= $value['quantity']; ?></td>
                <td><?= (isset($value['status'])) && ($value['status'] == 1) ? 'Served' : 'Not ready'; ?></td>
                <td>
                    <a href="catcher.php?action=approve&type=orders&uri=overview.php?view=barman&reservation_id=<?= $value['reservation_id']; ?>&order_id=<?= $value['orderid']; ?>"><i class="fas fa-check"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <span width="100%">No drinks found...</span>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>
</div>