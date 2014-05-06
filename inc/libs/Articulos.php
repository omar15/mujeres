<?php
include_once($_SESSION['model_path'].'beneficiario_pys.php');
include_once($_SESSION['model_path'].'producto_servicio.php');
include_once 'Carrito.php';

class Articulos extends Carrito{
    
    // Variables
    var $nombre;
    var $codigo_producto;
    var $codigo_componente;

    //Usaremos nuestra función de agregar (Sobreescribiremos de la clase Carrito)
    function agregar($articulo_id,$id_beneficiario = NULL,$cantidad = 1)
    {
        $LIMITE = 50;
        $mensaje = "";
        $pos = NULL;
        
        //Predeterminadamente se agrega 1 elemento
        if($cantidad <= 0){
            
            $cantidad = 1;
            
        }
                /* 
                echo "Articulo_id : ".$articulo_id;                
                echo "<br>Arreglo Carrito ";
                print_r($this->articulo_id);
                echo "<br>";
                */
                
                //Si existe el carrito, buscamos duplicados en él
                if($this->articulo_id){
                    
                    /*Posición que ocupa (en caso de ser duplicado) en el carrito.
                    la función array_search devuelve la posición en el arreglo en
                    caso de encontrarlo; caso contrario, devuelve 'false'
                    */
                    $pos = array_search($articulo_id,$this->articulo_id);                                                                                   
                    //echo "Pos carrito: ".$pos;   
                }
                
                //No se encontraron duplicados en el carrito, buscamos en tabla
                if($pos === false){
                        
                        //echo "Beneficiario: ".$id_beneficiario;
                        
                        //Obtenemos arreglo con los servicios ya asignados al beneficiario
                        $beneficiario_serv = Beneficiario_pys::listaArrPysBeneficiario($id_beneficiario);                        
                        
                        //de haber servicios ligados al beneficiario, comprobamos que no se duplique
                        if($beneficiario_serv != NULL){                                                        
                            
                            /* echo "<br>Arreglo en tabla del beneficiario $id_beneficiario ";
                            print_r($beneficiario_serv);
                            echo "<br>";*/
                    
                            //Buscamos en la tabla si ya tiene dicho artículo                
                            $pos = array_search($articulo_id,$beneficiario_serv);                  
                    
                            //echo "Pos:".$pos;
                        }                                             
                }
                
                            
                //Hay duplicado, mostramos mensaje
                if(is_int($pos)){
                    $mensaje = "Servicio ya agregado o asignado al beneficiario previamente";                        
                
                }else{
                        //echo "Se Agrega";
                        //Verificamos límite
                        //if ( count($this->articulo_id) <= $LIMITE ){						                                                         
                        
                      	$articulo = Producto_servicio::get_by_id($articulo_id);
                        
                        if($articulo != NULL){

                        $this->articulo_id[] = $articulo_id;
                        $this->cantidad[] = $cantidad;
                        $this->nombre[] = $articulo['codigo_producto'].' - '.$articulo['nombre'];
                        $this->codigo_producto[] = $articulo['codigo_producto'];
                        $this->codigo_componente[] = $articulo['codigo_componente'];

                        }else{
                            $mensaje = "Servicio Inexistente";
                        }                        
                    	
                       /*} else {
                       
                        $mensaje = "Solo se pueden solicitar " . $LIMITE . " artículos";
                       
                       }*/                
                }     
                         
        return $mensaje;
        
    }
    
} 