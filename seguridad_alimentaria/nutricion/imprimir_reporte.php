<?php
session_start();

 //Obtenemos conexión
include ($_SESSION['inc_path'] . "conecta.php");

//Guardamos variables
$id_municipio = '14'.$_POST['id_municipio_caratula'];
$axo_padron = $_POST['axo_padron'];
$nom_reporte = $_POST['nom_reporte'];
$id_centro_atencion = $_POST['id_centro_atencion'];
$CVE_ENT_MUN_LOC = $_POST['CVE_ENT_MUN_LOC'];

//Consulta para obtener datos del municipio
$sql = "SELECT CVE_ENT_MUN, CVE_MUN, NOM_MUN 
        FROM cat_municipio 
        WHERE CVE_ENT_MUN = ?";

//Concatenamos estado fijo (Jalisco)
$params = array($id_municipio);

//Datos del municipio
$municipio = $db->rawQuery($sql,$params);
$municipio = $municipio[0];

//Verificamos que los datos hayan sido enviados
if($id_municipio != NULL && $axo_padron != NULL && $nom_reporte != NULL){

  switch ($nom_reporte) {
    case 'caratula':
          
          //Importamos PDF
          include_once($_SESSION['module_path_r'].'pdf/reporte_caratula_pdf.php'); 

          //Importamos modelo alim_nutricion_extraescolar
          include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php'); 

          //Obtenemos datos para el reporte
          list($datos,$totales) = Alim_nutricion_extraescolar::reporte_caratula($id_municipio,$axo_padron);
          
          //Creamos reporte
          $reporte = new ReporteCaratulaPDF($datos,$totales,$axo_padron,$municipio);

          $reporte->reporteCaratula();
          break;
          
   case 'reporte_proalimne_indigena':
         
        //Importamos PDF
        include_once($_SESSION['module_path_r'].'pdf/reporte_caratula_pdf.php'); 

        //Importamos modelo alim_nutricion_extraescolar
        include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');
        
        //Con el parametro true indicamos que enviaremos un indigena
        list($datos,$totales) = Alim_nutricion_extraescolar::reporte_caratula($id_municipio,$axo_padron,true); 
        
        //Creamos reporte
        $reporte = new ReporteCaratulaPDF($datos,$totales,$axo_padron,$municipio);

        $reporte->reporteCaratula();
        break;
  
  case 'selecciona_centro_proalimne':
        //Verificamos que el centro de atención y la comunidad hayan sido enviados
        if($id_centro_atencion != NULL && $CVE_ENT_MUN_LOC != NULL){
            //Importamos PDF
            include_once($_SESSION['module_path_r'].'pdf/reporte_padron_pdf.php'); 

            //Importamos modelo alim_nutricion_extraescolar
            include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

            //Importamos modelo centros de atención
            include_once($_SESSION['model_path'].'centros_atencion.php');
        
            //Obtenemos Datos            
            $datos = Alim_nutricion_extraescolar::reporte_padron($id_municipio,$id_centro_atencion,$axo_padron); 
            $centro = Centros_atencion::datosCentro($id_centro_atencion);		
		
            //Creamos reporte
            $reporte = new ReportePadronPDF($datos,$centro,$axo_padron);            

            $reporte->reportePadron();

        }
        
        break;
 case 'selecciona_centro':
      
      //Verificamos que se envié variable para comunidad
      if($CVE_ENT_MUN_LOC != NULL){

      //Importamos PDF
      include_once($_SESSION['module_path_r'].'pdf/reporte_padron_transparencia_pdf.php');
      
      //Importamos modelo alim_nutricion_extraescolar
      include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

      //Importamos modelo comunidad
      include_once($_SESSION['model_path'].'comunidad.php');

      //Importamos modelo centros de atención
      include_once($_SESSION['model_path'].'centros_atencion.php');

      //Con el parametro true indicamos que enviaremos un indigena
      $datos = Alim_nutricion_extraescolar::reporte_padron_transparencia($id_municipio,$id_centro_atencion,$axo_padron,$CVE_ENT_MUN_LOC);
      $datos_comunidad = Comunidad::datos_comunidad($CVE_ENT_MUN_LOC);

      //Creamos reporte
      $reporte = new ReportePadronTransparenciaPDF($datos,$axo_padron,$datos_comunidad);
      $reporte->reporteTrans();

      }

    break;

    case 'selecciona_centro_firmas':

    //Verificamos que el centro de atención y la comunidad hayan sido enviados
    if($id_centro_atencion != NULL && $CVE_ENT_MUN_LOC != NULL){

      //Importamos PDF
      include_once($_SESSION['module_path_r'].'pdf/reporte_platica_firmas_pdf.php');

      //Importamos modelo alim_nutricion_extraescolar
      include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

      //Importamos modelo centros de atención
      include_once($_SESSION['model_path'].'centros_atencion.php');

      //Obtenemos Datos
      $datos = Alim_nutricion_extraescolar::reporte_platica_firmas($id_municipio,$id_centro_atencion,$axo_padron);
      $centro = Centros_atencion::datosCentro($id_centro_atencion);
      $reporte = new ReportePlaticaFirmasPDF($datos,$centro,$axo_padron);
      $reporte->reportePlaticas();
    }

    break;
    
    ///////////////////
    case 'selecciona_centro_firmas_frutas':

    //Verificamos que el centro de atención y la comunidad hayan sido enviados
    if($id_centro_atencion != NULL && $CVE_ENT_MUN_LOC != NULL){

      //Importamos PDF
      include_once($_SESSION['module_path_r'].'pdf/reporte_platica_firmas_frutas_pdf.php');

      //Importamos modelo alim_nutricion_extraescolar
      include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

      //Importamos modelo centros de atención
      include_once($_SESSION['model_path'].'centros_atencion.php');

      //Obtenemos Datos
      $datos = Alim_nutricion_extraescolar::reporte_platica_firmas($id_municipio,$id_centro_atencion,$axo_padron);
      $centro = Centros_atencion::datosCentro($id_centro_atencion);
      $reporte = new ReportePlaticaFirmasFrutasPDF($datos,$centro,$axo_padron);
      $reporte->reportePlaticasFrutas();
    }

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