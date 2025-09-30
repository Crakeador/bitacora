<?php

$departamento = DepartamentoData::getById($_GET["id"]);
$departamento->recuperar();
Core::redir("catdep.lista");
