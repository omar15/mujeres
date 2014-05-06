<?php
session_start();//Habilitamos uso de variables de sesión

//Obtenemos el id del aspirante
if(isset($_GET["id_aspirante"])){
    $id_aspirante = intval($_GET["id_aspirante"]);
}

//Obtenemos el tipo de edición
if(isset($_GET["id_edicion"]) ){
    $id_edicion = intval($_GET["id_edicion"]);
}

//Incluimos cabecera
include($_SESSION['inc_path']. 'header.php');

//Variable de respuesta
$respuesta = intval($_GET['r']);

//Mensaje respuesta
$mensaje = Permiso::mensajeRespuesta($respuesta);
?>

<div id="principal">
   <div id="contenido">
    <h2 class="centro">Edici&oacute;n de Trabajo Social</h2>
    
    <?php if($respuesta > 0){?>
    <div class="mensaje"><?php echo $mensaje;?></div>
    <?php } ?>
    <div  align="center">                
        <?php
            //Si el registro no es exitoso mostramos el formulario de usuario 
            if($respuesta != 1 || ( $id_aspirante>0 && $id_edicion >0 && $respuesta >0) ){
                include_once("form_trabajo_social.php");    
            }
        ?>
    </div>
  </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>