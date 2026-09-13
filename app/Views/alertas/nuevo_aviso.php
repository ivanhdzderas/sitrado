<div class="card-content">
        <div class="form-group label-floating">
            <label class="control-label">Mensaje</label>
            <textarea id="message" name="message" class="form-control"></textarea>
        </div>
        <button class="btn btn-info" onclick="guarda()">Guardar</button>
</div>
<script type="text/javascript">
	function guarda(){
		var url="<?php echo base_url()?>login/guarda_aviso";
        $.post(url,{mensaje:$("#message").val()},
            function(data){
            	if (data=="SI"){
            		alert("no fue posible guardar el aviso, pongase en contacto con su programador");
            	}else{
            		location.reload();
            	}
            });
	}
</script>