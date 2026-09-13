<div class="head_chat">Chat

              <div class="min"><a onclick="mini()">-</a></div>
            </div>
            
            <?php
            $repetido="";
            $cuantos=0;
            $data=array();

            foreach ($query->getResult() as $key) {
              
              $data[$cuantos]=$key->nombre;
              $cuantos=$cuantos+1;
            }
            $cuantos=$query->getNumRows();
           
            $van=0;
            $data2=array_unique($data);
            foreach ($data2 as $key => $valor) {
              
              //print_r($key."<br />");
              //print_r($query->getResult()[$key]->id."<br />");
              //print_r($valor."<br />");
              if ($valor==session()->get('logged_in')['nombre']){
              }else{
                ?>
                <div class="sidebar-name">
                <?php
                  if ($query->getResult()[$key]->envia==NULL){
                  ?>
                    <div id="cuantos_<?php echo $query->getResult()[$key]->id?>" style="width: 20px"></div>
                  <?php
                  }else{

                    $men=login_model()->cuenta_mensajes($query->getResult()[$key]->id)->getNumRows();

                    if ($men>0){
                      ?>
                      <div id="cuantos_<?php echo $query->getResult()[$key]->id?>" style="width: 20px"><div style="width: 10px; height: 10px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; background: #F44336;"></div></div>
                      <?php
                    }else{
                      ?>
                      <div id="cuantos_<?php echo $query->getResult()[$key]->id?>" style="width: 20px"></div>
                      <?php
                    }
                  }
                  ?>
                  <!-- Pass username and display name to register popup -->
                  <a href="javascript:register_popup('<?php echo $query->getResult()[$key]->usuario?>', '<?php echo $query->getResult()[$key]->nombre?>');">
                    <?php
                    if ($query->getResult()[$key]->img==""){
                      ?>
                      <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/avatar.jpg" />
                      <?php
                    }else{
                      ?>
                      <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/<?php echo $query->getResult()[$key]->img ?>" />
                      <?php
                    }
                    ?>
                    <span><?php echo utf8_decode($query->getResult()[$key]->nombre)?></span>
                  </a>
                </div>
                <?php
              }
             
            }
