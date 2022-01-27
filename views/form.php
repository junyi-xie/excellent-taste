<form action="reservation.php?view=reservation" method="post">
    <div class="form-group">
        <label>Voor- en achternaam *</label>
        <input class="form-control" type="text" name="customer[name]" placeholder="Voor- en achternaam" required>
    </div>
    <div class="form-group">
        <label>E-mail *</label>
        <input class="form-control" type="email" name="customer[email]" placeholder="E-mailadres" required>
    </div>
    <div class="form-group">
        <label>Telefoonnr. *</label>
        <input class="form-control" type="phone" name="customer[phone]" placeholder="Telefoonnummer" required>
    </div>
    <div class="form-group">
        <label>Straatnaam *</label>
        <input class="form-control" type="text" name="customer[street]" placeholder="Straatnaam..." required>
    </div>
    <div class="form-group">
        <label>Huisnummer *</label>
        <input class="form-control" type="text" name="customer[house_number]" placeholder="Vul je huisnummer in" id="house_number" required>
    </div>
    <div class="form-group">
        <label>Extra Toevoeging (optioneel)</label>
        <input class="form-control" type="text" name="customer[house_extra]" placeholder="House toevoeging">
    </div>
    <div class="form-group">
        <label>Postcode *</label>
        <input class="form-control" type="text" name="customer[zipcode]" placeholder="Postcode..." required>
    </div>
    <div class="form-group">
        <label>Woonplaats *</label>
        <input class="form-control" type="text" name="customer[place]" placeholder="Woonplaats..." required>
    </div>
    <div class="form-group">
        <label>Land *</label>
        <input class="form-control" type="text" name="customer[country]" placeholder="Land..." required>
    </div>
    <input class="btn btn-primary" type="submit" value="Volgende">
</form>