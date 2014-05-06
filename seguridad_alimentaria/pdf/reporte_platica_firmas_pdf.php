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

class ReportePlaticaFirmasPDF extends FPDF{

var $datos;
var $centro;
var $axo_padron;

    public function __construct($datos,$centro,$axo_padron)
    {
      parent::FPDF('L','mm','Legal');           
      $this->SetMargins(5,5,1);
      $this->AddPage();
      $this->datos = $datos;        
      $this->centro = $centro;
      $this->axo_padron = $axo_padron;
    }

    //Pie de página
    function Footer(){
    
    //Posición: a 1 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    putenv("TZ=America/Mazatlan");
    $this->Cell(0,10,'Fecha de Emisión:'.date('d/M/Y H:i').'hrs.     Pagina '.$this->PageNo(),0,0,'C');
    
    }

  public function reportePlaticas(){

    $this->image('../../img/dif.jpg',320,5,25,17);
    $this->image('../../img/gob.jpg',20,5,30,16);

    $this->SetFont('Arial','B',10);
    
    $this->ln();
    $this->Cell(310,4,'PROGRAMA DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');
    $this->Cell(310,4,'LISTADO DE FIRMAS PARA LA ENTREGA DE LA DOTACIÓN DE ALIMENTOS Y ',0,1,'C');
    $this->Cell(310,4,'ASISTENCIA A LA  PLATICA  DE ORIENTACIÓN ALIMENTARIA',0,1,'C');

    $this->ln(2);
    $this->SetFont('Arial','B',9);


    if($this->centro != NULL){

      $this->ln();
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
    $this->ln(3);
    $this->Cell(110,3,'TEMA DE LA PLÁTICA:______________________________________________',0,1,'L');
    $this->ln();

    $this->SetFont('Arial','B',9);
    //$this->Cell(30,4,'CURP',1,0,'C',1);
    $this->Cell(75,6,'NOMBRE DEL BENEFICIARIO',1,0,'C',1);
    $this->Cell(75,6,'RESPONSABLE',1,0,'C',1);
    $this->Cell(10,6,'SEXO',1,0,'C',1);
    $this->Cell(15,6,'PES/TAL',1,0,'C',1);
    $this->Cell(10,6,'EDAD',1,0,'C',1);
    $this->SetFont('Arial','B',7);
    $this->Cell(51,6,'FIRMA ASIST PLATICA ORIENTACIÓN ALIMENT.',1,0,'L',1);
    $this->Cell(51,6,'FIRMA RECEPCIÓN DE ALIMENTOS',1,0,'L',1);
    $this->Cell(51,6,'FIRMA CUOTA RECUPERACIÓN $7.00',1,1,'L',1);
    $this->SetFont('Arial','B',9);

    foreach ($this->datos as $value):

    $band=$band+1;// es el contador

    //$this->Cell(30,10,$this->datos["curp_dif"],1,0,'C',0);
    $this->SetAutoPageBreak(false);
    $ye=$this->GetY();
    $this->MultiCell(75,7,utf8_decode($value["paterno"])." ".utf8_decode($value["materno"])." \n".utf8_decode($value["nombres"]),1);
    $this->SetXY(80,$ye);
    $ye=$this->GetY();
    $this->MultiCell(75,7,utf8_decode($value["tutor_nombres"])." \n".utf8_decode($value["tutor_paterno"])." ".utf8_decode($value["tutor_materno"]),1);
    $this->SetXY(155,$ye);
    
    $this->Cell(10,14,substr($value["genero"],0,1),1,0,'C',0);

    //$this->Cell(9,10,$this->datos["pseso1"].'/'.$this->datos["talla1"],1,0,'C',0);
    $this->Cell(15,14,'',1,0,'C',0);
    $this->Cell(10,14,$value["edad"],1,0,'C',0);
    $this->Cell(51,14,"",1,0,'C',0);
    $this->Cell(51,14,"",1,0,'C',0);
    $this->Cell(51,14,"",1,1,'C',0);
    $this->SetAutoPageBreak(true,20);
    $this->Cell(0,0,'',0,1,'C',0);
    
    endforeach;
      
    $this->ln(3);

    $this->Cell(110,3,'FECHA________________________',0,0,'L');
    $this->ln(4);
    
    $this->Cell(110,3,'SELLO DEL DIF MUNICIPAL',0,0,'L');
    $this->Cell(110,3,' FIRMA DEL DIRECTOR(A)______________________________________________ ',0,0,'L'); 

    //  if ($unico==1)
    //  { 
    //    $this->SetFont('Arial','',10);
    //    $this->Cell(80,6,$nombreesc,1,0,'L');
    //    $this->Cell(40,6,$cve_esc,1,0,'C'); 
    //    $this->Cell(30,6,'0',1,0,'C');
    //    $this->Cell(30,6,'0',1,0,'C');
    //    $this->Cell(20,6,'0',1,0,'C');
    //    $this->Cell(18,6,'0',1,0,'C');
    //    $this->Cell(18,6,$frias2,1,0,'C');
    //    $this->Cell(25,6,$calientes2,1,0,'C');
    //    $this->Cell(20,6,$ninos2,1,0,'C');
    //    $this->Cell(20,6,$ninas2,1,0,'C');
    //    $this->Cell(20,6,$ninos2+$ninas2,1,1,'C');
    //    $this->SetFont('Arial','B',10);
    //   }

    $this->Output();

  }

}