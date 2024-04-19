<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/new-walt-disney-font" rel="stylesheet">

    <title>Page de connexion - Admin</title>
</head>
<body>
    <header>
        <div class="header">
            <img src="image/mikey_gouvernail.webp">
            <h1>Project - My Cinéma<br>By Robin</h1>
            <button class="client"><a href="index.php">Espace Client</a></button>
        </div>
    </header>
    <h1 class="title_co">Bienvenue sur votre Espace admistrateur, Veuillez vous connecter</h1>
    <form method="POST" action="admin.php" class="form_login">
        <fieldset>
            <legend>Espace de connexion</legend>
            <label>Identifiant :</label>
            <input type="text" placeholder = "Identifiant administrateur" name= "id_admin"><br>
            <label>Password :</label>
            <input type="password" placeholder = "Mot de passe" name= "password_admin"><br>
            <button type="submit" action="admin.php">Se connnecter</button>
        </fieldset>
    </form>
</body>
</html>