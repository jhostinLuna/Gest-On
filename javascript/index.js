var cont = 0;


$(document).ready(function () {
    
    if (document.getElementById("contenedor-chat")) {
        document.getElementById("contenedor-chat").scrollBy(0,5000);
    }
        setInterval(() => {
            if (document.getElementById("contenedor-chat")) {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {"chat":"on",":id_dest":document.getElementById(":id_dest").value},
                dataType: "html",
                success: function (response) {
                    
                    var chat = JSON.parse(response);
                    
                    if (chat.length > 0) {
                        for (i=0; i < chat.length; i++){
                            var div = document.createElement("div");
                            var mensaje = document.createElement("span");
                            var hora = document.createElement("span");
                            
                            if (chat[i]['id_rem'] == document.getElementById(":id_rem").value){
                                div.setAttribute("class","m_rem");
                            }else{
                                div.setAttribute("class","m_dest");
                            }
                            mensaje.appendChild(document.createTextNode(chat[i]['mensaje']));
                            f_hora = new Date(chat[i]['hora']);
                            
                            hora.appendChild(document.createTextNode(f_hora.getHours()+":"+f_hora.getMinutes()));
                            div.appendChild(mensaje);
                            div.appendChild(hora);
                            document.getElementById("chat").appendChild(div);
                            document.getElementById("contenedor-chat").scrollBy(0,100);
                            Push.create(
                                "mario",{
                                    body: chat[i]['mensaje'],
                                    icon: "./images/usuario.jpg"
                                }
                            );
                        }
                    }
                    
                    
                }
            });  
        }
        }, 3000);
    
    $("#delete_inc").click(function (e) { 
        e.preventDefault();        
        
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {"delete_inc":"on"},
            dataType: "html",
            success: function (response) {
                
                var span = document.createElement("span");
                span.setAttribute("class","mensaje");
                span.appendChild(document.createTextNode(response));
                document.getElementById("d_inc").insertBefore(span,document.getElementById("d_inc").childNodes[0]);
                
            setTimeout(function () {
                document.getElementById("d_inc").removeChild(document.getElementById("d_inc").childNodes[0]);
                
        },5000);
            }
        });
        
    });
    $("#c_inc").click(function (e) { 
        e.preventDefault();
        var asunto = document.getElementById("asunto").value;
        var equipo = document.getElementById("equipo").value;
        var ubicacion = document.getElementById("ubicacion").value;
        var descripcion = document.getElementById("descripcion").value;
        document.getElementById("asunto").value = "";
        document.getElementById("equipo").value = "";
        document.getElementById("ubicacion").value = "";
        document.getElementById("descripcion").value = "";
        if (asunto.length > 0 && equipo.length > 0 && ubicacion.length > 0) {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {"crear_inc":"on",":asunto":asunto,":equipo":equipo,":ubicacion":ubicacion,":descripcion":descripcion},
                dataType: "html",
                success: function (response) {
                    
                    var span = document.createElement("span");
                    span.setAttribute("class","mensaje");
                    span.appendChild(document.createTextNode(response));
                    document.getElementById("cmen").insertBefore(span,document.getElementById("cmen").childNodes[0]);
                    setTimeout(function () {
                        document.getElementsByClassName("mensaje")[0].innerHTML = "";
                        document.getElementsByClassName("mensaje")[0].removeAttribute("class");  
                        
                },5000);
                }
            });
        }else{
            var span = document.createElement("span");
            span.setAttribute("class","mensaje");
            span.appendChild(document.createTextNode("¡Descripcion es opcional el resto es obligatorio!"));
            document.getElementById("cmen").insertBefore(span,document.getElementById("cmen").childNodes[0]);
            setTimeout(function () {
                document.getElementsByClassName("mensaje")[0].innerHTML = "";
                document.getElementsByClassName("mensaje")[0].removeAttribute("class");  
                
        },5000);
        }
    });
    $("#enviar_men").click(function (e) { 
        e.preventDefault();
        var men = document.getElementById("mensaje").value;
        document.getElementById("mensaje").value = "";
        var h = new Date();
        
        if (men.length > 0) {
            var div = document.createElement("div");
            var mensaje = document.createElement("span");
            var hora = document.createElement("span");
            div.setAttribute("class","m_rem");            
            mensaje.appendChild(document.createTextNode(men));
            hora.appendChild(document.createTextNode(h.getHours()+":"+h.getMinutes()));
            div.appendChild(mensaje);
            div.appendChild(hora);
            document.getElementById("chat").appendChild(div);
            document.getElementById("contenedor-chat").scrollBy(0,100);
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {"enviar_men": "on","mensaje": men,":id_dest": document.getElementById(":id_dest").value},
                dataType: "html",
                success: function (response) {
                    
                    
                }
            });
        }
                
    });
    $("#mensaje").click(function (e) { 
        e.preventDefault();
        document.getElementById("contenedor-chat").scrollBy(0,5000);
    });
});