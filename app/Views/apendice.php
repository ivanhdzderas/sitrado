<style>
.archiva-modal .modal-content {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 18px 50px rgba(15, 35, 55, 0.22);
    overflow: hidden;
}
.archiva-modal .modal-header {
    background: linear-gradient(135deg, #0b5cab 0%, #1473c7 55%, #1f8a8a 100%);
    color: #fff;
    border-bottom: 0;
    padding: 1rem 1.25rem;
}
.archiva-modal .modal-title {
    font-family: var(--archiva-display, Georgia, serif);
    font-size: 1.15rem;
    font-weight: 700;
}
.archiva-modal .btn-close {
    filter: invert(1) grayscale(1) brightness(2);
}
.archiva-modal .modal-body {
    background: #f7f9fc;
    padding: 1.25rem;
}
.archiva-modal .modal-footer {
    background: #fff;
    border-top: 1px solid #e5ebf2;
}
</style>
<script>
function mostrar(tipo){ 
    var url="<?php echo base_url()?>lista_empresas";
    var titulo="Agrega "+tipo;
    $("#modal_title").html(titulo);
      $.post(url,
            {tipo:tipo},
            function(data){
                $("#modal_body").html(data);
             }); 
       
};

</script>
<div class="col-md-4">
    <div class="card card-chart">
        <div class="card-header card-header-icon" data-background-color="rose">
        </div>
        <div class="card-content">
            <h4 class="card-title">Grupos</h4>
                <p class="category">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" onclick="mostrar('grupo')" data-bs-target="#ModalVisor">Agrega Grupo</button>
                </p>
            </div>
            <div class="card-footer">
        </div>
    </div>
</div>

<div class="col-md-4" >
    <div class="card card-chart">
        <div class="card-header card-header-icon" data-background-color="blue">
        </div>
        <div class="card-content">
            <h4 class="card-title">SubGrupos</h4>
            <p class="category">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" onclick="mostrar('subgrupo')" data-bs-target="#ModalVisor">Agrega Subrupo</button>
            </p>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>


 <div class="modal fade archiva-modal" id="ModalVisor" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title" name="modal_title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body" name="modal_body">
                
            </div>
            <div class="modal-footer">
             
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
