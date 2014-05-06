<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'apoyo_otorgado.php');
include_once($_SESSION['model_path'].'beneficiario_pys.php');
include_once($_SESSION['model_path'].'componente.php');

//$id_beneficiario = $_POST['id_beneficiario'];
$id_producto_servicio = $_POST['id_producto_servicio'];
$componente = Componente::get_Componente($id_producto_servicio);
$componente = $componente [0];
$_POST['id_componente'] = $componente['id_componente'];

//print_r($_POST);
//exit;
//Tipo de Archivo, predeterminado el alta
$tipo = 'alta_apoyo';

//Respuesta al intentar guardar datos
$resp = 0;

//obtenemos id a editar
$id_edicion = $_POST['id_edicion'];
//echo $id_edicion;
//exit;
$id_trab_expediente = $_POST['id_trab_expediente'];

//Quitamos del arreglo POST la variable id_edicion
unset($_POST["id_edicion"] );

//Validamos si editaremos o no
 if($id_edicion > 0){
    
    //Tipo de archivo
    $tipo = 'edita_apoyo';        

    //Editamos registro
    $resp = Apoyo_otorgado::saveApoyo_otorgado($_POST,$id_edicion);
    
    }else{
    //Creamos registro        
     $resp = Apoyo_otorgado::saveApoyo_otorgado($_POST);  
       
    }

    /*Si la respuesta es exitosa enviamos al listado
    caso contrario (y si estamos editando) restauramos 
    los datos que se querían modificar*/
    if($resp == 1){ 
        $tipo = 'lista_apoyo';
    //doble condicion     
    }else if($id_edicion > 0){
        $resp .= '&id_edicion='.$id_edicion;
    }

//echo $resp;

//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
header('Location:'.$tipo.'.php?r=' . $resp.='&id_trab_expediente='.$id_trab_expediente);
?>