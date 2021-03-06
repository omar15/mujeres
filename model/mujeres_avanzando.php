<?php
/**
 * Clase que nos permite administrar lo relacionado a la tabla mujeres_avanzando
 * **/ 

//Incluimos librer�a Paginador
include_once($_SESSION['inc_path'].'libs/Paginador.php');
//Incluimos librer�a de fecha
include_once($_SESSION['inc_path'].'libs/Fechas.php');

class mujeresAvanzando extends MysqliDb{

    public function __construct(){}
        
      /**
      * Ejecutamos sentencia sql con par�metros
      * @param string $sql Sentencia SQL
      * @param array $params Cada uno de los par�metros de la sentencia
      * 
      * @return int Resultado
      **/   
    private static function executar($sql,$params){

      //Ejecutamos
      $resultado = self::getInstance()->rawQuery($sql, $params);

      //Regresamos resultado
      return $resultado;        

    }

    /**
    * Obtenemos los datos del aspirante por su id de entrevista
    *@param int $id_mujeres_avanzando id de la tabla aspirante
    *
    *@return Array datos de aspirante
    **/
    public static function get_by_id_entr($id_entrevista){

        $datos = self::getInstance()->where('id_entrevista', $id_entrevista)
                                    ->getOne('mujeres_avanzando');


        return $datos;
    }

  /**
  * Obtenemos datos para llenar la cartilla
  * @param Array $articulos Arreglo con los art�culos
  *
  * @return Array datos de cartilla
  **/
  public static function datos_cartilla($articulos){
    
    //Obtenemos los id de cada beneficiaria
    foreach($articulos->articulo_id as $key => $value):
    $lista.=$value.',';
    endforeach;    
    
    //Quitamos �ltima coma
    $lista=substr($lista,0,-1);

    $sql = 'SELECT
            mj.*,
            IFNULL(g.grado,?) as grado,
            m.NOM_MUN as municipio
            FROM mujeres_avanzando mj
            LEFT JOIN grado g on g.id = mj.id_grado
            LEFT JOIN cat_municipio m on m.CVE_ENT_MUN = concat(mj.id_cat_estado,mj.id_cat_municipio)
            where mj.folio IN ('.$lista.') ';

    $params = array("(SIN ESPECIFICAR)"); 

    return self::executar($sql,$params);
    
  }


    /**
    * Obtenemos los datos del aspirante por su id
    *@param int $id_mujeres_avanzando id de la tabla aspirante
    *
    *@return Array datos de aspirante
    **/
    public static function get_by_id($id_mujeres_avanzando = NULL,$folio = NULL){
       /*
        $datos = self::getInstance()->join("grado g", "g.id = m.id_grado", "LEFT")
                                    ->join("cat_municipio cm", "cm.CVE_MUN = m.id_cat_municipio and cm.CVE_ENT = 14", "LEFT")
                                    ->where('m.id', $id_mujeres_avanzando)
                                    ->getOne('mujeres_avanzando m', null, "m.*, g.grado, cm.NOM_MUN as municipio_nom");
                                   


        return $datos;
        */
    $sql = ' SELECT
              m.id,
              concat(ifnull(m.nombres,?),?,ifnull(m.paterno,?),?,ifnull(m.materno,?)) as nombres,
              m.edad,
              m.colonia,
              m.calle,
              m.num_ext,
              cm.NOM_MUN,
              m.CODIGO,
              m.num_int,
              m.telefono,
              m.folio,
              m.fecha_nacimiento
              from mujeres_avanzando m
              LEFT JOIN cat_municipio cm on cm.CVE_MUN =m.id_cat_municipio 
              and cm.CVE_ENT =14
              where 1 ';

    $params = array('',' ','',' ',''); 

        //Filtramos por ID
        if($id_mujeres_avanzando != NULL){
            $sql .= ' AND m.id = ?';
            $params[] = $id_mujeres_avanzando;
        }

        //Filtramos por Folio
        if($folio != NULL){
            $sql .= ' AND m.folio = ?';
            $params[] = $folio;
        }

     $datos = self::executar($sql,$params);
     $datos = $datos [0];
     return $datos;

        
    }

    
   /**
     * Cambiamos el estatus del beneficiario 
     * 1 = Activo, 0 = Inactivo
     * @param int $id_mujeres_avanzando a actualizar
     * 
     * @return string $msg_no No. de Mensaje a regresar
     * */
    public static function activaMujer($id_mujeres_avanzando){

        //Variable que nos indica el mensaje generado al guardar el registro
        $msg_no = 0;

        //Variable donde guardamos el estatus
        $estatus = 0;

        //Sentencia para obtener el campo activo de la tabla Subm�dulo
        $sql = 'SELECT activo from `mujeres_avanzando` where id = ?'; 

        //par�metros para la consulta
        $params = array($id_mujeres_avanzando);                

        //Verificamos el estatus del Modulo        
        $registro = self::executar($sql,$params);
        $registro = $registro[0];

        //Si el registro tiene estatus de 'Eliminado', se activar�
        if($registro['activo'] == 0){

            $estatus = 1;

        }else if($registro['activo'] == 1){

        //Si el registro tiene estatus de 'Activo', se eliminar�
            $estatus = 0;
        }

        //Preparamos update
        self::getInstance()->where('id',$id_mujeres_avanzando);                                                

        //datos a actualizar
        $updateData = array('activo' => $estatus);

        //Iniciamos transacci�n
        self::getInstance()->startTransaction();        

        if(!self::getInstance()->update('mujeres_avanzando',$updateData)){

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
    
    //lista generica
    
     public static function listaMujerGenerica($busqueda=NULL,$tipo_filtro=NULL,
      $activo = NULL,$nombre=null,$paterno=null,$materno=null,$curp=null,
      $id_mujer=NULL,$id_caravana=NULL){
        
         $sql = 
        'SELECT
        b.id,
        b.nombres,
        b.paterno,
        b.materno,
        concat(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) as nombre_completo,        
        v.NOM_VIA as nombre_via,
        b.num_ext as num_ext,
        b.num_int as num_int,
        b.curp,
        ase.NOM_ASEN as nombre_asentamiento,
        est.NOM_ENT as estado,
        mpo.NOM_MUN as municipio,
        loc.NOM_LOC as localidad,
        esc.nombre as  n_escolaridad,
        ev.nombre as estado_civil,
        b.fecha_nacimiento,
        b.genero,
        b.pasaporte,
        IF(b.activo = 1,?,?) as es_activo,
        b.activo,
        b.indigena,      
        b.mes,
        b.edad,
        c.descripcion as nom_caravana,
        b.ocupacion,
        b.folio,
        b.calle
        FROM `mujeres_avanzando` b
        left join cat_estado est on b.CVE_EDO_RES = est.CVE_ENT
        left join cat_municipio mpo on b.id_cat_municipio = mpo.CVE_MUN 
                                and mpo.CVE_ENT = b.CVE_EDO_RES
        left join cat_localidad loc on loc.CVE_EST_MUN_LOC = CONCAT(b.CVE_EDO_RES,b.id_cat_municipio,b.id_cat_localidad)
        left join escolaridad esc on b.id_escolaridad = esc.id
        left join ocupacion oc on b.id_ocupacion = oc.id
        left join estado_civil ev on b.id_estado_civil = ev.id
        left join vialidad v on b.CVE_VIA = v.CVE_VIA
        LEFT JOIN caravana c on c.id = b.id_caravana 
        left join asentamiento ase on  b.CVE_ASEN = ase.CVE_ASEN 
                                and ase.CVE_ENT = b.id_cat_estado
                                and ase.CVE_MUN = b.id_cat_municipio
                                and ase.CVE_LOC = b.id_cat_localidad 
        where ? ';

        //Par�metros de la sentencia
        $params = array('',' ','',' ','','SI','NO',1);

        //Filtro de b�squeda
        if ($busqueda !==NULL && $tipo_filtro !==NULL){

             switch($tipo_filtro){
                
                case 'nombre':
                 $alias=' concat(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) ';
                 $params = array_merge($params,array('',' ','',' ',''));
                 $sql .=  ' AND '.$alias.' LIKE ? ';
                 $params[] = '%'.$busqueda.'%';
                   
                    break; 
                case 'folio':
                 $sql .= ' AND b.folio = ? ';
                 $params[] = $busqueda;       
                    break;
                case 'calle':
                 $sql .= ' AND b.calle LIKE ? ';
                 $params[] = '%'.$busqueda.'%';       
                    break;    
                case 'caravana':
                 $sql .= ' AND c.descripcion LIKE ? ';
                 $params[] = '%'.$busqueda.'%';
                    break;    
                    
            }

        }
        
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
        
        //Filtramos por ID de mujer
        if($id_mujer !== NULL){
            $sql .= ' AND b.id = ?';
            $params[] = $id_mujer;
        }

        //Filtramos por caravana
        if($id_caravana != NULL){
            $sql .= ' AND c.id = ?';
            $params[] = $id_caravana;
        }

        //Regresamos resultado
        // self::executar($sql,$params);

        /*
        print_r($params);
        echo $sql;
        exit;
        */

      return array($sql,$params);          
    
        
     }
    /**
     * Obtenemos listado de mujeres
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro  
     * @param $activo Determinamos si queremos los activos, inactivos o ambos (predeterminado)      
     * @return array Resultado de la consulta
     * */
    public static function listaMujer($busqueda=NULL,$tipo_filtro=NULL,
      $activo = NULL,$nombre=null,$paterno=null,$materno=null,$curp=null,
      $id_mujer = NULL,$id_caravana=NULL)
    {

        list($sql,$params) = self::listaMujerGenerica($busqueda,$tipo_filtro,
       $activo,$nombre,$paterno,$materno,$curp,$id_mujer,$id_caravana);
        //Regresamos resultado        
        return Paginador::paginar($sql,$params);      
    
    }
    
     public static function listadoMujer($busqueda=NULL,$tipo_filtro=NULL,
      $activo = NULL,$nombre=null,$paterno=null,$materno=null,$curp=null,
      $id_mujer=NULL,$id_caravana=NULL)
    {

        list($sql,$params) = self::listaMujerGenerica($busqueda,$tipo_filtro,
       $activo,$nombre,$paterno,$materno,$curp,$id_mujer,$id_caravana);
        //Regresamos resultado        
        return self::executar($sql,$params);    
    
    }

    /**
     * Obtenemos listado de los programas que tiene una mujer
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro  
     * @param string $nombre_propio Nombre propio
     * @param string $paterno Apellido Paterno
     * @param string $materno Apellido Materno
     * @param string $id_cat_municipio Municipio
     * @param string $id_cat_localidad Localidad
     * @param string $cod_prog C�digo del programa
     * @return array Resultado de la consulta paginada
     * */
    public static function listaProgMujer(
    $busqueda=NULL,$tipo_filtro=NULL,$nombre_propio=NULL,$paterno=NULL,$materno=NULL,
    $id_cat_municipio=NULL,$id_cat_localidad=NULL,$cod_prog=NULL,$curp=NULL)
    {
       
        //Si se cumple con alguno de los filtros
        if($tipo_filtro != NULL || ($nombre_propio != NULL || $paterno !=NULL || 
        $materno !=NULL || $id_cat_municipio !=NULL ||$id_cat_localidad !=NULL || 
        $cod_prog !=NULL || $curp !=null)){
        
        $sql = 
        'SELECT
        b.id,
        concat(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) as nombre_completo,
        b.nombres, 
        b.paterno,
        b.materno, 
        b.curp,
        DATE_FORMAT(b.fecha_nacimiento,?) as fecha_nacimiento,
        bp.ID_MUJERES_AVANZANDO,
        mpo.NOM_MUN as municipio,
        loc.NOM_LOC as localidad,
        p.NOMBRE as programa
        FROM `mujeres_avanzando` b
        LEFT JOIN c_mujeres_avanzando_detalle bp on bp.ID_MUJERES_AVANZANDO = b.id
        left join cat_municipio mpo on mpo.CVE_ENT_MUN = CONCAT(b.CVE_EDO_RES,b.id_cat_municipio)
        left join cat_localidad loc on loc.CVE_EST_MUN_LOC = CONCAT(b.CVE_EDO_RES,b.id_cat_municipio,b.id_cat_localidad)         
        LEFT JOIN c_servicio s on s.ID_C_SERVICIO = bp.ID_C_SERVICIO
        LEFT JOIN c_programa p on p.ID_C_PROGRAMA = s.ID_C_PROGRAMA
        where 1  
        ';

        $params = array('',' ','',' ','','%d/%m/%Y');

        //Filtro de b�squeda
        if ($busqueda !==NULL && $tipo_filtro !==NULL){          

            if($tipo_filtro == 'nombre'){

                 $alias=' concat(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) ';
                 $params = array_merge($params,array('',' ','',' ',''));

                 $sql .=  ' AND '.$alias.' LIKE ? ';
                
            }else{

                if($tipo_filtro == 'curp'){ 
                  
                 $sql .=  ' AND b.curp like ? '; 

                 }              
            }
            $params[] = '%'.$busqueda.'%';       
        }

        //Buscamos nombre propio           
        if($nombre_propio !=null){
          $sql .= ' AND b.nombres like ? ';
          $params[] = '%'.$nombre_propio.'%';    
        }

        //Apellido paterno
        if($paterno !=null){
          $sql .= ' AND b.paterno like ? ';
          $params[] = '%'.$paterno.'%';    
        }

        //Apellido materno
        if($materno !=null){
          $sql .= ' AND b.materno like ? ';   
          $params[] = '%'.$materno.'%';    
        }

        //Municipio
        if($id_cat_municipio !=null){

          $sql .= 'and mpo.CVE_ENT_MUN  = ? ';
          $params[] = '14'.$id_cat_municipio;    

        }

        //Localidad 
        if($id_cat_localidad !=null){

          $sql .= ' AND loc.CVE_EST_MUN_LOC = ? ';           
          $params[] = '14'.$id_cat_municipio.$id_cat_localidad;    

        }
        
        //CURP
        if($curp !=null){
          $sql .= ' AND b.curp = ? ';           
          $params[] = $curp;    
        }              
                         
        $sql.= 'GROUP BY 1';        

        return Paginador::paginar($sql,$params); 

      }else{

        return  NULL;

      }

    }

     /**
     * Obtenemos informaci�n capturada del beneficiario para mostrar en su
     * expediente
     * @param int $id_mujeres_avanzando Id del beneficiario a revisar
     * 
     * @return array Resultado de la consulta
     * */
    public static function expedienteMujer($id_mujeres_avanzando){

     $sql = 'SELECT
            b.id,
            concat(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) as nombre_completo,
            DATE_FORMAT(b.fecha_nacimiento,?) as fecha_nacimiento,
            b.nombres,
            b.paterno,
            b.materno,
            b.curp_generada,            
            b.es_curp_generada, 
            DATE_FORMAT(b.fecha_creado,?) as fecha_creado,
            DATE_FORMAT(b.fecha_ultima_mod,?) as fecha_ultima_mod,
            b.num_ext as numero_exterior,
            b.num_int as numero_interior,
            b.CODIGO as codigo,
            b.desc_ubicacion as descripcion,
            b.correo as correo,
            b.telefono as telefono,
            b.curp as curp,
            b.ife as ife,
            b.pasaporte as pasaporte,            
            b.fecha_aproxim as fecha_a,
            b.genero as genero,
            b.ciudadano_mex as ciudadano,
            b.indigena as indigena,
            b.comunidad_indigena as comunidad_indigena,
            b.dialecto as dialecto,
            est.NOM_ENT as estado_residencia,
            mpo.NOM_MUN as municipio_residencia,
            loc.NOM_LOC as localidad,
            catv.DESCRIPCION as tipo_via_prin,
            v.NOM_VIA as via_prin,
            catv1.DESCRIPCION  as tipo_via_1,
            v1.NOM_VIA  as via_1,
            catv2.DESCRIPCION  as tipo_via_2,
            v2.NOM_VIA  as via_2,
            catvp.DESCRIPCION  as tipo_via_post,
            vp.NOM_VIA as via_post,           
            CONCAT(catv.DESCRIPCION,?,v.NOM_VIA) as vialidad_principal,            
            CONCAT(catv1.DESCRIPCION,?,v1.NOM_VIA) as entres_calle1,
            CONCAT(catv2.DESCRIPCION,?,v2.NOM_VIA) as entres_calle2,
            CONCAT(catvp.DESCRIPCION,?,vp.NOM_VIA) as calle_posterior,           
            cpx.d_asenta as asentamiento,          
            cpx.d_tipo_asenta as tipo_asentamiento,            
            ev.nombre as estado_civil,                      
            p.nombre as pais,
            estn.NOM_ENT as estado_de_nacimiento,
            mpon.NOM_MUN as municipio_nacimiento,
            esc.nombre as escolaridad,
            oc.nombre as ocupacion                      
            from mujeres_avanzando b
            left join cat_estado est on b.CVE_EDO_RES = est.CVE_ENT
            left join cat_municipio mpo on CONCAT(b.CVE_EDO_RES,b.id_cat_municipio) = mpo.CVE_ENT_MUN
            left join cat_localidad loc on loc.CVE_EST_MUN_LOC = CONCAT(b.CVE_EDO_RES,b.id_cat_municipio,b.id_cat_localidad)
            LEFT JOIN cat_vialidad catv on b.CVE_TIPO_VIAL = catv.CVE_TIPO_VIAL
            left join vialidad v on b.CVE_VIA = v.CVE_VIA
            LEFT JOIN cat_vialidad catv1 on catv1.CVE_TIPO_VIAL = b.CVE_TIPO_VIAL_CALLE1
            LEFT JOIN vialidad v1 on b.entre_calle1 = v1.CVE_VIA
            LEFT JOIN cat_vialidad catv2 on catv2.CVE_TIPO_VIAL = b.CVE_TIPO_VIAL_CALLE2  
            LEFT JOIN vialidad v2 on b.entre_calle2 = v2.CVE_VIA
            LEFT JOIN cat_vialidad catvp on catvp.CVE_TIPO_VIAL = b.CVE_TIPO_VIAL_CALLEP 
            LEFT JOIN vialidad vp on b.calle_posterior = vp.CVE_VIA
            LEFT JOIN codigos_postales cp on b.CODIGO = cp.CODIGO
            left join cp_sepomex cpx on b.id_cp_sepomex = cpx.id
            left join estado_civil ev on b.id_estado_civil = ev.id
            LEFT JOIN pais p on b.id_pais = p.id
            LEFT JOIN cat_estado estn on b.id_cat_estado = estn.CVE_ENT
            LEFT JOIN cat_municipio mpon on CONCAT(b.id_cat_estado,b.id_municipio_nacimiento) = mpon.CVE_ENT_MUN
            LEFT JOIN escolaridad esc on b.id_escolaridad = esc.id
            LEFT JOIN ocupacion oc on b.id_ocupacion = oc.id
            where b.id = ?
            ';

            $params = array('',' ','',' ','','%d/%m/%Y','%d/%m/%Y','%d/%m/%Y',' ',' ',' ',' ',$id_mujeres_avanzando);    
              
            //$expediente = $db->rawQuery($sql,$params); 
            return self::executar($sql,$params);
        
    }

     //Calculamos edad apartir de la fecha
     public static function calcular_edad($fecha_nacimiento){
        
        list($Y,$m,$d) = explode("-",$fecha_nacimiento);
        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y ); 
        }

    /**
    * Verificamos si hay alg�n hom�nimo en el sistema, deben enviarse
    * todos los campos para realizar la b�squeda
    * @param string $nombres Nombres propios
    * @param string $paterno Apellido Paterno
    * @param string $materno Apellido Materno
    * @param string $fecha_nacimiento Fecha de Nacimiento
    * @param int $id_municipio_nacimiento Municipio de Nacimiento
    * @param int $id_cat_estado Estado de Nacimiento
    * @param int $id_mujeres_avanzando ID del beneficiario (opcional)
    *
    * @return bool Regresa verdadero en caso de encontrar hom�nimo,
    *              Regresa falso en caso de no encontrarlo o por no poner los campos obligatorios
    */
    public static function verificaHomonimo($nombres,$paterno,$materno,$fecha_nacimiento,
    $id_municipio_nacimiento,$id_cat_estado,$id_mujeres_avanzando = null)
    {

        //Inicializamos la bandera
        $homonimo = false;

        //Verificamos que se tengan los campos obligatorios
        if($nombres&&$paterno&&$materno&&$fecha_nacimiento&&

            $id_municipio_nacimiento&&$id_cat_estado){

            $sql = 
            'SELECT
            id
            from mujeres_avanzando
            where 1
            AND nombres = ?
            and paterno = ?
            and materno = ?
            and fecha_nacimiento = ?
            and id_municipio_nacimiento = ?
            and id_cat_estado = ?';

            $params = array($nombres,
                            $paterno,
                            $materno,
                            $fecha_nacimiento,
                            $id_municipio_nacimiento,
                            $id_cat_estado);

            //Agregamos condicion del id del beneficiario
            if($id_mujeres_avanzando != NULL){

                $sql .= ' and id != ? ';
                $params[] = $id_mujeres_avanzando;

            }

            /*
            echo $sql;
            print_r($params);
            exit;            
            */

            self::getInstance()->rawQuery($sql, $params);
          
            //print_r($beneficiario);
            //exit;

            //Verificamos si encontramos alguna coincidencia
            $homonimo = (count($beneficiario) > 0 )? true : false;

        }
              
        return $homonimo;

    }

    /**
    * Generamos una curp ya sea para validarla o completar este campo
    * @param string $nombres Nombres propios
    * @param string $paterno Apellido Paterno
    * @param string $materno Apellido Materno
    * @param string $fecha_nacimiento Fecha de Nacimiento
    * @param int $id_cat_estado Estado de Origen
    * @param bool $omitir_digitos Omitimos d�gitos finales
    *
    * @return string CURP
    **/
    private static function generaCURP($paterno,$materno,$nombres,$fecha_nacimiento,

        $genero,$id_cat_estado,$omitir_digitos = false){

        //Importamos librer�as
        include_once($_SESSION['inc_path'].'libs/Curp.php');
        include_once($_SESSION['inc_path'].'libs/Permiso.php');            

        //Formateamos fecha
        $newDate = date("d/m/Y", strtotime($fecha_nacimiento));
            
        //Quitamos acentos y s�mbolos raros del nombre completo        
        $paterno_curp=Permiso::limpiar(utf8_decode($paterno));
        $materno_curp=Permiso::limpiar(utf8_decode($materno));
        $nombres_curp=Permiso::limpiar(utf8_decode($nombres));

        //Generamos CURP
        $curp=Curp::generar_CURP(
                    mb_strtoupper($paterno_curp,'UTF-8'),
                    mb_strtoupper($materno_curp,"UTF-8"),
                    mb_strtoupper($nombres_curp,"UTF-8"),
                    $newDate,
                    $genero,
                    $id_cat_estado,
                    $omitir_digitos);

        return $curp;

    }

    /**
     * Guardamos registro en la tabla Subm�dulo
     * @param array $submodulo Arreglo con los campos a guardar
     * @param int $id del Modulo a editar (opcional)
     * 
     * @return int No. de mensaje
     * */

    public static function saveMujer($mujeres_avanzando,$id = null){

        //Variable que nos indica el mensaje generado al guardar el registro
        $msg_no = 0;

        //Arreglo donde contendremos si hay un registro duplicado
        $duplicado=array();

        //Indicamos predeterminadamente que insertaremos un registro
        $db_accion = 'insert';

        //Variable para verificar si es hom�nimo un mujeres_avanzando
        $esHomonimo = NULL;

        /*Obtenemos cada una de las variables enviadas v�a POST y las asignamos
        a su respectiva variable. Por ejemplo 
        $id = $_POST['id'], $nombre = $_POST['nombre']*/

		    //Creamos variable CURP        $curp = "";

        foreach($mujeres_avanzando as $key => $value):

        ${$key} = self::getInstance()->real_escape_string($value);

        endforeach;

         /* De momento NO validaremos la curp
         //Comprobamos duplicidad y validez de CURP
         if($curp !=null){

            //Verificamos que la curp est� bien armada,la obtenemos sin los 2 �ltimos d�gitos

            $ver_curp = substr($curp, 0, -2);

            //Ejecutamos funci�n para verificar curp (sin d�gitos)
            $curp_gen = self::generaCURP(
                                $paterno,
                                $materno,
                                $nombres,
                                $fecha_nacimiento,
                                $genero,
                                $id_cat_estado,
                                true);    

            //Si el curp no es v�lido, regresamos el mensaje
            if($ver_curp != $curp_gen){

                //CURP no corresponde con los datos dados
                $msg_no = 15;

                //calcular edad;
                $edad = null;

                return array($msg_no,strtoupper($curp));
            }

            //Verificamos que no se repita
            $sql='SELECT id FROM `mujeres_avanzando` where curp = ? ';
            $params = array($curp);

            //S�lo si se edita el mismo registro puede 'repetir el nombre'
            if($id !=null){
                $sql.=' and id not in (?)';
                $params[] = $id;              
            }                                  

         }

         if($pasaporte !=null){

            //Evitamos duplicidad de nombres en los registros        
            $sql='SELECT id FROM `mujeres_avanzando` where pasaporte = ? ';

            $params = array($pasaporte);

            //S�lo si se edita el mismo registro puede 'repetir el nombre'
            if($id !=null){
                $sql.=' and id not in (?)';
                $params[] = $id;                
            }

         }

        if($curp !=null||$pasaporte !=null){

        //Ejecutamos sentencia
        $duplicado = self::getInstance()->rawQuery($sql,$params);

        }*/       

        //Verificamos que no haya nombre duplicado
        /*if(count($duplicado)>0){

            $msg_no = 6;
            //Nombre duplicado

        }else{*/
                    
            //Obtenemos el id del usuario creador
            $id_usuario = $_SESSION['usr_id'];

            /*Si no esta creada la variable activo 
            predeterminadamente la guardamos = 1*/        
            if(!isset($activo) ){

                $activo = 1 ;            

            }        

           //variable que utilizaremos para guardar una posible curp_generada
           $curp_generada='';
           $obj = NULL;
           
           //No se envio CURP, se generara o se obtendra
           if($curp == null){
            
             //Si ya se tenia un id_dif guardado previamente se reutilizara
            if(intval($id) > 0){             
             self::getInstance()->where('id',$id);
             $obj = self::getInstance()->getOne('mujeres_avanzando');             
           }
           
           if($obj){
            
            if($obj['curp_generada']!=null){
                
              $curp_generada=$obj['curp_generada'];
              
             }

           }else{
                 //Generamos CURP
                 $curp = self::generaCURP(
                                  $paterno,
                                  $materno,
                                  $nombres,
                                  $fecha_nacimiento,
                                  $genero,
                                  $id_cat_estado);
			                            $curp_generada=$curp;
             }
           
           $curp=$curp_generada;

           }
                                      
            //si se nos envia una feha aproximada se va a generar la curp
            if($fecha_aproxim == 'SI' ){
              $es_curp_generada='SI';            
            }else{              
              $es_curp_generada='NO';  
            }
           
            //definir si o no en ciudadano mexicano
            if($ciudadano_mex == 'SI'){
                $ciudadano='SI';
            }else{
                $ciudadano='NO';
            }
            
            //definir si o no es indigena
            if($indigena =='SI' ){
                $indig='SI';
            }else{
                $indig='NO';
            }                       

            //Campos obligatorios
            if($nombres && $paterno && $fecha_nacimiento && /*$fecha_aproxim &&*/ 
            /*$genero*/  /*$CVE_VIA*/  /*$indigena*/  /*$CVE_EDO_RES*/ /* $id_cat_municipio && 
            $id_cat_localidad && /*$CVE_ASEN $id_cp_sepomex*/  $escolaridad && $ocupacion 
           /* $id_estado_civil &&/* $num_ext*/ /* $id_pais/* $CODIGO /*$ciudadano_mex*/ && $id_grado && $folio
           && $colonia && $calle && $num_ext && $id_cat_municipio && $id_cat_localidad && $CODIGO){                       
            
             if($fecha_nacimiento != null) {
                              
                $dias = Fechas::anios_meses_dias(
                                    Fechas::invierte_fecha($fecha_nacimiento),
                                    Fechas::invierte_fecha(date('Y/m/d')));

                $div=explode(".",$dias);
                $edad = $div[0];
                $mes = $div[1];
                //echo $edad;
                //exit;
                /*$edad = Fechas::anios_meses_dias(Fechas::invierte_fecha($value["fecha_nacimiento"]),
											Fechas::invierte_fecha(date('Y/m/d')));*/
                
             }  

              //Quitamos vueltas de carro
              $desc_ubicacion = trim(str_replace("\\r\\n"," ",$desc_ubicacion));
                

                $insertData = array(
                'nombres' => mb_strtoupper(trim($nombres),"UTF-8"),
                'paterno' => mb_strtoupper(trim($paterno),"UTF-8"),
                'materno' => mb_strtoupper(trim($materno),"UTF-8"),
                'fecha_nacimiento' => $fecha_nacimiento,
                'fecha_aproxim' => $es_curp_generada, //si es curp generas es fecha aproximada
                'curp' => strtoupper($curp),
                'es_curp_generada' =>$es_curp_generada,
                'curp_generada' => strtoupper($curp_generada),
                'genero' => $genero,
                'pasaporte' => $pasaporte,
                'indigena' => $indig,
                'comunidad_indigena' => mb_strtoupper(trim($comunidad_indigena),"UTF-8"),
                'dialecto' => mb_strtoupper(trim($dialecto),"UTF-8"),
                'id_cat_estado' => $id_cat_estado,
                'id_cat_municipio' => $id_cat_municipio,
                'id_cat_localidad' => $id_cat_localidad,
                'fecha_creado' => date('Y-m-d H:i:s'),
                'id_usuario_ultima_mod' => $id_usuario,
                'activo' => $activo,
                //'id_escolaridad' => $id_escolaridad,
                //'id_ocupacion' => $id_ocupacion,
                'escolaridad' => $escolaridad,
                'ocupacion' => $ocupacion,
                 'id_estado_civil' => $id_estado_civil,
                'id_usuario_creador' => $id_usuario,
                'num_ext' => $num_ext,
                'num_int' => $num_int,
                'desc_ubicacion' => mb_strtoupper($desc_ubicacion,"UTF-8"),
                //'tutor' => mb_strtoupper(trim($tutor),"UTF-8"),
                'CVE_EDO_RES' => $CVE_EDO_RES,
                'entre_calle1' => $entre_calle1,
                'entre_calle2' => $entre_calle2,
                'calle_posterior' => $calle_posterior,
                //'CVE_ASEN' => $CVE_ASEN,
                'id_cp_sepomex' => $id_cp_sepomex,
                'CVE_VIA' => $CVE_VIA,
                'CODIGO' => $CODIGO,
                'id_pais' => $id_pais,
                'ciudadano_mex'=>$ciudadano,
                'telefono'=>$telefono,
                'correo'=>$correo,
                'ife'=>$ife,
                'CVE_TIPO_VIAL'=>$CVE_TIPO_VIAL,
                'CVE_TIPO_VIAL_CALLE1'=>$CVE_TIPO_VIAL_CALLE1,
                'CVE_TIPO_VIAL_CALLE2'=>$CVE_TIPO_VIAL_CALLE2,
                'CVE_TIPO_VIAL_CALLEP'=>$CVE_TIPO_VIAL_CALLEP,
                'id_municipio_nacimiento'=>$id_municipio_nacimiento,
                'edad'=>$edad ,
                'mes'=>$mes,
                'domicilio' => md5($CVE_TIPO_VIAL.$CVE_VIA.$num_ext),
                'soundex_nombre' => self::getInstance()->soundex($nombres.' '.$paterno),
                'CTA_FACEBOOK' => $facebook,
                'CTA_TWITTER' => $twitter,
                'ID_C_TIPODISCAPACIDAD' => $ID_C_TIPODISCAPACIDAD,
                'ID_C_MOTIVODISCAPACIDAD' => $ID_C_MOTIVODISCAPACIDAD,
                'ID_C_ACREDITADISCAPACIDAD' => $ID_C_ACREDITADISCAPACIDAD,
                'ID_C_MODULO' => $ID_C_MODULO,
                'PUNTOS_OTORGADOS' => $PUNTOS_OTORGADOS,
                'PUNTOS_UTILIZADOS' => $PUNTOS_UTILIZADOS,
                'id_grado' => $id_grado,
                'cartilla' => $cartilla,
                'id_entrevista' => $id_entrevista,
                'folio' => $folio,
                'programa' => $programa,
                'nombres_tutor' => mb_strtoupper(trim($nombres_tutor)),
                'paterno_tutor' => mb_strtoupper(trim($paterno_tutor)),
                'materno_tutor' => mb_strtoupper(trim($materno_tutor)),
                'id_caravana' => $id_caravana,
                'calle' => $calle,
                'colonia' => $colonia,
                'nivel' => $nivel,
                'calidad_dieta' => $calidad_dieta,
                'diversidad' => $diversidad,
                'variedad' => $variedad,
                'elcsa'=> $elcsa
                 );                            
                
                //Nos aseguramos que el apellido materno se guarde vac�o
               if($id >0){
                
                if($materno == ""){
                  $data = Array (
                    'materno' => ''
                    );
                    //print_r($data);
                   // echo $materno;
                   //exit;
                  }
                  self::getInstance()->where ('id', $id);
                  self::getInstance()->update ('mujeres_avanzando', $data);
                  unset($insertData['materno']);
                }

                //Quitamos del arreglo los valores vac�os
                $insertData = array_filter($insertData, create_function('$a','return preg_match("#\S#", $a);'));

                //Si no es ind�gena, los campos comunidad_indigena y dialecto ser�n nulos
                if($indigena == 'NO'){
                    $insertData['comunidad_indigena'] = NULL;
                    $insertData['dialecto'] = NULL;
                }

                /*
                //Verificamos hom�nimos
                $homonimo = self::verificaHomonimo(
                                $nombres,
                                $paterno,
                                $materno,
                                $fecha_nacimiento,
                                $id_municipio_nacimiento,
                                $id_cat_estado,
                                $id);

                //echo $homonimo.' - '.$esHomonimo.' - '.$id;
                //exit;

                //Si encontr� hom�nimo y no se ha confirmado que lo es
                if($homonimo === true && $esHomonimo != 'SI' && $id == NULL){

                    //mostramos mensaje de hom�nimo
                    $msg_no = 15; 
                  
                }else{*/

                    //Si recibimos id para editar
                    if(intval($id)>0){

                        //Indicamos que haremos un update
                        $db_accion = 'update';
                        
                        //Al editarse no se guardar� el usuario creador ni la fecha creada
                        unset($insertData['id_usuario_creador']);
                        unset($insertData['fecha_creado']);
                        //Agregamos condici�n para indicar qu� id se actualiza
                        self::getInstance()->where('id',$id);                                        

                  }

                    /*
                    print_r($insertData);
                    exit;
                    */
                    
                    //Iniciamos transacci�n
                    self::getInstance()->startTransaction();                  

                    if(!self::getInstance()->{$db_accion}('mujeres_avanzando', $insertData)){
                        
                        /*Si se hace un update, no se guardaron campos nuevos, caso contrario
                        NO se est� guardando el registro por tener campos incompletos o incorrectos*/
                        $msg_no = ($db_accion == 'update')?  14 : 3;                    
                        
                        //Cancelamos los posibles campos afectados
                        self::getInstance()->rollback();                        

                        }else{

                        //Campos guardados correctamente
                        $msg_no = 1;   

                        //Obtenemos el id del registro creado o editado
                        $id = ($db_accion == 'insert')?self::getInstance()->getInsertId():$id;                                            

                        //Concatenamos curp generada para saber si se guardo la CURP o la Generada                    
                        $curp = $es_curp_generada.$curp; 

                        //Guardamos campos afectados en la tabla
                        self::getInstance()->commit();               

                        }     

                //}

            }else{

            //'Campos Incompletos'
            $msg_no = 2;             

            }
              
        //}        

        //Regresamos el mensaje, CURP y el id generado/modificado
        return array($msg_no,strtoupper($curp),$id);

    }


    /**
     * Mostramos el total
     * @param  date $fecha_creacion_ini Fecha de creaci�n de inicio
     * @param  date $fecha_creacion_fin Fecha de creaci�n de fin
     * @return Array Listado con resultados
     */
    public function totalRepCarGrado($fecha_creacion_ini = null,$fecha_creacion_fin = null){
        $sql = 'SELECT
                SUM(m.id_grado = 1) AS severa,
                SUM(m.id_grado = 2) AS moderada,
                SUM(m.id_grado = 3) AS leve,
                SUM(m.id_grado = 4) AS segura,
                COUNT(*) AS total
                FROM
                mujeres_avanzando m
                LEFT JOIN caravana c ON m.id_caravana = c.id
                WHERE ? ';

        $params = array(1);
                
         //Verificamos si se quieren filtrar por fecha
        if($fecha_creacion_ini !== NULL){
            $sql .= ' and c.fecha_instalacion BETWEEN ? AND ? ';
            $params[] = $fecha_creacion_ini;             
            $params[] = ($fecha_creacion_fin !== NULL)? $fecha_creacion_fin : $fecha_creacion_ini ;
        }
        
        $Arreglo = self::executar($sql,$params);

        /*
        print_r($params);
        echo $sql;        
        */
       
        return $Arreglo[0];
    }

    /**
     * Reporte donde mostramos el total de beneficiarias
     * por cada grado, agrupado por caravana mediante un rango opcional
     * @param  date $fecha_creacion_ini Fecha de creaci�n de inicio
     * @param  date $fecha_creacion_fin Fecha de creaci�n de fin
     * @return Array Listado 
     */
    public function repCarGrado($fecha_creacion_ini = null,$fecha_creacion_fin = null){
     
        $sql = 'SELECT
                c.id,
                c.descripcion AS caravana,
                c.fecha_instalacion,
                SUM(m.id_grado = 1) AS severa,
                SUM(m.id_grado = 2) AS moderada,
                SUM(m.id_grado = 3) AS leve,
                SUM(m.id_grado = 4) AS segura,
                COUNT(*) AS total
                FROM mujeres_avanzando m
                LEFT JOIN caravana c ON m.id_caravana = c.id 
                WHERE ? ';
                
                $params = array(1);
                
        //Verificamos si se quieren filtrar por fecha
        if($fecha_creacion_ini !== NULL){
            $sql .= ' and c.fecha_instalacion BETWEEN ? AND ? ';
            $params[] = $fecha_creacion_ini;             
            $params[] = ($fecha_creacion_fin !== NULL)? $fecha_creacion_fin : $fecha_creacion_ini ;
        }
        
          //Ordenamos por caravana
        $sql .= ' GROUP BY c.id ';
        
        /* 
        print_r($params);
        echo $sql;
        */

        return self::executar($sql,$params);

    }

}?>