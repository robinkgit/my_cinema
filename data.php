<?php
extract($_POST);

$username = 'robin';
$password = 'robin-mysql';
try{
    $connexion = new PDO('mysql:host=localhost;dbname=cinema', $username,$password);
}catch(PDOException $e){
    echo "erreur: " . $e -> getMessage();
}
$id = 1;
$requete_1 = $connexion -> query("SELECT id_movie FROM movie_genre WHERE id_genre LIKE $id");


    $resultat_brut = $requete_1 -> fetchAll(PDO::FETCH_ASSOC);
    $arr = [];
   foreach($resultat_brut as $rows){
       $arr[] = $rows['id_movie'];
   }
   $id = implode(',',$arr);

   $resultat_brut2 = $requete_2 = $connexion -> query("SELECT title FROM movie WHERE id IN ($id)");


   $arr_title = [];
   foreach($resultat_brut2 as $rows2){
    $arr_title[] = $rows2['title'];
   }
   foreach($arr_title as $value){
    echo "$value\n";
   }
?>