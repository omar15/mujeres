<?php
session_start();//Habilitamos uso de variables de sesión

//Incluimos cabecera
include('../../inc/header.php'); 

//Incluimos modelo 'Acción'
include_once($_SESSION['model_path'].'beneficiario.php');

//Valores de la búsqueda
$tipo_filtro=$_GET['tipo_filtro'];
$busqueda=$_GET['busqueda'];
$respuesta=$_GET['r'];
$id_dif=$_GET['id_dif'];

//Obtenemos listado de acciones
//Beneficiario:: nombre de la clase beneficiario que esta en el archivo beneficiario 
//list($lista,$p) = Beneficiario::listaAccion($busqueda,$tipo_filtro);
list($lista,$p) = Beneficiario::listaBeneficiario($busqueda,$tipo_filtro);

//imprimos respuesta en caso de enviarse
if($respuesta !=null){
    $mensaje = Permiso::mensajeRespuesta($respuesta);

    //Se guardó exitosamente, mostramos la id_dif/curp generada
    if($respuesta == 1 && $id_dif){
        //Vemos si fue generada la curp
        $es_generada = substr($id_dif, 0,2);
        //Obtenemos curp
        $curp = substr($id_dif, 2);

        $mensaje .= ($es_generada == "SI")? '. ID DIF: '.$curp : '. CURP: '.$curp;

    }

}

//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista == NULL && $respuesta == NULL){
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
                <form id='formbusqueda' method="get" action='lista_beneficiario.php'>        
                <table>
                <tr>
                 <td>
                     <label for="tipo_filtro"> Buscar Por: </label>
                 </td>
                    <td>
                        <select id="tipo_filtro" name="tipo_filtro">
                            <option value="nombre">Nombre</option> 
                            <option value="nombre">CURP</option>
                            <option value="nombre">Pasaporte</option>                                        
                        </select>
                    </td>
                    <td><label for="busqueda"> Palabra Clave</label></td>
                    <td><input type = 'text' id = 'busqueda' name = 'busqueda'/><td>&nbsp;</td>
                    <td><input type="submit" id="boton"  value="Buscar" /></td></td>
                </tr>
                </table>
                </form>
                </div>
            </div>
            
             <h2 class="centro">Listado de Beneficiario</h2>
        
        <?php if($respuesta > 0){?>
    
    <div class="mensaje"><?php echo $mensaje;?></div>
            
     <?php } ?>
     
     <div id="page_list" align="center">        
    <p>
        <?php if(array_key_exists('alta_beneficiario',$central)){ ?>
        <a  id = 'enviar' href="alta_beneficiario.php">Agregar</a>
        <?php } ?>
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
        <th>Nombres</th>
        <th>Estado</th>
        <th>Municipio</th>
        <th>Localidad</th>
        <!--  <th>Escolaridad</th> -->
        <th>Ocupacion</th>
        <!-- <th>Estado Civil</th> -->
        <th>Fecha de Nacimiento</th>
        <!-- <th>G&eacute;nero</th> -->
        <!-- <th>Pasaporte</th> -->        
        <th>Activo</th>
        <!-- <th>Indigena</th> -->
        <th>Acci&oacute;n</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): ?>
        <tr>
            <td><?php echo $l['nombre_completo']; ?></td>
            <td><?php echo $l['estado']; ?></td>
            <td><?php echo $l['municipio'];?></td>
            <td><?php echo $l['localidad'];?></td>
            <!-- <td><?php //echo $l['n_escolaridad'];?></td> -->
            <td><?php echo $l['ocupacion'];?></td>
            <!-- <td><?php //echo $l['estado_civil'];?></td> -->
            <td><?php echo $l['fecha_nacimiento'];?></td>
            <!-- <td><?php //echo $l['genero'];?></td> -->
            <!--  <td><?php //echo $l['pasaporte'];?></td> -->
            <td><?php echo $l['es_activo'];?></td>
            <!-- <td><?php //echo $l['indigena'];?></td> -->            
            <td>
             <?php if($l['activo']==1){ ?>
                <?php if(array_key_exists('edita_beneficiario',$central)){ ?>
            
                <div title="Editar" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="edita_beneficiario.php?id_edicion=<?php echo $l['id']; ?>"></a>
                </div>
                                            
                <!-- 
                <div>            
                    <a href="edita_beneficiario.php?id_edicion=<?php //echo $l['id']; ?>">Editar</a>
                </div>
                 -->
            
                <?php } ?>
             <?php }?> 
                
                <?php if(array_key_exists('activa_beneficiario',$central)){ ?>
                
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro <?php echo $l['id']; ?> de <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?> acci&oacute;n?" 
                       href="activa_beneficiario.php?id_activo=<?php echo $l['id']; ?>"></a>
                </div>
                <?php } ?>
                
                <?php
                //Si es homónimo ponemos select para verificar si es un homónimo
                if(Permiso::accesoAccion('alta_beneficiario_pys', 'reg_pys_beneficiario', 'productos_servicios')){ ?>

                <div title="Agregar Programa" class="ui-state-default ui-corner-all lista">
                  <a class="ui-icon ui-icon-circle-triangle-e" href="seguimiento_beneficiario.php?id_edicion=<?php echo $l['id']; ?>"></a>
                </div>
                <?php } ?>

                <!-- 
                <a class="confirmation"  href="activa_beneficiario.php?id_activo=<?php //echo $l['id']; ?>">
                 -->
                
                  <?php /* if($l['activo'] == 1){

                    echo 'Eliminar';

                }else if($l['activo'] == 0){

                    echo 'Activar';

                }*/?>
                
                <!-- 
                </a>
                 -->            
            
            </td>
        </tr>

        <?php endforeach; ?>      
        
    </tbody>
    </table>        
    <?php } ?>
        </div>
     </div>        
<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>
