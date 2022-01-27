<!DOCTYPE html>
<html lang="en">
<head>
    <title>Excellent Taste Backup</title>
    <meta charset="UTF-8">
    <meta name="author" content="Junyi Xie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Excellent Taste Backup">
    <meta name="keywords" content="Excellent Taste, PHP">
    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap JavaScript CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Fontawesome kit -->
    <script src="https://kit.fontawesome.com/aef17d080e.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Navigation -->
<header class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Excellent Taste</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservation.php">Plaats een reservering</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list.php">Bekijk de reserveringen</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Serveren</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="overview.php?view=kok">Voor kok</a>
                        <a class="dropdown-item" href="overview.php?view=barman">Voor barman</a>
                        <a class="dropdown-item" href="overview.php?view=ober">Voor ober</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="menu.php?view=drinken">Drinken</a>
                        <a class="dropdown-item" href="menu.php?view=eten">Eten</a>
                        <a class="dropdown-item" href="menu.php?view=klanten">Klanten</a>
                        <a class="dropdown-item" href="menu.php?view=categorie">Categorie</a>
                        <a class="dropdown-item" href="menu.php?view=type">Type</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Start Container -->
<div class="container">