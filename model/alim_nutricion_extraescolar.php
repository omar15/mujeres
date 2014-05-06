<?php
/**
 * Clase que nos permite administrar lo relacionado al modulo de nutricion extraescolar
 * **/ 
//Inclumos librería Paginador
include_once($_SESSION['inc_path'].'libs/Paginador.php');

class Alim_nutricion_extraescolar extends MysqliDb{
    public function __construct(){}
        
            /**
             * Ejecutamos sentencia sql con parámetros
             * @param string $sql Sentencia SQL
             * @param array $params Cada uno de los parámetros de la sentencia
             * 
             * @return int Resultado
             * */   
        
    private static function executar($sql,$params){
            //Ejecutamos
    $resultado = self::getInstance()->rawQuery($sql, $params);
            
            //Regresamos resultado
      return $resultado;        
    }
    
    /**
     * Cambiamos el estatus del módulo 
     * 1 = Activo, 0 = Inactivo
     * @param int $id_modulo Módulo a actualizar
     * 
     * @return string $msg_no No. de Mensaje a regresar
     * */

    public static function activaAlim_nutricion_extraescolar($id_nutricion){



        //Variable que nos indica el mensaje generado al guardar el registro

        $msg_no = 0;



        //Variable donde guardamos el estatus

        $estatus = 0;



        //Sentencia para obtener el campo activo de la tabla Modulo

        $sql = 'SELECT activo from `alim_nutricion_extraescolar` where id = ?'; 

        

        //parámetros para la consulta

        $params = array($id_nutricion);                



        //Verificamos el estatus del Modulo        

        $registro = self::executar($sql,$params);

        $registro = $registro[0];



        //Si el registro tiene estatus de 'Eliminado', se activará

        if($registro['activo'] == 0){

            $estatus = 1;

        }else if($registro['activo'] == 1){

        //Si el registro tiene estatus de 'Activo', se eliminará

            $estatus = 0;

        }



        //Preparamos update

        self::getInstance()->where('id',$id_nutricion);                                                



        //datos a actualizar

        $updateData = array('activo' => $estatus);

        

        //Iniciamos transacción

        self::getInstance()->begin_transaction();

        

        if(!self::getInstance()->update('alim_nutricion_extraescolar',$updateData)){

            //'Error al guardar, NO se guardo el registro'

            $msg_no = 3;

            

            //Cancelamos los posibles campos afectados

            self::getInstance()->rollback();  

        }else{

            //Campos guardados correctamente

            $msg_no = 1;

            

            //Guardamos campos afectados en la tabla

            self::getInstance()->commit();                       

        } 



        return $msg_no;

    } 

   
   
    /**
     * Obtenemos listado de las Acciones 
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro  
     * @param $activo Determinamos si queremos los activos, inactivos o ambos (predeterminado)      
     * @return array Resultado de la consulta
     * */

    public static function listaAlim_nutricion_extraescolar($id_centro_atencion,$nombre=NULL,$paterno=NULL,$materno=NULL,$curp=NULL){
        
        $sql = 'SELECT        
        ane.id,
        ane.talla_1,
        ane.peso_1,
        ane.fecha_pesaje_1,
        ane.talla_2,
        ane.peso_2,
        ane.fecha_pesaje_2,
        ane.talla_3,
        ane.peso_3,
        ane.fecha_pesaje_3,
        b.curp,
        b.paterno,
        b.materno,
        b.nombres,
        b.activo,
        b.edad,
        b.mes,
        b.fecha_nacimiento,
        ane.activo as activo1,
        b.genero
        FROM alim_nutricion_extraescolar ane
        LEFT JOIN beneficiario b on ane.id_beneficiario = b.id
        WHERE 1 and ane.id_centro_atencion = ?
       ';

        //Parámetros de la sentencia
        $params = array($id_centro_atencion);
            
       
         //Buscamos nombre propio           

        if($nombre !=null){

                        

          $sql .= ' AND b.nombres like ? ';

          $params[] = '%'.$nombre.'%';    

            

        }



        //Apellido paterno

        if($paterno !=null){
         //echo $paterno;
        //exit;
            

          $sql .= ' AND b.paterno like ? ';

          $params[] = '%'.$paterno.'%';    

            

        }

        

        //Apellido materno

        if($materno !=null){

            

          $sql .= ' AND b.materno like ? ';   

          $params[] = '%'.$materno.'%';    

            

        }
        
        //Curp

        if($curp !=null){

            

          $sql .= ' AND b.curp = ? ';   

          $params[] = $curp;    

            

        }

        //Verificamos si se quieren filtrar los activos/inactivos
        if($activo !== NULL){
            $sql .= ' AND b.activo = ?';
            $params[] = $activo;
        }

        //Regresamos resultado
        // self::executar($sql,$params);
        
        //print_r($sql).'<br>';
        //print_r($params);
        //exit;
		    
        //Instancia de paginador
        $paginador = new Paginador();
        
        //Cambiamos el límite de resultados paginados mediante función
        $paginador->setPagesPerSection(100);
        
        return $paginador->objPaginar($sql,$params);           
    }

    /**
    * Obtenemos datos del centro de atención al que pertenece un beneficiario
    *
    * @param int $id_beneficiario ID de la tabla beneficiario
    *
    * @return 
    **/

     public static function centro_atencion($id_beneficiario=null){
        
        $sql = 'SELECT
                ct.nombre,
                ct.CVE_EST_MUN_LOC as clave_comunidad,
                tp.tipo as nom_tipo_centro 
                from alim_nutricion_extraescolar  ane
                LEFT JOIN beneficiario b on b.id = ane.id_beneficiario
                LEFT JOIN centros_atencion ct on ct.id = ane.id_centro_atencion
                LEFT JOIN tipo_centro_atencion tp on tp.id = ct.tipo_centro
                where id_beneficiario = ?

       ';             

         //Parámetros de la sentencia
         $params = array($id_beneficiario);
        
         return Paginador::paginar($sql,$params);          
    }
    
    /**
    * Función para redondear decimales 
    * @param float $number Número a aplicar redondeo
    *
    * @return float $number Número redondeado
    **/
    public static function round_to_nearest_half($number) {
if($number==null || $number=='' || $number <=0){
        return null;
    }else{  
    $array=explode('.',$number);
    $decimales=$array[1];
    if($decimales[0]=='5'){
    return($number);    
   
    }else{
    return round($number);
    }
    }
	}
    
    /**
     * Guardamos registro en la tabla alim_nutricion_extraescolar
     * @param array $centros Arreglo con los campos a guardar
     * @param int $id del Modulo a editar (opcional)
     * 
     * @return int No. de mensaje
     * */

     public static function saveAlim_nutricion_extraescolar($nutricion,$id = null){
       //print_r($nutricion);
       //exit; 
       
         
       //Variable que nos indica el mensaje generado al guardar el registro
        $msg_no = 0;

      //Indicamos predeterminadamente que insertaremos un registro

        $accion = 'insert';



        /*Obtenemos cada una de las variables enviadas vía POST y las asignamos

        a su respectiva variable. Por ejemplo 

        $id = $_POST['id'], $nombre = $_POST['nombre']*/



        foreach($nutricion as $key => $value):

        ${$key} = self::getInstance()->real_escape_string($value);
    
        endforeach;
        //print_r($id_centro_atencion);
        //exit;

       //Evitamos duplicidad de nombres en los registros        

       $sql='SELECT id_beneficiario FROM `alim_nutricion_extraescolar` where id_beneficiario = ?';

        $params = array($id_beneficiario);
        

        //Sólo si se edita el mismo registro puede 'repetir el nombre'

        if($id !=null){

            $sql.=' and id not in (?)';

            $params[] = $id;

            

        }

                                

        //Ejecutamos sentencia

        $duplicado = self::getInstance()->rawQuery($sql,$params);

        

        //Verificamos que no haya nombre duplicado en el centro de atencion

       if(count($duplicado)>0){

            $msg_no = 16;

            //

        }else{

                        

            //Obtenemos el id del usuario creador

            $id_usuario_creador = $_SESSION['usr_id'];

            

            /*Si no esta creada la variable activo 
            predeterminadamente la guardamos = 1*/        
            if(!isset($activo) ){
                $activo = 1 ;            
            }           

          

            //Substraemos cadena para obtener el CVE_EST_MUN
            $id_municipio = substr($id_localidad, 0,5);

            //Campos obligatorios

            if ( $nombres && $paterno && $materno  && $id_tipo_familia) 
            
              

            {
                include_once($_SESSION['inc_path'].'libs/Permiso.php');
                
                $insertData = array(

                'tutor_nombres' => mb_strtoupper(trim($nombres, "UTF-8")),
                'tutor_paterno' => mb_strtoupper(trim($paterno, "UTF8")),
                'tutor_materno' => mb_strtoupper(trim($materno, "UTF8")),
                'id_tipo_familia' => $id_tipo_familia,
                'tipo_centro' =>$id_tipo_centro,
                'id_vulnerabilidad' => $id_vulnerabilidad,
                'id_vulnerabilidad_familia' => $id_vulnerabilidad_familia,
                'ingreso_familiar' => $ingreso,
                'talla_1' => $talla_1,
                'peso_1' => self::round_to_nearest_half($peso_1),
                'fecha_pesaje_1' => $fecha_pesaje_1,
                'talla_2' => $talla_2,
                'peso_2' => self::round_to_nearest_half($peso_2),
                'fecha_pesaje_2' => $fecha_pesaje_2,
                'talla_3' => $talla_3,
                'peso_3' => self::round_to_nearest_half($peso_3),                
                'fecha_pesaje_3' => $fecha_pesaje_3,
                'id_beneficiario' => $id_beneficiario,
                'id_centro_atencion' => $id_centro_atencion,
                'id_municipio'=> $id_municipio,
                'id_usuario_creador' => $id_usuario_creador,
                'activo' => $activo, 
                'fecha_creado' => date('Y-m-d H:i:s')
                );                

               
                //Quitamos del arreglo los valores vacíos

                $insertData = array_filter($insertData, create_function('$a','return preg_match("#\S#", $a);'));

                

                //Si recibimos id para editar

                if(intval($id)>0){
                    

                    //Indicamos que haremos un update

                    $accion = 'update';

                    

                    //Agregamos condición para indicar qué id se actualiza

                    self::getInstance()->where('id',$id);                                        

                }

                
                   // print_r($insertData);
                    //exit;
                //Iniciamos transacción

                self::getInstance()->begin_transaction();

                

                if(! self::getInstance()->{$accion}('alim_nutricion_extraescolar', $insertData)){

                    //'Error al guardar, NO se guardo el registro'

                    $msg_no = 3; 

                    

                    //Cancelamos los posibles campos afectados

                    self::getInstance()->rollback();

                    

                    }else{

                    //Campos guardados correctamente

                    $msg_no = 1;          

                    

                    //Guardamos campos afectados en la tabla

                    self::getInstance()->commit();             

                    } 

                    

                }else{

                //'Campos Incompletos'

                $msg_no = 2;             

            }        

        

          }

        

        return $msg_no ;

        

    }

    /**
    *Obtenemos información para crear reporte de padrón
    *@param int $id_municipio clave del municipio
    *@param int $id_centro_atencion id de la tabla centro de atención
    *@param int $axo Año que se consulta
    *
    * @return Array $datos_nut_ext
    **/    
    public static function reporte_padron($id_municipio,$id_centro_atencion,$axo){

      $sql_nut_ext = 'SELECT 
              b.paterno,
              b.materno,
              b.nombres,
              b.curp,
              b.genero,
              b.fecha_nacimiento,
              a.activo, -- activo=1 inactivo=0 reingreso = 2
              via.NOM_VIA as nombre_via,
              cv.DESCRIPCION as tipo_via,
              asen.NOM_ASEN,
              asen.CVE_TIPO_ASEN,
              b.num_ext,
              a.id_vulnerabilidad, -- vulnerabilidad
              v.descripcion_vulnerabilidad,
              a.tutor_paterno,
              a.tutor_materno,
              a.tutor_nombres,
              a.id_tipo_familia,-- descripcion_tipo_familia 
              t.descripcion,
              vf.descripcion_vulnerabilidad_familiar,
              a.id_vulnerabilidad_familia,
              a.ingreso_familiar,
              a.talla_1,
              a.peso_1,
              a.fecha_pesaje_1,
              a.talla_2,
              a.peso_2,
              a.fecha_pesaje_2,
              a.talla_3,
              a.peso_3,
              a.fecha_pesaje_3,
              a.talla_4,
              a.peso_4,
              a.fecha_pesaje_4,
              a.talla_5,
              a.peso_5,
              a.fecha_pesaje_5,
              a.talla_6,
              a.peso_6,
              a.fecha_pesaje_6
              from alim_nutricion_extraescolar a
              LEFT JOIN tcat_vulnerabilidad as v on v.cod_vulnerabilidad = a.id_vulnerabilidad
              LEFT JOIN tvulnerabilidad_familiar as vf on vf.cod_vulnerabilidad_familiar = a.id_vulnerabilidad_familia
              LEFT JOIN tipo_familia as t on t.id = a.id_tipo_familia
              LEFT JOIN beneficiario b on a.id_beneficiario = b.id
              left join vialidad via on b.CVE_VIA = via.CVE_VIA 
              left join cat_vialidad cv on b.CVE_TIPO_VIAL = cv.CVE_TIPO_VIAL
              lEFT JOIN asentamiento asen on b.CVE_ASEN = asen.CVE_ASEN 
                                          and b.CVE_EST_MUN_LOC = asen.CVE_EST_MUN_LOC
              LEFT JOIN cat_tipo_asen cta on cta.CVE_TIPO_ASEN = asen.CVE_TIPO_ASEN
              where 1
              AND YEAR(a.fecha_creado) = ?
              and a.id_centro_atencion = ?
              and a.activo NOT IN (0)
              and a.id_municipio = ?
              ORDER by b.paterno, b.materno, b.nombres';
      
      $params = array($axo,$id_centro_atencion,$id_municipio);

      //Datos generales
      $datos_nut_ext = self::executar($sql_nut_ext,$params);

      return $datos_nut_ext;
    }

    /**
     * Obtenemos la información necesaria para generar el reporte de carátula
     * @param char $id_municipio municipio a buscar
     * @param char $axo año a buscar
     * 
     * @return Array $datos Arreglo con datos filtrados
     * */

    public static function reporte_caratula($id_municipio = NULL,$axo = NULL){
      
      /*
      //Quitamos lo relacionado a comunidades indígenas
      if ($id_municipio == '019' or $id_municipio == '061'){
        $mun_indigena =' and com.tipo <> 2';
      }
      */
      
      //Condiciones generales para las consultas
      $from = '
      FROM `alim_nutricion_extraescolar` a
      INNER JOIN beneficiario b on a.id_beneficiario = b.id
      LEFT JOIN centros_atencion c on c.id = a.id_centro_atencion
      LEFT JOIN comunidad com on com.CVE_ENT_MUN_LOC = c.CVE_EST_MUN_LOC 
      where 1 
      and a.activo NOT IN (0)
      and a.id_municipio = ?
      and year(a.fecha_creado) = ? ';

      $params = array($id_municipio,$axo);

      //si requerimos municipios indigenas verificamos 
      if($indigena == true){ 
      $con_indigena=($indigena===true)?' and com.tipo = 2 and com.id_municipio in(?,?) ':'';
      $params[]='061';
      $params[]='019';
      $from.=$con_indigena;
        }
      //Consulta general
      $sql_gral = 'SELECT
                  -- ca.CLAVE_CENTRO,co.`LOCAL`,co.COMUNIDAD,co.NOMBRECOMU,p.sexo,co.TIPO --Originales
                  c.CVE_EST_MUN_LOC,
                  com.nombre_comunidad,
                  c.nombre as nombre_centro,
                  concat(c.CVE_EST_MUN_LOC,?,c.id) as clave_centro,
                  com.CVE_ENT_MUN_LOC,
                  com.CVE_LOC,                  
                  b.genero,
                  com.TIPO as tipo_comunidad,
                  c.tipo_centro '.$from;
      
      //ponemos al inicio del arreglo
      array_unshift($params,' - ');
      //Datos generales
      $datos = self::executar($sql_gral,$params);
      //quitamos primer elemento
      array_shift($params);

      //Consulta total niñas
      $sql_ninas = 'SELECT 
                    b.genero,
                    IFNULL(count(b.genero),0) as total'
                    .$from.' and b.genero = ?
                    GROUP BY b.genero';      

      //Consulta total niños
      $sql_ninos = 'SELECT 
                    b.genero,
                    IFNULL(count(b.genero),0) as total'
                    .$from.' and b.genero = ?
                    GROUP BY b.genero';      
      
      //Total de Comunidades
      $sql_comunidades='SELECT 
                        COUNT(DISTINCT com.CVE_ENT_MUN_LOC) as total_comunidades -- total comunidades'
                        .$from;

      //Total de centros
      $sql_centros='SELECT 
                    count(DISTINCT c.id) as total_centros  -- total centros'
                    .$from;

      //Total de Beneficiarios
      $sql_beneficiarios='SELECT 
                          COUNT(DISTINCT b.id) as total_beneficiarios -- total beneficiarios'
                          .$from;

      //Agregamos parámetro para obtener los niños
      $params[] = 'HOMBRE';
      //Total de niños
      $total_ninos = self::executar($sql_ninos,$params);
      //Quitamos último arreglo
      array_pop($params);      

      //Agregamos parámetro para obtener los niños
      $params[] = 'MUJER';
      //Total de niñas
      $total_ninas = self::executar($sql_ninas,$params);
      //Quitamos último arreglo
      array_pop($params);

      //Total de centros y sus totales
      $total_centros = self::executar($sql_centros,$params);

      //Total de comunidades
      $total_comunidades = self::executar($sql_comunidades,$params);

      //Total de beneficiarios
      $total_beneficiarios = self::executar($sql_beneficiarios,$params);
      
      //print_r($datos);
      
      //Concentrado de totales
      $totales = array('total_ninas' => 0,
                        'total_ninos' => 0,
                        'total_centros' => 0,
                        'total_comunidades' => 0,
                        'total_beneficiarios' => 0);

      if($total_ninas != NULL){
        
        //Al ser el primer registro, obtenemos primer arreglo
        $totales['total_ninas'] = $total_ninas[0]['total'];
        //echo 'Total Ninas: '.$total_ninas;
      }

      if($total_ninos != NULL){

        //Al ser el primer registro, obtenemos primer arreglo
        $totales['total_ninos'] = $total_ninos[0]['total'];
        //echo 'Total Ninos: '.$total_ninos;
      }

      if($total_centros != NULL){

        $totales['total_centros'] = $total_centros[0]['total_centros'];
        //echo 'Total Centros: '.$total_centros;
      }
      
      if($total_comunidades != NULL){
        $totales['total_comunidades']  = $total_comunidades[0]['total_comunidades'];
        //echo 'Total Comunidades: '.$total_comunidades; 
      }

      if($total_beneficiarios != NULL){
        $totales['total_beneficiarios'] = $total_beneficiarios[0]['total_beneficiarios'];
        //echo 'Total Beneficiarios: '.$total_beneficiarios; 
      }

      /*print_r($totales);*/
      //exit;      
      

      return array($datos,$totales);

    }

    /**
    *Obtenemos información para crear reporte de firmas
    *@param int $id_municipio clave del municipio
    *@param int $id_centro_atencion id de la tabla centro de atención
    *@param int $axo Año que se consulta
    *
    *@return Array $datos
    **/    
    public static function reporte_platica_firmas($id_municipio,$id_centro_atencion,$axo){

      $sql = 
      'SELECT 
        b.paterno,
        b.materno,
        b.nombres,
        b.genero,
        a.tutor_paterno,
        a.tutor_materno,
        a.tutor_nombres, 
       YEAR(CURDATE()) - YEAR(b.fecha_nacimiento) + 
       IF(DATE_FORMAT(CURDATE(),?) > DATE_FORMAT(b.fecha_nacimiento,?), 0, -1) as edad       
       from alim_nutricion_extraescolar a
       LEFT JOIN beneficiario b on a.id_beneficiario = b.id
       where 1
       and YEAR(a.fecha_creado) = ?
       and a.id_municipio = ?
       and a.id_centro_atencion = ?
       and a.activo NOT IN (0)
       ORDER BY b.paterno, b.materno, b.nombres
       ';

      $params = array("%m-%d","%m-%d",$axo,$id_municipio,$id_centro_atencion);

      //Datos referente a los centros
      $datos = self::executar($sql,$params);

      /*
      print_r($params);
      echo $sql;
      */

      return $datos;

    }

    /**
    *Obtenemos información para crear reporte de padrón de transparencia
    *@param int $id_municipio id del municipio
    *@param int $id_centro_atencion id de la tabla centro de atención
    *@param int $axo Año que se consulta
    *@param int $CVE_ENT_MUN_LOC Comunidad
    *
    *@return Array $datos
    **/  
    public static function reporte_padron_transparencia($id_municipio,
     $id_centro_atencion,$axo_padron,$CVE_ENT_MUN_LOC){
       
     $sql_todos= 'SELECT * from alim_nutricion_extraescolar ane
     inner join centros_atencion ct on ane.id_centro_atencion = ct.id
     inner join comunidad co on ct.CVE_EST_MUN_LOC = co.CVE_ENT_MUN_LOC
     LEFT JOIN beneficiario b on b.id = ane.id_beneficiario
     where year(ane.fecha_creado) = ?
     and ct.CVE_EST_MUN_LOC = ?
     ORDER BY b.paterno,b.materno,b.nombres
     ';

     $params = array($axo_padron,$CVE_ENT_MUN_LOC);
     $datos = self::executar($sql_todos,$params);

     return $datos;
   }
  }
?>