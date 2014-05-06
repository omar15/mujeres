<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'trabajo_social.php');

//Obtenemos variables
$id_activo = $_GET["id_activo"];

//Respuesta al intentar guardar datos
$resp = 0;

if($id_activo){
    //Editamos registro
    $resp = Trabajo_social::activaTrabajo_social($id_activo);
    }
    
//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="lista_modulo.php?r=' . $resp .'"</script>';
header('Location:lista_trabajo_social.php?r=' . $resp);
?>