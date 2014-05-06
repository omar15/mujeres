<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php');
//obtenemos id_trab_expediente
$id_trab_expediente = $_GET['id_trab_expediente'];
//obtenemos id_beneficiario
$id_beneficiario = $_GET['id_beneficiario'];
//Variable de respuesta
$respuesta = intval($_GET['r']);
//Mensaje respuesta
$mensaje = Permiso::mensajeRespuesta($respuesta);
?>

<div id="principal">
   <div id="contenido">
    <h2 class="centro">Servicios Otorgados al Beneficiario</h2>
    <?php if($respuesta > 0){?>
    <div class="mensaje"><?php echo $mensaje;?></div>
    <?php } ?>
	    <div  align="center">                
	        <?php
	            //Si el registro no es exitoso mostramos el formulario de usuario 
	            if($respuesta != 1){        
	                include_once("form_apoyo.php");    
	            }
	        ?>
	    </div>
    </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>