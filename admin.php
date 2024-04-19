<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/new-walt-disney-font" rel="stylesheet">
    <script type="text/javascript" src="./script.js"></script>
    <title>My Cinéma - Espace Admin</title>
</head>
<body>
    <header>
        <div class="header">
            <img src="image/mikey_gouvernail.webp">
            <h1>Project - My Cinéma<br>By Robin</h1>
            <button class="client"><a href="index.php">Espace Client</a></button>
        </div>
    </header>
        <form method="POST" action="admin.php" class="form_membre">
        <fieldset>
            <legend>Rechercher un membre</legend>
        <label>Recherche d'un membre:</label>
        <input type="text" name ="membre-nom" Placeholder="Nom">
        <input type="text" name ="membre-prenom" Placeholder="Prénom">
        <button type="submit" value="recherche-membre">Rechercher</button>
        </fieldset>
    </form>

    <form method="POST" action="admin.php" class="form_seance">
        <fieldset>
            <legend>Ajout d'une séance</legend>
        <label>Ajout d'une séance pour un film:</label>
        <input type="text" name="nom-film" placeholder="Insérer le nom du film">
        <input type="date" name="date-film" value="2024-01-21" min="2024-01-21" max="2024-12-31">
        <input type="time" name="time-film" step="2" value="00:00:00" max="23:00:00">
        <label> Selectionner la salle :</label>
        <select name="salle">
            <option>Montana</option>
            <option>Highscore</option>
            <option>Salle 3</option>
            <option>Astek</option>
            <option>Gecko</option>
            <option>Azure</option>
            <option>Toshiba</option>
            <option>Salle 14</option>
            <option>Asus</option>
            <option>Salle 16</option>
            <option>Microsoft</option>
            <option>VIP</option>
            <option>Golden</option>
            <option>Salle 23</option>
            <option>Lenovo</option>
            <option>Salle 31</option>
            <option>Huawei</option>
        </select>
        <button type="submit"> Ajouter la séance</button>
        </fieldset>
    </form>

    <form method="POST" action="">
        <div class="form_abonnement">
        <fieldset>
            <legend>Changement Abonnement</legend>
        <label>Recherche membre</label>
        <input type="text" name="nom-membre-abo" Placeholder="Nom">
        <input type="text" name="prenom-membre-abo" Placeholder="Prénom">
        <select name="modif">
            <option>--Modification d'abonnement--</option>
            <option>Supprimer abonnement</option>
            <option>Ajouter un abonnement</option>
            <option>Changer abonnement</option>
        </select>
        <select name="abonnement">
            <option>VIP</option>
            <option>GOLD</option>
            <option>Classic</option>
            <option>Pass Day</option>
        </select>
        <button type="submit" action="">Valider</button>
    </fieldset>
    </div>
    </form>


    <form method="POST" action ="admin.php" class="form_historique">
        <fieldset>
            <legend>Consulter Historique Abonnement</legend>
        <label>Recherche membre:</label>
        <input type="text" name="nom-membre-hist" Placeholder="Nom">
        <input type="text" name="prenom-membre-hist" Placeholder="Prénom">
        <button type="submit" action="">Rechercher</button>
        </fieldset>
        <fieldset>
            <legend>Ajout d'un film à l'historique</legend>
        <label>Nom du film:</label>
        <input type="text" name="nom-film-hist" Placeholder="Nom du film">
        <input type="date" name="date-film-hist" max="2024-01-23">
        <input type="time" name="time-film-hist" ste="2" max="23:59:59">
        </fieldset>
    </form>
    <?php 


    $username = 'robin';
    $password = 'robin-mysql';
    
    try{
        $connexion = new PDO('mysql:host=localhost;dbname=cinema', $username,$password);
    }catch(PDOException $e){
        echo "erreur: " . $e -> getMessage();
    }

    if(empty($_POST)){
        exit;
    }
    if(array_key_exists('membre-nom',$_POST) || array_key_exists('membre-prenom',$_POST)){
    if($_POST['membre-nom'] !== "" && $_POST['membre-prenom'] !== ""){
        $requete_3 =  $connexion -> query("SELECT email,firstname,lastname,birthdate,address,zipcode,city,country FROM user WHERE lastname LIKE '%".$_POST['membre-nom']."%' AND firstname LIKE '%".$_POST['membre-prenom']."%'");
        $resulat_brut1 = $requete_3 -> fetchAll(PDO::FETCH_ASSOC);
        $arr1 = [];
        foreach($resulat_brut1 as $rows1){
            $arr1[] = $rows1['email'];
            $arr1[] = $rows1['firstname'];
            $arr1[] = $rows1['lastname'];
            $arr1[] = $rows1['birthdate'];
            $arr1[] = $rows1['address'];
            $arr1[] = $rows1['zipcode'];
            $arr1[] = $rows1['city'];
            $arr1[] = $rows1['country'];
        }
        foreach($arr1 as $value1){
            echo"$value1<br>";
        }
        
        $requete_3 = $connexion -> query("SELECT name FROM subscription INNER JOIN membership ON subscription.id = membership.id_subscription INNER JOIN user ON membership.id_user = user.id WHERE lastname LIKE '%".$_POST['membre-nom']."%' AND firstname LIKE '%".$_POST['membre-prenom']."%'");
        $resulat_brut3 = $requete_3 -> fetchAll(PDO::FETCH_ASSOC);
        $arr3 = [];
        foreach($resulat_brut3 as $rows3){
        $arr3[] = $rows3['name'];
        }
        foreach($arr3 as $value3){
        echo "Abonnement : $value3<br>";
        }   
       // return;
    }


    if($_POST['membre-nom'] !== "" && $_POST['membre-prenom'] == ""){
    $requete_1 = $connexion -> query("SELECT email,firstname,lastname,birthdate,address,zipcode,city,country FROM user WHERE lastname LIKE '%".$_POST['membre-nom']."%'");
    $resulat_brut1 = $requete_1->fetchAll(PDO::FETCH_ASSOC);
    $arr1 = [];
    foreach($resulat_brut1 as $rows1){
        $arr1[] = $rows1['email'];
        $arr1[] = $rows1['firstname'];
        $arr1[] = $rows1['lastname'];
        $arr1[] = $rows1['birthdate'];
        $arr1[] = $rows1['address'];
        $arr1[] = $rows1['zipcode'];
        $arr1[] = $rows1['city'];
        $arr1[] = $rows1['country'];
    }
    foreach($arr1 as $value1){
        echo"$value1<br>";
    }

    $requete_3 = $connexion -> query("SELECT name FROM subscription INNER JOIN membership ON subscription.id = membership.id_subscription INNER JOIN user ON membership.id_user = user.id WHERE lastname LIKE '%".$_POST['membre-nom']."%' AND firstname LIKE '%".$_POST['membre-prenom']."%'");
    $resulat_brut3 = $requete_3 -> fetchAll(PDO::FETCH_ASSOC);
    $arr3 = [];
    foreach($resulat_brut3 as $rows3){
    $arr3[] = $rows3['name'];
    }
    foreach($arr3 as $value3){
        echo "Abonnement : $value3<br>";
    }
   // return;
    }


    if($_POST['membre-prenom'] !== "" && $_POST['membre-nom'] == ""){
    $requete_2 = $connexion -> query("SELECT email,firstname,lastname,birthdate,address,zipcode,city,country FROM user WHERE firstname LIKE '%".$_POST['membre-prenom']."%'");
    $resulat_brut2 = $requete_2 -> fetchAll(PDO::FETCH_ASSOC);
    $arr2 = [];
    foreach($resulat_brut2 as $rows2){
        $arr2[] = $rows2['email'];
        $arr2[] = $rows2['firstname'];
        $arr2[] = $rows2['lastname'];
        $arr2[] = $rows2['birthdate'];
        $arr2[] = $rows2['address'];
        $arr2[] = $rows2['zipcode'];
        $arr2[] = $rows2['city'];
        $arr2[] = $rows2['country']; 
    }
    foreach($arr2 as $value2){
        echo"$value2<br>";
    }

    $requete_3 = $connexion -> query("SELECT name FROM subscription INNER JOIN membership ON subscription.id = membership.id_subscription INNER JOIN user ON membership.id_user = user.id WHERE lastname LIKE '%".$_POST['membre-nom']."%' AND firstname LIKE '%".$_POST['membre-prenom']."%'");
    $resulat_brut3 = $requete_3 -> fetchAll(PDO::FETCH_ASSOC);
    $arr3 = [];
    foreach($resulat_brut3 as $rows3){
        $arr3[] = $rows3['name'];
    }
    foreach($arr3 as $value3){
        echo "Abonnement : $value3<br>";
    }
}
    }

    if(array_key_exists('modif',$_POST)){
    if($_POST["modif"] == "Supprimer abonnement"){
        $foreign = $connexion -> query("SET FOREIGN_KEY_CHECKS=0");
        $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%".$_POST['nom-membre-abo']."%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
        $resultat_brut_id = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr_id = [];
            foreach($resultat_brut_id as $rows6){
                $arr_id[] = $rows6['id'];
            }
            $impl = implode("",$arr_id);
            var_dump($impl);
        $requete_4 = $connexion ->  query("DELETE membership FROM membership WHERE id_user LIKE '$impl'");
    }
    if($_POST["modif"] == "Changer abonnement"){
        if($_POST["abonnement"] == "VIP"){
            $id_sub = 1;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
            $requete_change_abo = $connexion -> query("UPDATE membership SET id_subscription = $id_sub WHERE id_user LIKE '$impl'");
        }
        if($_POST["abonnement"] == "GOLD"){
            $id_sub = 2;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
            $requete_change_abo = $connexion -> query("UPDATE membership SET id_subscription = $id_sub WHERE id_user LIKE '$impl'");
        }
        if($_POST["abonnement"] == "Classic"){
            $id_sub = 3;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
            $requete_change_abo = $connexion -> query("UPDATE membership SET id_subscription = $id_sub WHERE id_user LIKE '$impl'");
        }
        if($_POST["abonnement"] == "Pass Day"){
            $id_sub = 4;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
            $requete_change_abo = $connexion -> query("UPDATE membership SET id_subscription = $id_sub WHERE id_user LIKE '$impl'");
        } 
    }
    if($_POST["modif"] == "Ajouter un abonnement"){
        if($_POST["abonnement"] == "VIP"){
            $id_sub = 1;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
           $requete_id_user = $connexion -> query("INSERT INTO membership (id_user,id_subscription) VALUES('$impl',$id_sub)");
        }
        if($_POST["abonnement"] == "GOLD"){
            $id_sub = 2;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
           $requete_id_user = $connexion -> query("INSERT INTO membership (id_user,id_subscription) VALUES('$impl',$id_sub)");
        }
        if($_POST["abonnement"] == "Classic"){
            $id_sub = 3;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
           $requete_id_user = $connexion -> query("INSERT INTO membership (id_user,id_subscription) VALUES('$impl',$id_sub)");
        }
        if($_POST["abonnement"] == "Pass Day"){
            $id_sub = 4;
            $requete_id_util = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-abo']. "%' AND firstname LIKE '%".$_POST['prenom-membre-abo']."%'");
            $resulat_brut6 = $requete_id_util -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut6 as $rows6){
                $arr6[] = $rows6['id'];
            }
            $impl = implode("",$arr6);
           $requete_id_user = $connexion -> query("INSERT INTO membership (id_user,id_subscription) VALUES('$impl',$id_sub)");
        }
}
    }

    if(array_key_exists('salle',$_POST)){
        $requete_salle = $connexion -> query("SELECT id FROM room WHERE name LIKE '%".$_POST['salle']."%'" );
        $resulat_brut4 = $requete_salle -> fetchAll(PDO::FETCH_ASSOC);
        $arr4 = [];
        foreach($resulat_brut4 as $rows4){
            $arr4[] = $rows4['id'];
        }
        $imp = implode('',$arr4);
        //var_dump($imp);
        $requete_id_movie = $connexion-> query("SELECT id FROM movie WHERE title LIKE'%".$_POST['nom-film']."%'");
        $resulat_brut5 = $requete_id_movie -> fetchAll(PDO::FETCH_ASSOC);
        $arr5 = [];
        foreach($resulat_brut5 as $rows5){
            $arr5[] =  $rows5['id'];
        }
        $imp2 = implode('',$arr5);
        $date = "'".$_POST['date-film']." ".$_POST['time-film']."'";
        var_dump($date);
        var_dump($imp);
        var_dump($imp2);
        $requete_salle_fin = $connexion -> query("INSERT INTO movie_schedule (id_movie,id_room,date_begin) VALUES ($imp2,$imp,$date)");
    }

    if(array_key_exists('nom-membre-hist',$_POST)){
        // if($_POST['nom-membre-hist'] == "" && $_POST['prenom-membre-hist'] == ""){
        //     echo "Aucun résultat";
        //     exit;
        // }
        $requete_id_utilisateur = $connexion -> query("SELECT id FROM user WHERE lastname LIKE '%". $_POST['nom-membre-hist']. "%' AND firstname LIKE '%".$_POST['prenom-membre-hist']."%'");
            $resulat_brut9 = $requete_id_utilisateur -> fetchAll(PDO::FETCH_ASSOC);
            $arr6 = [];
            foreach($resulat_brut9 as $rows9){
                $arr6[] = $rows9['id'];
            }
            $impl_hist = implode('',$arr6);
            $requete_hist = $connexion -> query("SELECT id_movie,movie_schedule.date_begin FROM movie_schedule LEFT JOIN membership_log ON movie_schedule.id = membership_log.id_session LEFT JOIN membership ON membership_log.id_membership = membership.id LEFT JOIN user ON membership.id_user = user.id WHERE user.id = $impl_hist");
            $resulat_brut_hist = $requete_hist->fetchAll(PDO::FETCH_ASSOC);
            $arr_hist_id_movie = [];
            $arr_hist_date= [];
            foreach($resulat_brut_hist as $rows_hist){
                $arr_hist_id_movie[] = $rows_hist['id_movie'];
                $arr_hist_date[] = $rows_hist['date_begin'];
            }
            $j=0;
            $k =0;
            $arr_movie = [];
            foreach($arr_hist_id_movie as $value_int){
                $requete_movie = $connexion -> query("SELECT title FROM movie WHERE id LIKE '".$arr_hist_id_movie[$j]."'");
                $resulat_brut_int = $requete_movie -> fetchAll(PDO::FETCH_ASSOC);
                $j++;
                foreach($resulat_brut_int as $rows_movie){
                    $arr_movie[] = $rows_movie['title'];
                    echo "<br>".$arr_movie[$k]."<br>";
                    echo "<br>".$arr_hist_date[$k]."<br>";
                    $k++;
                }
            }
            }

    if(array_key_exists("nom-film-hist", $_POST)){
        $requete_id_movie = $connexion-> query("SELECT id FROM movie WHERE title LIKE'%".$_POST['nom-film-hist']."%'");
        $resulat_brut5 = $requete_id_movie -> fetchAll(PDO::FETCH_ASSOC);
        $arr5 = [];
        foreach($resulat_brut5 as $rows5){
            $arr5[] =  $rows5['id'];
        }
        $imp2 = implode('',$arr5);
       // var_dump($imp2);

        $foreign = $connexion -> query("SET FOREIGN_KEY_CHECKS=0");
        $connexion -> query("INSERT INTO movie_schedule (id_movie,id_room,date_begin) VALUES ('$imp2','0','".$_POST['date-film-hist']." ".$_POST['time-film-hist']."')");
        
        $requete_id_utilisateur = $connexion -> query("SELECT membership.id FROM membership INNER JOIN  user ON membership.id_user = user.id WHERE user.lastname LIKE '%". $_POST['nom-membre-hist']. "%' AND user.firstname LIKE '%".$_POST['prenom-membre-hist']."%'");
        $resulat_brut9 = $requete_id_utilisateur -> fetchAll(PDO::FETCH_ASSOC);
        $arr_id_user = [];
        foreach($resulat_brut9 as $rows_id_user){
            $arr_id_user[] =  $rows_id_user['id'];
        }
        $imp_user = implode("",$arr_id_user);
        $date_time = $_POST['date-film-hist']." ".$_POST['time-film-hist'];
      //  var_dump($date_time);


        $movie_schedule_id = $connexion -> query("SELECT id FROM movie_schedule WHERE date_begin = '$date_time'");
        $requete_schedule_id = $movie_schedule_id -> fetchAll(PDO::FETCH_ASSOC);
        $arr_id_schedule = [];
        foreach($requete_schedule_id as $rows_schedule){
            $arr_id_schedule[] =  $rows_schedule['id'];
        }
        $imp_schedule = implode("",$arr_id_schedule);
        var_dump($imp_schedule);
        $connexion -> query("INSERT INTO membership_log (id_membership,id_session) VALUES ('$imp_user','$imp_schedule')");

    }

    ?>
</body>
</html> 