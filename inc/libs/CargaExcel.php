<?php
//Librería para leer/crear exceles
include_once('PHPExcel.php');
//Obtenemos el modelo de mujeres avanzando
include_once($_SESSION['model_path'].'mujeres_avanzando.php');
include_once($_SESSION['model_path'].'familiares_mujer.php');
include_once($_SESSION['model_path'].'registro_excel_enhina.php');
include_once($_SESSION['inc_path'].'libs/Permiso.php');

class CargaExcel extends MysqliDb{
    
    // Variables
    var $Hojas;    

    public function __construct(){}
    public function __destruct(){}

    /**
    * Carga de excel
    *@param varchar $nombre Nombre del archivo SIN extensión
    *@param varchar $ruta Ruta del archivo (de ser diferente a la establecida)
    *
    *@return Array que contiene
	*    	 int $msg_no Mensaje generado
	*		 int $id_generado ID generado
    **/
    public static function carga($nombre,$ruta = NULL,$id_caravana=0,$ext = 'xls')
    {


    $total_encuestados = 0;
    $total_enc_completo = 0;
    $total_familiares = 0;
    $total_prog_mac = 0;
    $total_prog_map = 0;
    $total_registrados = 0;
    $total_duplicados = 0;
    $total_no_coinciden = 0;
    $total_enc_inc = 0;
    $id_entrevista_dup = NULL;
	$total_enc_inc = NULL;    
	$total_severa = 0;
	$total_moderada = 0;
	$total_leve = 0;
	$total_segura = 0;
	$total_otra = 0;

     //Obtenemos ruta
     $ruta = ($ruta == NULL)? $_SESSION['files_path'] : $ruta ;
	 
	 //ID recién generado
     $id_generado = NULL;

     //CURP Generado
     $curp = NULL;
     
	 //Armamos la ruta completa del archivo
	 $inputFileName =  $ruta.$nombre.".".$ext;     

	 //Cargamos archivo
	try {
	    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(PHPExcel_Reader_Exception $e) {
	    die('Error al cargar archivo "'.
	    pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	//Obtenemos las 2 hojas
	$Hojas[] = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
	$Hojas[] = $objPHPExcel->getSheet(1)->toArray(null,true,true,true);

	//Validamos que tengamos 2 hojas
	if(count($Hojas) >= 2){

		//Obtenemos total de columnas
		$total_cols_h1 = count($Hojas[0][1]);
		$total_datos_h1 = count($Hojas[0][2]);
		$total_cols_h2 = count($Hojas[1][1]);
		$total_datos_h2 = count($Hojas[1][2]);		

		//Quitamos columnas de ambas hojas
		unset($Hojas[0][1]);
		unset($Hojas[1][1]);

		//Validamos total de datos y columnas
		if($total_cols_h1 == 182 && $total_cols_h2 == 40){
			
			//Total de filas de excel menos la fila que contiene 
			$total_encuestados = count($Hojas[0]);

			//Obtenemos hojas
			list($datos_h1,$datos_h1_false) = self::procesaH1($Hojas[0]);
			$datos_h2 = $Hojas[1];

			//Obtenemos beneficiarios únicos y sus familiares
			list($beneficiarias,$familiares) = self::procesaH2($datos_h2);

			$total_enc_completo = count($datos_h1);
			$total_enc_inc = count($datos_h1_false);

			//Recorremos total de filas en el excel
			foreach ($datos_h1 as $key => $value):				

				//Obtenemos ID del registro donde coincide
				$k = self::searchForId($value['B'], $beneficiarias);            

           		//Guardaremos registro
				$msg_no = self::guarda($value,$beneficiarias[$k],$id_caravana);
				
				//Dependiendo la respuesta hacemos incrementos
				switch ($msg_no) {
		                case 1:
		                    $total_registrados++;
		                    break;
		                
		                case 21:
		                	//Registro de Beneficiario duplicado
		                    $total_duplicados++;
		                    //Guardamos el ID de entrevista para no duplicar
		                    //los familiares
		                    $id_entrevista_dup[]=$beneficiarias[$k]['C'];
		                    break;

		                case 22:
		                	//No coinciden ID de entrevista
		                    $total_no_coinciden++;
		                    $id_entrevista_dup[]=$beneficiarias[$k]['C'];
		                    break;

		                default:
		                	$id_entrevista_dup[]=$beneficiarias[$k]['C'];
		                    break;
		        }

		        //Obtenemos programa
				$prog = substr($value['AH'], 0,3);

				//Dependiendo el programa evaluamos
				switch ($prog) {
		                case 'MAC':
		                    $total_prog_mac++;
		                    break;
		                
		                case 'MAP':
		                    $total_prog_map++;
		                    break;

		                default:
		                    break;
		        }

		        //Obtenemos programa
				$grado_ins = $value['FU'];

				//Dependiendo el programa evaluamos
				switch (trim(strtoupper($grado_ins))){

					case 'SEVERA':
    					$total_severa++;
    					break;
			    	case 'MODERADA':
			    		$total_moderada++;
			    		break;
			    	case 'LEVE':
			    		$total_leve++;
			    		break;
			    	case 'SEGURA':
			    		$total_segura++;
			    		break;
			    	default:
			    		$total_otra++;
		                break;
		        }

			endforeach;

			$id_entrevista_dup = ($id_entrevista_dup == NULL)? array(0) : $id_entrevista_dup ;
			$datos_h1_false = ($datos_h1_false == NULL)? array(0) : $datos_h1_false ;

			//Recorremos los registro de los familiares
			foreach ($familiares as $key => $valor):
				
				if(!in_array($valor['C'], $id_entrevista_dup) && 
					!in_array($valor['C'], $datos_h1_false)){
					$msg_no = Familiaresmujer::guardaFamiliares($valor);
					$total_familiares++;
				}				

			endforeach;

			$totales = array('total_encuestados' => $total_encuestados,
							 'total_enc_completo' => $total_enc_completo,
							 'total_enc_inc' => $total_enc_inc,
							 'total_familiares' => $total_familiares,
							 'total_prog_mac' => $total_prog_mac,
							 'total_prog_map' => $total_prog_map,
							 'total_registrados' => $total_registrados,
							 'total_duplicados' => $total_duplicados,
							 'total_no_coinciden' => $total_no_coinciden,
							 'total_severa' => $total_severa,
							 'total_moderada' => $total_moderada,
							 'total_leve' => $total_leve,
							 'total_segura' => $total_segura,
							 'total_otra' => $total_otra,
                             'nombre' => $nombre);
                             
                             
                             Registro_excel::saveRegistroexcel($totales);
                             

		}else{
			//Número incorrecto de columnas y/o datos incorrectos
			$msg_no = 20;
		}
		
	}else{
		//Número de hojas incorrecto
		$msg_no = 19;
	}		

	return array($msg_no,$totales);

    }

    /**
    *Buscamos un valor en un arreglo de arreglos
    * @param int $id ID a buscar
    * @param array $array Arreglo de arreglos donde buscaremos
    *
    * @return int $key Llave de la coincidencia
    **/
    private static function searchForId($id, $array) {
   	
	   foreach ($array as $key => $val):
	       if ($val['C'] === $id) {
	           return $key;
	       }
	   endforeach;

	   return null;
	}

    /**
    *Procesamos los registros de beneficiarios y sus familiares de la hoja 2
    *@param array $hoja2 Hoja que procesaremos
    *
    *@return array que contiene
    * array $datos_h1 Beneficiarias únicos que SÍ completaron la encuesta
    * array $datos_h1_false Beneficiarios únicos que NO completaron la encuesta
    **/
    private function procesaH1($hoja1){

    //Inicializamos variables
    $datos_h1 = NULL;
    $datos_h1_false = NULL;

	    //Recorremos la hoja
	    foreach ($hoja1 as $key => $value):
	        
	        //Omitimos columna de nombres
	        if($key == 1) continue;

	    	//Obtenemos los entrevistados
	       if(trim($value['Z']) == 'True'){

	            //Guardamos arreglo
	            $datos_h1[] = $value;

	        }else{
	        	$datos_h1_false[] = $value['B'];
	        }

	    endforeach;

    return array($datos_h1,$datos_h1_false);

    }


    /**
    *Procesamos los registros de beneficiarios y sus familiares de la hoja 2
    *@param array $hoja2 Hoja que procesaremos
    *
    *@return array que contiene
    * array $beneficarias Beneficiarias únicos de la hoja
    * array $familiares Familiares de los beneficiarios
    **/
    private function procesaH2($hoja2){

    //Inicializamos variables
    $beneficiarias = NULL;
    $familiares = NULL;

    //Recorremos la hoja
    foreach ($hoja2 as $key => $value):
        
        //Omitimos columna de nombres
        if($key == 1) continue;

    	//Obtenemos los entrevistados
       if(trim($value['X']) == 'SI'){

            //Guardamos arreglo
            $beneficiarias[] = $value;

        }else{
            //Es un familiar
            $familiares[] = $value;
        }

    endforeach;

    return array($beneficiarias,$familiares);

    }

    /**
    * Guardamos un registro en la tabla de mujeresAvanzando
    * array $datos_h1 Arreglo con la información de la hoja 1
    * array $datos_h2 Arreglo con la información de la hoja 2
    **/
    public static function guarda($datos_h1,$datos_h2,$id_caravana){

	//Obtenemos id de la entrevista
	$id_entrevista_h1 = $datos_h1['B'];
	$id_entrevista_h2 = $datos_h2['C'];
    $gr = $datos_h1['FU'];
    $grados = 0;
    $n = $datos_h1['FV'];
    $niveles = 0;
    $cd = $datos_h1['FW'];
    $dietas = 0;
    $d = $datos_h1['FX'];
    $diversidadades = 0;
    $v = $datos_h1['FY'];
    $variedades = 0;
    $elc = $datos_h1['FZ'];
    $elcs = 0;
    
    switch (strtoupper(trim($elc))) {
    	case 'LEVE':
    		$elcs = 1;
    		break;
    	case 'MODERADA':
    		$elcs = 2;
    		break;
    	case 'SEGURA':
    		$elcs = 3;
    		break;
        case 'SEVERA':
    		$elcs = 4;
    		break;
        
    
    	default:
    		# code...
    		break;
    }
    
    switch (strtoupper(trim($v))) {
    	case 'NO VARIADA':
    		$variedades = 1;
    		break;
    	case 'POCO VARIADA':
    		$variedades = 2;
    		break;
    	case 'VARIADA':
    		$variedades = 3;
    		break;
    
    	default:
    		# code...
    		break;
    }
    
    
     switch (strtoupper(trim($d))) {
    	case 'COMPLETA':
    		$diversidadades = 1;
    		break;
    	case 'MODERADA':
    		$diversidadades = 2;
    		break;
    	default:
    		# code...
    		break;
    }
    
    switch (strtoupper(trim($cd))) {
    	case 'NO SALUDABLE':
    		$dietas = 1;
    		break;
    	case 'POCO SALUDABLE':
    		$dietas = 2;
    		break;
    	case 'SALUDABLE':
    		$dietas = 3;
    		break;
    
    	default:
    		# code...
    		break;
    }
    
    
    
    
    switch (strtoupper(trim($n))) {
    	case 'ALTO':
    		$niveles = 1;
    		break;
    	case 'BAJO':
    		$niveles = 2;
    		break;
    	case 'MEDIO':
    		$niveles = 3;
    		break;
    
    	default:
    		# code...
    		break;
    }
	
    
    switch (strtoupper(trim($gr))) {
    	case 'SEVERA':
    		$grados = 1;
    		break;
    	case 'MODERADA':
    		$grados = 2;
    		break;
    	case 'LEVE':
    		$grados = 3;
    		break;
    	case 'SEGURA':
    		$grados = 4;
    		break;
    	default:
    		# code...
    		break;
    }
	//$tel_prueba = '379-605-14 3339696809 ,referencia santa lucia';
   
    //echo 'resultado'.$r;
    //exit;
    
	//Programas válidos
	$programas = array('MAP','MAC');

	//Los ID de ambas hojas deben coincidir
	if($id_entrevista_h1 == $id_entrevista_h2){

		//Vemos si hay un registro con el mismo id de entrevista
		$obj = mujeresAvanzando::get_by_id_entr($id_entrevista_h1);

		//Si no encontramos una entrevista previa, procedemos a guardar
		if($obj == NULL){

		//Obtenemos programa
        $prog = substr($datos_h1['AH'], 0,3);
        $fecha = substr($datos_h2['H'],0,10);

	        //Sólo los programas válidos
	        if(in_array($prog,$programas)){
	           
               
					        	
			//Obtenemos información
			$desc_ubicacion = 'CALLE: '.$datos_h1['AJ'].' COLONIA: '.$datos_h1['AM'];
            $calle = $datos_h1['AJ'];
            $colonia =$datos_h1['AM'];
            $paterno = $datos_h2['E'];
			$materno = $datos_h2['F'];
            $nombres = $datos_h2['G'];			
			$fecha_nacimiento = Fechas::fechadmyAymd($fecha);
			$genero = $datos_h2['J'];
			$id_cat_municipio = str_pad($datos_h1['U'],3,"0",STR_PAD_LEFT);
			$id_cat_localidad = str_pad($datos_h1['W'],4,"0",STR_PAD_LEFT);
			$num_ext = $datos_h1['AK'];
			$num_int = $datos_h1['AL'];
			$id_grado = $grados;
			$CODIGO = $datos_h1['R'];
			$folio = $datos_h1['D'];
	        $referencia = Permiso::procesa_tel($datos_h1['AN']);
            //$referencia=$datos_h1['AN'];
	        $programa = strtoupper($prog);
            $nivel = $niveles;
            $calidad_dieta = $dietas;
            $diversidad = $diversidadades;
            $variedad = $variedades;
            $elcsa = $elcs;
            //$id_ocupacion = $datos_h1['N'];
            //$id_escolaridad = $datos_h1['K'];
            $ocupacion = $datos_h2['N'];
            $escolaridad = $datos_h2['K'];
            

			/*Campos obligatorios de nuestro modelo, de momento pondremos los
			siguientes valores predeterminados*/
			$CVE_VIA = 475946;
			$CVE_EDO_RES = 14;
			$id_estado_civil = null;

			//Nuevo registro, procedemos a registrarlo en mujeres avanzando
			$mujeres_avanzando = array(
			    'nombres' => $nombres,
			    'paterno' => $paterno,
			    'materno' => $materno,
			    'fecha_nacimiento' => $fecha_nacimiento,
			    'genero' => $genero,
			    'id_cat_estado' => 14,
			    'id_cat_municipio' => $id_cat_municipio,
			    'id_cat_localidad' => $id_cat_localidad,
			    'num_ext' => $num_ext,
			    'num_int' => $num_int,
			    'desc_ubicacion' => $desc_ubicacion,
                'calle' => $calle,
                'colonia' => $colonia,
                'id_grado' => $id_grado,
			    'id_pais' => 90,
			    'CODIGO' => $CODIGO,
			    'CVE_VIA' => $CVE_VIA,
			    'CVE_EDO_RES' => $CVE_EDO_RES,
				//'id_escolaridad' => $id_escolaridad,
				//'id_ocupacion' => $id_ocupacion,
                'escolaridad' => $escolaridad,
				'ocupacion' => $ocupacion,
				'id_estado_civil' => $id_estado_civil,
				'id_entrevista' => $id_entrevista_h1,
				'folio' => $folio,
	            'telefono' => $referencia,
	            'programa' => $programa,
                'id_caravana' => $id_caravana,
                'nivel' => $nivel,
                'calidad_dieta' => $calidad_dieta,
                'diversidad' => $diversidad,
                'variedad' => $variedad,
                'elcsa'=> $elcsa
                
			    );    
							
				list($msg_no,$curp,$id_generado) = mujeresAvanzando::
													saveMujer($mujeres_avanzando);

	        }

		}else{
			//Registro de Beneficiaria duplicado
			$msg_no = 21;
		}

	}else{
		//No coinciden los ID de entrevista
		$msg_no = 22;
	}

	return $msg_no;    	
   }
   
}