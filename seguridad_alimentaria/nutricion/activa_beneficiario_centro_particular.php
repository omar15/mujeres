<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

//Obtenemos variables
$id_activo = $_GET["id_activo"];
$id_centro_atencion =$_GET["id_centro_atencion"];

//Respuesta al intentar guardar datos
$resp = 0;

if($id_activo){
    //Editamos registro
    $resp = Alim_nutricion_extraescolar::activaAlim_nutricion_extraescolar($id_activo);
    }
    
//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="lista_modulo.php?r=' . $resp .'"</script>';
header('Location:lista_beneficiario_centro.php?r=' . $resp.'&id_centro_atencion='.$id_centro_atencion);
?>