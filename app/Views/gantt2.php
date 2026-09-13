<!DOCTYPE html>
<html lang="en" class="no-js">

<!-- Head -->
  <head>
  <!-- Meta data -->
    <meta charset="utf-8">
    <title>gantt</title>
    <meta name="description" content="FREE javascript gantt - jsGantt Improved HTML, CSS and AJAX only">
    <meta name="keywords" content="jsgantt-improved free javascript gantt-chart html css ajax">
    <meta name="viewport" content="width=device-width,initial-scale=1">

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
  </head>

<!-- Content -->
  <body >
  <?php
  $proyecto_nombre="";
  $id_lider=0;
  $id_backup=0;
  foreach ($nombre_proyecto as $key) {
    $proyecto_nombre=$key->nombre_proyecto;
    $id_lider=$key->capitan;
    $id_backup=$key->subcapitan;
  }
$imparte=login_model()->extre_impartidor($id_lider)->getResult();
$lider="";
foreach ($imparte as $key) {
  $lider=$key->nombre;
}
$backup="";
$imparte=login_model()->extre_impartidor($id_backup)->getResult();
foreach ($imparte as $key) {
  $backup=$key->nombre;
}
  ?>
  <table>
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
var g = new JSGantt.GanttChart(document.getElementById('embedded-Gantt'), 'week');
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
  ?>
  g.AddTaskItem(new JSGantt.TaskItem(1<?php echo $conteo?>,  '<?php echo $key->tarea?>',         '<?php echo $key->f_inicio?>','<?php echo $key->f_fin?>', 'gtaskblue',   '',                 0, '<?php echo substr ($key->nombre,0,8)?>',   0,  0,      1,       1,     '',      '',      '',      g));
  <?php
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
        </div>
      </div>
    
      
    


  </body>

</html>
