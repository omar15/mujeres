<?php
/**
 * Clase que nos permite administrar lo relacionado a la tabla de accion_grupo
 * **/ 

//Inclumos librería MysqliDb
include_once($_SESSION['inc_path'].'libs/fpdf/fpdf.php');

class ReporteCaratulaPDF extends FPDF{

var $datos;
var $totales;
var $axo_padron;
var $municipio;

	public function __construct($datos,$totales,$axo_padron,$municipio)
    {
        parent::FPDF('L','mm','Legal');		        
		$this->SetMargins(20,5,5); 
		$this->AddPage();
		$this->datos = $datos;        
        $this->totales = $totales;
        $this->axo_padron = $axo_padron;
        $this->municipio = $municipio;
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

	public function reporteCaratula(){

		$this->image('../../img/dif.jpg',320,5,25,17);
		$this->image('../../img/gob.jpg',20,5,30,16);

		$this->SetFont('Arial','B',10);
		$this->ln();
		$this->Cell(320,4,'SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA',0,1,'C');
		$this->Cell(320,4,'DIRECCION DE ASISTENCIA ALIMENTARIA',0,1,'C');
		$this->Cell(320,4,'PROGRAMA DE NUTRICIÓN EXTRAESCOLAR',0,1,'C');
		$this->ln();
		  
		$this->SetFont('Arial','B',8);

		$this->Cell(320,3,'TOTAL DE BENEFICIARIOS : '.$this->totales['total_beneficiarios'],0,1,'C');
		
		$this->Cell(100,3,'MUNICIPIO : '.$this->municipio['CVE_MUN'].' - '.$this->municipio['NOM_MUN'],0,0,'L');		
		$this->Cell(225,3,'NO. DE NIÑOS :  '.$this->totales['total_ninos'],0,1,'R');
		$this->Cell(100,3,'NO. DE COMUNIDADES : '.$this->totales['total_comunidades'],0,0,'L');		
		$this->Cell(225,3,'NO. DE NIÑAS : '.$this->totales['total_ninas'],0,1,'R');
		$this->Cell(100,3,'NO. DE CENTROS : '.$this->totales['total_centros'],0,1,'L');
		$this->Cell(100,3,'AÑO DEL PADRON : '.$this->axo_padron,0,0,'L');
		$this->Cell(230,3,'',0,1,'R');		
		$this->ln();

		$this->SetFillColor(224,235,255);
		$this->Cell(80,4,'',0,0,'C');
		$this->Cell(40,4,'DIF MUNICIPAL',1,0,'C');
		$this->Cell(30,4,'CDC',1,0,'C');
		$this->Cell(30,4,'CAIC',1,0,'C');
		$this->Cell(20,4,'OTROS',1,0,'C');
		$this->Cell(18,4,'',1,0,'C');
		$this->Cell(18,4,'',1,0,'C');
		$this->Cell(25,4,'',1,0,'C');
		$this->Cell(20,4,'NIÑOS',1,0,'C');
		$this->Cell(20,4,'NIÑAS',1,0,'C');
		$this->Cell(20,4,'TOTAL',1,1,'C');

		//Contadores y banderas
		$band2=0;
		$dif_mun2=0;
		$cdc2=0;
		$caic2=0;   
		$otros2=0;
		$ninos2=0;
		$ninas2=0;
		$comunidades2=1;
		$total_centros2=1;
		$centro2='';
		$total_ben2=0;
		$unico=1;
		$recordcount=count($this->datos);
		$cont=0;
 		
 		//Total de cada centro y de niños
		$total_dif_mun = 0;
		$total_cdc = 0;
		$total_caic = 0;   
		$total_otros = 0;
		$total_ninas = 0;
		$total_ninos = 0;

 		foreach($this->datos as $row_todos2):
 			
 			if ($band2==0){
				$this->Cell(321,4,$row_todos2['CVE_LOC'].' - '.$row_todos2['nombre_comunidad'],1,1,'L',1);
				$local2=$row_todos2['CVE_LOC'];
				$centro2=$row_todos2['clave_centro'];
				$band2=1;
   			}
    	   
   			//Totales
		    $total_dif_mun += $dif_mun2;
			$total_cdc += $cdc2;
			$total_caic += $caic2;
			$total_otros += $otros2;

    	   //Imprimimos conteo de cada centro evitando duplicar centros de atención
		   if ($centro2!=$row_todos2['clave_centro']){
		    $this->SetFont('Arial','',8);
		    $this->Cell(80,4,$nombrecen.' - '.$centro2,1,0,'L');
		    $this->Cell(40,4,$dif_mun2,1,0,'C'); 
		    $this->Cell(30,4,$cdc2,1,0,'C');
		    $this->Cell(30,4,$caic2,1,0,'C');
		    $this->Cell(20,4,$otros2,1,0,'C');
		    $this->Cell(18,4,'',1,0,'C');
		    $this->Cell(18,4,'',1,0,'C');
		    $this->Cell(25,4,'',1,0,'C');
		    $this->Cell(20,4,$ninos2,1,0,'C');
		    $this->Cell(20,4,$ninas2,1,0,'C');
		    $this->Cell(20,4,$ninos2+$ninas2,1,1,'C');
		    $this->SetFont('Arial','B',8);			    

		    //Reiniciamos contadores
		    $dif_mun2=0;
		    $cdc2=0;
		    $caic2=0;   
		    $otros2=0;
		    $ninos2=0;
		    $ninas2=0;
		    $unico=0;

		   }   					    

		   	$centro2=$row_todos2['clave_centro'];
		   	$nombrecen=$row_todos2['nombre_centro'];
   			
   			//Se imprime la comunidad procurando no repetir ninguna
		    if($local2 != $row_todos2['CVE_LOC']){ 
		     	$this->Cell(321,4,$row_todos2['CVE_LOC'].' - '.$row_todos2['nombre_comunidad'],1,1,'L',1);
		   	}
   
   			$local2 = $row_todos2['CVE_LOC'];   
   			
   		   //Contamos total de niñas y niños
		   if ($row_todos2['genero']=='HOMBRE') $ninos2++;
		   if ($row_todos2['genero']=='MUJER') $ninas2++;
		   
		   //Contamos cada tipo de centro dependiendo el caso
		   if ($row_todos2['tipo_centro']==0) $dif_mun2 ++;
		   if ($row_todos2['tipo_centro']==2) $caic2 ++;
		   if ($row_todos2['tipo_centro']==1) $cdc2 ++;
		   if ($row_todos2['tipo_centro']==3) $otros2 ++;
		   		   
		   $total_ben2 ++;
		   $cont ++;
   
   			// aqui se resuelve lo del ultimo registro
   			if ($cont==$recordcount){

   				$this->SetFont('Arial','',8);
			    $this->Cell(80,4,$nombrecen.' - '.$centro2,1,0,'L');
			    $this->Cell(40,4,$dif_mun2,1,0,'C'); 
			    $this->Cell(30,4,$cdc2,1,0,'C');
			    $this->Cell(30,4,$caic2,1,0,'C');
			    $this->Cell(20,4,$otros2,1,0,'C');
			    $this->Cell(18,4,'',1,0,'C');
			    $this->Cell(18,4,'',1,0,'C');
			    $this->Cell(25,4,'',1,0,'C');
			    $this->Cell(20,4,$ninos2,1,0,'C');
			    $this->Cell(20,4,$ninas2,1,0,'C');
			    $this->Cell(20,4,$ninos2+$ninas2,1,1,'C');
			    $this->SetFont('Arial','B',8);
			 }			

  		endforeach;

		$this->ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(80,4,'TOTAL DE DIF MUNICIPALES :'.$total_dif_mun,1,0,'C',1);
		$this->Cell(80,4,'TOTAL DE CDC´S :'.$total_cdc,1,0,'C',1);
		$this->Cell(80,4,'TOTAL DE CAIC´S :'.$total_caic,1,0,'C',1);
		$this->Cell(80,4,'TOTAL DE OTROS :'.$total_otros,1,1,'C',1);		

        //$this->Output('caratula_nut_ext.pdf','D');
		$this->Output();
	}
 
}