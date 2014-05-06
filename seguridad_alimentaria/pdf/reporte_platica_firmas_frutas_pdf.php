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

class ReportePlaticaFirmasFrutasPDF extends FPDF{

var $datos;
var $centro;
var $axo_padron;

    public function __construct($datos,$centro,$axo_padron)
    {
      parent::FPDF('P','mm','Legal');           
      $this->SetMargins(3,3,1);
      $this->AddPage();
      $this->datos = $datos;        
      $this->centro = $centro;
      $this->axo_padron = $axo_padron;
    }
//////////////////////////////////////////////////////////////////////
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

public function reportePlaticasFrutas(){

$this->image('../../img/dif.jpg',190,5,20,13);
$this->image('../../img/gob.jpg',5,5,25,12);

$this->SetFont('Arial','B',10);
$this->ln();

$this->SetFont('Arial','B',7);
$this->Cell(210,4,'PROGRAMA DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');
$this->Cell(210,4,'LISTADO DE FIRMAS PARA LA ENTREGA DE LA FRUTA Y VERDURA ADQUIRIDA CON LAS CUOTAS DE RECUPERACIÓN ',0,1,'C');
$this->Cell(210,4,'CORRESPONDIENTE A LA ESTRATEGIA AMPLIACIÓN DE COBERTURA Y FORTALECIMIENTO DE LOS INSUMOS ALIMENTARIOS',0,1,'C');

$this->ln();
$this->ln();
$this->SetFont('Arial','B',7);


if ($this->centro != NULL) {

$this->Cell(110,3,'AÑO DE REGISTRO :  '.$this->axo_padron,0,0,'L');
$nom_centro=$this->centro["id_centro_atencion"].' - '.$this->centro["CVE_EST_MUN_LOC"].' - '.$this->centro["nombre_centro"];
$this->Cell(110,3,'NOMBRE DEL CENTRO : '.utf8_decode($nom_centro),0,0,'L');
$tipo_comunidad = $this->centro["nombre_tipo"];

$this->Cell(110,3,'TIPO DE CENTRO: '.utf8_decode($this->centro["nombre_tipo_centro"]),0,1,'R');
$this->Cell(110,3,'MUNICIPIO :'.utf8_decode($this->centro['id_municipio']).' - '.utf8_decode($this->centro["municipio_nom"]),0,0,'L');
$this->Cell(110,3,'DIRECCIÓN : '.utf8_decode($this->centro["direccion"]),0,0,'L');
$this->Cell(110,3,'NIÑOS INSCRITOS : '.count($this->datos),0,1,'R');
$this->Cell(110,3,'COLONIA/LOCALIDAD :'.$this->centro["CVE_EST_MUN_LOC"].' - '.utf8_decode($this->centro["nombre_comunidad"]),0,0,'L');
$this->Cell(110,3,'TELEFONO : '.$this->centro["telefono"],0,1,'L');

$this->Cell(110,3,'CÓDIGO POSTAL : '.$this->centro["cp"].', TIPO DE LOCALIDAD : '.utf8_decode($this->centro["nombre_tipo"]),0,1,'L');


}
$this->SetFillColor(224,235,255);
$this->ln();
$this->ln();
$this->ln();
 $this->Cell(110,3,'CONTENIDO DE LA ENTREGA:______________________________________________',0,1,'L');
$this->ln();

$this->SetFont('Arial','B',8);
//$pdf->Cell(30,4,'CURP',1,0,'C',1);
$this->Cell(50,6,'NOMBRE DEL BENEFICIARIO',1,0,'C',1);
$this->Cell(55,6,'RESPONSABLE',1,0,'C',1);
$this->Cell(8,6,'SEXO',1,0,'C',1);
$this->Cell(15,6,'PES/TAL',1,0,'C',1);
$this->Cell(8,6,'EDAD',1,0,'C',1);
$this->SetFont('Arial','B',7);
$this->Cell(65,6,'FIRMA DE PADRE O TUTOR DEL BENEFICIARIO.',1,1,'L',1);

$this->SetFont('Arial','B',8);




  foreach ($this->datos as $value):
  
  $band=$band+1;// es el contador

//$pdf->Cell(30,10,$row_todos["curp_dif"],1,0,'C',0);
$this->SetAutoPageBreak(false);
$ye=$this->GetY();
$this->MultiCell(50,7,utf8_decode($value["paterno"])." ".utf8_decode($value["materno"])." \n".utf8_decode($value["nombres"]),1);
//$this->MultiCell(50,7,$row_todos["apellido_pat"]." ".$row_todos["apellido_mat"]." \n".$row_todos["nombres"],1);
$this->SetXY(53,$ye);
$this->Cell(55,14,utf8_decode($value["tutor_nombres"]),1,0,'C',0);
//$this->Cell(55,14,$row_todos["nombre_responsable"],1,0,'C',0);

$this->Cell(8,14,substr($value["genero"],0,1),1,0,'C',0);

//$pdf->Cell(9,10,$row_todos["pseso1"].'/'.$row_todos["talla1"],1,0,'C',0);
$this->Cell(15,14,'',1,0,'C',0);
$this->Cell(8,14,$row_todos["edad"],1,0,'C',0);
$this->Cell(65,14,"",1,1,'C',0);
$this->SetAutoPageBreak(true,20);
$this->Cell(0,0,'',0,1,'C',0);
   
   endforeach;

 $this->ln();


$this->ln();
$this->ln();

$this->Cell(110,3,'FECHA________________________',0,0,'L');
$this->ln();
$this->ln();
$this->ln();
$this->ln();
$this->Cell(110,3,'SELLO DEL DIF MUNICIPAL',0,0,'L');
$this->Cell(110,3,' FIRMA DEL DIRECTOR(A)______________________________________________ ',0,0,'L');



$this->Output();




/////////////////////////////////////////////////////////////////////

}
}