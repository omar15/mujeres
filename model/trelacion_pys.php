<?php
 /**
 * Clase que nos permite administrar lo relacionado a la tabla Usuario
 * **/ 

//Inclumos librería Paginador
include_once($_SESSION['inc_path'].'libs/Paginador.php');

class Trelacion_pys extends MysqliDb{

/*Iniciamos un constructor vacío pues se tomarian 
los valores del constructor de MysqliDb, la clase de la que
heredamos*/
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
     * Obtenemos listado de los usuarios. Predeterminadamente mostramos
     * en ambos estatus (activos e inactivos)
     * @param string $busqueda Campo a buscar
     * @param string $tipo_filtro Tipo de filtro para realizar la búsqueda
     * @param int $activo Determinamos si queremos los activos, inactivos o ambos
     * @param int $cod_prog Id del Programa
     * @param int $id_beneficiario Id del Beneficiario     
     * 
     * @return array Resultado de la consulta
     * */
    private static function listPys($busqueda=NULL,$tipo_filtro=NULL,
        $activo = 1,$cod_prog = NULL,$id_beneficiario = NULL){
    
    //Preparamos sentencia
    $sql = 
    'SELECT
       pys.cod_rpys as id,
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
                  IFNULL(s8.descrip8,?),?
                  )
             )
             ) as servicio,
       pys.cod_prog
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
          where 1                       
    ';
    
    //Parámetros
    $params = array
    ('/',' ','',' ',
    '',' ',
    '',' ',
    '',' ',
    '',' ',
    '',' ',
    '',' ',
    '',' ');
        
        //filtro de busqueda
        if ($busqueda && $tipo_filtro){
            
            switch($tipo_filtro){
                
                case 'programa':
                    $sql .= ' AND pys.cod_prog = ? ';                    
                    break; 
                case 'registro':
                    $sql .= ' and pys.cod_rpys = ? ';
                    break;
            }
            
            $params[] = $busqueda;
            
           
        }

        //Filtramos por otros campos

        //Filtramos por programa
        if($cod_prog != NULL){
                $sql .= ' and pys.cod_prog = ? ';
                $params[] = $cod_prog;
        }

        //Mostramos servicios que NO tiene el usuario
        if($id_beneficiario != NULL){
                //Consulta usando la tabla de beneficiario_serv
                /*$sql .= ' and pys.cod_rpys not in 
                            ( SELECT cod_rpys from beneficiario_serv where id_beneficiario = ? ) ';*/

                //Consulta usando la tabla de beneficiario_pys
                $sql .= ' and pys.cod_rpys not in 
                            ( SELECT cod_rpys from beneficiario_pys where id_beneficiario = ? ) ';
                $params[] = $id_beneficiario;
        }

        //Verificamos si se quieren filtrar los activos/inactivos 
        if($activo !== NULL){
            $sql .= ' and pys.activo = ?';
            $params[] = $activo;
        }
        
        $sql .= ' ORDER BY pys.cod_rpys ASC ';

        /*
        echo $sql;
        print_r($params);
        */

        return array($sql,$params);
    }

      /**
     * Obtenemos listado de los usuarios SIN PAGINAR. Predeterminadamente mostramos
     * en ambos estatus (activos e inactivos)
     * @param string $busqueda Campo a buscar
     * @param string $tipo_filtro Tipo de filtro para realizar la búsqueda
     * @param int $activo Determinamos si queremos los activos, inactivos o ambos
     * 
     * @return array Resultado de la consulta
     * */
     public static function listadoPys($busqueda=NULL,$tipo_filtro=NULL,$activo = 1)
     {
        
        //Obtenemos parámetros
        list($sql,$params) = self::listPys($busqueda,$tipo_filtro,$activo);
        
        //Regresamos listado de usuarios
        return self::executar($sql,$params);
                        
     }

     /**
     * Obtenemos listado de los usuarios PAGINADO. Predeterminadamente mostramos
     * en ambos estatus (activos e inactivos)
     * @param string $busqueda Campo a buscar
     * @param string $tipo_filtro Tipo de filtro para realizar la búsqueda
     * @param int $activo Determinamos si queremos los activos, inactivos o ambos
     * 
     * @return array Resultado de la consulta
     * */
    public static function listaPys($busqueda=NULL,$tipo_filtro=NULL,$activo = 1){
    
        //Obtenemos parámetros
        list($sql,$params) = self::listPys($busqueda,$tipo_filtro,$activo);
        
        //Regresamos resultado paginado     
        return Paginador::paginar($sql,$params);      
    }
    
    /**
     * Obtenemos listado de los servicios ACTIVOS que ya dispone un beneficiario
     * @param int $id_beneficiario
     * 
     * @return array Total de servicios
     * **/    
    public static function totalBeneficiarioServ($id_beneficiario){
        
        $sql = 'SELECT cod_rpys FROM `beneficiario_serv` where id_beneficiario = ? AND activo = 1';
        $params = array($id_beneficiario);
        $resultado = self::getInstance()->rawQuery($sql,$params);         
        
        $serv = array();
        
        foreach($resultado as $l):
        $serv[] = $l['cod_rpys'];
        endforeach;
        
        return $serv;
    }

    /**
    * Filtramos los servicios disponibles, evitando tener servicios
    * duplicados.
    * @param int $cod_prog Código del programa
    * @param int $id_beneficiario ID de la tabla beneficiario
    * @param int $activo Determinamos si queremos los activos, inactivos o ambos
    *
    * @return array Resultado con el listado de servicios disponibles
    **/
    public static function filtraServiciosDisp($cod_prog,$id_beneficiario=NULL,$activo = 1){
        
        //Obtenemos parámetros
        list($sql,$params) = self::listPys(null,null,$activo,$cod_prog,$id_beneficiario);
        
        $resultado = self::getInstance()->rawQuery($sql,$params);                 
        
        return $resultado;
        
    }
}
?>