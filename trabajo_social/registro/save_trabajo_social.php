<?php
session_start();//Indicamos el uso de variables de sesión

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
include_once($_SESSION['model_path'].'trab_expediente.php');
include_once($_SESSION['model_path'].'aspirantes.php');

//Tipo de Archivo, predeterminado el alta
$tipo = 'alta_trabajo_social';

//Respuesta al intentar guardar datos
$resp = 0;

//obtenemos id a editar
$id_edicion = $_POST['id_edicion'];
$id_aspirante = $_POST['id_aspirante'];
$id_beneficiario = $_POST['id_beneficiario'];

//Quitamos del arreglo POST la variable id_edicion
unset($_POST["id_edicion"] );

//Validamos si editaremos o no
if($id_edicion > 0 && ($id_aspirante > 0 || $id_beneficiario >0) ){
    
    //Tipo de archivo
    $tipo = 'edita_trabajo_social';        

    //Editamos registro de aspirante
    list($resp,$id_aspirante) = Aspirantes::saveAspirantes($_POST,$id_aspirante);
    
    //echo '1er Respuesta : '.$resp;

    //Guardamos datos
    if($resp == 1 && ($id_aspirante > 0 || $id_beneficiario > 0)){
        list($resp,$id_trabajo_social) = Trab_expediente::saveTrab_expediente($_POST,$id_edicion);

      //echo '\n 2da Respuesta : '.$resp;
    }

}else{
    
    //Si es beneficiario o aspirante ya registrado, no daremos de alta en la tabla aspirante
    if($id_aspirante > 0 || $id_beneficiario >0){
        $resp = 1;
    }else{        
        //Creamos registro en la tabla aspirantes
        list($resp,$id_aspirante) = Aspirantes::saveAspirantes($_POST);
        //Tenemos id de aspirante, lo actualizamos
        $_POST['id_aspirante'] = $id_aspirante;        

        //echo '\n 3er Respuesta : '.$resp;
    }
            
     //Editamos el registro
     if($resp == 1 && ($id_aspirante > 0 || $id_beneficiario > 0)){
        //Obtenemos la respuesta
        list($resp,$id_trabajo_social) = Trab_expediente::saveTrab_expediente($_POST);

        //echo '\n 4ta Respuesta : '.$resp;

     }else{
        //print_r($_POST);
        //echo $resp.' No se tuvo id de aspirante :'.$id_aspirante.' id_edicion: '.$id_edicion;
     }
    
}

    /*Si la respuesta es exitosa enviamos al listado
    caso contrario (y si estamos editando) restauramos 
    los datos que se querían modificar*/
    if($resp == 1){ 
        $tipo = 'lista_trabajo_social'; 
        $resp .= '&id='.$id_trabajo_social;
    }else if($id_edicion > 0){
        $resp .= '&id_edicion='.$id_edicion;
    }

//print_r($_POST);


//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
header('Location:'.$tipo.'.php?r=' . $resp);
?>