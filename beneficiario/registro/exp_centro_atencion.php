<?php

//si la lista nula enviamos mensaje de que no hay registro en la busqueda
if($lista_c == NULL ){
    //No existen registros
    $mensaje = Permiso::mensajeRespuesta(8);
}

//Obtenemos acciones del menú
$central = Permiso::arregloMenu(substr(basename(__file__),0,-4),'center');

?>

<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function() {
    $("table").tablesorter({widgets: ['zebra']});
});
</script>

   <p>
    <?php
    //Si tenemos listado
    if($lista_c != NULL){                
        // Listado de páginas del paginador
        echo $p->display();
    ?>
    </p>
   
   <table class="tablesorter">
    <thead>
        <th>Nombre de Centro de Atenci&oacute;n</th>
        <th>Clave Comunidad</th>
        <th>Tipo de Centro</th>
       
    </thead>

    <tbody>
        <?php foreach($lista_c as $l): ?>
        <tr>
            <td><?php echo $l['nombre']; ?></td>
            <td><?php echo $l['clave_comunidad']; ?></td>
            <td><?php echo $l['nom_tipo_centro'];?></td>
           
        </tr>

        <?php endforeach; ?>      
        
    </tbody>
    </table>        
  <?php }else{ 
    
    echo '<h2><div class ="mensaje">NO TIENE CENTROS DE ATENCION ASIGNADOS<div/><h2/>'; 
      
  } ?>
  
  