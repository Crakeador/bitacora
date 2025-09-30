<?php
// Precesar las ventas de los puesto y la dotacion 

if(isset($_SESSION["cart"])){
	$cart = $_SESSION["cart"];
	//var_dump($cart); echo '</br>';
	if(count($cart)>0){
		// antes de proceder con lo que sigue vamos a verificar que:
		// haya existencia de productos
		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){
			$q = OperationData::getQYesF($c["product_id"]);
			if($c["q"]<=$q){
				if(isset($_POST["is_oficial"])){
				$qyf =OperationData::getQYesF($c["product_id"]); /// son los productos que puedo facturar
				if($c["q"]<=$qyf){
					$num_succ++;
				}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto para facturar en inventario.");					
				$errors[count($errors)] = $error;
				}
				}else{
					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
					$num_succ++;
				}
			}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}
		}

		if($num_succ==count($cart)){
			$process = true;
		}

		if($process==false){
			$_SESSION["errors"] = $errors;
			if(isset($_GET))
				print "<script>window.location='index.php?view=sell';</script>";
			else
				print "<script>window.location='index.php?view=opedot.guardia';</script>";
		}

		//////////////////////////////////
		if($process==true){
			$sell = new SellData();
			$sell->user_id = $_SESSION["user_id"];

			$sell->total = $_POST["total"];
			$sell->discount = $_POST["discount"];

			if(isset($_POST["client_id"]) && $_POST["client_id"]!=""){
			 	$sell->person_id=$_POST["client_id"];
 				$s = $sell->add_with_client();
			}else{
 				$s = $sell->add();
			}

			foreach($cart as  $c){
				$op = new OperationData();
				$op->product_id = $c["product_id"] ;
				$op->operation_type_id=OperationTypeData::getByName("salida")->id;
				$op->sell_id=$s[1];
				$op->q= $c["q"];

				if(isset($_POST["is_oficial"])){
					$op->is_oficial = 1;
				}

				$add = $op->add();			 		

				unset($_SESSION["cart"]);
				setcookie("selled","selled");
			}
			if(isset($_GET["valor"])){
				$puesto = PuestoData::getById($_SESSION["id_puesto"]);
				$_SESSION["puesto"] = $puesto->descripcion;
				$_SESSION["valor"] = 1;
			}else{
				// Sin comentario
			}
			
			unset($_SESSION["id_cliente"]);
			unset($_SESSION["id_puesto"]);
			unset($_SESSION["id_person"]);
			print "<script>window.location='index.php?view=onesell&id=$s[1]';</script>"; 
		}
	}else{
		Core::alert("Error...!!!!", "No hay productos agregados al carrito...!!!", "error");
	}
}else{
	if($_POST["idcliente"] == "0"){	
		print "<script>window.location='index.php?view=prendas&error=1';</script>";
	}else{
		if(count($_POST["idarticulo"])>0){
			echo 'Total de Ventas: '.count($_POST["idarticulo"]).'</br>';
			
			var_dump($_POST);		
		}
	}
	
}
/*
array(8) {
  ["idventa"]=>
  string(0) ""
  ["idcliente"]=>
  string(2) "97"
  ["fecha_hora"]=>
  string(10) "2023-11-27"
  ["total_venta"]=>
  string(2) "50"
  ["idarticulo"]=>
  array(1) {
    [0]=>
    string(1) "3"
  }
  ["cantidad"]=>
  array(1) {
    [0]=>
    string(1) "1"
  }
  ["precio_venta"]=>
  array(1) {
    [0]=>
    string(2) "50"
  }
  ["descuento"]=>
  array(1) {
    [0]=>
    string(1) "0"
  }
} */