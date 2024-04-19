var script = document.createElement('script'); 
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'; 
script.type = 'text/javascript'; 
document.getElementsByTagName('head')[0].appendChild(script); 
var res = document.getElementById("resultat");

$("#film_form").submit(function(){
    genre = $(this).find("select[name=genre]").val();
    nom = $(this).find("input[name=nom]").val();
    distributeur = $(this).find("input[name=distributeur]").val();
    $.post("data.php", {genre: genre, nom: nom, distributeur: distributeur},function(data){
        res.append(data);
    });
    return false;
})