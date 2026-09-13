
<?php
$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+3 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );



$nuevafecha2 = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
$nuevafecha2 = date ( 'Y-m-j' , $nuevafecha2 );

$nuevafecha3 = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$nuevafecha3 = date ( 'Y-m-j' , $nuevafecha3 );

?>
  <!-- External resources -->
    <!-- jQuery + Ajax [required by Bootstrap] -->
      <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
      <!-- Required by smooth scrolling -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap v4.0.0 Alpha -->
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
      <script src="https://use.fontawesome.com/78d1e57168.js"></script>
    <!-- Google's Code Prettify -->
      <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&amp;skin=sunburst"></script>
    <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Cookie|Satisfy|Kelly+Slab|Overlock" rel="stylesheet">

  <!-- Internal resources -->
    <!-- Webpage -->
      <link href="<?php echo base_url()?>assets/css/main.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url()?>assets/js/main.js" type="text/javascript"></script>
    <!-- jsGanttImproved App -->
      <link href="<?php echo base_url()?>assets/css/jsgantt.css" rel="stylesheet" type="text/css"/>
      <script src="<?php echo base_url()?>assets/js/jsgantt.js" type="text/javascript"></script>
<style>
body{
      background-image:none

}
</style>
  <script>
    function grafica(){
      window.print();
  
}
  </script>
<!-- Content -->
 
  <?php
  $proyecto_nombre="";
  $id_lider=0;
  $id_backup=0;
  $fecha_proyecto="";
  $patro="";
  $patrocinador="";

  foreach ($nombre_proyecto as $key) {
    $proyecto_nombre=$key->nombre_proyecto;
    $id_lider=$key->capitan;
    $id_backup=$key->subcapitan;
    $fecha_proyecto=$key->f_inicio;
    $patro=$key->patrocinador;
  }

$imparte=login_model()->extre_impartidor($id_lider)->getResult();
$lider="";
foreach ($imparte as $key) {
  $lider=$key->nombre;
}

if ($patro<>"0"){
  $ir=login_model()->carga_datos_usuario($patro)->getResult();
  foreach ($ir as $key) {
    $patrocinador=$key->nombre;
  }
}else{
  $patrocinador="";
}
$backup="";
$imparte=login_model()->extre_impartidor($id_backup)->getResult();
foreach ($imparte as $key) {
  $backup=$key->nombre;
}

  ?>
  <style>

    h3 {
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  font-size: 18px;
  font-style: normal;
  font-variant: normal;
  font-weight: 500;
  line-height: 15.4px;
  color:#051D4D;

}
body{
  font-size: 15px;
}
.gtasktable{
  font-size: 15px;
}
.mini{
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  font-size: 10px;
  font-style: normal;
  font-variant: normal;
  font-weight: 500;
  line-height: 15.4px;
  color:#000000;
}
.tit{
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  font-size: 14px;
  font-style: normal;
  font-variant: normal;
  font-weight: 500;
  line-height: 15.4px;
  color:#000000;
}
  </style>
  <table width="70%"   >
    <tr>
      <td width="80%">
        <img src="<?php echo base_url()?>assets/img/logo.jpg" width="90px">
      </td>
      <td align="right">
        <h3><b>Synergy to Business</b></h3>
        <table width="100%" >
          <tr>
            <td colspan="3" align="right">
              <h3 class="tit"><b>Grafica de Gantt</b></h3>
            </td>
          </tr>
          <tr align="right">
            <td>
              <label class="mini">Codigo</label>
            </td>
            <td>
              <label class="mini">Rev.</label>
            </td>
            <td>
              <label class="mini">Fecha</label>
            </td>
          </tr>
          <tr align="right">
            <td>
              <label class="mini">MP-F-11</label>
            </td>
            <td>
              <label class="mini">0</label>
            </td>
            <td>
              <label class="mini">18/09/2017</label>
            </td>s
          </tr>
        </table>
      </td>
      <td>

      </td>
    </tr>
  </table>
  <br / >
  <table>
    <tr>
      <td>
        <!--<button onclick="grafica()" class="btn-sm btn-primary">Imprimir</button>
        -->
      </td>
    </tr>
    <tr>
      <td align="right">
        <b>Proyecto:</b>
      </td>
      <td>
        <?php echo $proyecto_nombre?>
      </td>
    </tr>
    <tr>
      <td  align="right">
        <b>Lider:</b>
      </td>
      <td>
        <?php echo $lider?>
      </td>
    </tr>
    <tr>
      <td align="right">
        <b>Backup:</b>
      </td>
      <td>
        <?php echo $backup?>
      </td>
    </tr>
    <tr>
      <td align="right">
        <b>Patrocinador:</b>
      </td>
      <td>
        <?php echo $patrocinador?>
      </td>
    </tr>
  </table>

  <style>

  .gminorheadingwkend{
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fac695+0,f5ab66+47,ef8d31+100;Orange+3D+%232 */
background: #fac695; /* Old browsers */
background: -moz-linear-gradient(top, #fac695 0%, #f5ab66 47%, #ef8d31 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fac695', endColorstr='#ef8d31',GradientType=0 ); /* IE6-9 */
  }
  .gminorheading{
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+33,b7df2d+100;Green+3D+%234 */
background: #f8ffe8; /* Old browsers */
background: -moz-linear-gradient(top, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8ffe8', endColorstr='#b7df2d',GradientType=0 ); /* IE6-9 */
  }
  .gtaskheading,.gmajorheading {
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#7abcff+0,60abf8+44,4096ee+100;Blue+3D+%2314 */
background: #7abcff; /* Old browsers */
background: -moz-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #7abcff 0%,#60abf8 44%,#4096ee 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 ); /* IE6-9 */
    }
  </style>  

        <div id="embedded-Gantt">
          <script type="text/javascript">
var g = new JSGantt.GanttChart(document.getElementById('embedded-Gantt'), 'day');
if (g.getDivId() != null) {
  g.setCaptionType('Complete');  // Set to Show Caption (None,Caption,Resource,Duration,Complete)
  g.setQuarterColWidth(36);
  g.setDateTaskDisplayFormat('day dd month yyyy'); // Shown in tool tip box
  g.setDayMajorDateDisplayFormat('mon yyyy - Week ww') // Set format to display dates in the "Major" header of the "Day" view
  g.setWeekMinorDateDisplayFormat('dd mon') // Set format to display dates in the "Minor" header of the "Week" view
  g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
  g.setShowEndWeekDate(0); // Show/Hide the date for the last day of the week in header for daily view (1/0)
  g.setUseSingleCell(10000); // Set the threshold at which we will only use one cell per table row (0 disables).  Helps with rendering performance for large charts.
  g.setFormatArr('Day', 'Week', 'Month', 'Quarter'); // Even with setUseSingleCell using Hour format on such a large chart can cause issues in some browsers
  // Parameters                     (pID, pName,                  pStart,       pEnd,        pStyle,         pLink (unused)  pMile, pRes,       pComp, pGroup, pParent, pOpen, pDepend, pCaption, pNotes, pGantt)


<?php 

foreach ($nombre_proyecto as $key) {
  ?>
  g.AddTaskItem(new JSGantt.TaskItem(1,   '<?php echo $key->nombre_proyecto?>',     '',           '',          '',  '',                 0, '',    0,     1,      0,       1,     '',      '',      '', g ));
  <?php
}
$conteo=1;

foreach ($detalles->getResult() as $key) {
  if ($key->terminado=="NO"){
    if (date('Y-m-j')>$key->f_fin){
      ?>
        g.AddTaskItem(new JSGantt.TaskItem(1<?php echo $conteo?>,  '<?php echo $key->tarea?>',         '<?php echo $key->f_inicio?>','<?php echo $key->f_fin?>', 'gtaskred',   '',                 0, '<?php echo substr ($key->nombre,0,8)?>',   0,  0,      1,       1,     '',      '',      '',      g));
      <?php
    }else{
      if ($nuevafecha==$key->f_fin || $nuevafecha2==$key->f_fin || $nuevafecha3==$key->f_fin){
        ?>
          g.AddTaskItem(new JSGantt.TaskItem(1<?php echo $conteo?>,  '<?php echo $key->tarea?>',         '<?php echo $key->f_inicio?>','<?php echo $key->f_fin?>', 'gtaskyellow',   '',                 0, '<?php echo substr ($key->nombre,0,8)?>',   0,  0,      1,       1,     '',      '',      '',      g));
        <?php
      }else{
        ?>
          g.AddTaskItem(new JSGantt.TaskItem(1<?php echo $conteo?>,  '<?php echo $key->tarea?>',         '<?php echo $key->f_inicio?>','<?php echo $key->f_fin?>', 'gtaskblue',   '',                 0, '<?php echo substr ($key->nombre,0,8)?>',   0,  0,      1,       1,     '',      '',      '',      g));
        <?php
      }
      
    }
  }else{
    ?>
      g.AddTaskItem(new JSGantt.TaskItem(1<?php echo $conteo?>,  '<?php echo $key->tarea?>',         '<?php echo $key->f_inicio?>','<?php echo $key->f_fin?>', 'gtaskgreen',   '',                 0, '<?php echo substr ($key->nombre,0,8)?>',   100,  0,      1,       1,     '',      '',      '',      g));
    <?php
  }
  $conteo=$conteo+1;
}
?>
  
  

  g.Draw();
} else {
  alert("Error, unable to create Gantt Chart");
}
          </script>
        </div>
        <div id="external-Gantt">
          <script type="text/javascript">
var g = new JSGantt.GanttChart(document.getElementById('external-Gantt'), 'day');

if (g.getDivId() != null) {
  g.setCaptionType('Responsable');  // Set to Show Caption (None,Caption,Resource,Duration,Complete)
  g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
  g.setDayMajorDateDisplayFormat('dd mon');
  g.setDateTaskDisplayFormat('dd month yyyy HH:MI');
  // Use the XML file parser
  JSGantt.parseXML('project.xml', g)

  g.Draw();
} else {
  alert("Error, unable to create Gantt Chart");
}
          </script>
          <style>
          .ggroupcaption{
            visibility: hidden;
          }
        </style>
        </div>
      </div>
  <div style="right: 80px">
    <div class="gtaskred"  style="width: 10px; height: 10px">
    </div>Tarea Fuera de Tiempo
    <div class="gtaskgreen" style="width: 10px; height: 10px">
    </div>Tarea Terminada
    <div class="gtaskblue" style="width: 10px; height: 10px"></div>Tarea Dentro de Tiempo
    <div class="gtaskyellow"  style="width: 10px; height: 10px">
    </div>Por Vencer
  </div>  


  