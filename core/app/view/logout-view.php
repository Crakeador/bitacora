<?php

if(isset($_SESSION['ingreso'])){
    if($_SESSION['ingreso']==1){		
        Core::redir('salir');
    }else{
        session_destroy();
        echo '<script>
                localStorage.removeItem("usuario");
                localStorage.removeItem("puesto");
                localStorage.removeItem("ingreso");
                localStorage.removeItem("turno");
                localStorage.removeItem("verifica");
                localStorage.clear();
            
                window.location = "index.php?view=logout";
              </script>';
        Core::redir('home');
    }
}else{
    session_destroy();
    Core::redir('home');
}