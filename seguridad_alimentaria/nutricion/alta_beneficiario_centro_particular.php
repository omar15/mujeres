<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php');
//Variable de respuesta
$respuesta = intval($_GET['r']);
//obtenemos id_centro_atencion
$id_centro_atencion=$_GET['id_centro_atencion'];
//obtenemos id_beneficiario
$id_beneficiario=$_GET['id_beneficiario'];
//obtenemos id_localidad
$id_localidad=$_GET['id_localidad'];
//obtenemos nobres de centros
$sql = 'SELECT CVE_EST_MUN_LOC, nombre FROM `centros_atencion` where id=?';
$params = array($id_centro_atencion);
$centros = $db->rawQuery($sql,$params);
$centros = $centros[0];
//Mensaje respuesta
$mensaje = Permiso::mensajeRespuesta($respuesta);
?>

<div id="principal">

   <div id="contenido">

    <h2 class="centro">Alta Beneficiario centro particular</h2>
    <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />
    
      <h2 class="centro"> Centro De Atenci&oacute;n: <?php echo $centros['CVE_EST_MUN_LOC'].' -  '.$centros['nombre']; ?></h2>
    <?php if($respuesta > 0){?>

    <div class="mensaje"><?php echo $mensaje;?></div>

    <?php } ?>

    <div  align="center">                

        <?php

            //Si el registro no es exitoso mostramos el formulario de usuario 

            if($respuesta != 1){        

                include_once("form_beneficiario_centro_particular.php");    

            }

        ?>

    </div>

    </div>

</div>
<?php 

//Incluimos pie

include($_SESSION['inc_path'].'/footer.php');

?>

        
  

