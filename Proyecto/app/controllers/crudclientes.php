<?php
    require_once "funcionesForm.php";

function crudBorrar ($id){    
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ( $resu){
         $_SESSION['msg'] = " El usuario ".$id. " ha sido eliminado.";
    } else {
         $_SESSION['msg'] = " Error al eliminar el usuario ".$id.".";
    }

}

function crudTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function crudAlta(){
    $cli = new Cliente();
    $orden= "Nuevo";
    $_SESSION['current_id'] = "";
    include_once "app/views/formulario.php";
}

function crudDetalles($id){
    global $bandera;

    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $bandera = getBandera($cli->ip_address);
    include_once "app/views/detalles.php";
}



function crudModificar($id){
    global $imgURL;
    
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $imgURL = checkFotoPerfil($id);
    print_r($imgURL);
    $orden="Modificar";
    include_once "app/views/formulario.php";
}

function crudPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    // !!!!!! No se controlan que los datos sean correctos 
    if(postCheckDatosCorrectos())
    {
        $cli = new Cliente();
        $_POST['id'] = "";
       
        $cli->id            =$_POST['id'];
        $cli->first_name    =$_POST['first_name'];
        $cli->last_name     =$_POST['last_name'];
        $cli->email         =$_POST['email'];	
        $cli->gender        =$_POST['gender'];
        $cli->ip_address    =$_POST['ip_address'];
        $cli->telefono      =$_POST['telefono'];
        $db = AccesoDatos::getModelo();
        if ( $db->addCliente($cli) ) {
            $_SESSION['msg'] = " El usuario ".$cli->first_name." se ha dado de alta ";
            $newID = $db->getLastCliente();
            addProfileId($newID->id);
            } else {
                $_SESSION['msg'] = " Error al dar de alta al usuario ".$cli->first_name."."; 
            }
    }
}

function crudPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    
    if(postCheckDatosCorrectos())
    {
        $cli = new Cliente();

        $cli->id            =$_POST['id'];
        $cli->first_name    =$_POST['first_name'];
        $cli->last_name     =$_POST['last_name'];
        $cli->email         =$_POST['email'];	
        $cli->gender        =$_POST['gender'];
        $cli->ip_address    =$_POST['ip_address'];
        $cli->telefono      =$_POST['telefono'];
        $db = AccesoDatos::getModelo();
        if ( $db->modCliente($cli) ){
            $_SESSION['msg'] = " El usuario ha sido modificado";
        } else {
            $_SESSION['msg'] = " Error al modificar el usuario ";
        }
    }
}



function crudPostSiguiente($id){
    $db = AccesoDatos::getModelo();
    $clientes = $db->numClientes();

    $calc = intval($id) + 1;
    ($calc <= $clientes) ? $cli = crudModificar($calc): $cli = crudModificar($id);
}

function crudPostAnterior($id){
    $db = AccesoDatos::getModelo();
    $calc = intval($id) - 1;

    ($calc > 0) ? $cli = crudModificar($calc): $cli = crudModificar(intval($id));
}

function crudSiguiente($id){
    $db = AccesoDatos::getModelo();
    $clientes = $db->numClientes();

    $calc = intval($id) + 1;
    ($calc <= $clientes) ? $cli = crudDetalles($calc): $cli = crudDetalles($id);
}

function crudAnterior($id){
    $db = AccesoDatos::getModelo();
    $calc = intval($id) - 1;

    ($calc > 0) ? $cli = crudDetalles($calc): $cli = crudDetalles(intval($id));
}



