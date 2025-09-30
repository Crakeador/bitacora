<?php 
// Sistema de Rsporte de la dotacion entregadas

$sell = SellData::getByIdPerson($_GET["id"]); 
// print_r($sell); 
?>
<!-- Content Header (Page header) --> 
<section class="content-header">
	<h1>
		Reportes
		<small>lista de dotaci&oacute;n entregada</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=entregas"><i class="fa fa-book"></i> Talento Humano </a></li>
		<li class="active">resumen de Asignaci&oacute;n</li>
	</ol>
  <div class="btn-group pull-right">
    <button type="button" class="btn btn-success" onClick="btn_Imprimir(<?php echo $sell->id; ?>)"><i class="fa fa-tasks"></i> Imprimir </button>
    <button type="button" class="btn btn-default" data-toggle="dropdown">
      <i class="fa fa-download"></i> Descargar <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      <li><a href="report/onesell-word.php?id=<?php echo $sell->id; ?>">Word 2007 (.docx)</a></li>
    </ul>
  </div>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
  <?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
  <?php
    $productos = $sell->getByIdProduct($_GET["id"]);
    $operations = OperationData::getAllProductsBySellId($_GET["id"]);
    $total = 0;
    
    if(isset($_COOKIE["selled"])){
        foreach ($operations as $operation) {
            // print_r($operation);
            $qx = OperationData::getQYesF($operation->product_id);
            // print "qx=$qx";
            $p = $operation->getProduct();
            if($qx==0){
                echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> no tiene existencias en inventario.</p>";
            }else if($qx<=$p->inventary_min/2){
                echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene muy pocas existencias en inventario.</p>";
            }else if($qx<=$p->inventary_min){
                echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene pocas existencias en inventario.</p>";
            }
        }
        setcookie("selled","",time()-18600);
    }
  ?>
  <table class="table table-bordered" border=0>
  <?php
  if($sell->person_id!=""):
    $client = $sell->getPerson();
    echo '<tr>';
      echo '<td style="width:150px;">Cliente</td>';
      echo '<td>'.utf8_encode($client->idcard).'-'.$client->name.'</td>'; // utf8_encode()
    echo '</tr>';
  endif;
  if($sell->user_id!=""):
  $user = $sell->getUser();
  ?>
  <tr>
      <td>Atendido por</td>
      <td><?php echo $user->name." ".$user->lastname; //utf8_encode() ?></td> 
  </tr>
  <?php endif; ?>
  </table>
  <br>
  <table class="table table-bordered table-hover">
      <thead>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Categoria</th>
          <th>Descuento</th>
          <th>Entregado</th>
      </thead>
    <?php
      foreach($productos as $base){
        echo '<tr>';
        echo '<td>'.$base["producto"].'</td>';
        echo '<td>'.$base["cantidad"].'</td>';
        echo '<td>'.utf8_encode($base["categoria"]).'</td>';
        echo '<td>$ '.number_format($base["descuento"],2,".",",").'</td>';
        echo '<td>'.$base["entregado"].'</td>';
        echo '</tr>';
      }
      ?>
  </table>
  </br></br>
  <div class="col-md-8">
      <table class="table table-bordered">
          <tr>
              <td width="84"><h4>Descontado:</h4></td>
              <td width="129"><h4>$ <?php echo number_format($sell->discount,2,'.',','); ?></h4></td>
              <td width="26">&nbsp;</td>
              <td width="501" align="right">............................................................................</br><?php echo utf8_encode($client->name); ?></br><?php echo utf8_encode($client->idcard); ?></td>
          </tr>
      </table>
  </div>
</section>
</br></br>
</br></br>
</br></br>
<?php else:?>
    501 Internal Error
<?php endif; ?>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/resumen_pdf.php?id='+$id,'Entrega de Dotacion','','1024','768','true');
	}
</script>