<?php
// Ingreso de los NUEVOS aspirantes
if(isset($_SESSION['id_card'])){
    $person = RespuestasData::getById($_SESSION['id_card']);
    if(isset($person->idcard)){
		echo '<script>
		         sweetAlert("Examen tecnico", "Ya se realizo la evaluacion...!!!", "error");
		         //window.location="./home";
		      </script>';
    }
}else{
    if(count($_POST)>0){
        $total = 0; $grupo1 = 0; $grupo2 = 0; $grupo3 = 0; $grupo4 = 0; $grupo5 = 0; $valor = 0;
        $preguntas = PreguntasData::getAll(); 
        //var_dump($_POST); echo '<br>----------------------------------------------------------------------<br>';
        foreach($preguntas as $tables) { 
            if($tables->grupo == 1){
                if($tables->id ==  1) 
                    if($tables->correcta == $_POST["resp101"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp101"].' ---------<br>';
                    }
                if($tables->id ==  2) 
                    if($tables->correcta == $_POST["resp102"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp102"].' ---------<br>';
                    }
                if($tables->id ==  3) 
                    if($tables->correcta == $_POST["resp103"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp103"].' ---------<br>';
                    }
                if($tables->id ==  4) 
                    if($tables->correcta == $_POST["resp104"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp104"].' ---------<br>';
                    }
                if($tables->id ==  5) 
                    if($tables->correcta == $_POST["resp105"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp105"].' ---------<br>';
                    }
                if($tables->id ==  6) 
                    if($tables->correcta == $_POST["resp106"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp106"].' ---------<br>';
                    }
                if($tables->id ==  7) 
                    if($tables->correcta == $_POST["resp107"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp107"].' ---------<br>';
                    }
                if($tables->id ==  8) 
                    if($tables->correcta == $_POST["resp108"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp108"].' ---------<br>';
                    }
                if($tables->id ==  9) 
                    if($tables->correcta == $_POST["resp109"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp19"].' ---------<br>';
                    }
                if($tables->id == 10) 
                    if($tables->correcta == $_POST["resp110"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp110"].' ---------<br>';
                    }
                if($tables->id == 11) 
                    if($tables->correcta == $_POST["resp111"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp111"].' ---------<br>';
                    }
                if($tables->id == 12) 
                    if($tables->correcta == $_POST["resp112"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp112"].' ---------<br>';
                    }
                if($tables->id == 13) 
                    if($tables->correcta == $_POST["resp113"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp113"].' ---------<br>';
                    }
                if($tables->id == 14) 
                    if($tables->correcta == $_POST["resp114"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp114"].' ---------<br>';
                    }
                if($tables->id == 15) 
                    if($tables->correcta == $_POST["resp115"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp115"].' ---------<br>';
                    }
                if($tables->id == 16) 
                    if($tables->correcta == $_POST["resp116"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp116"].' ---------<br>';
                    }
                if($tables->id == 17) 
                    if($tables->correcta == $_POST["resp117"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp117"].' ---------<br>';
                    }
                if($tables->id == 18) 
                    if($tables->correcta == $_POST["resp118"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp118"].' ---------<br>';
                    }
                if($tables->id == 19) 
                    if($tables->correcta == $_POST["resp119"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp19"].' ---------<br>';
                    }
                if($tables->id == 20) 
                    if($tables->correcta == $_POST["resp120"]) {
                        $grupo1 = $grupo1 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["resp120"].' ---------<br>';
                    }
            }
            if($tables->grupo == 2){
                if($tables->id == 22) 
                    if($tables->correcta == $_POST["defi101"]) {
                        $grupo2 = $grupo2 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["defi101"].' ---------<br>';
                    }
                if($tables->id == 23) 
                    if($tables->correcta == $_POST["defi102"]) {
                        $grupo2 = $grupo2 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["defi102"].' ---------<br>';
                    }
            }
            if($tables->grupo == 3){
                if($tables->id == 24) 
                    if($tables->correcta == $_POST["sisn101"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn101"].' ---------<br>';
                    }
                if($tables->id == 25) 
                    if($tables->correcta == $_POST["sisn102"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn102"].' ---------<br>';
                    }
                if($tables->id == 26) 
                    if($tables->correcta == $_POST["sisn103"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn103"].' ---------<br>';
                    }
                if($tables->id == 27) 
                    if($tables->correcta == $_POST["sisn104"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn104"].' ---------<br>';
                    }
                if($tables->id == 28) 
                    if($tables->correcta == $_POST["sisn105"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn105"].' ---------<br>';
                    }
                if($tables->id == 29) 
                    if($tables->correcta == $_POST["sisn106"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn106"].' ---------<br>';
                    }
                if($tables->id == 31) 
                    if($tables->correcta == $_POST["sisn107"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn107"].' ---------<br>';
                    }
                if($tables->id == 32) 
                    if($tables->correcta == $_POST["sisn108"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo3.' - '.$tables->correcta.' == '.$_POST["sisn108"].' ---------<br>';
                    }
                if($tables->id == 33) 
                    if($tables->correcta == $_POST["sisn109"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["sisn109"].' ---------<br>';
                    }
                if($tables->id == 34) 
                    if($tables->correcta == $_POST["sisn110"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["sisn110"].' ---------<br>';
                    }
                if($tables->id == 35) 
                    if($tables->correcta == $_POST["sisn111"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["sisn111"].' ---------<br>';
                    }
                if($tables->id == 36) 
                    if($tables->correcta == $_POST["sisn112"]) {
                        $grupo3 = $grupo3 + 0.25;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["sisn112"].' ---------<br>';
                    }
            }
            if($tables->grupo == 4){
                if($tables->id == 37) 
                    if($tables->correcta == $_POST["serie1"]) {
                        $grupo4 = $grupo4 + 2.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["serie1"].' ---------<br>';
                    }
                if($tables->id == 38) 
                    if($tables->correcta == $_POST["serie2"]) {
                        $grupo4 = $grupo4 + 2.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$total.' - '.$tables->correcta.' == '.$_POST["serie2"].' ---------<br>';
                    }
            }
            if($tables->grupo == 5){
                if($tables->id == 39) //1
                    if($tables->correcta == $_POST["cono101"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 40) //2
                    if($tables->correcta == $_POST["cono102"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono102"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 41) //3
                    if($tables->correcta == $_POST["cono103"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono103"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 42) //4
                    if($tables->correcta == $_POST["cono104"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono104"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 43) //5
                    if($tables->correcta == $_POST["cono105"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono105"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 44) //6
                    if($tables->correcta == $_POST["cono106"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono106"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono106"].' ---------<br>';
                    }
                if($tables->id == 45) //7
                    if($tables->correcta == $_POST["cono107"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono107"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 46) //8
                    if($tables->correcta == $_POST["cono108"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono108"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 47) //9
                    if($tables->correcta == $_POST["cono109"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono109"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
                if($tables->id == 48) // 10
                    if($tables->correcta == $_POST["cono110"]) {
                        $grupo5 = $grupo5 + 0.50;
                        //echo '<br>-------- Pregunta: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono110"].' ---------<br>';
                    }else{
                        echo '<br>-------- Errrorrr: '.$tables->id.' Pregunta: '.$tables->fase.' Total: '.$grupo5.' - '.$tables->correcta.' == '.$_POST["cono101"].' ---------<br>';
                    }
            }
        }
        
        $total = 0;
        $os = array("PISTOLA", "POLICIA", "PERSECUCION", "PERCUSION", "PELIGRO", "PROCEDIMIENTO", "PRECAUCION", "PREVENCION", "PATRULLAJE", "PLANIFICACION", "PROTOCOLO", "PUESTO", "PANICO", "PLAN", "PAZ", "PATRULLA", "PERITAJE", "PERICIA", "PERITO", "PERFIL", "POBLACION", "POLITICA", "PENAL", "PENALIZACION", "PANDILLA", "PARAMETRO", "PERCEPCION", "PORTE", "PREVENTIVA", "PROTEGIDO", "PASE", "PENITENCIARIO", "PENITENCIARIA", "PATRIMONIO", "PROTECCION", "PUERTA", "PASO", "PARTIDA", "PERMISO", "PRISION", "PROGRAMA", "PRUEBA", "PROBLEMA -PROTEGER", "PELIGROSO", "PROPAGACION", "PROPOSITO", "PENDIENTE", "PERMANECER", "PERSONAL", "PERSONALIDAD", "POSTURA", "POTENCIAL", "PODER", "PRESERVAR", "PRIORIDAD", "PRACTICA", "PRESENCIA", "PREPARACION", "PRIMERO", "PRINCIPAL", "PROXIMO", "PROFUNDO", "PUNTO", "PROPIEDAD", "PUNTUALIDAD", "PARTICULAR", "PERTIENENTE", "PARTE");

        if (in_array($_POST["referencia1"], $os)) $total = $total + 0.25;
        if (in_array($_POST["referencia2"], $os)) $total = $total + 0.25;
        if (in_array($_POST["referencia3"], $os)) $total = $total + 0.25;
        if (in_array($_POST["referencia4"], $os)) $total = $total + 0.25;
        if (in_array($_POST["referencia5"], $os)) $total = $total + 0.25;
        if (in_array($_POST["referencia6"], $os)) $total = $total + 0.25;
        
        $grupos = ($grupo2+$grupo3+$total);
        echo 'Total de Grupo Personalidad: '.$grupo1;
        echo '<br>----------------------------------------------------------------------<br>';
        echo 'Total de Grupo Actitudes Verbales: '.$grupo2.' '.$grupo3.' '.$total.' '.$grupos;
        echo '<br>----------------------------------------------------------------------<br>';
        echo 'Total de Grupo Razonamiento Abstracto: '.$grupo4;
        echo '<br>----------------------------------------------------------------------<br>';
        echo 'Total de Grupo Conocimiento: '.$grupo5;
        echo '<br>----------------------------------------------------------------------<br>';
        $valor = $grupo1+$grupo2+$grupo3+$grupo4+$grupo5+$total;
        echo '<br>----------------------------------------------------------------------<br>';
        echo 'Total de Respuesta: '.$valor;
        echo '<br>----------------------------------------------------------------------<br>';
        
        $user = new RespuestasData();

        $user->resp101 = (int) $_POST["resp101"];
        $user->resp102 = (int) $_POST["resp102"];
        $user->resp103 = (int) $_POST["resp103"];
        $user->resp104 = (int) $_POST["resp104"];
        $user->resp105 = (int) $_POST["resp105"];
        $user->resp106 = (int) $_POST["resp106"];
        $user->resp107 = (int) $_POST["resp107"];
        $user->resp108 = (int) $_POST["resp108"];
        $user->resp109 = (int) $_POST["resp109"];
        $user->resp110 = (int) $_POST["resp110"];
        $user->resp111 = (int) $_POST["resp111"];
        $user->resp112 = (int) $_POST["resp112"];
        $user->resp113 = (int) $_POST["resp113"];
        $user->resp114 = (int) $_POST["resp114"];
        $user->resp115 = (int) $_POST["resp115"];
        $user->resp116 = (int) $_POST["resp116"];
        $user->resp117 = (int) $_POST["resp117"];
        $user->resp118 = (int) $_POST["resp118"];
        $user->resp119 = (int) $_POST["resp119"];
        $user->resp120 = (int) $_POST["resp120"];
        $user->defi101 = (int) $_POST["defi101"];
        $user->defi102 = (int) $_POST["defi102"];
        $user->sisn101 = (int) $_POST["sisn101"];
        $user->sisn102 = (int) $_POST["sisn102"];
        $user->sisn103 = (int) $_POST["sisn103"];
        $user->sisn104 = (int) $_POST["sisn104"];
        $user->sisn105 = (int) $_POST["sisn105"];
        $user->sisn106 = (int) $_POST["sisn106"];
        $user->sisn107 = (int) $_POST["sisn107"];
        $user->sisn108 = (int) $_POST["sisn108"];
        $user->sisn109 = (int) $_POST["sisn109"];
        $user->sisn110 = (int) $_POST["sisn110"];
        $user->sisn111 = (int) $_POST["sisn111"];
        $user->sisn112 = (int) $_POST["sisn112"];
        $user->serie1 = (int) $_POST["serie1"];
        $user->serie2 = (int) $_POST["serie2"];
        $user->referencia1 = strtoupper($_POST["referencia1"]);
        $user->referencia2 = strtoupper($_POST["referencia2"]);
        $user->referencia3 = strtoupper($_POST["referencia3"]);
        $user->referencia4 = strtoupper($_POST["referencia4"]);
        $user->referencia5 = strtoupper($_POST["referencia4"]);
        $user->referencia6 = strtoupper($_POST["referencia6"]);
        $user->cono101 = (int) $_POST["cono101"];
        $user->cono102 = (int) $_POST["cono102"];
        $user->cono103 = (int) $_POST["cono103"];
        $user->cono104 = (int) $_POST["cono104"];
        $user->cono105 = (int) $_POST["cono105"];
        $user->cono106 = (int) $_POST["cono106"];
        $user->cono107 = (int) $_POST["cono107"];
        $user->cono108 = (int) $_POST["cono108"];
        $user->cono109 = (int) $_POST["cono109"];
        $user->cono110 = (int) $_POST["cono110"];
        $user->grupo1 = (int) $grupo1;
        $user->grupo2 = (int) $grupos;
        $user->grupo3 = (int) $grupo4;
        $user->grupo4 = (int) $grupo5;
        $user->total = (int) $grupo1+$grupo2+$grupo3+$grupo4+$grupo5+$total;

        $ingreso = $user->add();

        if($errores1 == '' && $errores2 == '' && $errores3 == '' && $errores4 == '' && $errores5 == '' && $errores6 == ''){
            //
        }else{
            echo '<script type="text/javascript">
        			swal("Corrija...!!!!", "'.$errores1.'&nbsp;&nbsp;'.$errores2.'&nbsp;&nbsp;'.$errores3.'&nbsp;&nbsp;'.$errores4.'&nbsp;&nbsp;'.$errores5.'&nbsp;&nbsp;'.$errores6.'&nbsp;&nbsp;'.$errores7.'&nbsp;&nbsp;'.'", "error");
        		  </script>'; 
        }

        if($valor > 0){
        	// Varios destinatarios 
        	$para = $_POST["email"]; // atención a la coma <span style="border-radius:50px;background-color:#7d66a9;color:#ffffff;font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;display:inline-block;margin-top:5px;margin-right:5px">Oferta de servicio solicitada</span>
        	$título = 'Registro de los datos del Aspirante '.$_POST["nombres"];
        
        	// mensaje
        	$cuerpo = '<!DOCTYPE PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                       <html xmlns="http://www.w3.org/1999/xhtml">
                          <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width,initial-scale=1.0">
                    	    <title>Ingreso de solicitud de aspirante</title>
                          </head>
                          <body>
                	         <br><br>
                        	 <div style="font-family:Arial,sans-serif;font-size:15px;background-color:#ffffff;border-radius:10px;border:1px solid #e1e5ea">
                        	    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="80%" style="font-family:Arial,sans-serif;border-radius:10px">
                        	       <tbody>
                        	           <tr>
                        	               <td style="padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                            	               <table style="font-family:Arial,sans-serif" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                            	                   <tbody>
                            	                       <tr>
                            	                         <td style="font-size:14px;padding-bottom:10px">
                            	                            <span style="border-radius:50px;background-color:#ec6984;color:#ffffff;font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;display:inline-block;margin-top:5px;margin-right:5px">Solicitud en tramite</span>
                            	                         </td>
                            	                       </tr>
                            	                       <tr>
                            	                         <td style="font-size:18px;padding-bottom:10px;line-height:24px">
                            	                            <strong>Se completo el examen de: </strong> <p>'.$_POST["nombres"].'</p>
                            	                         </td>
                            	                       </tr>
                            	                       <tr>
                            	                         <td style="font-size:16px;padding-bottom:5px;line-height:24px">
                            	                            CIPOL
                            	                            <span style="padding-left:5px;display:inline-block"><img width="16" src="https://images.computrabajo.com/2021/10/06/etiqueta/verificada.png" alt="verificada" title="verificada" style="width:16px;vertical-align:bottom;padding-bottom:2px" class="CToWUd" data-bit="iit">
                            	                                <span style="color:#5e7d22;font-size:13px;padding-left:2px">Empresa 100% verificada</span>
                            	                            </span>
                            	                         </td>
                            	                       </tr>
                            	                       <tr>
                            	                         <td style="font-size:16px;padding-bottom:10px;line-height:24px">Guayaquil, Guayas</td>
                            	                       </tr>
                            	                       <tr>
                            	                         <td style="font-size:14px;color:#4b5968">Se ingreso una solicitud de empleo</td>
                            	                       </tr>
                            	                   </tbody>
                            	               </table>
                            	           </td>
                            	       </tr>
                            	   </tbody>
                            	</table>
                             </div>
                          </body>
                	    </html>';
        	
            // Set the headers
            $headers = [
                "MIME-Version: 1.0",
                "Content-type: text/html; charset=UTF-8",
                'From: CIPOL Oficial <info@cipol.ec>',
                'Cc: talentohumano@cipol.ec, asist.tthh@cipol.ec, auditoria@cipol.ec',
            ];
            
        	// Enviarlo
        	$bool = mail($para, $título, $cuerpo, implode("\r\n", $headers));
        	
        	if ($bool) {
                //echo '<br>----------------------<br>Success...!' . PHP_EOL;
            } else {
                echo 'Error.' . PHP_EOL;
            }
        }
        
		echo '<script>window.location="https://cipol.ec";</script>';  
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Test Psicotecnico
		<small>pruebas de calificacion para el aspirante</small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-database"></i> Aspirantes </li>
		<li class="active">Test Psicologico</li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-md-12">
       	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Datos importantes...! </h4>
                <p>El siguiente test realiza una valoración general de las características, conducta, conocimiento y naturaleza de Ud. Realice el test con tranquilidad y lo más sinceramente posible marcando la respuesta con la que más te sientas identificado, en caso de las preguntas de conocimiento se breve. </p>
                <p>Adelante ¡hazlo ya!</p> 
                <p>Conteste las preguntas indicadas a continuación</p>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div align="center">
                        <img class="profile-user-img img-responsive img-circle" style="width:80%; height:60%;" src="/storage/persons/american.png" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $_SESSION['name']; ?></h3>
                        <p class="text-muted text-center">Aspirantes</p>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="aspirante" name="aspirante" action="preguntas" role="form">
                    <div class="box-header with-border">
                        <h3 class="box-title">TALENTO HUMANO FR.004</h3>
                        <button class="btn btn-success btn-app pull-right" style="text-decoration: none;"><i class="fa fa-edit"></i>Enviar</button>
                    </div>
                    <div class="box-body">
                        <!-- tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_fase01" data-toggle="tab" aria-expanded="false"><b>Personalidad</b></a>
                            </li>
                            <li>
                                <a href="#tab_fase02" data-toggle="tab" aria-expanded="false"><b>Aptitud Verbal</b></a>
                            </li>
                            <li>
                                <a href="#tab_fase03" data-toggle="tab" aria-expanded="false"><b>Razonamiento </b></a>
                            </li>
                            <li>
                                <a href="#tab_fase04" data-toggle="tab" aria-expanded="false"><b>Conocimiento</b></a>
                            </li>
                        </ul>
                        <div class="panel-body">
                            <!-- tabs content -->
                            <div class="tab-content panel">
                                <div class="tab-pane active" id="tab_fase01">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Seleccione con SI o NO</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody><?php 
                                            $preguntas = PreguntasData::getById(1); 
                                            $i = 0;
                                            foreach($preguntas as $tables) { 
                                                $i++;
                                                $ceros = str_pad($i, 2, "0", STR_PAD_LEFT);
                                                $cadena = 'resp1'.$ceros; ?>
                                                <tr>
                                                    <td><?php echo $tables->pregunta?></td>
                                                    <td>
                  										<div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="1"> Si &nbsp;&nbsp;
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="0"> No
                  										</div>
                                          			</td>
                                                  </tr><?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_fase02">
    								<div class="col-md-12">
                                        <div class="miAlbum" style="display: block;">
                            				<h3>Fluidez Verbal</h3>
                            			</div>
          								<div class="form-group">
          									<label class="col-md-12 col-sm-12 control-label">Escriba 6 palabras que se le ocurre que comiencen por la letra P</label>
          								</div>
          								<div class="form-group">
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">1:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia1" name="referencia1" placeholder="...................................." value="<?php echo $person->referencia1; ?>"></div>
          									
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">2:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia2" name="referencia2" placeholder="...................................." value="<?php echo $person->referencia2; ?>"></div>
          									
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">3:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia3" name="referencia3" placeholder="...................................." value="<?php echo $person->referencia3; ?>"></div>
          								</div>
          								<hr>
          								<div class="form-group">
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">4:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia4" name="referencia4" placeholder="....................................." value="<?php echo $person->referencia4; ?>"></div>
          									
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">5:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia5" name="referencia5" placeholder="....................................." value="<?php echo $person->referencia5; ?>"></div>
          									
                              				<label for="referencia1" class="col-md-1 col-sm-1 control-label">6:</label>
          									<div class="col-md-3 col-sm-3"><input type="text" class="form-control" id="referencia6" name="referencia6" placeholder="....................................." value="<?php echo $person->referencia6; ?>"></div>
          								</div>
                            		</div>
    								<div class="col-md-12">
                                        <div class="miAlbum" style="display: block;">
                            				<h3>Definiciones</h3>
                            			</div>
                            		</div>
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th colspan="5">Elija la palabra que corresponde a la definicon</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php
                                            $preguntas = PreguntasData::getById(2);
                                            
                                            $i = 0;
                                            foreach($preguntas as $tables) { 
                                                $i++;
                                                $ceros = str_pad($i, 2, "0", STR_PAD_LEFT);
                                                $cadena = 'defi1'.$ceros; ?>
                                                <tr>
                                                    <td colspan="5"><?php echo $i.'. "'.$tables->nombre.'"'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="1"> A) <?php echo $tables->respuestA; ?>
                  										</div>
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="2"> B) <?php echo $tables->respuestB; ?>
                  										</div>
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="3"> C) <?php echo $tables->respuestC; ?>
                  										</div>
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="4"> D) <?php echo $tables->respuestD; ?>
                  										</div>
                                                    </td>
                                                </tr><?php
                                            } ?>
                                        </tbody>
                                    </table>
    								<div class="col-md-12">
                                        <div class="miAlbum" style="display: block;">
                            				<h3>Sinonimos</h3>
                            			</div>
                            		</div>
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th colspan="5">Elija la palabra que corresponde a la definicon</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php
                                            $preguntas = PreguntasData::getById(3);
                                            
                                            $i = 0;
                                            foreach($preguntas as $tables) { 
                                                $i++;
                                                $ceros = str_pad($i, 2, "0", STR_PAD_LEFT);
                                                $cadena = 'sisn1'.$ceros; ?>
                                                <tr>
                                                    <td colspan="5"><?php echo $i.'. "'.$tables->nombre.'"'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="1"> A) <?php echo $tables->respuestA; ?>
                  										</div> 
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="2"> B) <?php echo $tables->respuestB; ?>
                  										</div> 
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="3"> C) <?php echo $tables->respuestC; ?>
                  										</div> 
                                                    </td>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="4"> D) <?php echo $tables->respuestD; ?>
                  										</div>
                                                    </td>
                                                </tr><?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_fase03">
    								<div class="col-md-12">
                                        <div class="miAlbum" style="display: block;">
                            				<h3>Serie de Figuras</h3>
                            			</div>
                            		</div>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td colspan="5">1.- Elija la figura que completa la serie</td>
                                            </tr>
                                            <tr>
                                                <td><img style="width:80%; height:60%;" src="/assets/images/test/figura1.JPG" alt="User profile picture"></td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie1" name="serie1" value="1"> A) <img src="/assets/images/test/figuraA.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie1" name="serie1" value="2"> B) <img src="/assets/images/test/figuraB.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie1" name="serie1" value="3"> C) <img src="/assets/images/test/figuraC.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie1" name="serie1" value="4"> D) <img src="/assets/images/test/figuraD.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">2.- Elija la figura que no pertenece al grupo</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;</td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie2" name="serie2" value="1"> A) <img src="/assets/images/test/figura2.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie2" name="serie2" value="2"> B) <img src="/assets/images/test/figura3.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie2" name="serie2" value="3"> C) <img src="/assets/images/test/figura4.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                                <td>
                                                    <div class="radiobutton">
              											<input type="radio" id="serie2" name="serie2" value="4"> D) <img src="/assets/images/test/figura5.JPG" alt="User profile picture">
              										</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_fase04">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>Seleccione la respuesta correcta</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php
                                            $preguntas = PreguntasData::getById(5);
                                            
                                            $i = 0;
                                            foreach($preguntas as $tables) { 
                                                $i++;
                                                $ceros = str_pad($i, 2, "0", STR_PAD_LEFT);
                                                $cadena = 'cono1'.$ceros; ?>
                                                <tr>
                                                    <td><b><?php echo $i.'. ¿'.$tables->pregunta.'?'; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="1"> <?php echo $tables->respuestA; ?>
                  										</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="2"> <?php echo $tables->respuestB; ?>
                  										</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="radiobutton">
                  											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="3"> <?php echo $tables->respuestC; ?>
                  										</div>
                                                    </td>
                                                </tr><?php
                                                if($tables->respuestD == NULL){
                                                    //sin pregunta
                                                }else{ ?>
                                                    <tr>
                                                        <td>
                                                            <div class="radiobutton">
                      											<input type="radio" id="<?php echo $cadena; ?>" name="<?php echo $cadena; ?>" value="4"> <?php echo $tables->respuestD; ?>
                      										</div>
                                                        </td>
                                                    </tr><?php
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
</section>
<div class="text-right">
    <a href="#" id="js_up" class="ir-arriba" title="Volver arriba">
        <span class="fa-stack">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
        </span>
    </a>
</div>
<script>
    document.title = "CIPOL | Ingreso de aspirante";
    
    $(document).ready(function(){
        $('input').iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_flat-red'
        });
    
        //invocamos al objeto (window) y a su método (scroll), solo se ejecutara si el usuario hace scroll en la página
        $(window).scroll(function(){
          if($(this).scrollTop() > 300){ //condición a cumplirse cuando el usuario aya bajado 301px a más.
            $("#js_up").slideDown(300); //se muestra el botón en 300 mili segundos
          }else{ // si no
            $("#js_up").slideUp(300); //se oculta el botón en 300 mili segundos
          }
        });
    
        //creamos una función accediendo a la etiqueta i en su evento click
        $("#js_up i").on('click', function (e) {
          e.preventDefault(); //evita que se ejecute el tag ancla (<a href="#">valor</a>).
          $("body,html").animate({ // aplicamos la función animate a los tags body y html
            scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
          },700); //el valor 700 indica que lo ara en 700 mili segundos
          return false; //rompe el bucle
        });
    });
</script>
