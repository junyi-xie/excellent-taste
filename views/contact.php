<form action="reservation.php?view=order" method="post">
    <input type="hidden" name="reservation[date_added]" value="<?= date("YmdHis"); ?>">
    <div class="form-group">
        <label>Tafelnr.</label>
        <input class="form-control" type="number" name="reservation[table_number]" placeholder="1" min="0" required>
    </div>
    <div class="form-group">
        <label>Datum</label>
        <input class="form-control" type="date" name="reservation[date]" required>
    </div>
    <div class="form-group">
        <label>Tijdstip</label>
        <input class="form-control" type="time" name="reservation[time]" required>
    </div>
    <div class="form-group">
        <label>Aantal volwassenen</label>
        <input class="form-control" type="number" name="reservation[quantity]" placeholder="Aantal volwassenen..." required>
    </div>
    <div class="form-group">
        <label>Aantal kinderen</label>
        <input class="form-control" type="number" name="reservation[quantity_kids]" placeholder="Aantal kinderen..." required>
    </div>
    <div class="form-group">
        <label>Notes</label>
        <input class="form-control" type="textarea" name="reservation[notes]" row="10">
    </div>
    <div class="form-group">
        <label>Allergieën</label>
        <input class="form-control" type="textarea" name="reservation[allergens]" row="5">
    </div>
    <div class="mt-3">
        <a class="btn btn-primary" href="reservation.php">Terug</a>
        <input class="btn btn-primary" type="submit" value="Volgende">
    </div>
</form>