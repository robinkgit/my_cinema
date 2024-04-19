window.onload = function (){
    var button_1 = document.getElementsByTagName('form')[3].getElementsByTagName('button')[0];
    var form = document.getElementsByTagName('form')[3];
    console.log(button_1);

    button_1.addEventListener("click", function(){
        
        var new_input = document.createElement("input");
        var label = document.createElement("label");
        var new_input_date = document.createElement("input");
        var new_input_time = document.createElement("input");
        
        form.append(new_input);
        new_input.append(label);
        new_input.append(new_input_date);
        new_input.append(new_input_time);

        label.innerHTML = "Nom du film vu :";

        new_input.setAttribute("type","text");
        new_input_date.setAttribute("type","date");
        new_input_date.setAttribute("name","date_histo");
        new_input_time.setAttribute("type" , "time");
        new_input_time.setAttribute("name","time_histo");
        new_input_time.setAttribute("step","2");
        
        
    })
}