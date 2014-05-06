<?php
session_start();

 //Obtenemos conexión
include ($_SESSION['inc_path'] . "conecta.php");

//Guardamos variables
$nom_reporte = $_POST['nom_reporte'];

//Verificamos que los datos hayan sido enviados
if($nom_reporte != NULL){

  switch ($nom_reporte) {
    case 'concentrado_mensual':
          
          //Incluimos modelos
          include_once($_SESSION['model_path'].'apoyo_otorgado.php');          

          //Listado de servicios específicos
          $datos = Apoyo_otorgado::TotalesMesAys();
          
          //Obtenemos los totales por servicio
          $totales_mes = Apoyo_otorgado::repTotalesPorMeses();
          
          //Importamos PDF
          include_once($_SESSION['module_path_r'].'pdf/reporte_mens_anual_ays_pdf.php');           
          
          //Creamos reporte
          $reporte = new ReporteMensAnualAysPDF($datos,$totales_mes);
          $reporte->reporteConcentrado();
          
          break;
          
    break;
    
    default:
          echo '<div class="mensaje">Reporte no disponible</div>';
          break;
  }

}else{
    echo '<div class="mensaje">Datos incompletos</div>.<br>';
    //echo 'municipio'.$id_municipio.'<br>';
     //echo 'ano_padron'.$axo_padron.'<br>';
      //echo 'reporte'.$nom_reporte.'<br>';  
}
?>