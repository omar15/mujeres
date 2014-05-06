<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'trab_exp_beneficiario.php');

//Obtenemos variables
$id_activo = $_GET["id_activo"];
$id_trab_expediente = $_GET["id_trab_expediente"];

//Respuesta al intentar guardar datos
$resp = 0;

if($id_activo){
    //Editamos registro
    $resp = Trab_exp_beneficiario::activaTrabExpBeneficiario($id_activo);
    }
    
//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="lista_modulo.php?r=' . $resp .'"</script>';
//header('Location:edita_trabajo_social.php?r=' . $resp.='&id_edicion='.$id_trab_expediente);
header('Location:' . getenv('HTTP_REFERER'));
?>