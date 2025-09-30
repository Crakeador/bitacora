<div class="row">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Catalogo
			<small>lista de las categorias registradas</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		</ol>
	</section>
	<!-- Main content -->
	<form id='frmC' name='frmC' method='post' action=''>
		<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
		<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
      <div class="col-md-12">
          <div class="text-left">
            <a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick();">
                <span class="glyphicon glyphicon-plus"></span>
                Ingresar categorias
            </a>
          </div>
      </div>
    	</br>
    	</br>
    	<section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body mailbox-messages">
                            <table id="viewlista" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Categorias</th>
                                    <th>Descripci&oacute;n</th>
                                    <th><div align="center">Estados</div></th>
                                    <th><div align="center">Acciones</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $products = CategoryData::getAll();
                                    // Crea tabla de Ventas
                                    foreach($products as $product) {
                                        echo '<tr>';
                                            echo '<td width="30%">'.$product->name.'</td>';
                                            echo '<td width="40%">'.$product->description.'</td>';
                                            echo '<td width="6%">';
												echo '<small>';
													if($product->active == 1){
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Activo</span>';
													}else{
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Inactivo</span>';
													}
												echo '</small>';
											echo '</td>';
											echo '<td width="8%">';
												echo '<div align="center">';
													echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$product->id.'\');"><i class="fa fa-trash"></i></button>';
													echo '<a href="?view=editcategory&id='.$product->id.'" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
												echo '</div>';
											echo '</td>';
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
	</form>
</div>
<!-- Page specific script -->
<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	function btn_EnviarOnClick($valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 if(idrol > 3){
			 sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
					title: 'Confirm',
					text: 'Are you sure to delete this message?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#987463',
					timer: 1500
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "./?view=newcategory";
	} //
</script>
