<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/new-walt-disney-font" rel="stylesheet">
    <title>My Cinéma - Espace Client</title>
</head>
<body>

<header>
  <div class="header">
    <img src="image/mikey_gouvernail.webp">
    <h1>Project - My Cinéma<br>By Robin</h1>
    <button><a href="connexion.php" class="admin_a">Espace Admin</a></button>
    </div>
</header>
<form method ="GET" action="" id="film_form">
  <div class="find_movie">
  <fieldset>
      <legend>Recherche de film</legend>
    <label>Recherche par genre:</label>
    <select name="genre">
        <option>--Choissiez le genre--</option>
        <option>Action</option>
        <option>Adventure</option>
        <option>Animation</option>
        <option>Biography</option>
        <option>Comedy</option>
        <option>Crime</option>
        <option>Drama</option>
        <option>Family</option>
        <option>Fantasy</option>
        <option>Horror</option>
        <option>Mystery</option>
        <option>Romance</option>
        <option>Sci-Fi</option>
        <option>Thriller</option>
    </select>

      <label>Recherche par nom:</label>
      <input type="text" name="nom">
      <label>Recherche par distributeur:</label>
      <input type="text" name="distributeur">
      <button type="submit" id="button_submit">Rechercher</button>
  </fieldset>
</div>
    <div class="pagination">
    <fieldset>
      <legend>Pagination</legend>
      <label>Pagination, Veuillez sélectionner le nombre de résultat à afficher par pages :</label>
      <input type= "number" min="1" max="10" name="pagination_number">
      <button type="submit" value ="recherche">Rechercher</button>
    </fieldset>
    </div>
</form>

<form method="GET" action="index.php">
  <div class="seance_soon">
  <fieldset>
    <legend>Les séance à venir...</legend>
  <label>Les séances à venir :</label>
  <input type="text" name="nom-film" placeholder="Nom du film">
  <input type="date" name="date-seance">
  <button type="submit">Rechercher</button>
</fieldset>
</div>
</form>

<div class="corps">
<?php

$username = 'robin';
$password = 'robin-mysql';
try{
    $connexion = new PDO('mysql:host=localhost;dbname=cinema', $username,$password);
}catch(PDOException $e){
    echo "erreur: " . $e -> getMessage();
}
if(empty($_GET)){
  exit;
}

if(isset($_GET['page']) && !empty($_GET['page'])){
  $current_page = (int)strip_tags($_GET['page']);
}else{
  $current_page = 1; 
}

if(array_key_exists('genre',$_GET)){
if($_GET["genre"] == "Action"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 1;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }


    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=1;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 1;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
//PAGINATION 
$id = 1;

  $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }

//FIN PAGINATION


    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

   $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");


   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }

  // var_dump($_POST);
  // echo json_encode($_POST);
}


elseif($_GET["genre"] == "Adventure"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 3;


    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=3;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 3;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 3;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }

    




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}


elseif($_GET["genre"] == "Animation"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 2;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=2;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 2;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }





    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 2;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}




elseif($_GET["genre"] == "Biography"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 7;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=7;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 7;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 7;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Comedy"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 5;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=5;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 5;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 5;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Crime"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 8;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=8;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 8;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 8;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);
    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Drama"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 4;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=4;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }


    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 4;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 4;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");

    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Family"){
   if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 13;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=13;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 13;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 13;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Fantasy"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 9;

    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
       echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=9;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 9;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 9;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Horror"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 10;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }





    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=10;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 10;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 10;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Mystery"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 6;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=6;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }





    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 6;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 6;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}


elseif($_GET["genre"] == "Romance"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 12;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }





    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=12;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 12;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }



    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 12;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }



    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}



elseif($_GET["genre"] == "Sci-Fi"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 11;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=11;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }





    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 11;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 11;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}


elseif($_GET["genre"] == "Thriller"){
  if($_GET["nom"] != "" && $_GET["distributeur"] == ""){
    $id = 14;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie WHERE id_genre LIKE $id AND movie.title LIKE'%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
    foreach($resultat_brut as $rows){
      $arr[] = $rows['title'];
    }
    foreach($arr as $value){
      echo "<br>$value</br>";
    }
    return;
  }



  if($_GET["distributeur"] !== "" && $_GET["nom"] !== ""){
    $id=14;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%'");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }





    $requete_5 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id AND movie.title LIKE '%".$_GET['nom']."%' LIMIT $element,$par_page");
    $resultat_brut6 = $requete_5 -> fetchAll(PDO::FETCH_ASSOC);
    $arr4=[];
    foreach($resultat_brut6 as $rows6){
      $arr4[] = $rows6['title'];
    }
    foreach($arr4 as $value4){
      echo"<br>$value4</br>";
    }
    return;
  }

  
  if($_GET["distributeur"] !== "" && $_GET["nom"] == ""){
    $id = 14;
    $requete_nombre_film = $connexion-> query("SELECT count(title) FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(title)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button><a href='?page=$i&genre=".$_GET["genre"]."&nom=&distributeur=".$_GET["distributeur"]."'>$i<a></button>";
    }




    $requete_7 = $connexion -> query("SELECT title FROM movie INNER JOIN movie_genre ON movie.id = movie_genre.id_movie INNER JOIN distributor ON movie.id_distributor = distributor.id WHERE name LIKE '%".$_GET['distributeur']."%'AND id_genre LIKE $id LIMIT $element,$par_page");
    $resultat_brut7 = $requete_7 -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    foreach($resultat_brut7 as $rows7){
      $arr5[] = $rows7['title'];
    }
    foreach($arr5 as $value5){
      echo "<br>$value5</br>";
    }
    return;
  }
    $id = 14;
    $requete_nombre_film = $connexion-> query("SELECT count(id_movie) FROM movie_genre WHERE id_genre LIKE $id");
    $resultat_count = $requete_nombre_film -> fetchAll(PDO::FETCH_ASSOC);
    $arr_count =[];
    foreach($resultat_count as $rows_count){
      $arr_count[] = $rows_count['count(id_movie)'];
    }
    $nb_film = $arr_count[0];

    $par_page = 20; //$_GET["pagination_number"];
    $page = ceil($nb_film / $par_page);

    $element = ($current_page * $par_page) - $par_page;

    for($i =1; $i <= $page; $i++){
      echo "<button class=".'button_pagination'."><a href='?page=$i&genre=".$_GET["genre"]."&nom=".$_GET['nom']."&distributeur='>$i<a></button>";
    }




    $requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

    $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id) LIMIT $element,$par_page");
   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "<br>$value<br>";
   }
}
}

  if(array_key_exists('nom',$_GET)){
   if($_GET['nom']){
    $requete_3 = $connexion -> query("SELECT title FROM movie WHERE title LIKE '%".$_GET['nom']."%'");
    $resultat_brut3 = $requete_3 -> fetchAll(PDO ::FETCH_ASSOC);
    $arr2 = [];
    foreach ($resultat_brut3 as $rows3){
        $arr2[] = $rows3['title'];
    }
    foreach($arr2 as $value2){
        echo "<br>$value2<br>";
    }
  }
}

  if(array_key_exists('distributeur',$_GET)){
    if($_GET['distributeur']){
      $requete_4 = $connexion -> query("SELECT id FROM distributor WHERE name LIKE '%".$_GET['distributeur']."%'");
      $resultat_brut4 = $requete_4 -> fetchAll(PDO::FETCH_ASSOC);
      $arr3 = [];
      foreach($resultat_brut4 as $rows4){
        $arr3[] = $rows4['id'];
      }
      $result_tempo = implode(',',$arr3);
      $resultat_brut5 = $connexion -> query("SELECT title FROM movie WHERE id_distributor IN ($result_tempo)");


      $arr_distri = [];
      foreach($resultat_brut5 as $rows5){
        $arr_distri[] = $rows5['title'];
      }
      foreach($arr_distri as $value3){
        echo "<br>$value3</br>";
      }
    }
  }


    if(array_key_exists('nom-film',$_GET)){
    $requete_id_movie = $connexion-> query("SELECT id,title FROM movie WHERE title LIKE'%".$_GET['nom-film']."%'");
    $resulat_brut5 = $requete_id_movie -> fetchAll(PDO::FETCH_ASSOC);
    $arr5 = [];
    $arr_name = [];
    foreach($resulat_brut5 as $rows5){
        $arr5[] =  $rows5['id'];
        $arr_name[] = $rows5['title'];

    }
    $imp2 = implode('',$arr5);

    $requete_seance = $connexion -> query("SELECT id_movie,id_room,date_begin FROM movie_schedule WHERE id_movie LIKE '%$imp2%' AND date_begin LIKE '%".$_GET['date-seance']."%'");
    $resulat_brut6 = $requete_seance -> fetchAll(PDO::FETCH_ASSOC);
    $arr_room = [];
    $arr_date = [];
    foreach($resulat_brut6 as $rows_room){
      $arr_room[] = $rows_room['id_room'];
      $arr_date[] = $rows_room['date_begin'];
    }
    $arr_nom_room = [];
    foreach($arr_room as $value){
    $requete_nom_seance = $connexion -> query ("SELECT name FROM room WHERE id LIKE '$value'");
    $resultat_name = $requete_nom_seance -> fetchAll(PDO::FETCH_ASSOC);
    foreach($resultat_name as $rows_name_room){
      $arr_nom_room[] = $rows_name_room['name'];
      
    }
    }$i=0;
    foreach($arr_nom_room as $value6){
      foreach($arr_name as $value_name){
        echo"<br>Film: $value_name<br>";
      }
      echo "<br>En Salle: $value6<br>";
      echo"<br>Le: ".$arr_date[$i]."<br>";
      $i++;
    }
  }
?>
</div>
<div id="resultat">
</div>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="script_client.js"></script> -->
</body>
</html>




