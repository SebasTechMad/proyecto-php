<?php
session_start();
define ('FPAG',10); // Número de filas por página


require_once 'app/helpers/util.php';
require_once 'app/config/configDB.php';
require_once 'app/models/Cliente.php';
require_once 'app/models/Usuario.php';
require_once 'app/models/AccesoDatosPDO.php';
require_once 'app/controllers/crudclientes.php';
require_once 'vendor/autoload.php';
require_once 'app/controllers/funcionesForm.php';

    $msgLogin = "";


    if(!isset($_SESSION['current_id'])){
        $_SESSION['current_id'] = "";
    }

    if(!isset($_SESSION['intentos'])){
        $_SESSION['intentos'] = 0;
    }

    if(isset($_POST['comprobar'])){

        if($_POST['login'] != "" && $_POST['clave'] != ""){
            $db = AccesoDatos::getModelo();
            $usuario = $db->getUsuario($_POST['login']);

            if($usuario){

                if(password_verify($_POST['clave'], $usuario->password)){
                    $_SESSION['user_login'] = $_POST['login'];
                    $_SESSION['intentos'] = 0;
                }else{
                    $msgLogin = "Error, Usuario o contraseña no válidos";
                    $_SESSION['intentos'] += 1;
                }


            }else{
                $msgLogin = "Error, Usuario o contraseña no válidos";
                $_SESSION['intentos'] += 1;
            }

        }else{
            $msgLogin = "Rellena todos los campos";
        }
    }
    


    if($_SESSION['intentos'] > 2){
        require_once "app/views/error.php";
    }else{
        if(!isset($_SESSION['user_login'])){
            require_once "app/views/login.php";   
        }else{
            #region INDEX
            $imgURL = "";
            $bandera = "";
            // $_SESSION['organizar'] = "";
    
            //---- PAGINACIÓN ----
            $midb = AccesoDatos::getModelo();
            $totalfilas = $midb->numClientes();
            if ( $totalfilas % FPAG == 0){
                $posfin = $totalfilas - FPAG;
            } else {
                $posfin = $totalfilas - $totalfilas % FPAG;
            }
    
            if ( !isset($_SESSION['posini']) ){
            $_SESSION['posini'] = 0;
            }
            $posAux = $_SESSION['posini'];
            //------------
            $_SESSION['msg']=" ";
            //ob_start(); // La salida se guarda en el bufer
    
    
                // //CONTROLAMOS LA FUNCION DE ORDENACION
                // En caso de que inicie el programa, que arranque con esta ordenacion default
                if(!isset($_SESSION['current_ordenacion'])){
                    $_SESSION['current_ordenacion'] = "id";
                    $_SESSION['current_sentido'] = "ASC";
                }
    
    
                //SI ENCUENTRA ALGÚN TIPO DE ORDENACION MANDADO POR EL USER, QUE HAGA LAS SIGUIENTES COMPROBACIONES
                if(isset($_GET['ordenacion']))
                {
                    $cambiarSentido = false;
                    //SI EL USUARIO LE DA AL MISMO TIPO DE ORDENACION, SOLO SE CAMBIARA SI ES ASC O DESC
                    if($_SESSION['current_ordenacion'] == $_GET['ordenacion'])
                    {
    
                        if($_SESSION['current_sentido'] == "ASC"){
                            $_SESSION['current_sentido'] = "DESC";
                        }else{
                            $_SESSION['current_sentido'] = "ASC";
                        }
    
                    }else{
                        $_SESSION['current_sentido'] = "ASC";
                    }
    
    
    
                    $_SESSION['current_ordenacion'] = $_GET['ordenacion'];
                }
                
                // echo("<br>");
                // print_r($_SESSION['current_ordenacion']);
                // echo("<br>");
                // print_r($_SESSION['current_sentido']);
    
            ob_start(); // La salida se guarda en el bufer
    
    
            if ($_SERVER['REQUEST_METHOD'] == "GET" ){
                
                // Proceso las ordenes de navegación
                if ( isset($_GET['nav'])) {
                    switch ( $_GET['nav']) {
                        case "Primero"  : $posAux = 0; break;
                        case "Siguiente": $posAux +=FPAG; if ($posAux > $posfin) $posAux=$posfin; break;
                        case "Anterior" : $posAux -=FPAG; if ($posAux < 0) $posAux =0; break;
                        case "Ultimo"   : $posAux = $posfin;
                    }
                    $_SESSION['posini'] = $posAux;
                }
    
    
                // Proceso de ordenes de CRUD clientes
                if ( isset($_GET['orden'])){
                    switch ($_GET['orden']) {
                        case "Nuevo"    : crudAlta(); break;
                        case "Borrar"   : crudBorrar   ($_GET['id']); break;
                        case "Modificar": crudModificar($_GET['id']); break;
                        case "Detalles" : crudDetalles ($_GET['id']);break;
                        case "Terminar" : crudTerminar(); break;
                        case "Anterior" : crudAnterior($_SESSION['current_id']); break;
                        case "Siguiente": crudSiguiente($_SESSION['current_id']); break;
                        case "Imprimir": imprimirDetalles($_SESSION['current_id']); break;
                    }
                }
            } 
            // POST Formulario de alta o de modificación
            else {
                if (  isset($_POST['orden'])){
                    switch($_POST['orden']) {
                        case "Nuevo"    : crudPostAlta(); break;
                        case "Modificar": crudPostModificar(); break;
                        case "Detalles":; // No hago nada
                        case "Siguiente": crudPostSiguiente($_SESSION['current_id']); break;
                        case "Anterior": crudPostAnterior($_SESSION['current_id']); break;        
                    }
                }
            }
    
            // Si no hay nada en la buffer 
            // Cargo genero la vista con la lista por defecto
            if ( ob_get_length() == 0){
                $db = AccesoDatos::getModelo();
                $posini = $_SESSION['posini'];
                $tclientes = $db->getClientes($posini,FPAG);
                require_once "app/views/list.php";    
            }
            $contenido = ob_get_clean();
            $msg = $_SESSION['msg'];
            // Muestro la página principal con el contenido generado
            require_once "app/views/principal.php";
            #endregion
        }
    }


    







