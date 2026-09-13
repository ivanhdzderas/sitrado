<style>
.archiva-alerts-body .table-responsive,
.archiva-alerts-body .card-content {
    font-size: 0.9rem;
    color: var(--archiva-ink, #12263a);
}
.archiva-alerts-body .card-title,
.archiva-alerts-body h3,
.archiva-alerts-body h4 {
    font-family: var(--archiva-display, Georgia, serif);
    font-size: 1.05rem;
    margin: 1.25rem 0 0.65rem;
    color: var(--archiva-ink, #12263a);
}
.archiva-alerts-body .btn-xs {
    padding: 0.2rem 0.55rem;
    font-size: 0.78rem;
    border-radius: 0.4rem;
}
.archiva-alerts-body table.table {
    background: #fff;
    border: 1px solid #d7e0ea;
    border-radius: 0.75rem;
    overflow: hidden;
}
.archiva-alerts-body th.warning {
    background: #eaf2fb !important;
    color: #334155 !important;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.archiva-alerts-body center {
    text-align: left;
    margin: 0.75rem 0;
    padding: 0.85rem 1rem;
    border: 1px solid #d7e0ea;
    border-radius: 0.75rem;
    background: #f8fafc;
}
.archiva-alerts-body center h3 {
    margin: 0 0 0.5rem;
}
</style>
<?php
/* Acciones JS: public/assets/js/archiva-alerts.js (refresh sin reload de página) */
$_nr = static function ($q): int {
    if ($q === null || $q === false || $q === '') {
        return 0;
    }
    if (is_array($q)) {
        return count($q);
    }
    if (is_object($q) && method_exists($q, 'getNumRows')) {
        return (int) $q->getNumRows();
    }
    return 0;
};

$cuantos1 = $_nr($pendientes1 ?? null);
$cuantos2 = $_nr($pendientes2 ?? null);
$cuantos3 = $_nr($pendientes3 ?? null);
$cuantos4 = is_array($pendientes4 ?? null) ? count($pendientes4) : $_nr($pendientes4 ?? null);
$cuantos7 = 0;
$cuantos12 = $_nr($pendientes12 ?? null);
$cuantos13 = 0;
$cuantos14 = $_nr($pendientes14 ?? null);
$cuantos15 = $_nr($pendientes15 ?? null);
$cuantos16 = $_nr($pendientes16 ?? null);
$cuantos17 = $_nr($pendientes17 ?? null);
$cuantos18 = $_nr($pendientes18 ?? null);
if (! empty($pendientes7) && is_object($pendientes7)) {
    foreach ($pendientes7->getResult() as $key) {
        $rev = login_model()->revisar_doc($key->id);
        if (empty($rev) || ! isset($rev[0]->total) || (int) $rev[0]->total === 0) {
            $cuantos7++;
        }
    }
}
$cuantos10 = $_nr($pendientes10 ?? null);
if (session()->get('logged_in')['iduser'] == (session()->get('grade')['proyectos'] ?? null)) {
    $cuantos5 = $_nr($pendientes5 ?? null);
    $cuantos6 = $_nr($pendientes6 ?? null);
    $cuantos13 = $_nr($pendientes13 ?? null);
} else {
    $cuantos5 = 0;
    $cuantos6 = 0;
    $cuantos13 = 0;
}


if ($cuantos7>0){
?>
    <center><h3>Tienes Documentos por Autorizar</h3><button class="btn btn-warning btn-xs" onclick="autorizaciones()">Ver Documentos</button></center>
<?php
}
if ($cuantos15>0){
    ?>
    <h4 class="card-title">Proximos eventos</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Evento</th>
                <th class="warning">Fecha</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes15->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->titulo?></td>
                            <td><?php echo $key->fecha_inicio?></td>
                            <td><button class="btn btn-success btn-xs" onclick="window.location='<?php echo base_url()?>login/eventos';">ver</button>
                                
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>
    <?php
}
if ($cuantos14>0){
    ?>
    <h4 class="card-title">Pendientes Personales</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Tema</th>
                <th class="warning">Fecha</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes14->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->titulo?></td>
                            <td><?php echo $key->fecha?></td>
                            <td><button class="btn btn-success btn-xs" onclick="terminar_agenda('<?php echo $key->id_pendiente?>')">Terminado</button>
                                
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>
    <?php
}
if ($cuantos13>0){
    ?>
    <h4 class="card-title">Respuestas Reagendar</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Proyecto</th>
                <th class="warning">Subproyecto</th>
                <th class="warning">Respuestas</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes13->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->nombre_proyecto?></td>
                            <td><?php echo $key->subproyecto?></td>
                            <td><?php echo $key->respuesta?></td>
                            <td><button class="btn btn-success btn-xs" onclick="atendido('<?php echo $key->id_reagenda?>')">Atendido</button>
                                
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>
    <?php
}
if ($cuantos12>0){
    ?>
    <h4 class="card-title">Actividad a Reagendar</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Proyecto</th>
                <th class="warning">Actividad</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes12->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->nombre_proyecto?></td>
                            <td><?php echo $key->subproyecto?><button class="btn btn-info btn-xs" onclick="ver_nota_reagendar('<?php echo $key->id_reagenda?>')">Ver nota</button></td>
                            <td><button class="btn btn-success btn-xs" onclick="solucion('<?php echo $key->id_reagenda?>','NO')">Aprobar</button>
                                <button class="btn btn-danger btn-xs" onclick="solucion('<?php echo $key->id_reagenda?>','SI')">Rechazar</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>
    <?php
}
if (session()->get('logged_in')["plaza"]=="1" and $_nr($pendientes8 ?? null)>0){
            ?>
            <center><h3>Tienes <?php echo $_nr($pendientes8) ?> Documentos por Revisar</h3><button class="btn btn-warning btn-xs" onclick="revisar()">Ver Documentos</button></center>

            
            <?php

}
if (session()->get('logged_in')["plaza"]=="1" and $_nr($pendientes11 ?? null)>0){
    ?>
    <center><h3>Tienes <?php echo $_nr($pendientes11) ?> Solicitudes</h3><button class="btn btn-warning btn-xs" onclick="solicitudes()">Ver Solicitudes</button></center>
    <?php
}
 

if($cuantos10>0){
    ?>
    <center><h3>Tienes <?php echo $cuantos10 ?> Documentos por Revisar</h3><button class="btn btn-warning btn-xs" onclick="revisar_doc()">Ver Documentos</button></center>
    <?php
}
if (session()->get('logged_in')['iduser']==(session()->get('grade')['proyectos'] ?? null) && !empty($pendientes9) && is_object($pendientes9)){
    ?>
   <h4 class="card-title">Pendientes Generales Proyectos por Vencer</h4>
    <div class="card-content table-responsive table-full-width">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="warning">Proyecto</th>
                    <th class="warning">Nombre</th>
                    <th class="warning">Fecha Inicio</th>
                    <th class="warning">Fecha Fin</th>
                    <th class="warning"></th>
                </tr>
            </thead>
            <tbody>
               <?php
                        foreach ($pendientes9->getResult() as $key) {
                            ?>
                            <tr>
                                <td><?php echo $key->nombre_proyecto?></td>
                                <td><?php echo $key->nombre?></td>
                                <td><?php echo $key->f_inicio?></td>
                                <td><?php echo $key->f_fin?></td>
                                <td>
                                    <?php
                                    if ($key->f_fin==date('Y-m-j')){
                                        echo "En Fecha";
                                    }else{
                                        echo "Por Vencer";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
            </tbody>
        </table>
    </div>

    <?php
}


if ($cuantos1>0){

?>
<h4 class="card-title">Pendientes Junta</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Junta</th>
                <th class="warning">Tema</th>
                <th class="warning">Fecha Compromiso</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pendientes1->getResult() as $key) {
                ?>
                <tr>
                    <td><?php echo $key->junta?></td>
                    <td><?php echo $key->tema?></td>
                    <td><?php echo $key->fecha_compromiso?></td>
                    <?php
                    if ($key->archivo=="SI"){
                        $query=login_model()->buscar_archivo($key->id_tema);
                        $cuantos=$query->getNumRows();
                        if ($cuantos==0){
                            ?>
                            <td><button class="btn btn-warning btn-xs" onclick="subir_archivo1('<?php echo $key->id_tema?>')">Subir Archivo</button></td>
                            <?php
                        }else{
                            ?>
                            <td>En espera de Autorizacion</td>
                            <?php
                        }
                    }else{
                        ?>
                        <td></td>
                        <?php
                    }
                    ?>
                    
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>




<?php
}
if ($cuantos2>0){
	?>
<h4 class="card-title">Proximas Junta</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Tema</th>
                <th class="warning">Fecha</th>
                <th class="warning">Lugar</th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes2->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->tema?></td>
                            <td><?php echo $key->fecha?></td>
                            <td><?php echo $key->lugar?></td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>


<?php
}
if ($cuantos3>0){
	?>
<h4 class="card-title">Pendientes Proyectos</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Proyecto</th>
                <th class="warning">Nombre</th>
                <th class="warning">Fecha Inicio</th>
                <th class="warning">Fecha Fin</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes3->getResult() as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key->nombre_proyecto?></td>
                            <td><?php echo $key->nombre?></td>
                            <td><?php echo $key->f_inicio?></td>
                            <td><?php echo $key->f_fin?></td>
                            <td><button class="btn btn-warning btn-xs" onclick="subir_archivo2('<?php echo $key->id_subproyecto?>','<?php echo $key->proyecto?>')">Subir Archivo</button></td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>

	<?php
}
if ($cuantos4>0){
    ?>

    <h4 class="card-title">Pendientes 8D'S</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Solucion</th>
                <th class="warning">Tipo de Solucion</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
                    foreach ($pendientes4 as $key) {
                        ?>
                        <tr>
                            <td><?php echo $key[1]?></td>
                            <td>
                                <?php
                                    switch($key[2]){
                                        case "permanente":
                                            echo "Solucion Permanente";
                                        break;
                                        case "preventivo":
                                            echo "Solucion Preventivo";
                                        break;
                                        case "temporal":
                                            echo "Solucion Temporal";
                                        break;
                                    }
                                ?>
                            </td>
                            
                            <td><button class="btn btn-warning btn-xs" onclick="subir_archivo3('<?php echo $key[0]?>','<?php echo $key[2]?>')" >Subir Archivo</button></td>
                        </tr>
                        <?php
                    }
                    ?>
        </tbody>
    </table>
</div>

    <?php
}

if ($cuantos5>0){
    ?>
   <h4 class="card-title">Nuevos Archivos</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Proyecto</th>
                <th class="warning">Actividad</th>
                <th class="warning">Usuario</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($pendientes5->getResult() as $key) {
              ?>
            </tr>
              <td><?php echo $key->nombre_proyecto?></td>
              <td><?php echo $key->subproyecto?></td>
              <td><?php echo $key->nombre?></td>
              <td><button class="btn btn-warning btn-xs" onclick="window.location='<?php echo base_url()?>proyectos'" >Ver proyecto</button></td>
            </tr>
              <?php
           }
           ?>
        </tbody>
    </table>
</div> 
    <?php
}
if ($cuantos6>0){
    ?>
    <h4 class="card-title">Pedimentos</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Mensaje</th>
                <th class="warning">Tipo</th>
                <th class="warning">Usuario</th>
                <th class="warning">Fecha</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($pendientes6->getResult() as $key) {
              ?>
            </tr>
              <td><?php echo $key->nombre?></td>
              <td><?php echo $key->tipo?></td>
              <td><?php echo $key->pidio?></td>
              <td><?php echo $key->fecha?></td>
              <td><button class="btn btn-warning btn-xs" onclick="marcar('<?php echo $key->id_pedimento?>')"  >Atendido</button></td>
            </tr>
              <?php
           }
           ?>
        </tbody>
    </table>
</div>
    <?php
}

if ($cuantos16>0){
    ?>
    <h4 class="card-title">RACI</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="warning">Proyecto</th>
                <th class="warning">Tarea</th>
                <th class="warning">Tipo</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($pendientes16->getResult() as $key) {
              ?>
            </tr>
              <td><?php echo $key->proyecto?></td>
              <td><?php echo $key->subproyecto?></td>
              <td>
                <?php
                    switch($key->tipo){
                        case "R":
                            echo "Resposible";
                            break;
                        case "A":
                            echo "Acountable";
                            break;
                        case "C":
                            echo "Consulted";
                            break;
                        case "I":
                            echo "Informed";
                            break;
                    }
                ?> 
                </td>
                <?php
                if (session()->get('logged_in')['tipo']=="admin"){
                    ?>
                    <td><button class="btn btn-info btn-xs" onclick="ir_proyecto('<?php echo $key->id_proyecto?>')"  >IR</button></td>
                    <?php
                }else{
                    ?>
                    <td><button class="btn btn-info btn-xs" onclick="ir_proyecto2('<?php echo $key->id_proyecto?>')"  >IR</button></td>
                    <?php
                }
                ?>
              
            </tr>
              <?php
           }
           ?>
        </tbody>
    </table>
</div>
    <?php
}
if ($cuantos17>0){
    ?>
     <h4 class="card-title">Alerta de Nuevo Documento en el Sistema</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
                <tr>
                <th class="warning">Nombre</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($pendientes17->getResult() as $documento) {
               $query=login_model()->nombre_archivo($documento->id_documento)->getResult();
                foreach ($query as $key ) {
                    ?>
                        <tr>
                            <td> <a onclick="ver_documento('<?php echo $documento->id_documento?>')"><?php echo $key->nombre?></a></td>
                             <td><button class="btn btn-info btn-xs" onclick="visto('<?php echo $documento->id_documento?>')"  >Visto</button></td>
                        </tr>
                    <?php   
                }
           }
           ?>
        </tbody>
    </table>
</div>
    <?php
}
if ($cuantos18>0){
    ?>
     <h4 class="card-title">Alerta de Avisos</h4>
<div class="card-content table-responsive table-full-width">
    <table class="table table-hover">
        <thead>
                <tr>
                <th class="warning">Mensaje</th>
                <th class="warning"></th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($pendientes18->getResult() as $aviso) {
               
              ?>
              <tr>
                <td><?php echo $aviso->mensaje?></td>
                <td><button class="btn btn-info btn-xs" onclick="visto2('<?php echo $aviso->id?>')"  >Visto</button></td>

              </tr>
              <?php
           }
           ?>
        </tbody>
    </table>
</div>
    <?php
}
?>