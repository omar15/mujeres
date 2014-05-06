<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 
//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'alim_nutricion_extraescolar.php');

//id_centro_atencion
$id_centro_atencion=$_GET['id_centro_atencion'];
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
list($lista,$p) = Alim_nutricion_extraescolar::listaAlim_nutricion_extraescolar($id_centro_atencion,$nombre,$paterno,$materno,$curp);

//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);
}
//print_r($lista);
//exit;
//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista == NULL && $busqueda !=null){
    
    //No existen registros
    $mensaje = Permiso::mensajeRespuesta(8);
}

//Obtenemos acciones del menú
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center');


?>

<div id="principal">
        <div id="contenido">
            <div class="centro">       
                <div  align="center">
                <form id='formbusqueda' method="get" action='lista_beneficiario_centro.php'> 
                <input style="float: right;" type="button" onclick="javascript:history.back(-1)" value="REGRESAR"   />
             <h2 class="centro">Padron de nutrici&oacute;n extraescolar</h2>
             <h2 class="centro"> Centro De Atenci&oacute;n: <?php echo $centros['CVE_EST_MUN_LOC'].' -  '.$centros['nombre']; ?></h2>    
             <?php if ($lista !=null){ ?>
             <h3 class="centro"> Resultados Encontrados: <?php echo count($lista);  ?></h3> 
             <?php }?>         
                <fieldset>
                <table>
                <legend>
                   <label>
                     Buscar beneficiarios del centro de atenci&oacute;n "<?php echo $centros['nombre']; ?>"
                   </label>  
                 </legend>
                <tr>
                 <td>
                     <input type="hidden" name="id_centro_atencion" value="<?php echo $id_centro_atencion; ?>" />
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
                </div>
            </div>
            
            
             
             <?php if($respuesta > 0){?>
    
    <div class="mensaje"><?php echo $mensaje;?></div>
            
     <?php } ?>
 

   <div id="page_list" align="center">        
    <p>
        <?php //if(array_key_exists('alta_centros_atencion',$central)){ ?>
       <!-- <a  id = 'enviar' href="alta_beneficiario_centro.php?id_centro_atencion=<?php echo $id_centro_atencion; ?>">Alta de beneficiario al centro</a>  -->
        <?php //} ?>
    </p> 
    <p>
    <?php
    //Si tenemos listado
    if($lista != NULL){                
        // Listado de páginas del paginador
        echo $p->display();
    ?>
    </p>

    <script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
    $(function() {
    $("table").tablesorter({widgets: ['zebra']});
    });
    </script>

    <table class="tablesorter">
    <thead>
        <th>Curp</th>
        <th>Paterno</th>
        <th>Materno</th>
        <th>Nombres</th>
        <th>Estatus</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th>E1</th>
        <th>E2</th>
        <th>E3</th>
        <th>Acci&oacute;n</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): ?>
        <tr>
            <td><?php echo ($l['curp']!=null)? $l['curp']:$l['curp_generada']; ?></td>
            <td><?php echo $l['paterno']; ?></td>
            <td><?php echo $l['materno'];?></td>
            <td><?php echo $l['nombres'];?></td>
            <td><?php echo $l['activo1'];?></td>
             <td><?php echo $l['genero'];?></td>
             <td><?php echo $l['edad'].','.$l['mes'];?></td>
             <td><?php 
                  
                  echo Permiso::estimador_pct($l['fecha_nacimiento'],$l['fecha_pesaje_1'],$l['genero'],$l['peso_1']);
                 ?></td>
                  <td><?php 
                  
                  echo Permiso::estimador_pct($l['fecha_nacimiento'],$l['fecha_pesaje_2'],$l['genero'],$l['peso_2']);
                 ?></td>
                 <td><?php 
                  
                  echo Permiso::estimador_pct($l['fecha_nacimiento'],$l['fecha_pesaje_3'],$l['genero'],$l['peso_3']);
                 ?></td>
            <td>
             <?php if($l['activo1']==1){ ?>
                <?php if(array_key_exists('edita_beneficiario_centro_particular',$central)){ ?>
            
                <div title="Editar datos especificos del beneficiario" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="edita_beneficiario_centro_particular.php?id_edicion=<?php echo $l['id']; ?>&id_centro_atencion=<?php echo $id_centro_atencion ?>"></a>
                </div>
                                            
                <?php } ?>
             <?php }?> 
            <?php if(array_key_exists('activa_beneficiario_centro_particular',$central)){ ?>
                
                <div title="<?php echo ($l['activo1'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo1'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro de <?php echo ($l['activo1'] == 1)? 'eliminar' : 'activar' ?> beneficiario" 
                       href="activa_beneficiario_centro_particular.php?id_activo=<?php echo $l['id']; ?>&id_centro_atencion=<?php echo $id_centro_atencion ?>"></a>
                </div>
                <?php } ?>
                
                
                 
                
                
                      
            
            </td>
        </tr>

        <?php endforeach; ?>      
        
    </tbody>
    </table>        
    <?php  }else{?>
        <h2 class="centro">NO HAY BENEFICIARIOS LIGADOS A ESTE CENTRO DE ATENCI&oacute;N</h2>
    <?php }?>
        </div>
     </div>
    </div>         
<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>       