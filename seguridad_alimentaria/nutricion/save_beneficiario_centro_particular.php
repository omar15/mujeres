<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

//Tipo de Archivo, predeterminado el alta
$tipo = 'alta_beneficiario_centro_particular';

//Respuesta al intentar guardar datos
$resp = 0;

//obtenemos id a editar
$id_edicion = $_POST['id_edicion'];
$id_centro_atencion = $_POST['id_centro_atencion'];
//echo $id_edicion;
//exit;
//print_r($_POST);
//exit;

//Quitamos del arreglo POST la variable id_edicion
unset($_POST["id_edicion"] );

//Validamos si editaremos o no
 if($id_edicion > 0){
    
    //Tipo de archivo
    $tipo = 'edita_centro_atencion_particular';        

    //Editamos registro
    $resp = Alim_nutricion_extraescolar::saveAlim_nutricion_extraescolar($_POST,$id_edicion);

    }else{
        
    //Creamos registro        
     $resp = Alim_nutricion_extraescolar::saveAlim_nutricion_extraescolar($_POST);    
    }

    /*Si la respuesta es exitosa enviamos al listado
    caso contrario (y si estamos editando) restauramos 
    los datos que se querían modificar*/
    if($resp == 1){ 
        $tipo = 'lista_beneficiario_centro'; 
    }else if($id_edicion > 0){
        $resp .= '&id_edicion='.$id_edicion;
    }

//echo $resp;

//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
header('Location:'.$tipo.'.php?r=' . $resp.='&id_centro_atencion='.$id_centro_atencion); 
?>