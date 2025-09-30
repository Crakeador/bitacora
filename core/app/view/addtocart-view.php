<?php
//Ingreso de los articulos de dotacion del personal
if(!isset($_SESSION["cart"])){	//echo '</br>No definido...!!!';	$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);	$_SESSION["cart"] = array($product);
	$cart = $_SESSION["cart"];
	///////////////////////////////////////////////////////////////////
	$num_succ = 0;
	$process=false;
	$errors = array();
	foreach($cart as $c){
		$q = OperationData::getQYesF($c["product_id"]);
		if($c["q"]<=$q){
			$num_succ++;
		}else{
			$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario 111.");
			$errors[count($errors)] = $error;
		}
	}
	///////////////////////////////////////////////////////////////////

	//echo $num_succ;
	if($num_succ==count($cart)){
		$process = true;
	}
	if($process==false){
		unset($_SESSION["cart"]);
		$_SESSION["errors"] = $errors;

		print '<script>window.location="?view=sell";</script>';
	}
}else{
	//echo '</br>Definido...!!!';
	$found = false;
	$cart = $_SESSION["cart"];	
	$errors = array();
	$index=0;

	$q = OperationData::getQYesF($_POST["product_id"]);
	$can = true;
	if($_POST["q"]<=$q){
		// No suppera el inventario	}else{		$error = array("product_id"=>$_POST["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario");		$errors[count($errors)] = $error;		$can=false;	}
	if($can==false){		$_SESSION["errors"] = $errors;
		if(isset($_GET['valor']) && $_GET['valor'] == 1)			print "<script>window.location='index.php?view=opedot.guardia';</script>";		else			print "<script>window.location='index.php?view=opedot.puestos';</script>"; 
	} 
	if($can==true){		foreach($cart as $c){			if($c["product_id"]==$_POST["product_id"]){				$found=true;				break;			}			$index++;		}
		if($found==true){			$q1 = $cart[$index]["q"];			$q2 = $_POST["q"];			$cart[$index]["q"]=$q1+$q2;			$_SESSION["cart"] = $cart;		}
		if($found==false){			$nc = count($cart);			$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);			$cart[$nc] = $product;			// se actualiza el carrito			$_SESSION["cart"] = $cart;		}	}}
if(isset($_GET['valor']) && $_GET['valor'] == 1)	print "<script>window.location='index.php?view=opedot.guardia';</script>";else	print "<script>window.location='index.php?view=opedot.puestos';</script>";
