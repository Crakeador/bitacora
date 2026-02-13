<?php
//Salida del sistema
if(isset($_SESSION['idrol'])){
    echo '<script>console.log("Rol: '.$_SESSION['idrol'].'");</script>';
    if($_SESSION['idrol'] == 7){
        if($_SESSION['ingreso']==1){
            Core::redir('salir');
        }else{
            session_destroy();
            echo '<script>
                    console.log("Cerrando sin foto...");
                    localStorage.removeItem("usuario");
                    localStorage.removeItem("puesto");
                    localStorage.removeItem("ingreso");
                    localStorage.removeItem("turno");
                    localStorage.removeItem("verifica");
                    localStorage.clear();
                
                    window.location = "./";
                </script>';
        }
    }else{ 
        session_destroy();
        echo '<script>
                console.log("Cerrando sesión...");
                localStorage.removeItem("usuario");
                localStorage.removeItem("puesto");
                localStorage.removeItem("ingreso");
                localStorage.removeItem("turno");
                localStorage.removeItem("verifica");
                localStorage.clear();
            
                window.location = "./";
            </script>';
    }
}else{
    echo '<script>
            console.log("No se encontró el rol en la sesión.");
            localStorage.removeItem("usuario");
            localStorage.removeItem("puesto");
            localStorage.removeItem("ingreso");
            localStorage.removeItem("turno");
            localStorage.removeItem("verifica");
            localStorage.clear();
        
            window.location = "./";
        </script>';  

    session_destroy();
    Core::redir('home');
}