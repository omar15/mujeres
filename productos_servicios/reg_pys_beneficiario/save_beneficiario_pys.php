<?php
session_start();

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
//para poder utilizar las funciones de la clase modelo
include_once($_SESSION['model_path'].'beneficiario_pys.php');

//Tipo de Archivo, predeterminado el alta
$tipo = 'alta_beneficiario_pys';

//Respuesta al intentar guardar datos
$resp = 0;

//obtenemos id a editar
$id_edicion = $_POST['id_edicion'];

//Quitamos del arreglo POST la variable id_edicion
unset($_POST["id_edicion"] );

//Si hacemos petición ajax, guardamos en la variable
$ajax = $_POST["ajax"];

//Validamos si editaremos o no
 if($id_edicion > 0){

    //ID's generados de la tabla beneficiario_pys
    $id_generados = array();

    //Tipo de archivo
    $tipo = 'edita_beneficiario_pys';
    //Editamos registro
    //$_POST cacha todos los names del form

    //Beneficiario:: para poder utilizar lla funcion saveBneficiario del modelo 
    list($resp,$id_generados) = Beneficiario_pys::saveBeneficiario_pys($_POST,$id_edicion);

    }else{
    //Creamos registro        
     list($resp,$id_generados) = Beneficiario_pys::saveBeneficiario_pys($_POST);    
    }

//echo $resp;

//Si realizamos petición ajax es nula, redireccionamos a listado
if($ajax == NULL){

    //Si la respuesta es exitosa enviamos al listado caso contrario (y si estamos editando) restauramos los datos que se querían modificar
    if($resp == 1){
        $tipo = 'lista_beneficiario_pys'; 
    }else if($id_edicion > 0){
        $resp .= '&id_edicion='.$id_edicion;
    }

    //echo $resp;
    //Redireccionamos con el tipo de respuesta
    //echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
    header('Location:'.$tipo.'.php?r=' . $resp);    

}
?>