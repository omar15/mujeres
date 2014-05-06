<?php
session_start();

//Incluimos cabecera
include('../../inc/header.php' );

?>
<div id="principal">
   <div id="contenido">
    <h1 class="centro">Formatos</h1>
     
     <ul>      
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/ACTA CONSTITUTIVA.pdf">Acta Constitutiva Nutrici&oacute;n Extraescolar</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Estudio Sociofamiliar General.pdf">ESF Nutrici&oacute;n Extraescolar</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Reporte de Inconformidad.pdf">Reporte de Inconformidad</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Recepci&oacute;n de Alimentos.pdf">Recepci&oacute;n de Alimentos</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/FORMATOS PROYECTO CUOTAS 2014.pdf">Formato Proyecto Cuotas 2014</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Carta Compromiso Padres o Tutores de beneficiarios.pdf">Carta Compromiso Padres o Tutores de Beneficiarios</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/CARTA COMPROMISO SDIF M.pdf">Carta Compromiso Sistema DIF Municipal</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/CARTA COMPROBACION DE INGRESOS.pdf">Carta Comprobaci&oacute;n de Ingresos</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/COSTANCIA DE AUTORIZACION.pdf">Constancia de Autorizaci&oacute;n</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Ejemplo Validaci&oacute;n Padron de Beneficiarios.pdf">Ejemplo Validaci&oacute;n Padr&oacute;n de Beneficiarios</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Entrega Dotaci&oacute;n lista de Espera.pdf">Entrega Dotaci&oacute;n Lista de Espera</a></li> 
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Plan de Limpieza y Fumigacion.pdf">Plan de Limpieza y Fumigaci&oacute;n</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Reglas de  DE Operaci&oacute;n 2013.pdf">Reglas de Operaci&oacute;n 2013</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/RECETARIO PROALIMNE 2013.pdf">Recetario Nutrici&oacute;n Extraescolar 2013</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/2012 Manual Nutricion Extraescolar Nov 2012.pdf">Manual de Nutrici&oacute;n Extraescolar</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Cartas descriptivas Platicas de Orientacion Alimentaria.pdf">Cartas descriptivas de Pl&aacute;ticas de Orientacion Alimentaria</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-01 Proyect d Capt Aplic Cuotas recup.xls">Proyecto de Aplicaci&oacute;n de Cuotas de Recuperaci&oacute;n</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-02 Cuot Recup Ampliac Cobertura 2013.xlsx">Cuotas de Recuperaci&oacute;n ampliaci&oacute;n de Cobertura</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-03 Cuot Recup Proyectos Productivos 2013.xlsx">Cuotas de Recuperaci&oacute;n Proyectos Productivos</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-42 Evaluacion Inicial y Final 2013.pdf">Evaluaci&oacute;n Inicial y Final</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-43 Formatos para Comprobar Proyecto 2013.xls">Formatos para Comprobar Proyectos</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/DJ-SA-SG-RE-47 Intrucciones para elaboracion del proyecto.pdf">Instrucciones para Elaboraci&oacute;n de Proyectos</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/Calendario para la comprobacion de proyecto.pdf">Calendario para la Comprobaci&oacute;n del Proyectos</a></li>
     <li><a target="_blank" href="<?php echo $_SESSION['files_path']?>proalimne/INSTRUCCIONES PARA LA CAPTURA de padron 2014.pdf">Instrucciones para la captura del Padr&oacute;n 2014</a></li>
     </ul> 
       
   </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path']. 'footer.php'); 		