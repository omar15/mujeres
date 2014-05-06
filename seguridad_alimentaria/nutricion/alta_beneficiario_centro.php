<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 
//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'beneficiario.php');

//cachamos id_centro_atencion
$id_centro_atencion=$_GET['id_centro_atencion'];
//cachamos id_localidad
$id_localidad=$_GET['id_localidad'];

//Valores de la búsqueda
$nombre=$_GET['nombre'];
$paterno=$_GET['paterno'];
$materno=$_GET['materno'];
$curp=$_GET['curp'];
$respuesta=$_GET['r'];

//obtenemos nobres de centros
$sql = 'SELECT CVE_EST_MUN_LOC, nombre FROM `centros_atencion` where id=?';
$params = array($id_centro_atencion);
$centros = $db->rawQuery($sql,$params);
$centros = $centros[0];

//Obtenemos listado de acciones
//Beneficiario:: nombre de la clase beneficiario que esta en el archivo beneficiario 
//list($lista,$p) = Beneficiario::listaAccion($busqueda,$tipo_filtro);
//forzamos busqueda para ver resultados
if($tipo_filtro == null){
    $tipo_filtro=$curp;
}
if($nombre !=null || $paterno!=null || $materno!=null || $curp!=null){
list($lista,$p) = Beneficiario::listaBeneficiario(null,null,null,$nombre,$paterno,$materno,$curp);  
}


//print_r($lista);
//exit;
//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);
}

//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista == NULL){
    //No existen registros
    $mensaje = Permiso::mensajeRespuesta(8);
}

//Obtenemos acciones del menú
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center');
//print_r($central);
//exit;

//echo 'CENTRO: '.$id_centro_atencion;
?>
 <div id="principal">
   <div id="contenido">
       <h2 class="centro">Alta de Beneficiario al centro de atenci&oacute;n</h2>
       <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   /> 
       <h2 class="centro"> Centro De Atenci&oacute;n: <?php echo $centros['CVE_EST_MUN_LOC'].' -  '.$centros['nombre']; ?></h2>
                 
       
   <?php if($respuesta > 0){?>
      <div class="mensaje"><?php echo $mensaje;?></div>
  <?php } ?>
   
     <div class="centro">       
        <div  align="center">
        <form id='formbusqueda' method="get" action='alta_beneficiario_centro.php'>        
                <fieldset>
                <table>
                <legend>
                   <label>
                     Buscar beneficiarios del padron &uacute;nico
                   </label>  
                 </legend>
                <tr>
                 <td>
                     <input type="hidden" name="id_centro_atencion" value="<?php echo $id_centro_atencion; ?>" />
                     <input type="hidden" name="id_localidad" value="<?php echo $id_localidad; ?>" />
                 </td>
                  </tr>  
                    
                    
                    <tr>
                  <td>
                    <label for="nombre">Nombre(s)</label>
                  </td>
                  <td>
                    <label for="paterno">Apellido Paterno</label>
                  </td>
                  <td>
                    <label for="materno">Apellido Materno</label>
                  </td>
                  <td>
                    <label for="curp">Curp</label>
                  </td>
                </tr>
                <tr>
                  <td>
                   <input type = 'text' id = 'nombre' name = 'nombre' class="nombre"/>
                 </td>
                  <td>
                   <input type = 'text' id = 'paterno' name = 'paterno' class="nombre"/>
                 </td>
                  <td>
                    <input type = 'text' id = 'materno' name = 'materno' class="nombre"/>
                  </td>
                  <td>
                    <input type = 'text' id = 'curp' name = 'curp' class="nom_num"/>
                  </td>
                  <td><input type="submit" id="boton"  value="Buscar" /></td></td>
                </tr>
                </table>
                </fieldset>
                </form>
                
                 <!--
                 permiso de agregar  
                  -->
                 
                 
                 
                    </div>
                    
    <div>
    <p>
       <?php //Verificamos si tiene permiso de activar/desactivar servicio

       if(Permiso::accesoAccion('alta_beneficiario', 'registro', 'beneficiario')){ ?> 
        <a  id = 'enviar' href="../../beneficiario/registro/alta_beneficiario.php">Agregar nuevo beneficiario al padron unico</a>
       <?php }?>
    </p> 

    <?php 

    if($lista == NULL && $nombre == NULL && $paterno == null && $materno == null && $curp == null ){?>

    <div class="mensaje">
        No se encontraron resultados con el criterio de b&uacute;squeda seleccionado
    </div>

    <?php } 

      include_once("lista_beneficiario_centro_busqueda.php");
         
   ?>

    </div>
                    
                 </div>
                </div>
            </div>


<?php 

//Incluimos pie

include($_SESSION['inc_path'].'/footer.php');

?>                
                
                