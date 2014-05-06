<?php
session_start();

include ("../inc/conecta.php"); 

//Obtenemos la respuesta al momento de querer loguearnos
$respuesta = (isset($_GET["r"]))? $_GET["r"] : NULL;

include_once('../inc/libs/Permiso.php');

//Nos ayudará a determinar el navegador del cliente
include_once('../inc/libs/Navegador.php');

//Mensaje respuesta
$mensaje = Permiso::mensajeRespuesta($respuesta);
//Validamos Respuesta
if($respuesta == 1) {
		
    //Actualizamos la variable de sesión del módulo
    
    Permiso::updateModule();	
	
    header('Location: log/menu.php');    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
    <meta charset="UTF-8"/>
    <title>Login</title>
    
    <link href="../css/benefits.css" rel="stylesheet" type="text/css" />
	<link href="../css/modulo/login.css" rel="stylesheet" type="text/css"/>
    
    <script lang="javascript" type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>        
     <!-- jqueryui -->
     <script lang="javascript" type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>             
     <script lang="javascript" type="text/javascript" src="../js/jquery.validate.js"></script>
     <script lang="javascript" type="text/javascript" src="../js/inicio.js"></script>       
    </head>
    <body>    
    
    <div id="pagina">
    <div id="header">
    	<div id="header_superior">
            <div id="logo_dif"><img src="../img/logo_dif.png" width="104" height="78" /></div>
            <div id="titulo_header">Sistema de Beneficiarios</div>
            <div id="logo_bienestar"><img src="../img/logo_bienestar.png" width="204" height="58" /></div>
        </div>        
    </div>
    
    <div id="principal">
    	   <?php if($respuesta > 0){?>    
            <div class="mensaje"><?php echo $mensaje;?></div>    
            <?php } ?>                        
            
        	<div  align="center">                
                <?php
                    //Obtenemos datos del navegador
                    $Nav = new Navegador();

                    if($Nav->Name == 'msie'){
                        echo '
                        <div class="mensaje">
                        Para el correcto el uso del sistema, le recomendamos el uso de otro navegador,
                        como <a target="_blank" href="https://www.mozilla.org/">Firefox</a> &Oacute;  
                        <a target="_blank" href="https://www.google.com/chrome/">Chrome</a>. 
                        Evite usar Internet Explorer.
                        </div>';
                    }                    

                    //Si el registro no es exitoso mostramos el formulario de usuario 
                    if($respuesta != 1){        
                        include_once("log/form_login.php");    
                    }
                ?>
        	</div>
    </div>   
    
     <div id="footer">
    	<div id="footer_superior">
        	<div id="logo_dif_footer"><img src="../img/logo_dif_inferior.png" width="64" height="48" /></div>
            <div id="titulo_footer">Sistema de Beneficiarios</div>
        </div>
        <div id="footer_inferior">
        	&copy; Sistema para el Desarrollo Integral de la Familia del Estado de Jalisco
        </div>
    </div>     
	
    </div>        
    </body>
</html>