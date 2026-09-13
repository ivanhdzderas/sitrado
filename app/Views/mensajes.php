    <link href="<?php echo base_url()?>assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/js/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css" />
<div class="msg-wgt-body">
<table>
	<?php 
	
	foreach ($mensajes->getResult() as $key) {
		?>
		<tr class="msg-row-container">
	        <td>
	          <div class="msg-row">
	            <div class="avatar">
	            	
	            		<?php


	            		$query=login_model()->carga_datos_usuario($key->envia);
	            		
						if ($query->getResult()[0]->img==""){
                      ?>
                      <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/avatar.jpg" />
                      <?php
                    }else{
                      ?>
                      <img width="30" height="30" src="<?php echo base_url()?>/assets/img/faces/<?php echo $query->getResult()[0]->img ?>" />
                      <?php
                    }
                    
	            		?>


	            </div>
	            <div class="message">
	              <span class="user-label"><a href="#" style="color: #6D84B4;"><?php
	              	$query=login_model()->carga_datos_usuario($key->envia);
	              	login_model()->cambia_mensajes($key->envia);
	               echo $query->getResult()[0]->nombre; 

	               ?></a> <span class="msg-time"><?php echo $key->sent_on ?></span></span><br/><?php echo $key->message ?>
	            </div>
	          </div>
	        </td>
	     </tr>
		<?php
	}
	?>
	
</table>
</div>

<script>
	setInterval(get_mensaje('<?php echo $id?>'), 10000);
	
</script>