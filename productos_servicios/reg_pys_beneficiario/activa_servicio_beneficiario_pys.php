<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'beneficiario_pys.php');

//Obtenemos variables
$id_beneficiario_pys = $_GET["id_beneficiario_pys"];

//Respuesta al intentar guardar datos
$resp = 0;

//si recibimos el id activo entonces lo mandamos a activaBeneficiario
if($id_beneficiario_pys){
    //Editamos registro
    $resp = Beneficiario_pys::activaServicioBeneficiario_pys($id_beneficiario_pys);
    }

//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="lista_accion.php?r=' . $resp .'"</script>';
//header('Location:servicio_beneficiario_pys.php?r=' . $resp . '&id_beneficiario='. $id_beneficiario);
//header('Location:../../beneficiario/registro/seguimiento_beneficiario.php?r=' . $resp . '&id_beneficiario='. $id_beneficiario);
header('Location:' . getenv('HTTP_REFERER'));

?>