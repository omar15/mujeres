<?php
session_start();//Habilitamos uso de variables de sesi�n

    //Obtenemos el tipo de edici�n
    if(isset($_GET["id_edicion"])){
        $id_edicion = intval($_GET["id_edicion"]);
    }

//Incluimos cabecera
include($_SESSION['inc_path']. 'header.php');
//Mensaje respuesta
list($mensaje,$clase) = Permiso::mensajeRespuesta($respuesta);
?>
<div id="principal">
   <div id="contenido">
    <h2 class="centro">Edici&oacute;n de Men&uacute;s</h2>
    <?php if($respuesta > 0){?>
    
    <div class="mensaje <?php echo $clase; ?>">
        <?php echo $mensaje;?>
    </div>
    
    <?php } ?>
    
	<div  align="center">                
        <?php
            //Si el registro no es exitoso mostramos el formulario de usuario 
            if($respuesta != 1){        
                include_once("form_menu.php");    
            }
        ?>
    </div>
        </div>
    </div>
<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>