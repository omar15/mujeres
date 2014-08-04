<?php
session_start();//Habilitamos uso de variables de sesión

//Incluimos cabecera
include('../../inc/header.php');

//Incluimos modelos a usar
include_once($_SESSION['model_path'].'log_mujeres_avanzando.php');

//Variable de respuesta

//Si requerimos obtener totales por fecha
$fecha_creacion = ($_GET['fecha_creacion'] != NULL)? $_GET['fecha_creacion']: NULL;
$id_caravana = ($_GET['id_caravana'] != NULL)? $_GET['id_caravana'] : NULL;

//Listamos los programas del beneficiario
list($lista,$p) = logMujeresAvanzando::listaLog(null,null,$id_caravana,$fecha_creacion);                                        

//Obtenemos caravanas disponibles
//$db->where ('activo', 1);
$caravanas = $db->get('caravana');

//Obtenemos totales por caravana
$totalesCar = logMujeresAvanzando::totalPorCaravana($fecha_creacion);

//Obtenemos totales generales
$totalesGen = logMujeresAvanzando::totalGral();

//Mensaje respuesta
$respuesta = ($_GET['r'] == NULL && $lista == NULL)? 8 : $_GET['r'];
list($mensaje,$clase) = Permiso::mensajeRespuesta($respuesta);

?>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>combobox.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function() {
    $("table").tablesorter({widgets: ['zebra']});
});
</script>

<div id="principal">

   <div id="contenido">
    <h2 class="centro">Estad&iacute;sticas Generales Mujeres Avanzando</h2>

    <?php if($respuesta > 0){?>
    
    <div class="mensaje <?php echo $clase; ?>"><?php echo $mensaje;?></div>
    
    <?php } ?>

    <div class="centro">       
       

    <div>   

    <table id="totales" class="tablesorter">
    <thead>
        <th>Nombre de Caravana</th>
        <th>Total Fotos</th>
        <th>Total Impresiones</th>        
    </thead>

    <tbody>
    <?php foreach ($totalesCar as $k => $c):?>
        <tr>
            <td><?php echo $c['caravana']; ?></td>
            <td><?php echo $c['total_foto']; ?></td>
            <td><?php echo $c['total_imp'];?></td>            
        </tr>
    <?php endforeach;?>        
        <tr>
            <th>Totales</th>
        <td><?php echo $totalesGen['total_foto'] ?></td>
        <td><?php echo $totalesGen['total_imp'] ?></td>
        </tr>        
    </tbody>
    </table>    

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <table>
        <tr>
            <th>Caravana</th>
            <td>
                <select id="id_caravana" name="id_caravana">
                    <option value="">Seleccione Caravana</option>
                    <?php foreach($caravanas as $c): 
                    $selected = ($c['id'] == $id_caravana )? 'selected' : ''; 
                    ?>
                        <option value='<?php echo $c['id'] ?>'  <?php echo $selected;?> > 
                            <?php echo $c['descripcion'];?>
                        </option>
                    <?php endforeach; ?>                       
                </select>
            </td>
        </tr>
        <tr>
            <th>Fecha Creaci&oacute;n</th>
            <td>
                <input type="text" id="fecha_creacion" class="fecha" name="fecha_creacion"/>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value ="Filtrar"/></td>
        </tr>
        </table>
    </form> 

   <?php
   
    //Si tenemos listado
    if($lista != NULL){  
    echo $p->display();
    ?>
    </p>        

    </div>

    <table id="totales" class="tablesorter">
    <thead>
        <th>Folio</th>
        <th>Nombres</th>
        <th>A. Paterno</th>
        <th>A. Materno</th>
        <th>Caravama</th>        
        <th>Fecha Foto</th>
        <th>Fecha Impresi&oacute;n</th>        
        <th>Fecha Creaci&oacute;n</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): ?>
        <tr>
            <td><?php echo $l['folio']; ?></td>
            <td><?php echo $l['nombres']; ?></td>
            <td><?php echo $l['paterno']; ?></td>
            <td><?php echo $l['materno'];?></td>
            <td><?php echo $l['caravana'];?></td>            
            <td><?php echo $l['fecha_foto'];?></td>
            <td><?php echo $l['fecha_impresion'];?></td>            
            <td><?php echo $l['fecha_creacion'];?></td>
        </tr>

        <?php endforeach; ?>

    </tbody>
    </table>

 <?php } ?>
  
  </div>
 </div>

</div>
 
<?php 
//Incluimos pie
include($_SESSION['inc_path'].'/footer.php');
?>