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

class ReportePadronPDF extends FPDF{

var $datos;
var $centro;
var $axo_padron;

	public function __construct($datos,$centro,$axo_padron)
    {
        parent::FPDF('L','mm','Legal');		        
		//$this->SetMargins(20,5,5); 
		$this->SetMargins(3,1,1);
		$this->AddPage();
		$this->datos = $datos;        
        $this->centro = $centro;
        $this->axo_padron = $axo_padron;
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

	public function reportePadron(){
		
		$this->image('../../img/dif.jpg',320,5,25,17);
		$this->image('../../img/gob.jpg',20,5,30,16);
		$this->ln();

		$this->SetFont('Arial','B',10);
		$this->ln();
		$this->Cell(320,4,'PROGRAMA DN2 ASISTENCIA ALIMENTARIA A POBLACIÓN VULNERABLE DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');
		$this->Cell(320,4,'INSCRIPCIÓN DE MENORES A BENEFICIAR CON EL PROGRAMA DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');

		$this->ln();
		$this->ln();
		$this->ln();
		$this->ln();

		$this->SetFont('Arial','B',7);		

		if($this->centro != NULL){

		$this->ln();
		$this->Cell(110,3,'AÑO DE REGISTRO :  '.$this->axo_padron,0,0,'L');
		$nom_centro=$this->centro["id_centro_atencion"].' - '.$this->centro["CVE_EST_MUN_LOC"].' - '.$this->centro["nombre_centro"];
		$this->Cell(110,3,'NOMBRE DEL CENTRO : '.utf8_decode($nom_centro),0,0,'L');
		$tipo_comunidad = $this->centro["nombre_tipo"];

		$this->Cell(110,3,'TIPO DE CENTRO: '.utf8_decode($this->centro["nombre_tipo_centro"]),0,1,'R');


		$this->Cell(110,3,'MUNICIPIO :'.utf8_decode($this->centro['id_municipio'].' - '.$this->centro["municipio_nom"]),0,0,'L');
		$this->Cell(110,3,'DIRECCIÓN : '.utf8_decode($this->centro["direccion"]),0,0,'L');

		$this->Cell(110,3,'NIÑOS INSCRITOS : '.count($this->datos),0,1,'R');

		$this->Cell(110,3,'COLONIA/LOCALIDAD :'.$this->centro["CVE_EST_MUN_LOC"].' - '.utf8_decode($this->centro["nombre_comunidad"]),0,0,'L');
		$this->Cell(110,3,'TELEFONO : '.$this->centro["telefono"],0,1,'L');
		$this->Cell(110,3,'CÓDIGO POSTAL : '.$this->centro["cp"].', TIPO DE LOCALIDAD : '.utf8_decode($this->centro["nombre_tipo"]),0,1,'L');
		
		}
		$this->SetFillColor(224,235,255);
		$this->ln();

		$this->SetFont('Arial','',6);
		$this->Cell(27,4,'',0,0,'C');
		$this->Cell(60,4,'',0,0,'C');
		$this->Cell(5,4,'',0,0,'C');
		$this->Cell(6,4,'',0,0,'C');
		$this->Cell(14,4,'',0,0,'C');
		$this->Cell(5,4,'',0,0,'C');
		$this->Cell(45,4,'',0,0,'C');

		if ( $this->axo_padron < 2012)
		{
		  $equis=1;
		}
		else
		  $equis=105;

		$this->Cell($equis,4,'',0,0,'C');

		$this->Cell(27,4,'1ra REVISION',1,0,'C');
		$this->Cell(27,4,'2da REVISIÓN',1,0,'C');
		$this->Cell(27,4,'3ra REVISIÓN',1,0,'C');
		if ( $this->axo_padron < 2012)
		{
		$this->Cell(27,4,'4ta REVISIÓN',1,0,'C');
		$this->Cell(27,4,'5ta REVISIÓN',1,0,'C');
		$this->Cell(27,4,'6ta REVISIÓN',1,0,'C');
		}
		$this->ln();

		//$this->Cell(27,4,'CURP',1,0,'C',1);
		$this->Cell(75,4,'NOMBRE COMPLETO DEL MENOR',1,0,'C',1);
		$this->Cell(5,4,'SEX',1,0,'C',1);

		$this->Cell(18,4,'FEC NAC/EDAD',1,0,'C',1);
		$this->Cell(4,4,'ST',1,0,'C',1);
		$this->Cell(35,4,'DOMICILIO',1,0,'C',1);

		if  ( $this->axo_padron >= 2012 )
		{
		   $this->SetFont('Arial','B',6);
		   $this->Cell(40,4,'VUL BEN',1,0,'C',1);
		   $this->Cell(30,4,'NOM. PADRE O TUTOR',1,0,'C',1);
		   $this->Cell(10,4,'TIPO FAM',1,0,'C',1);
		   $this->Cell(40,4,'VUL FAM',1,0,'C',1);
		   $this->Cell(10,4,'ING FAM',1,0,'C',1);
		   $this->SetFont('Arial','B',6);
		}


		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		if   ( $this->axo_padron < 2012 )
		{
		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		$this->Cell(7,4,'TALLA',1,0,'C',1);
		$this->Cell(6,4,'PESO',1,0,'C',1);
		$this->Cell(14,4,'PESAJE',1,0,'C',1);
		}
		//$this->Cell(8,4,'PCT INI',1,0,'C',1);
		//$this->Cell(8,4,'PCT FIN',1,0,'C',1);
		$this->ln();

		foreach ($this->datos as $key => $value):
			
			$band=$band+1;// es el contador

			$this->SetAutoPageBreak(false);
			//$this->Cell(27,4,$this->datos["curp_dif"],1,0,'C',0);
			$this->SetFont('Arial','B',7);
			$ye=$this->GetY();
			$this->MultiCell(75,4,utf8_decode($value["paterno"]).' '.utf8_decode($value["materno"])." \n".utf8_decode($value["nombres"]).'       '.$value["curp"],1);
			$this->SetXY(78,$ye);

			$this->Cell(5,8,substr($value["genero"], 0,1),1,0,'C',0);	

			$dias= Fechas::anios_meses_dias(Fechas::invierte_fecha($value["fecha_nacimiento"]),
											Fechas::invierte_fecha(date('Y/m/d')));
			$div=explode(".",$dias);
			$ye=$this->GetY();
			$this->MultiCell(18,4,Fechas::invierte_fecha($value["fecha_nacimiento"])." \n".$div[0].','.$div[1] ,1);
			

			$this->SetXY(101,$ye);
			if ($value["status"]==1) $this->Cell(4,8,'B',1,0,'C',0);
			if ($value["status"]==0) $this->Cell(4,8,'A',1,0,'C',0);
			if ($value["status"]==2) $this->Cell(4,8,'R',1,0,'C',0);
			$ye=$this->GetY();
			$this->MultiCell(35,4,utf8_decode($value["tipo_via"])." ".utf8_decode($value["nombre_via"])." \n".$value["num_ext"],1);
			$this->SetXY(140,$ye);			

			if($this->axo_padron >= 2012){
				$this->SetFont('Arial','B',6);
			   $this->Cell(40,8,$value["descripcion_vulnerabilidad"],1,0,'C',0);
			   $ye=$this->GetY();
			   $this->MultiCell(30,4,$value["tutor_nombre"]." \n".
			   						 $value["tutor_paterno"].' '.
			   						 $value["tutor_materno"],1);
			   $this->SetXY(210,$ye);
			   $this->Cell(10,8,$value["descripcion_tipo_familia"],1,0,'C',0);
			   $this->Cell(40,8,$value["descripcion_vulnerabilidad_familiar"],1,0,'C',0);
			   $this->Cell(10,8,$value["ingreso_familiar"],1,0,'C',0);
			   $this->SetFont('Arial','B',7);

			}

			$this->Cell(7,8,$value["talla_1"],1,0,'C',0);
			$this->Cell(6,8,$value["peso_1"],1,0,'C',0);			
			$color = Permiso::estimador_pct_ajax($value["fecha_nacimiento"],$value["fecha_pesaje_1"],$value["genero"], $value["peso_1"]);
			$this->SetFillColor($color[0],$color[1],$color[2]);
			$this->Cell(14,8,Fechas::invierte_fecha($value["fecha_pesaje_1"]),1,0,'C',1);

			if ($value["talla_2"]<>0){
				$this->Cell(6,8,$value["talla_2"],1,0,'C',0);
				$this->Cell(7,8,$value["peso_2"],1,0,'C',0);
				$color = Permiso::estimador_pct_ajax($value["fecha_nacimiento"],$value["fecha_pesaje_2"],$value["genero"], $value["peso_2"]);
				$this->SetFillColor($color[0],$color[1],$color[2]);
				$this->Cell(14,8,Fechas::invierte_fecha($value["fecha_pesaje_2"]),1,0,'C',1);
			}else{
				$this->Cell(7,8,'',1,0,'C',0);
				$this->Cell(6,8,'',1,0,'C',0);
				$this->Cell(14,8,'',1,0,'C',0);
			}


			if ($value["talla_3"]<>0){
				$this->Cell(7,8,$value["talla_3"],1,0,'C',0);
				$this->Cell(6,8,$value["peso_3"],1,0,'C',0);
				$color = Permiso::estimador_pct_ajax($value["fecha_nacimiento"],$value["fecha_pesaje_3"],$value["genero"], $value["peso_3"]);
				$this->SetFillColor($color[0],$color[1],$color[2]);
				$this->Cell(14,8,Fechas::invierte_fecha($value["fecha_pesaje_3"]),1,0,'C',1);
			}else{
				$this->Cell(7,8,'',1,0,'C',0);
				$this->Cell(6,8,'',1,0,'C',0);
				$this->Cell(14,8,'',1,0,'C',0);
				}

			if($this->axo_padron<2012){

				if($value["talla_4"]<>0){
					$this->Cell(7,8,$value["talla_4"],1,0,'C',0);
					$this->Cell(6,8,$value["peso_4"],1,0,'C',0);
				$this->Cell(7,8,$value["genero"],1,0,'C',0);
					$this->Cell(14,8,'',1,0,'C',0);
				}

				if ($value["talla_5"]<>0){
					$this->Cell(7,8,$value["talla_5"],1,0,'C',0);
					$this->Cell(6,8,$value["peso_5"],1,0,'C',0);
				$this->Cell(7,8,$value["genero"],1,0,'C',0);
					$this->Cell(14,8,'',1,0,'C',0);
				}

				if($value["talla_6"]<>0){
					$this->Cell(7,8,$value["talla_6"],1,0,'C',0);
					$this->Cell(6,8,$value["peso_6"],1,0,'C',0);
				$this->Cell(7,8,$value["genero"],1,0,'C',0);
					$this->Cell(14,8,'',1,0,'C',0);
				}
			}
		
			//$this->Cell(8,8,$value["pct_inicial"],1,0,'C',0);
			//$this->Cell(8,8,$value["pct_final"],1,0,'C',0);
			$this->SetAutoPageBreak(true,20);
			$this->Cell(20,8,'',0,1,'C',0);
		endforeach;

		//$this->Output('padron_nut_ext.pdf',D);
		$this->Output();
	}

}