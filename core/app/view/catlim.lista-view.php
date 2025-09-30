<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h1>Articulos</h1>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
        Nuevo Articulo
      </button>
      <br>
      <br>
      <?php
        $users = ProductData::getProduct(6);
        // print_r($users);
        if(count($users)>0){
          // si hay usuarios ?>
          <div class="box box-primary">
            <div class="box-body">
              <table id="viewlista" class="table table-bordered table-hover datatable">
                <thead>
                  <th>Nombre</th>
                  <th>Categoria</th>                
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Activo</th>
                  <th>Creacion</th>
                  <th></th>
                </thead>
                <?php
                  foreach($users as $user){
                    ?>
                      <tr>
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo CategoryData::getById($user->category_id)->name; ?></td>
                        <td><?php echo $user->price_in; ?></td>
                        <td><?php echo $user->price_out; ?></td>
                        <td><?php if($user->is_active==1){ echo "<i class='fa fa-check'></i>"; }?></td>
                        <td><?php echo $user->created_at; ?></td>
                        <td style="width:130px;">
                        <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editModal<?php echo $user->id; ?>">
                          Editar
                        </button>
                        <a href="index.php?action=posts&opt=del&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
                      </tr>
                    <?php
                    }
                  ?>
              </table>
              <?php foreach($users as $user):?>
                <!-- Modal -->
                <div class="modal fade" id="editModal<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header" style="background:#3c8dbc; color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar producto</h4>
                      </div>                      
                      <div class="modal-body">
                        <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=posts&opt=update" role="form">
                          <div class="box-body">
                            <div class="col-xs-12">   
                              <div class="form-group">               
                                <div class="input-group">              
                                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                  <select name="category_id" class="form-control" required>
                                    <option value="">-- SELECCIONAR --</option>
                                    <?php foreach(CategoryData::getAll() as $g):?>
                                      <option value="<?php echo $g->id; ?>"   <?php if($user->category_id==$g->id) { echo "selected"; } ?>><?php echo $g->name; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">              
                                <div class="input-group">              
                                  <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                                  <input type="text" class="form-control input-lg" id="nuevoCodigo" value="<?php echo $user->barcode; ?>" name="nuevoCodigo" placeholder="0DA85808DS08" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
                                </div>
                              </div>
                              <div class="form-group">              
                                <div class="input-group">              
                                  <span class="input-group-addon"><i class="fa fa-cart-plus"></i></span> 
                                  <input type="text" class="form-control input-lg" name="nuevaNombre" value="<?php echo $user->name; ?>" placeholder="Ingresar nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
                                </div>
                              </div>
                              <!-- ENTRADA PARA PRECIO COMPRA -->
                              <div class="form-group row">
                                <div class="col-xs-6">                
                                  <div class="input-group">                  
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" value="<?php echo $user->price_in; ?>" step="any" min="0" placeholder="Precio de entrada" required>
                                  </div>
                                </div>
                                <!-- ENTRADA PARA PRECIO VENTA -->
                                <div class="col-xs-6">                
                                  <div class="input-group">                  
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" value="<?php echo $user->price_out; ?>" step="any" min="0" placeholder="Precio de salida" required>
                                  </div>
                                </div>
                              </div>
                              <!-- ENTRADA PARA SUBIR FOTO -->
                              <div class="form-group">
                                <div class="col-xs-6"> 
                                  <div class="panel">SUBIR IMAGEN</div>
                                  <input type="file" class="nuevaImagen" name="nuevaImagen">
                                  <p class="help-block">Peso máximo de la imagen 2MB</p>
                                  <img src="assets/images/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                                </div>
                              </div>
                            </div>
                          </div>                          
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                              <button type="submit" class="btn btn-primary">Guardar producto</button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
      <?php
        }else{
          echo "<p class='alert alert-danger'>No hay Articulos</p>";
        }
      ?>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar producto</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="addcategory" action="index.php?action=processart&opt=add" role="form">
          <div class="alert alert-info alert-styled-left text-blue-800 content-group">
              <span class="text-semibold">Estimado usuario</span>
              Los campos remarcados con <span class="text-danger"> * </span> son necesarios.
              <button type="button" class="close" data-dismiss="alert">×</button>
              <input type="hidden" id="txtID" name="txtID" class="form-control" value="">
              <input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="Registro">
          </div>
          <div class="box-body">
            <div class="col-xs-12">   
              <div class="form-group">               
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <select name="category_id" class="form-control" required>
                    <option value="">-- SELECCIONAR --</option>
                    <?php foreach(CategoryData::getAll() as $g):?>
                      <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                  <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="0DA85808DS08" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
                </div>
              </div>
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-cart-plus"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevaNombre" placeholder="Ingresar nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" required>
                </div>
              </div>
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                  <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Inventario Inicial" required>
                </div>
              </div>
            </div>
            <!-- ENTRADA PARA PRECIO COMPRA -->
            <div class="form-group row">
              <div class="col-xs-6">                
                <div class="input-group">                  
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                  <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" step="any" min="0" placeholder="Precio de entrada" required>
                </div>
              </div>
              <!-- ENTRADA PARA PRECIO VENTA -->
              <div class="col-xs-6">                
                <div class="input-group">                  
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                  <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de salida" required>
                </div>
              </div>
            </div>
            <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="col-xs-6"> 
                <div class="panel">SUBIR IMAGEN</div>
                <input type="file" class="nuevaImagen" name="nuevaImagen">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="assets/images/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>