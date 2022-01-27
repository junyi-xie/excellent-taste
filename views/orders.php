<h1>Bestelling bekijken</h1>
<div class="table-responsive">
    <table class="table table-responsive">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Klantnaam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoon</th>
                <th scope="col">Straatnaam</th>
                <th scope="col">Huisnummer</th>
                <th scope="col">Toev.</th>
                <th scope="col">Postcode</th>
                <th scope="col">Woonplaats</th>
                <th scope="col">Land</th>
                <th scope="col">Dranknaam</th>
                <th scope="col">Dranktype</th>
                <th scope="col">Drankcategorie</th>
                <th scope="col">Aantal</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($getOrdersWhere as $key => $value): ?>
            <tr>
                <th scope="row"><?= $value['orderid']; ?></th>
                <td><?= $value['name']; ?></td>
                <td><?= $value['email']; ?></td>
                <td><?= $value['phone']; ?></td>
                <td><?= $value['street']; ?></td>
                <td><?= $value['house_number']; ?></td>
                <td><?= $value['house_extra']; ?></td>
                <td><?= $value['zipcode']; ?></td>
                <td><?= $value['place']; ?></td>
                <td><?= $value['country']; ?></td>
                <td><?= $value['menuname']; ?></td>
                <td><?= $value['typename']; ?></td>
                <td><?= $value['categoryname']; ?></td>
                <td><?= $value['quantity']; ?></td>
                <td><?= (isset($value['status'])) && ($value['status'] == 1) ? 'Served' : 'Not ready'; ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>