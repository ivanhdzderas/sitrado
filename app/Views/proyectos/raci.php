      <?php
      $arreglo_genenral=array();
      foreach ($partes as $key) {
        foreach ($tareas[$key->tarea] as $alfa ) {
          $texto=explode("-",$alfa);
          array_push($arreglo_genenral, $texto[1]);
          //print_r($alfa."<br />");
        }
        //print_r($tareas[$key->tarea]);
      }
      $participantes=array_unique($arreglo_genenral);
      ?>
<style>
body{
      font-size: 1rem;

}
    h3 {
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  font-size: 18px;
  font-style: normal;
  font-variant: normal;
  font-weight: 500;
  line-height: 15.4px;
  color:#051D4D;

}
.mini{
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  font-size: 15px;
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

div.vertical
{
 margin-left: -100px;
 position: absolute;
 width: 215px;
 transform: rotate(-90deg);
 -webkit-transform: rotate(-90deg); /* Safari/Chrome */
 -moz-transform: rotate(-90deg); /* Firefox */
 -o-transform: rotate(-90deg); /* Opera */
 -ms-transform: rotate(-90deg); /* IE 9 */
}

th.vertical
{
  width: 30px;
 font-weight: normal;
 font-size: 16px;
 height: 280px;
 line-height: 15px;
 text-align: left;
}
.head{
   /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+33,b7df2d+100;Green+3D+%234 */
background: #f8ffe8; /* Old browsers */
background: -moz-linear-gradient(top, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8ffe8', endColorstr='#b7df2d',GradientType=0 ); /* IE6-9 */
  
}

.color{
 /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#7abcff+0,60abf8+44,4096ee+100;Blue+3D+%2314 */
background: #7abcff; /* Old browsers */
background: -moz-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #7abcff 0%,#60abf8 44%,#4096ee 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 ); /* IE6-9 */
    
}
  </style>
  
  
  <table width="95%"  >
    <tr>
      <td width="75%">
        <img src="<?php echo base_url()?>assets/img/logo.jpg" width="90px">
      </td>
      <td align="right" >
        <table width="100%"  >
          
          <tr>
            <td colspan="3" align="right">
            <h3><b>Synergy to Business</b></h3>
              <h3 class="tit"><b>Grafica RACI</b></h3>
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
              <label class="mini">MP-F-14</label>
            </td>
            <td>
              <label class="mini">0</label>
            </td>
            <td>
              <label class="mini">25/09/2017</label>
            </td>
          </tr>
        </table>
      </td>
      <td>

      </td>
    </tr>
  </table>
  <br / >

<?php 
//print_r($tareas);
//print_r($participantes);
$cuantos=count($participantes);
$bucador=array("R","A","C","I");
$diferenciales=0;
?>
  <table border="0" cellspacing="0">
    <tr>
      <td></td>
      <td colspan="<?php echo $cuantos?>">
        <center><h1>Personal</h1></center>
      </td>
    </tr>
    <tr >
      <td valign="bottom" ><b style="color: #ff8c00">Actividades</b></td>
      <?php
      foreach ($participantes as $key) {
        ?>
        <th class="head vertical" style='border-width: 0.5px;border-style: solid;border-color: #000000;'>
          <div class="vertical"><?php echo $key?></div>
        </th>
        <?php
      }
      ?>
    </tr>
      <?php
      foreach ($partes as $key) {
        
          ?>
            <tr>
              <td class="color" style='border-width: 0.5px;border-style: solid;border-color: #000000;'><?php echo $key->tarea?></td>
              <?php
                foreach ($participantes as $participa) {
                  echo "<td style='border-width: 0.5px;border-style: solid;border-color: #000000;'>";
                  foreach ($bucador as $clave) {
                    $bus=array_search($clave."-".$participa,$tareas[$key->tarea]);
                      
                      if ($bus!==false){
                          echo $clave;
                        
                      }
                  }
                  echo "</td>";
                }
              ?>
            </tr>
          <?php
      }
      ?>
   
  </table>

<div>
  <br />
  <br />
  Nomenclaturas   <br />
  R - Responsible<br />
  A - Accountable<br />
  C - Consulted<br />
  I - Informed<br />
</div>