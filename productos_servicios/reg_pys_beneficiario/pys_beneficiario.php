<?php
session_start();  
//Incluimos cabecera
include($_SESSION['inc_path'].'header.php'); 
//Obtenemos listado de permiso en menu central
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center');
//Incluimos modelos
//include_once($_SESSION['model_path'].'beneficiario_pys.php');
include_once($_SESSION['model_path'].'beneficiario.php');
//Obtenemos id del beneficiario
$id_beneficiario=$_GET['id_edicion'];
//Obtenemos listado de servicios
//list($lista_pys,$p) = Beneficiario_pys::listaPagBeneficiarioServ($id_beneficiario);
//Obtenemos datos del beneficiario
$lista= Beneficiario::expedienteBeneficiario($id_beneficiario);
$lista = $lista[0];
?>
 
  <div id="principal">

  <div id="contenido">
<!-- programas y servicios del beneficiario -->

   <h2 class="centro">Seguimiento de Servicios Otorgados</h2>    

     <div id="page_list" align="center">        

     <?php include($_SESSION['inc_path']."productos_servicios/lista_pys.php");?>

    </div>


  <!-- form agregar productos y servicios a beneficiario -->

  <div>

    <h2 class="centro">Otorgar Nuevo Servicio</h2>

    <div  id='nuevo_servicio'>

      <?php include("form_beneficiario_pys.php");?>

       </div>    

     </div>   
  
  
  </div>    

  </div>       
  
  <?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>


      