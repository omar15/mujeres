<?php
session_start();

//Incluimos cabecera
include('../../inc/header.php');

?>
<div id="principal">
   <div id="contenido">
    <h1 class="centro">&iexcl;Bienvenido al M&oacute;dulo de <?php echo $_SESSION['module_desc']; ?>!</h1>
    
    <p>El Sistema DIF Jalisco atendiendo la demanda de atenci&oacute;n de la poblaci&oacute;n vulnerable y obedeciendo a la normatividad establecida en el c&oacute;digo de asistencia social (art&iacute;culos 5, 6, y 7), implementa estrategias encaminadas a apoyar a familias, personas y grupos que se encuentran inmersos en problem&aacute;ticas sociales, quienes por su condici&oacute;n de vulnerabilidad, marginaci&oacute;n o exclusi&oacute;n, est&aacute;n imposibilitados para resolverlas. </p>
<p>Conexo a lo anterior, resulta menester se&ntilde;alar que el trabajo social tiene como objeto de estudio las necesidades y problemas sociales, est&aacute; orientado a intervenir en ellos de manera profesional, integrando en los modelos los conocimientos tanto de otras disciplinas como de las sociedades concretas. Enfocado en convertir al individuo en actor principal de su cambio social, a trav&eacute;s de la potencializaci&oacute;n de sus capacidades, guiando su actuar en los principios de los derechos humanos y la justicia social. 
</p>

        <?php
        //Si enviamos respuesta
        if(isset($_GET['r'])){
        
            //Variable de respuesta
            $respuesta = $_GET['r'];
            
            //Mensaje respuesta
            $mensaje = Permiso::mensajeRespuesta($respuesta);            
            
            //Imprimimos mensaje
            echo $mensaje;                      
        
        }                        
        ?>
       
   </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path']. 'footer.php'); 		
?>  