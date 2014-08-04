<?php
session_start();

//Librería de conexión
include ($_SESSION['inc_path']."conecta.php");

//Librería de permisos
//para poder utilizar las funciones de la clase modelo
include_once($_SESSION['inc_path'].'libs/CargaExcel.php');

//Tipo de Archivo, predeterminado el alta
$tipo = 'subir_archivo';

//Obtenemos id de caravana
$id_caravana = $_POST['id_caravana'];

//Eliminamos variable de sesión
unset($_SESSION['totales']);

//Respuesta al intentar guardar datos
$resp = 0;

//establecemos formato del archivo
$allowedExts = array("xlsx",'xls');//extensiones de archivo que se permitiran
$temp = explode(".", $_FILES["archivo"]["name"]);//sacamos el nombre y la extension del archivo 
$nombre = $temp[0];//nombre_archivo
$extension = end($temp);//tipo de extension del archivo

//el tipo de archivo, por ahora xlsx y xls
$mime[] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
$mime[] = 'application/vnd.ms-excel';

$destino = $_SESSION['files_path'].$_FILES["archivo"]["name"];//obtengo nombre del archivo y tipo de extension y tiene concatenada la ruta donde se guadra el archivo

/*
echo '<br>'.$destino;
exit;
*/

if ((in_array($_FILES["archivo"]["type"],$mime)) && in_array($extension, $allowedExts)){
  
  if ($_FILES["archivo"]["error"] > 0){
      
      //Error al cargar archivo
      $resp = 'Error al cargar el archivo: '.$_FILES["archivo"]["error"];
    
    }else if(move_uploaded_file($_FILES['archivo']['tmp_name'],$destino)){
        
        list($resp,$totales) = CargaExcel::carga($nombre,null,$id_caravana,$extension);    

        //Creamos variable de sesión para tener los totales de la carga
        $_SESSION['totales'] = $totales;

        /*Si la respuesta es exitosa enviamos al archivo de
        carga_exitosa, caso contrario regresamos a subir_archivo
        */      
        if($resp == 1){         
            $tipo = 'subir_archivo';            
        }

    }else{
      $resp = 23;
    }

}else{
      //Formato no válido
      $resp = 24;
}

//Redireccionamos con el tipo de respuesta
//echo '<script language="JavaScript">location.href="'. $tipo .'.php?r=' . $resp .'"</script>';
header('Location:'.$tipo.'.php?r=' . $resp);    
?>