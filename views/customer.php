<h1>Reservering en gegevens bewerken</h1>
<form action="catcher.php?action=edit&uri=list.php" method="post">
    <input type="hidden" name="customer_id" value="<?= $getReservationsWhere['customer_id']; ?>">
    <input type="hidden" name="reservation_id" value="<?= $getReservationsWhere['id']; ?>">
    <h3>Je gegevens</h3>
    <div class="form-group">
        <label>Voor- en achternaam</label>
        <input class="form-control" type="text" name="customer[name]" value="<?= $getReservationsWhere['name']; ?>" placeholder="Voor- en achternaam">
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input class="form-control" type="email" name="customer[email]" value="<?= $getReservationsWhere['email']; ?>" placeholder="E-mailadres">
    </div>
    <div class="form-group">
        <label>Telefoonnr.</label>
        <input class="form-control" type="phone" name="customer[phone]" value="<?= $getReservationsWhere['phone']; ?>" placeholder="Telefoonnummer">
    </div>
    <div class="form-group">
        <label>Straatnaam</label>
        <input class="form-control" type="text" name="customer[street]" value="<?= $getReservationsWhere['street']; ?>" placeholder="Straatnaam...">
    </div>
    <div class="form-group">
        <label>Huisnummer</label>
        <input class="form-control" type="text" name="customer[house_number]" value="<?= $getReservationsWhere['house_number']; ?>" placeholder="Huisnummer...">
    </div>
    <div class="form-group">
        <label>Extra Toevoeging</label>
        <input class="form-control" type="tet" name="customer[house_extra]" value="<?= $getReservationsWhere['house_extra']; ?>" placeholder="Toevoeging...">
    </div>
    <div class="form-group">
        <label>Postcode</label>
        <input class="form-control" type="text" name="customer[zipcode]" value="<?= $getReservationsWhere['zipcode']; ?>" placeholder="Postcode...">
    </div>
    <div class="form-group">
        <label>Woonplaats</label>
        <input class="form-control" type="text" name="customer[place]" value="<?= $getReservationsWhere['place']; ?>" placeholder="Woonplaats...">
    </div>
    <div class="form-group">
        <label>Land</label>
        <input class="form-control" type="text" name="customer[country]" value="<?= $getReservationsWhere['country']; ?>" placeholder="Land...">
    </div>
    <h3>Je reserveringsgegevens</h3>
    <div class="form-group">
        <label>Tafelnr.</label>
        <input class="form-control" type="number" name="reservation[table_number]" value="<?= $getReservationsWhere['table_number']; ?>" placeholder="Tafelnummer...">
    </div>
    <div class="form-group">
        <label>Datum</label>
        <input class="form-control" type="text" name="reservation[date]" value="<?= $getReservationsWhere['date']; ?>" placeholder="Datum...">
    </div>
    <div class="form-group">
        <label>Tijd</label>
        <input class="form-control" type="text" name="reservation[time]" value="<?= $getReservationsWhere['time']; ?>" placeholder="Tijdstip...">
    </div>
    <div class="form-group">
        <label>Aantal volwassenen</label>
        <input class="form-control" type="number" name="reservation[quantity]" value="<?= $getReservationsWhere['quantity']; ?>" placeholder="Aantal volwassenen..." >
    </div>
    <div class="form-group">
        <label>Aantal kinderen</label>
        <input class="form-control" type="number" name="reservation[quantity_kids]" value="<?= $getReservationsWhere['quantity_kids']; ?>" placeholder="Aantal kinderen...">
    </div>
    <div class="form-group">
        <label>Extra Toevoeging</label>
        <input class="form-control" type="textarea" name="reservation[notes]" value="<?= $getReservationsWhere['notes']; ?>" row="10">
    </div>
    <div class="form-group">
        <label>Allergieën</label>
        <input class="form-control" type="textarea" name="reservation[allergens]" value="<?= $getReservationsWhere['allergens']; ?>" row="5">
    </div>
    <div class="mt-3">
        <input class="btn btn-primary mt-3" type="submit" value="Wijzigingen opslaan">
    </div>
</form>