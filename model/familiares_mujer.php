<?php
/**
 * Clase que nos permite administrar lo relacionado a los familiares de la beneficiaria
 * **/ 
//Inclumos librería MysqliDb
include_once($_SESSION['inc_path'].'libs/Paginador.php');
include_once($_SESSION['inc_path'].'libs/Fechas.php');

class Familiaresmujer extends MysqliDb{

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

 
       public static function guardaFamiliares($valor){
     // if($valor != null){
        $id_entrevista = $valor['C'];           
        $nombres = $valor['G'];
        $paterno = $valor['E'];            
        $materno = $valor['F'];
        $fecha_nacimiento = Fechas::fechadmyAymd(trim(substr($valor['H'],0,10)));  
                   
         $datos = array('id_entrevista' => $id_entrevista,'nombres'=>$nombres,'paterno'=>$paterno,'materno'=>$materno,'fecha_nacimiento'=>$fecha_nacimiento); 
         $msg_no = self::saveFamiliares($datos);
         
         return $msg_no;
                   
               }
                
        public static function saveFamiliares($datos){
        //Variable que nos indica el mensaje generado al guardar el registro               
                 $msg_no = 0;
// print_r($datos);
// exit;
         //Indicamos predeterminadamente que insertaremos un registro
                $accion = 'insert';
                
                
                foreach($datos as $key => $p):
                 ${$key} = self::getInstance()->real_escape_string($p);
                endforeach;
                 
                 
                 //echo $fecha_nacimiento;
                 //exit;
        
                  //obtenemos fechas con formato correcto

                  //$fecha = Fechas::fechadmyAymd($fecha_nacimiento);
        
                                
                    $insertData = array(
                        'id_entrevista' => $id_entrevista,
                        'nombres' => $nombres,
                        'paterno' => $paterno,
                        'materno' => $materno,
                        'fecha_nacimiento' => $fecha_nacimiento
                        
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
                        
                        //Iniciamos transacción
                        self::getInstance()->startTransaction();
                        
                        if(! self::getInstance()->{$accion}('familiares_mujer', $insertData)){
                            //'Error al guardar, NO se guardo el registro'
                            $msg_no = 3;
                            
                            //Cancelamos los posibles campos afectados
                            self::getInstance()->rollback(); 
        
                        }else{
                            //Campos guardados correctamente
                            $msg_no = 1;
                            
                            //Guardamos los campos afectados en la tabla
                            self::getInstance()->commit();                    
                        } 
        
               
                           
        return $msg_no;
    }
}
?>