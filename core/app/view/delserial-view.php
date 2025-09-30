<?php

$operations = OperationData::getAllByProductId($_GET["id"]);
$product = ProductData::getById($_GET["id"]);

foreach ($operations as $op) {
	$op->del();
}

$product->del();
Core::redir("resumenpuesto");
