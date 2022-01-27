<h1>Lijst met reserveringen</h1>
<div class="table-responsive">
    <table class="table table-responsive">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnr.</th>
                <th scope="col">Tafelnr.</th>
                <th scope="col">Datum</th>
                <th scope="col">Tijd</th>
                <th scope="col">Aantal</th>
                <th scope="col">Kinderen</th>
                <th scope="col">Toegevoegd</th>
                <th scope="col">Allergieën</th>
                <th scope="col">Opmerking</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($getAllReservations as $key => $value): ?>
            <tr>
                <th scope="row"><?= $value['id']; ?></th>
                <th><?= $value['name']; ?></th>
                <th><?= $value['email']; ?></th>
                <th><?= $value['phone']; ?></th>
                <th><?= $value['table_number']; ?></th>
                <th><?= date("M j, Y", strtotime($value['date'])); ?></th>
                <th><?= date("g:i A", strtotime($value['time'])); ?></th>
                <th><?= $value['quantity']; ?></th>
                <th><?= $value['quantity_kids']; ?></th>
                <th><?= date("M j, Y", strtotime($value['date_added'])); ?></th>
                <th><?= $value['allergens']; ?></th>
                <th><?= $value['notes']; ?></th>
                <th><?= (isset($value['status'])) && ($value['status'] == 1) ? 'Served' : 'Not ready'; ?></th>
                <th>
                    <a href="list.php?action=edit&id=<?= $value['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a href="catcher.php?action=delete&uri=list.php&id=<?= $value['id']; ?>"><i class="fas fa-trash"></i></a>
                    <a href="catcher.php?action=print&uri=list.php&type=download&id=<?= $value['id']; ?>"><i class="fas fa-print"></i></a>
                    <a href="catcher.php?action=print&uri=list.php&type=read&id=<?= $value['id']; ?>"><i class="fas fa-eye"></i></a>
                    <a href="list.php?action=view&id=<?= $value['id']; ?>"><i class="fas fa-search-plus"></i></a>
                </th>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>