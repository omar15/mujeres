<?php
/**
* Clase que nos permite administrar lo relacionado a la tabla beneficiario_pys
* (programas ligados al usuario) 
 * **/ 

//Inclumos librería Paginador
include_once($_SESSION['inc_path'].'libs/Paginador.php');
//Incluimos modelo 'trelacion_pys' para obtener todo lo relacionado al servicio
include_once($_SESSION['inc_path'].'libs/Articulos.php');               
//Incluimos modelo producto_servicio
include_once($_SESSION['model_path'].'producto_servicio.php');  

class Beneficiario_pys extends MysqliDb{

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
     * Cambiamos el estatus del beneficiario 
     * 1 = Activo, 0 = Inactivo
     * @param int $id_Beneficiario a actualizar
     * 
     * @return string $msg_no No. de Mensaje a regresar
     * */
   public static function activaBeneficiario_pys($id_beneficiario_pys){

    //Variable que nos indica el mensaje generado al guardar el registro
    $msg_no = 0;

    //Variable donde guardamos el estatus
    $estatus = 0;

    //Sentencia para obtener el campo activo de la tabla beneficiario_pys
    $sql = 'SELECT activo, cod_prog, id_beneficiario from `beneficiario_pys` where id = ?';

    //parámetros para la consulta
    $params = array($id_beneficiario_pys);

    //Verificamos el estatus del Modulo
    $registro = self::executar($sql,$params);
    $registro = $registro[0];

    /* Si el registro tiene estatus de 'Eliminado', se activará
       Si el registro tiene estatus de 'Activo', se eliminará*/
    $estatus = ($registro['activo'] == 0)? 1: 0;

    //Datos a actualizar
    $updateData = array('activo' => $estatus);

    //Iniciamos transacción
    self::getInstance()->begin_transaction();

    //Preparamos update
    self::getInstance()->where('id',$id_beneficiario_pys);

    if(!self::getInstance()->update('beneficiario_pys',$updateData)){
    //'Error al guardar, NO se guardo el registro'

        $msg_no = 3; 

    //Cancelamos los posibles campos afectados
        self::getInstance()->rollback();
    }else{

        $msg_no = 1;

        //Guardamos campos afectados en la tabla
        self::getInstance()->commit();

        //Activamos o desactivamos los servicios ligados al programa

        $updateData = array(
            'activo' => $estatus
        );

        //Iniciamos transacción
        self::getInstance()->begin_transaction();

        //Condiciones de búsqueda
        self::getInstance()->where('id_beneficiario', $registro['id_beneficiario'])
                           ->where('cod_prog', $registro['cod_prog']);

        if(!self::getInstance()->update('beneficiario_serv',$updateData)){

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

        } 

        return $msg_no;

    }

    /**
     * Obtenemos la consulta y parámetros para paginar o listar
     * los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro       
     *       
     * @return array Regresamos consulta y parámetros resultado de la consulta
     * */
    private static function listadoBeneficiarioServ($id_beneficiario = NULL,$busqueda=NULL,
        $tipo_filtro=NULL)
    {

        //Consulta utilizada cuando se usa beneficiario_pys y beneficiario_serv
        $sql_1 = 
        'SELECT 
         bs.cod_rpys,
         bs.id_beneficiario,
         concat(b.nombres,?,b.paterno,?,b.materno) as nombre_completo,
         (SELECT
          CONCAT(ca.descripcion,?,se.descripcion,?,
                                TRIM(
                                  CONCAT(
                                          IFNULL(s1.descrip1,?),?,
                                          IFNULL(s2.descrip2,?),?,
                                          IFNULL(s3.descrip3,?),?,
                                          IFNULL(s4.descrip4,?),?,
                                          IFNULL(s5.descrip5,?),?,
                                          IFNULL(s6.descrip6,?),?,
                                          IFNULL(s7.descrip7,?),?,
                                          IFNULL(s8.descrip8,?)
                                        )
                                    )
                ) as servicio
                from trelacion_pys pys
                inner join tcat_programas cp on pys.cod_prog = cp.cod_prog
                INNER JOIN tcat_actividades ca on pys.cod_act = ca.cod_act
                left join tservicios_especificos se on pys.cod_pyse = se.cod_pyse
                left join tsubnivel_1 as s1 on s1.cod_1 = pys.cod_1
                left join tsubnivel_2 as s2 on s2.cod_2 = pys.cod_2
                left join tsubnivel_3 as s3 on s3.cod_3 = pys.cod_3
                left join tsubnivel_4 as s4 on s4.cod_4 = pys.cod_4
                left join tsubnivel_5 as s5 on s5.cod_5 = pys.cod_5
                left join tsubnivel_6 as s6 on s6.cod_6 = pys.cod_6
                left join tsubnivel_7 as s7 on s7.cod_7 = pys.cod_7
                left join tsubnivel_8 as s8 on s8.cod_8 = pys.cod_8
                where pys.cod_rpys = bs.cod_rpys

        )as servicio,
        tp.programa,
        bs.activo
        FROM `beneficiario_serv` bs
        left join beneficiario b on bs.id_beneficiario = b.id
        LEFT JOIN trelacion_pys p on bs.cod_rpys = p.cod_rpys
        LEFT JOIN tcat_programas tp on p.cod_prog = tp.cod_prog
        where 1 ';

        

        //Consulta utilizada cuando se usa solamente beneficiario_pys 

        $sql_2 = 
        'SELECT 
        bp.cod_rpys,
        bp.id_beneficiario,
        concat(b.nombres,?,b.paterno,?,b.materno) as nombre_completo,
        (
             SELECT 
             CONCAT(ca.descripcion,?,se.descripcion,?,
             TRIM(CONCAT(
                         IFNULL(s1.descrip1,?),?,
                         IFNULL(s2.descrip2,?),?,
                         IFNULL(s3.descrip3,?),?,
                         IFNULL(s4.descrip4,?),?,
                         IFNULL(s5.descrip5,?),?,
                         IFNULL(s6.descrip6,?),?,
                         IFNULL(s7.descrip7,?),?,
                         IFNULL(s8.descrip8,?)
                         )
                  )
            ) as servicio
            from trelacion_pys pys
            inner join tcat_programas cp on pys.cod_prog = cp.cod_prog
            INNER JOIN tcat_actividades ca on pys.cod_act = ca.cod_act
            left join tservicios_especificos se on pys.cod_pyse = se.cod_pyse
            left join tsubnivel_1 as s1 on s1.cod_1 = pys.cod_1
            left join tsubnivel_2 as s2 on s2.cod_2 = pys.cod_2
            left join tsubnivel_3 as s3 on s3.cod_3 = pys.cod_3
            left join tsubnivel_4 as s4 on s4.cod_4 = pys.cod_4
            left join tsubnivel_5 as s5 on s5.cod_5 = pys.cod_5
            left join tsubnivel_6 as s6 on s6.cod_6 = pys.cod_6
            left join tsubnivel_7 as s7 on s7.cod_7 = pys.cod_7
            left join tsubnivel_8 as s8 on s8.cod_8 = pys.cod_8
            where pys.cod_rpys = bp.cod_rpys

        )as servicio,
        bp.cod_prog,
        tp.programa,
        bp.fecha_asignado,
        bp.fecha_creado,
        bp.activo
        from beneficiario_pys bp
        left join beneficiario b on bp.id_beneficiario = b.id
        LEFT JOIN trelacion_pys p on bp.cod_rpys = p.cod_rpys
        LEFT JOIN tcat_programas tp on p.cod_prog = tp.cod_prog
        where 1 ';

        //Parámetros de la sentencia
        $params = array(' ',' ',
        '/',' ',
        '',' ',
        '',' ',
        '',' ',
        '',' ',
        '',' ',
        '',' ',
        '',' ',
        '');

        //Filtramos un beneficiario
        if($id_beneficiario){
          $sql_1 .= " and bs.id_beneficiario = ? ";
          $sql_2 .= " and bp.id_beneficiario = ? ";
          $params[] = $id_beneficiario; 
        }                

        $sql_1 .= " GROUP BY 1 ";
        $sql_2 .= " GROUP BY 1 ";

        //echo $sql_2;

        return array($sql_2,$params);
    }

    /**
     * Obtenemos listado PAGINADO de los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro   
     *       
     * @return array Resultado de la consulta
     * */
    public static function listaPagBeneficiarioServ($id_beneficiario = NULL,$busqueda=NULL,
        $tipo_filtro=NULL)
    {

        list($sql,$params) = self::listadoBeneficiarioServ($id_beneficiario,$busqueda,$tipo_filtro);
        return Paginador::paginar($sql,$params);           
    }

    /**
     * Obtenemos LISTA de los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro   
     *       
     * @return array Resultado de la consulta
     * */
    public static function listaBeneficiarioServ($id_beneficiario = NULL,$busqueda=NULL,
        $tipo_filtro=NULL)
    {

        list($sql,$params) = self::listadoBeneficiarioServ($id_beneficiario,$busqueda,$tipo_filtro);
        return self::executar($sql,$params);
    }

    public static function listaBeneficiario_pys($busqueda=NULL,$tipo_filtro=NULL,$activo = NULL){

    $sql = 
    'SELECT
     CONCAT(ifnull(b.nombres,?),?,ifnull(b.paterno,?),?,ifnull(b.materno,?)) as nombre,
     bp.id,
     u.usuario,
     bp.cod_prog,
     bp.fecha_creado,
     tp.programa,
     bp.activo,
     bp.id_beneficiario
     from beneficiario_pys bp
     left join beneficiario b on b.id = bp.id_beneficiario
     left join usuario u on u.id = bp.id_usuario_atiende
     LEFT JOIN tcat_programas tp on tp.cod_prog = bp.cod_prog ';

     //Parámetros de la sentencia
     $params = array('',' ','',' ','');

     //Verificamos si se quieren filtrar los activos/inactivos
     if($activo !== NULL){
            $sql .= ' AND bp.activo = ?';
            $params[] = $activo;
        }

        return Paginador::paginar($sql,$params);           
    }

    /**
     * Guardamos registro en la tabla beneficiario_pys
     * @param array $beneficiario_pys Arreglo con los campos a guardar
     * @param int $id del registro a editar (opcional)
     * 
     * @return int No. de mensaje
     * */
    public static function saveBeneficiario_pys($beneficiario_pys,$id = null){        

        //Variable que nos indica el mensaje generado al guardar el registro
        $msg_no = 0;

        //Arreglo con los id's generados
        $id_generados = array();

        //Arreglo donde contedremos si hay un registro duplicado
        $duplicado=array();

        //Indicamos predeterminadamente que insertaremos un registro
        $db_accion = 'insert';

        /*Obtenemos cada una de las variables enviadas vía POST y las asignamos
        a su respectiva variable. Por ejemplo 
        $id = $_POST['id'], $nombre = $_POST['nombre']*/
        foreach($beneficiario_pys as $key => $value):

        ${$key} = self::getInstance()->real_escape_string($value);

        endforeach;        

        //Obtenemos el id del usuario creador
        $id_usuario = $_SESSION['usr_id'];

        /*Si no esta creada la variable activo 
         predeterminadamente la guardamos = 1*/        
        if(!isset($activo) ){
            $activo = 1 ;            
        }

        //Campos obligatorios
        if($id_beneficiario && $id_componente){                       

            //Quitamos vueltas de carro
            $desc_ubicacion = trim(str_replace("\\r\\n"," ",$desc_ubicacion));

            $insertData = array(
                'id_beneficiario' => $id_beneficiario,
                'fecha_asignado' => $fecha_asignado,
                'observaciones' => $observaciones,
                'id_usuario_atiende' => $id_usuario,
                'id_componente' => $id_componente,
                'activo' => $activo,
                'fecha_creado' => date('Y-m-d H:i:s')
                );                

            //Quitamos del arreglo los valores vacíos
            $insertData = array_filter($insertData, 
                                       create_function('$a','return preg_match("#\S#", $a);'));

            //Si tenemos un arreglo de artículos (carrito)
            if(isset($_SESSION['arrayArt'])){

                //Arreglo de fechas
                $arreglo_fechas = json_decode($beneficiario_pys['arreglo_fechas']);

                //Enviamos datos para guardar cada servicio
                list($msg_no,$id_generados) = self::savePys($insertData,$arreglo_fechas);

            }else{
                //Guardaremos solamente 1 producto/servicio

                //Obtenemos los códigos
                $datos = Producto_servicio::getCodCompPys($id_producto_servicio);

                //Complementamos arreglo para guardar el producto/servicio
                $insertData['id_producto_servicio'] = $id_producto_servicio;
                $insertData['id_servicio_especifico'] = $id_servicio_especifico;
                $insertData['codigo_producto'] = $datos['codigo_producto'];
                $insertData['codigo_programa'] = $datos['codigo_componente'];

                //Iniciamos transacción
                self::getInstance()->begin_transaction(); 

                //Enviamos datos 
                list($msg_no,$id_gen) = self::guardaPys($insertData,$id);                

                //Guardamos el id generado
                $id_generados[] = $id_gen;

                //Si no hubo error al insertar algún servicio
                if($msg_no == 1){

                    //Guardamos campos afectados en la tabla
                    self::getInstance()->commit();

                }else{
                    //Cancelamos los posibles campos afectados
                    self::getInstance()->rollback(); 
                }             

            }

        }else{
            //'Campos Incompletos'
            $msg_no = 2;             
        }

        return array($msg_no,$id_generados);

    } 

    /**
    *Función para guardar los productos y/o servicios recolectados en carrito
    *@param Array $insertData Datos recolectados del formulario
    *@param Array $arreglo_fechas Cada una de las fechas del producto/servicio
    *
    *@return Array Arreglo con: int $msg_no Mensaje de respuesta
    *                           array $id_generados ID's generados de la tabla beneficiario_pys      
    **/
    private static function savePys($insertData = NULL,$arreglo_fechas = NULL){        

        //Obtenemos objeto con los artículos 
        $articulos = unserialize($_SESSION['arrayArt']);

        //Arreglo de id's generados
        $id_generados = array();

        $msg_no = 1;

        //Iniciamos transacción
        self::getInstance()->begin_transaction();        

        //Recorremos arreglo
        foreach($articulos->articulo_id as $key => $value):

            //Complementamos arreglo para guardar el servicio
            $insertData['id_producto_servicio'] = $value;
            $insertData['codigo_producto'] = $articulos->codigo_producto[$key];
            $insertData['codigo_programa'] = $articulos->codigo_componente[$key];
            $insertData['fecha_asignado'] = $arreglo_fechas[$key];

            //Buscamos si ya está este registro pero como inactivo
            $sql = 'SELECT 
                    id, activo 
                    from `beneficiario_pys` 
                    where 1 
                    AND id_producto_servicio = ? 
                    AND id_beneficiario = ? AND activo = 0';

            $params = array($value,$id_beneficiario);     

            //Verificamos el estatus del Modulo        
            $servicio = self::executar($sql,$params);
            $servicio = $servicio[0];

            /*Previamente había un registro inactivo de este servicio, 
            sólo será activado de nuevo, caso contrario, agregamos un nueco
            registro en la tabla*/
            if($servicio != NULL){

              $msg_no = self::activaServicioBeneficiario_pys($value,$id_beneficiario);

            }else{

              //Guardamos cada registro, en caso de haber error, cancelamos los registros
              list($msg_no,$id) = self::guardaPys($insertData);

              //Guardamos lista de id's generados
              $id_generados[] = $id;
            }

            //Si tenemos mensaje de error
            if($msg_no == 3){

            //Cancelamos los posibles campos afectados
            self::getInstance()->rollback();               

            }                    

        endforeach;

        //Si no hubo error al insertar algún servicio
        if($msg_no == 1){

            //Guardamos campos afectados en la tabla
            self::getInstance()->commit();

        }                

        return array($msg_no,$id_generados);

    }

    /**
    *Función con la que guardamos el producto/servicio
    *@param Array $insertData Arreglo con información a guardar
    *
    *@return Array que contiene int $msg_no Mensaje al ejecutar función
    *                           int $id ID generado de la tabla beneficiario_pys
    */
    private static function guardaPys($insertData = NULL,$id = NULL){

        //Variable con el mensaje final
        $msg_no = 0;
        
        //Predeterminadamente insertamos registro
        $db_accion = 'insert';

        //Si recibimos id para editar
        if(intval($id)>0){                    

            //Indicamos que haremos un update
            $db_accion = 'update';
                  
            //Agregamos condición para indicar qué id se actualiza
            self::getInstance()->where('id',$id);

        }

        if(!self::getInstance()->{$db_accion}('beneficiario_pys', $insertData)){
            
            //No se pudo guardar uno de los servicios
            $msg_no = 3;

        }else{
            
            //Datos guardados correctamente
            $msg_no = 1;

            //Obtenemos el id del registro ya sea que lo actualizamos o generamos
            $id = ($id != NULL)? $id : self::getInstance()->getInsertId();
        }

        return array($msg_no,$id);
    }

    /**
    *Activamos o desactivamos un producto/servicio del beneficiario
    *@param int $id_beneficiario_pys id de la tabla beneficiario_pys
    *
    *@return int $msg_no Mensaje
    **/

     public static function activaServicioBeneficiario_pys($id_beneficiario_pys = NULL)
     {
        //Variable que nos indica el mensaje generado al guardar el registro
        $msg_no = 0;

        //Variable donde guardamos el estatus
        $estatus = 0;

        //Sentencia para obtener el campo activo de la tabla beneficiario_pys
        $sql = 'SELECT id, activo from `beneficiario_pys` where 1 ';

        //Dependiendo las variables recibidas, armamos la sentencia
        if($id_beneficiario_pys != NULL){

                $sql .= ' AND id = ?';
                //parámetros para la consulta
                $params = array($id_beneficiario_pys);

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

                //Obtenemos id del registro
                $id_serv_beneficiario_pys = $registro['id'];

                //Preparamos update
                self::getInstance()->where('id',$id_serv_beneficiario_pys);                                                

                //datos a actualizar
                $updateData = array('activo' => $estatus);

                //Iniciamos transacción
                self::getInstance()->begin_transaction();

                if(!self::getInstance()->update('beneficiario_pys',$updateData)){

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

        //ERROR: Campos incompletos
        $msg_no = 2;                       

        }        
        
        return $msg_no;

    }

    /**
     * Obtenemos la consulta y parámetros para paginar o listar
     * los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro       
     *       
     * @return array Regresamos consulta y parámetros resultado de la consulta
     * */
    private static function listadoPysBeneficiario($id_beneficiario = NULL,$busqueda=NULL,
        $tipo_filtro=NULL)
    {
        $sql = 
        'SELECT 
         bp.id,
         bp.id_beneficiario,
         concat(b.nombres,?,b.paterno,?,b.materno) as nombre_completo,
         bp.id_producto_servicio,
         pys.nombre as nombre_pys,
         c.nombre as nombre_componente,
         pys.tipo,
         bp.fecha_asignado,
         bp.fecha_creado,
         bp.activo
         from beneficiario_pys bp
         LEFT JOIN beneficiario b on bp.id_beneficiario = b.id
         LEFT JOIN producto_servicio pys on bp.id_producto_servicio = pys.id
         LEFT JOIN componente c on bp.id_componente = c.id
         where 1 ';

         $params = array(' ',' ');

         //Filtramos un beneficiario
        if($id_beneficiario != NULL){

          $sql .= " and bp.id_beneficiario = ? ";
          $params[] = $id_beneficiario; 

        }                

        return array($sql,$params);

    }


    /**
     * Obtenemos listado PAGINADO de los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro   
     *       
     * @return array Resultado de la consulta
     * */

    public static function listaPagPysBeneficiario($id_beneficiario = NULL,$busqueda=NULL,$tipo_filtro=NULL){

        list($sql,$params) = self::listadoPysBeneficiario($id_beneficiario,$busqueda,$tipo_filtro);
        return Paginador::paginar($sql,$params);           
    }

    

    /**
     * Obtenemos LISTA de los servicios ligados al beneficiario 
     * @param int $id_beneficiario ID del beneficiario a buscar
     * @param string $busqueda La cadena a buscar
     * @param string $tipo_filtro Tipo de filtro   
     *       
     * @return array Resultado de la consulta
     * */
    public static function listaPysBeneficiario($id_beneficiario = NULL,$busqueda=NULL,$tipo_filtro=NULL){

        list($sql,$params) = self::listadoPysBeneficiario($id_beneficiario,$busqueda,$tipo_filtro);
        return self::executar($sql,$params);
    }

     /**
     * Obtenemos listado de los productos y servicios ACTIVOS que ya dispone un beneficiario
     * @param int $id_beneficiario
     * 
     * @return array Id's de los productos y servicios
     * **/
    public static function listaArrPysBeneficiario($id_beneficiario){

        $resultado = self::listaPysBeneficiario($id_beneficiario);         
        $serv = array();

        foreach($resultado as $l):

        $serv[] = $l['id_producto_servicio'];

        endforeach;

        return $serv;
    }

}

?>