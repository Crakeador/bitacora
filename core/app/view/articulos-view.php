<section class="content-header">
    <h1>
        Administrar productos
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar productos</li>
    </ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <div class="box">
        <div class="box-header with-border">
            <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modalAgregarProducto">
                Agregar producto
            </button>
            <div style="float: right">
                <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modalAgregarExcelProducto">
                    Descargar precios
                </button>
            </div>
        </div>
        <div class="box-body">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <form id='frmC' name='frmC' method='post' action=''>
                    <input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
                    <input type='hidden' name='hid_frmIsAmd' id='hid_frmIsAmd' value='<?php echo $_SESSION['is_admin']; ?>'/>
                    <input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
                    <table id="viewlista" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><div align="center">Imagen</div></th>
                            <th><div align="center">Nombre</div></th>
                            <th><div align="center">Descripci&oacute;n</div></th>
                            <th width="8%"><div align="center">Precio Entrada</div></th>
                            <th width="8%"><div align="center">Precio Salida</div></th>
                            <th>Categoria</th>
                            <th width="8%"><div align="center">Inventario Inicial</div></th>
                            <th width="8%"><div align="center">Entregados</div></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products = ProductData::getTodos();

                                // Crea la tabla de Productos
                                foreach($products as $tables) {
                                        echo '<tr>';
                                            echo '<td>';
                                            echo '<div align="center">';
                                                if($tables->image!="")
                                                        echo '<img src="storage/products/'.$tables->image.'" style="width:64px;">';
                                                    else
                                                        echo '<img src="storage/products/default-50x50.gif" style="width:64px;">';
                                                echo '</div>';
                                            echo '</td>';
                                            echo '<td>';
                                                echo '<a class="text-primary" href="index.php?view=editproduct&id='.$tables->id.'">'.$tables->name.'</a>';
                                                echo '<div class="mini-tabla">';
                                                    echo '<small>';
                                                        echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
                                                        echo '<span class="text-success">&nbsp;Activo</span>&nbsp;·&nbsp;';
                                                        echo '<span class="glyphicon glyphicon-barcode"></span> '.$tables->barcode;
                                                    echo '</small>';
                                                echo '</div>';
                                            echo '</td>';
                                            echo '<td>'.$tables->description.'</td>';
                                            echo '<td><div align="right">'.number_format($tables->price_in,2,'.',',').'</div></td>';
                                            echo '<td><div align="right">'.number_format($tables->price_out,2,'.',',').'</div></td>';
                                            echo '<td>';
                                                if($tables->category_id!=null){
                                                    echo utf8_encode($tables->getCategory()->name);
                                                }else{
                                                    echo "Sin Categoria"; }
                                            echo '</td>';
                                            $valor=$tables->getOperation()->q-$tables->getTotal();
                                            echo '<td><div align="right">'.$tables->getOperation()->q.'</div></td>';
                                            echo '<td><div align="right">'.$valor.'</div></td>';
                                        echo '</tr>';
                                    }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>

<!--=====================================
MODAL venta produc
======================================-->
<div id="modalBackupDB" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Opciones para el respaldo de la base de datos</h4>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->

            <div class="modal-body">
                <center>
                    <a class="btn btn-app" onclick="DownloadDb();">
                        <i class="fa fa-save"></i> Guardar respaldo
                    </a>

                    <a class="btn btn-app" onclick="showemail();"> 
                        <i class="fa fa-envelope"></i> Enviar por correo
                    </a>
                </center>


                <div class="form-group" style="display: none;" id="inputemail">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                        <input type="email" class="form-control input-lg" name="emailaenviar" id="emailaenviar" placeholder="Ingresar correo electronico" required="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-lg" onclick="enviarmail();">Enviar!</button>
                        </span>
                    </div>
                </div>
            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            </div>    

        </div>

    </div>

</div>

<!-------------------------
* Modal Fechas
+ --------------------- -->
<div id="modalFechas" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>
            </div>
            <form method="POST" action="extensiones/tcpdf/pdf/VentasPorCliente.php" target="_blank">  
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">
                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>
    </div>
</div>
<!---------------------
Modal de fechas por pedidos
---------------------->
<div id="modalFechasPedidos" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">

                <button type="button" class="close" data-dismiss="modal">×</button>

                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>

            </div>
            <form method="POST" action="http://posinventario.tresniveles.com/extensiones/tcpdf/pdf/PedidosPorCliente.php" target="_blank">  

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">

                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>

    </div>

</div>

<div id="modalFechasCredito" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->

            <div class="modal-header" style="background:#3c8dbc; color:white">

                <button type="button" class="close" data-dismiss="modal">×</button>

                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>

            </div>
            <form method="GET" action="http://posinventario.tresniveles.com/extensiones/tcpdf/pdf/CYC.php" target="_blank">  

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">

                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>

    </div>

</div>

<div id="modalVentasEstilo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>
            </div>
            <form method="POST" action="http://posinventario.tresniveles.com/extensiones/tcpdf/pdf/VentasPorEstilo.php" target="_blank">  
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">

                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">

                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>

    </div>

</div>


<div id="modalPedidosEstilo" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">



            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->

            <div class="modal-header" style="background:#3c8dbc; color:white">

                <button type="button" class="close" data-dismiss="modal">×</button>

                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>

            </div>
            <form method="POST" action="http://posinventario.tresniveles.com/extensiones/tcpdf/pdf/PedidosPorEstilo.php" target="_blank">  

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">

                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>

    </div>

</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalAgregarProducto" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="nuevaImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="assets/images/anonymous.png" class="img-thumbnail previsualizar" width="200px">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required="">
                                        <option value="">Selecionar categoría</option>
                                        <option value="37">Regalos</option><option value="36">Regalos</option><option value="35">Panetones</option><option value="34">Utiles escolares</option><option value="33">hola</option><option value="32">Mouse</option><option value="31">FRIOS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <input type="text" class="form-control input-lg" name="descripcion" id="descripcion" placeholder="Ingrese nombre del producto" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <font color="red"><h5 style="font-weight: bold;">Seleccione Clave de producto SAT:</h5></font>
                                <input type="text" name="buscadorsat2" id="buscadorsat2" onkeyup="busquedaclavessatproductos()" placeholder="Ingrese nombre o clave del sat..." class="form-control input-lg">
                                <div id="displaybusquedasatproduc" class="row" style="padding:5px 15px; z-index:100000000; position: absolute; background-color: #fff; width: 100%"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">
                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <input type="text" step="any" class="form-control input-lg" id="nuevaCategoriaSat" value="31162800" name="nuevaCategoriaSat" placeholder="Esperando clave de producto del sat..." onkeypress="return false;">
                                    <input type="hidden" id="sat_Unidad" name="sat_Unidad" value="PZA">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                                    <input type="text" class="form-control input-lg" id="nuevoCodigo" onchange="valiCod();" name="nuevoCodigo" placeholder="Ingresar código" required="" autofocus="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA STOCK -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                    <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" name="nuevoMaximo" min="0" placeholder="Ingrese máximo">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <!-- ENTRADA PARA PRECIO VENTA -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" name="nuevoMinimo" min="0" placeholder="Ingrese minimo">
                                </div>
                                <br>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" step="any" min="1" placeholder="Precio de compra" required="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"> Precio 1 <i class="fa fa-usd"></i></span> 
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required="">
                                </div>
                            </div>
                        </div>
                        <!-- CHECKBOX PARA PORCENTAJE -->
                        <!--                                <div class="col-xs-6">
              
                                                            <div class="form-group">
                        
                                                                <label>
                        
                                                                    <input type="checkbox" class="minimal porcentaje" checked>
                                                                    Utilizar procentaje
                                                                </label>
                        
                                                            </div>
                        
                                                        </div>-->

                        <!-- ENTRADA PARA PORCENTAJE -->

                        <!--                                <div class="col-xs-6" style="padding:0">
                        
                                                            <div class="input-group">
                        
                                                                <input type="text" class="form-control input-lg nuevoPorcentaje" onkeypress="return valida(event)" value="40" required>
                        
                                                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        
                                                            </div>
                        
                                                        </div>-->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon">Precio 2<i class="fa fa-arrow-down"></i></span> 

                                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta2" name="nuevoPrecioVenta2" step="any" min="0" placeholder="Precio de DC Remisión" required="">

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon">Precio 3<i class="fa fa-arrow-down"></i></span> 

                                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta3" name="nuevoPrecioVenta3" step="any" min="0" placeholder="Precio 3 Facturado" required="">

                                </div>
                            </div>
                        </div>







                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary">Guardar producto</button>

                </div>

            </form>

              

        </div>

    </div>

</div>



<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Editar producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="editarImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="./Inventa_files/anonymous.png" class="img-thumbnail previsualizar" width="350px">
                                <input type="hidden" name="imagenActual" id="imagenActual">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 


                                    <select class="form-control input-lg" name="editarCategoria" required="">

                                        <option id="editarCategoria"></option>
                                        <option value="">Selecionar categoría</option>
                                        <option value="37">Regalos</option><option value="36">Regalos</option><option value="35">Panetones</option><option value="34">Utiles escolares</option><option value="33">hola</option><option value="32">Mouse</option><option value="31">FRIOS</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->

                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                                    <input type="text" class="form-control input-lg" name="descripcion_edit" id="descripcion_edit" placeholder="Ingrese nombre" required="">

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">

                            <font color="red"><h5 style="font-weight: bold;">Seleccione Clave de producto SAT:</h5></font>
                            <div class="form-group">



                                <input type="text" name="buscadorsat3" id="buscadorsat3" onkeyup="busquedaclavessatproductosedicion()" placeholder="Ingrese nombre o clave del sat..." class="form-control input-lg">

                                <div id="displaybusquedasatproduc2" class="row" style="padding:5px 15px; z-index:100000000; position: absolute; background-color: #fff; width: 100%"></div>




                            </div>

                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">
                            <!-- ENTRADA PARA EL CÓDIGO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                                    <input type="text" step="any" class="form-control input-lg" id="editCategoriaSat" name="editCategoriaSat" placeholder="Esperando clave de producto del sat..." onkeypress="return false;">
                                    <input type="hidden" id="sat_Unidad_edita" name="sat_Unidad_edita">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA EL CÓDIGO -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                                    <input type="hidden" class="form-control input-lg" id="idEditarPro" name="idEditarPro" readonly="" required="">
                                    <input type="hidden" class="form-control input-lg" id="codigoDir" name="codigoDir" required="">
                                    <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" onchange="valiCodEdita();" required="" placeholder="Código del producto">

                                </div>

                            </div>
                        </div>


                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA STOCK -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                                    <input type="number" class="form-control input-lg" id="traerStock" name="traerStock" placeholder="Stock del producto" min="0" readonly="readonly">

                                </div>

                            </div>  
                        </div>

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA STOCK -->

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" placeholder="Agregar stock al producto" min="0" value="0" required="required">
                                    <input type="hidden" class="form-control input-lg" id="editarStock_gnrl" name="editarStock_gnrl" placeholder="Agregar stock al producto" min="0" value="0" required="required">

                                </div>

                            </div>  
                        </div>



                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editMaximo" name="editMaximo" min="0" placeholder="Ingrese máximo">

                                </div>
                            </div>

                        </div>

                        <!-- ENTRADA PARA PRECIO VENTA -->

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editMinimo" name="editMinimo" min="0" placeholder="Ingrese minimo">

                                </div>
                            </div>
                        </div>



                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" placeholder="Precio de compra" step="any" min="0" required="">

                                </div>
                            </div>

                        </div>

                        <!-- ENTRADA PARA PRECIO VENTA -->

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon">Precio 1<i class="fa fa-usd"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" required="">

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon">Precio 2<i class="fa fa-arrow-down"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta2" name="editarPrecioVenta2" step="any" min="0" required="">

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">

                                    <span class="input-group-addon">Precio 3<i class="fa fa-arrow-down"></i></span> 

                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta3" name="editarPrecioVenta3" step="any" min="0" required="">

                                </div>
                            </div>
                        </div>

        </div>

    </div>

    <!--=====================================
    PIE DEL MODAL
    ======================================-->

    <div class="modal-footer">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>

    </div>

</form>
</div>
</div>
</div>

<!--====================
  Descontar
  =======================-->
<div id="modalBajar" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">×</button>

                    <h4 class="modal-title">Descontar productos del Stock</h4>

                </div>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                        <input type="hidden" class="form-control input-lg" id="idEditarPro2" name="idEditarPro2" readonly="" required="">
                                        <input type="hidden" class="form-control input-lg" id="estilo2" name="estilo2" readonly="" required="">
                                        <input type="hidden" class="form-control input-lg" id="stock_gnrl" name="stock_gnrl" readonly="" required="">
                                        <input type="number" class="form-control input-lg" id="traerStock2" name="traerStock2" placeholder="Stock del producto" min="0" readonly="readonly">

                                    </div>

                                </div>  
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                                        <input type="number" class="form-control input-lg" id="editarStock2" name="editarStock2" min="0" value="0" required="required">

                                    </div>

                                </div>   
                            </div>

                        </div>
                    </div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>

                </div>

            </form>

             
        </div>

    </div>

</div>

<!--=====================================
MODAL AGREGAR excel
======================================-->
<div id="modalAgregarExcelProducto" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Descargar lista de precios</h4>
            </div>
            <form role="form" method="get" action="http://posinventario.tresniveles.com/vistas/modulos/descargar-lista.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control" name="cat23goria" id="cat23goria" required="required">
                                    <option value="">Selecionar categoría</option>
                                    <option value="todas">Todas las categorias</option>
                                    <option value="37">Regalos</option><option value="36">Regalos</option><option value="35">Panetones</option><option value="34">Utiles escolares</option><option value="33">hola</option><option value="32">Mouse</option><option value="31">FRIOS</option>                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-default btn-flat btn-sm">Generar lista de precios</button>
                </div>
            </form>
             
        </div>
    </div>
</div>
