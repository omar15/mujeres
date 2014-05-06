<?php

session_start();//Habilitamos uso de variables de sesión



    //Obtenemos el tipo de edición

    if(isset($_GET["id_edicion"])){

        $id_edicion = intval($_GET["id_edicion"]);

    }

$id_centro_atencion=$_GET['id_centro_atencion'];

//Incluimos cabecera

include($_SESSION['inc_path']. 'header.php');

//Mensaje respuesta

$mensaje = Permiso::mensajeRespuesta($respuesta);

?>

<div id="principal">

   <div id="contenido">
  
    <h2 class="centro">Edici&oacute;n de Beneficiarios Centro Particular</h2>
    <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />
  
            
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