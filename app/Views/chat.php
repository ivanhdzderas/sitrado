<link rel="stylesheet" href="<?php echo base_url()?>assets/css/chat.css" />
 <script>

   
            
            setInterval(reorden, 5000);
    function reorden(){
        $.ajax({
           type: "POST",
           url: '<?php echo base_url()?>login/reorden_chat',
           //data: {mensaje:$("#texto_"+id).val(),sentto:id}, // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
              $("#enlistados").html(data);  
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
              //get_mensaje(id);
           }
         });
    }

 function ver_tecla(id){

 }

  function enviar_mensaje(id){
    var url = "<?php echo base_url()?>login/envia_mensaje"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: {mensaje:$("#texto_"+id).val(),sentto:id}, // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
              $("#texto_"+id).val("");  
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
              $("#cuerpo_"+id).html(data);
           }
         });

    return false; // Evitar ejecutar el submit del formulario.

  }

function get_mensaje(id){
            //sleep(2000);
              //sleep(1000);

          $.ajax({
                type: "POST",
                url: '<?php echo base_url()?>login/get_messages',
                data: {usuario:id},
                success: function(data)
                {
                    $("#cuerpo_"+id).html(data);

                       

                }
               })
}

  //this function can remove a array element.
            Array.remove = function(array, from, to) {
                var rest = array.slice((to || from) + 1 || array.length);
                array.length = from < 0 ? array.length + from : from;
                return array.push.apply(array, rest);
            };
        
            //this variable represents the total number of popups can be displayed according to the viewport width
            var total_popups = 0;
            
            //arrays of popups ids
            var popups = [];
        
            //this is used to close a popup
            function close_popup(id)
            {
                for(var iii = 0; iii < popups.length; iii++)
                {
                    if(id == popups[iii])
                    {
                        Array.remove(popups, iii);
                        
                        document.getElementById(id).style.display = "none";
                        
                        calculate_popups();
                        
                        return;
                    }
                }   
            }
        
            //displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
            function display_popups()
            {
                var right = 280;
                
                var iii = 0;
                for(iii; iii < total_popups; iii++)
                {
                    if(popups[iii] != undefined)
                    {
                        var element = document.getElementById(popups[iii]);
                        element.style.right = right + "px";
                        right = right + 320;
                        element.style.display = "block";
                    }
                }
                
                for(var jjj = iii; jjj < popups.length; jjj++)
                {
                    var element = document.getElementById(popups[jjj]);
                    element.style.display = "none";
                }
                $(".user").focus();
            }
            
            //creates markup for a new popup. Adds the id to popups array.
            function register_popup(id, name)
            {
                
                for(var iii = 0; iii < popups.length; iii++)
                {   
                    //already registered. Bring it to front.
                    if(id == popups[iii])
                    {
                        Array.remove(popups, iii);
                    
                        popups.unshift(id);
                        
                        calculate_popups();
                        
                        
                        return;
                    }
                }               
                


                var element = '<div class="popup-box chat-popup" id="'+ id +'">';
                element = element + '<div class="popup-head">';
                element = element + '<div class="popup-head-left">'+ name +'</div>';
                element = element + '<div class="popup-head-right"><a data-toggle="modal" data-target="#myModal_cam"  onclick="videochat(\''+ id +'\')"><i class="material-icons">&#xE04B;</i></a><a href="javascript:close_popup(\''+ id +'\');">&#10005;</a></div>';
                element = element + '<div style="clear: both"></div></div><div id="'+id+'" class="popup-messages">'
                element = element + '<div id="cuerpo_'+id+'"></div>';
                element=element+'<input type="text" onkeypress="if (event.keyCode==13){enviar_mensaje(\''+id+'\') ;}" id="texto_'+id+'"  style="width:70%""><button class="btn btn-primary btn-sm" onclick="enviar_mensaje(\''+id+'\')">Enviar</button></div></div>';
                
                document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element;  
        
                popups.unshift(id);
                        
                calculate_popups();
                 $.ajax({
                type: "POST",
                url: '<?php echo base_url()?>login/get_messages1',
                data: {usuario:id},
                success: function(data)
                {
                    $("#cuerpo_"+id).html(data);
                }
               })

                $(".user").focus();
            }
            
            //calculate the total number of popups suitable and then populate the toatal_popups variable.
            function calculate_popups()
            {
                var width = window.innerWidth;
                if(width < 540)
                {
                    total_popups = 0;
                }
                else
                {
                    width = width - 200;
                    //320 is width of a single popup box
                    total_popups = parseInt(width/320);
                }
                
                display_popups();
                
            }
            
            //recalculate when window is loaded and also when window is resized.
            window.addEventListener("resize", calculate_popups);
            window.addEventListener("load", calculate_popups);
            //.msg-wgt-body
            $(document).ready(function(){

            $(".msg-wgt-body").animate({scrollTop: $(".msg-wgt-body"[0].scrollHeight)});

           });
        
 </script>
 <div class="chat-sidebar2"  style="display: none">
    <div class="head_chat">Chat
      <div class="min"><a onclick="max()">+</a></div>
    </div>
  </div>

 <div class="chat-sidebar" id="enlistados">
            <div class="head_chat">Chat

              <div class="min"><a onclick="mini()">-</a></div>
            </div>
            
            <?php
            $query=login_model()->extra_admin();
            foreach ($query as $key) {
              ?>
              <div class="sidebar-name">
                <div id="cuantos_<?php echo $key->id?>" style="width: 20px"></div>
                <!-- Pass username and display name to register popup -->
                <a href="javascript:register_popup('<?php echo $key->usuario?>', '<?php echo $key->nombre?>');">
                    <?php
                    if ($key->img==""){
                      ?>
                      <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/avatar.jpg" />
                      <?php
                    }else{

                      ?>
                        <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/<?php echo $key->img ?>" />
                      <?php
                    }
                    ?>
                    
                    <span><?php echo $key->nombre?></span>
                </a>
              </div>
              <?php
            }
            ?>
            
            
        </div>
