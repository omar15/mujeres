<?php
/**
 * Clase que nos permite administrar lo relacionado a la tabla de accion_grupo
 * **/ 

//Inclumos librería MysqliDb
include_once($_SESSION['inc_path'].'libs/fpdf/fpdf.php');

//Inclumos librería de fechas
include_once($_SESSION['inc_path'].'libs/Fechas.php');

//Inclumos librería de fechas
include_once($_SESSION['inc_path'].'libs/Permiso.php');

class ReportePadronTransparenciaPDF extends FPDF{

var $datos;
var $axo_padron;
var $datos_comunidad;

  //Constructor de la clase para crear reporte
	public function __construct($datos,$axo_padron,$datos_comunidad)
    {
        parent::FPDF('P','mm','Legal');		   
    		$this->SetMargins(7,5,5);
    		$this->AddPage();
    		$this->datos = $datos;       
        $this->axo_padron = $axo_padron;
        $this->datos_comunidad = $datos_comunidad;                
    }

  //Pie de página
  function Footer()
  {
      //Posición: a 1 cm del final
      $this->SetY(-10);
      //Arial italic 8
      $this->SetFont('Arial','I',8);
      //Número de página
      putenv("TZ=America/Mazatlan");
      $this->Cell(0,10,'Fecha de Emisión:'.date('d/M/Y H:i').'hrs.     Pagina '.$this->PageNo(),0,0,'C');
  }

  public function reporteTrans(){
      
      $this->image('../../img/dif.jpg',185,5,22,15);
      $this->image('../../img/gob.jpg',10,2,30,20);

      $this->ln(3);
      
      $this->SetFont('Arial','B',7);
      $this->ln();
      $this->Cell(200,4,'PROGRAMA DN2 ASISTENCIA ALIMENTARIA A POBLACIÓN VULNERABLE DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');
      $this->Cell(200,4,'INSCRIPCIÓN DE MENORES A BENEFICIAR CON PROALIMNE',0,1,'C');

      $this->ln(4);      

      $this->SetFont('Arial','B',7);

      //Imprimimos datos generales de la comunidad
      if($this->datos_comunidad !=null) {

        $this->ln();
        $this->Cell(10,3,'AÑO DE REGISTRO :  '.$this->axo_padron,0,1,'L');
        $this->datos_comunidad["CVE_MUN"].' - '.utf8_decode($this->datos_comunidad["nombre_centro"]);
        $tipo_comunidad = $this->datos_comunidad["nombre_tipo"];

        $this->Cell(200,3,'MUNICIPIO :'.$this->datos_comunidad['CVE_MUN'].' - '.utf8_decode($this->datos_comunidad['NOM_MUN']),0,1,'L');
        $this->Cell(180,3,'NIÑOS INSCRITOS : '.count($this->datos),0,1,'L');
        //$this->Cell(110,3,'COLONIA/LOCALIDAD :'.$this->datos_comunidad["CVE_EST_MUN_LOC"].' - '.$this->datos_comunidad["nombre_comunidad"],0,1,'L');
        $this->Cell(110,3,'CÓDIGO POSTAL : '.$this->datos_comunidad["cp"].', TIPO DE LOCALIDAD : '.utf8_decode($this->datos_comunidad["nombre_tipo"]),0,1,'L');

        }

      $this->SetFillColor(224,235,255);
      $this->ln();

      $this->Cell(40,8,'',0,0,'C',0);
      $this->Cell(20,8,'#',1,0,'C',1);
      $this->Cell(100,8,'NOMBRE COMPLETO DEL MENOR',1,0,'C',1);

      $this->ln();
        
      //Usaremos contador para saber el número que cada beneficiario ocupa en la lista 
      $i = 0;

        //Recorremos arreglo de datos del beneficiario 
         foreach($this->datos as $d):
         
          $i++;
          
          $this->Cell(40,8,'',0,0,'C',0);
          $this->Cell(20,8,$i,1,0,'C',0);
          $this->Cell(100,8,utf8_decode($d["paterno"]).' '.utf8_decode($d["materno"])." ".utf8_decode($d["nombres"]),1,1,'C');
           
         endforeach;

      //$this->Output('padron_proalimne.pdf',D);
      $this->Output();   

}


}
