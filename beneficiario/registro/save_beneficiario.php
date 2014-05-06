<?php
session_start();

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
//para poder utilizar las funciones de la clase modelo
include_once($_SESSION['model_path'].'beneficiario.php');

//Tipo de Archivo, predeterminado el alta
$tipo = 'alta_beneficiario';

//tipo de accion te lo direcciona hasta abajo agregando la extension "".php

//Respuesta al intentar guardar datos
$resp = 0;

//Obtenemos id a editar
$id_edicion = $_POST['id_edicion'];

//Obtenemos id del expediente
$id_edicion_exp = $_POST['id_edicion_exp'];

//Obtenemos id de aspirante (de existir)
$id_aspirante = $_POST['id_aspirante'];

//Quitamos del arreglo POST la variable id_edicion
unset($_POST["id_edicion"] );
//Validamos si editaremos o no
 if($id_edicion > 0){
    
    //Tipo de archivo
    $tipo = 'edita_beneficiario';        

    //Editamos registro
    //$_POST cacha todos los names del form
    //Beneficiario:: para poder utilizar lla funcion saveBneficiario del modelo 
    list($resp,$curp,$id_beneficiario) = Beneficiario::saveBeneficiario($_POST,$id_edicion);
    
    }else{
        
    //Creamos registro        
     list($resp,$curp,$id_beneficiario)  = Beneficiario::saveBeneficiario($_POST);    
    }
    
    /*Si la respuesta es exitosa enviamos al listado
    caso contrario (y si estamos editando) restauramos 
    los datos que se querían modificar*/
    if($resp == 1){         
        $tipo = 'lista_beneficiario'; 

        //Si lo editamos desde Trabajo Social, lo redireccionamos
        if($id_aspirante > 0){
            $tipo = '../../trabajo_social/registro/edita_trabajo_social';
            $resp .= '&id_edicion='.$id_edicion_exp.'&id_aspirante='.$id_aspirante;
        }

    }else if($id_edicion > 0){
        $resp .= '&id_edicion='.$id_edicion;
    }

    //Si lo editamos desde Trabajo Social, lo redireccionamos
    if($id_aspirante <= 0){
     $resp .=  ($curp != NULL)? '&id_dif='.$curp : '';   
    }

//echo $resp;

//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
header('Location:'.$tipo.'.php?r=' . $resp);    
?>