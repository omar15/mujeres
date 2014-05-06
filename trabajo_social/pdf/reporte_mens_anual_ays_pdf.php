<?php
/**
 * Clase que nos permite administrar lo relacionado a la tabla de accion_grupo
 * **/ 

//Inclumos librerías
include_once($_SESSION['inc_path'].'libs/fpdf/fpdf.php');
include_once($_SESSION['model_path'].'apoyo_otorgado.php');

class ReporteMensAnualAysPDF extends FPDF{

var $datos;

	public function __construct($datos,$totales_mes)

    {
        parent::FPDF('L','mm','Legal');		        
		$this->SetMargins(20,5,5); 
		$this->AddPage();
		$this->datos = $datos; 
        $this->totales_mes = $totales_mes;       
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
	 $this->Cell(0,10,utf8_decode('Fecha de Emisión:'.date('d/M/Y H:i').'hrs.     Página '.$this->PageNo()),0,0,'C');
	}


	//Tabla simple
	function BasicTable($header,$data)
	{
	    //Cabecera
	    foreach($header as $col)
	        $this->Cell(40,7,$col,1);
	    $this->Ln();
	    //Datos
	    foreach($data as $row)
	    {
	        foreach($row as $col)
	            $this->Cell(40,6,$col,1);
	        $this->Ln();
	    }
	}

	//Una tabla más completa
	function ImprovedTable($header,$data)
	{
	    //Anchuras de las columnas
	    $w=array(40,35,40,45);
	    //Cabeceras
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C');
	    $this->Ln();
	    //Datos
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR');
	        $this->Cell($w[1],6,$row[1],'LR');
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	        $this->Ln();
	    }
	    //Línea de cierre
	    $this->Cell(array_sum($w),0,'','T');
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{
	    //Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B');
	    //Cabecera
	    $w=array(40,35,40,45);
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	    $this->Ln();
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    //Datos
	    $fill=0;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
	        $this->Ln();
	        $fill=!$fill;
	    }
	    $this->Cell(array_sum($w),0,'','T');
	}

	public function reporteConcentrado(){

		$this->image('../../img/dif.jpg',320,5,25,17);
		$this->image('../../img/gob.jpg',20,5,30,16);

		$this->SetFont('Arial','B',10);
		$this->SetXY(10,20);
		$this->Cell(320,4,'SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA',0,1,'C');
		$this->Cell(320,4,'DIRECCION DE ASISTENCIA ALIMENTARIA',0,1,'C');
		$this->Cell(320,4,'Concentrado Mensual y Anual de Actividades, Apoyos y Servicios Otorgados.',0,1,'C');

		$this->SetXY(10,38);
        $this->SetFont('Arial','B',9);

        $X = 83;
        $this->SetFillColor(180,180,180);
        $this->multiCell($X,8,'Apoyos Existenciales',1,'L',true);
        $this->SetXY( ($X + 10),38);
        $x = 21;
        $this->Cell($x,4,'Enero',1,0,'C',true);
        $this->Cell($x,4,'Febrero',1,0,'C',true);
        $this->Cell($x,4,'Marzo',1,0,'C',true);
        $this->Cell($x,4,'Abril',1,0,'C',true);
        $this->Cell($x,4,'Mayo',1,0,'C',true);
        $this->Cell($x,4,'Junio',1,0,'C',true);
        $this->Cell($x,4,'Julio',1,0,'C',true);
        $this->Cell($x,4,'Agosto',1,0,'C',true);
        $this->Cell($x,4,'Septiembre',1,0,'C',true);
        $this->Cell($x,4,'Octubre',1,0,'C',true);
        $this->Cell($x,4,'Noviembre',1,0,'C',true);
        $this->Cell($x,4,'Diciembre',1,1,'C',true);
        $this->setX(($X + 10));

        $this->SetFont('Arial','B',8);
        $x = ($x/2);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        
        
		$this->ln();
		  
		
        $Y = 46;       
 		foreach($this->datos as $d):
        if($d['padre'] != 0){ 
 		$this->setX(10);
 		$this->SetFont('Arial','B',5);
        //$this->setXY(10,$Y);
        $this->Cell($X,4,utf8_decode($d['nombre_serv']),1,0,"L");
        //$this->setXY(48,$Y);
        $this->SetFont('Arial','B',5);
        $this->Cell($x,4,$d['cantidad_tot_ene'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_ene']),1,0,"L"); 
        $this->Cell($x,4,$d['cantidad_tot_feb'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_feb']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_mar'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_mar']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_abr'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_abr']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_may'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_may']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_jun'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_jun']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_jul'],1,0,"L"); 
        $this->Cell($x,4,number_format($d['monto_tot_jul']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_ago'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_ago']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_sep'],1,0,"L"); 
        $this->Cell($x,4,number_format($d['monto_tot_sep']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_oct'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_oct']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_nov'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_nov']),1,0,"L");
        $this->Cell($x,4,$d['cantidad_tot_dic'],1,0,"L");
        $this->Cell($x,4,number_format($d['monto_tot_dic']),1,1,"L");
        $Y += 4;
        //break;
        }else{
            $this->SetFillColor(180,180,180);
          	$this->SetFont('Arial','B',7);  
          $this->setX(10);
          $this->Cell(335,4,utf8_decode($d['nombre_serv']),1,1,"L",true);   
        }
  		endforeach;
        
        ////////////TOTALES
        
         
        $this->SetXY(10,175);
        $this->SetFont('Arial','B',9);

        $X = 83;
         $this->SetFillColor(180,180,180);
        $this->multiCell($X,8,'Apoyos Existenciales',1,'L',true);
        $this->SetXY( ($X + 10),175);
        $x = 21;
        $this->Cell($x,4,'Enero',1,0,'C',true);
        $this->Cell($x,4,'Febrero',1,0,'C',true);
        $this->Cell($x,4,'Marzo',1,0,'C',true);
        $this->Cell($x,4,'Abril',1,0,'C',true);
        $this->Cell($x,4,'Mayo',1,0,'C',true);
        $this->Cell($x,4,'Junio',1,0,'C',true);
        $this->Cell($x,4,'Julio',1,0,'C',true);
        $this->Cell($x,4,'Agosto',1,0,'C',true);
        $this->Cell($x,4,'Septiembre',1,0,'C',true);
        $this->Cell($x,4,'Octubre',1,0,'C',true);
        $this->Cell($x,4,'Noviembre',1,0,'C',true);
        $this->Cell($x,4,'Diciembre',1,1,'C',true);
        $this->setX(($X + 10));

        $this->SetFont('Arial','B',8);
        $x = ($x/2);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        $this->Cell($x,4,'Cant.',1,0,'C',true);
        $this->Cell($x,4,'Monto',1,0,'C',true);
        
        
		$this->ln();
       	
	
		
        //$x = 10.5;
        $this->setX(10.1);
        $this->SetFont('Arial','B',9);
        $this->Cell($X,4,'Totales',1,0,"L",true);
        foreach($this->totales_mes as $t):
        $this->SetFont('Arial','B',7);
        $this->Cell($x,4,$t['total_cantidad'],1,0,"L");
        $this->Cell($x,4,number_format($t['total_monto']),1,0,"L"); 
        //$x+=10.5;
        endforeach;

        //$this->Output('caratula_nut_ext.pdf','D');
		$this->Output();
	}
    
 
}