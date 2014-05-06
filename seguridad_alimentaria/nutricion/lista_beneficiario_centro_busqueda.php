   
   <p>
    <?php
   
   include_once($_SESSION['inc_path'].'libs/Fechas.php');
                
         
                                   
                //echo $edad;
                //exit;
                /*$edad = Fechas::anios_meses_dias(Fechas::invierte_fecha($value["fecha_nacimiento"]),
											Fechas::invierte_fecha(date('Y/m/d')));*/
                
               
    
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
        <th>Centro De Atenci&oacute;n</th>
        <th>Acci&oacute;n</th>
    </thead>

    <tbody>
        <?php foreach($lista as $l): 
        
        $dias= Fechas::anios_meses_dias(Fechas::invierte_fecha($l["fecha_nacimiento"]),
			                       Fechas::invierte_fecha(date('Y/m/d')));
			                       $div=explode(".",$dias);
                                   $edad = $div[0];
                                   $mes = $div[1];
                                   
                                   
                      $rango_valido = Fechas::rango_edad($edad,$mes);     
        ?>
        
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
            <td><?php echo $l['nombre_centro'];?></td>
            <!-- <td><?php //echo $l['indigena'];?></td> -->            
            <td>
            
            <?php if($rango_valido == true ){ ?>
             <?php if($l['activo']==1){ ?>
                <?php if(Permiso::accesoAccion('edita_beneficiario', 'registro', 'beneficiario')){ ?>
            
                <div title="Editar datos del beneficiario" class="ui-state-default ui-corner-all lista">                
                    <a class="ui-icon ui-icon-note" href="../../beneficiario/registro/edita_beneficiario.php?id_edicion=<?php echo $l['id']; ?>"></a>
                </div>
                                            
                <!-- 
                <div>            
                    <a href="edita_beneficiario.php?id_edicion=<?php //echo $l['id']; ?>">Editar</a>
                </div>
                 -->
            
                <?php } ?>
             <?php }?> 
            <?php if(Permiso::accesoAccion('activa_beneficiario', 'registro', 'beneficiario')){ ?>
                
                <div title="<?php echo ($l['activo'] == 1)? 'Eliminar' : 'Activar' ?>" class="ui-state-default ui-corner-all lista">                
                    <a class="confirmation ui-icon ui-icon-<?php echo ($l['activo'] == 1)? 'closethick' : 'check'  ?>"
                       title="&iquest;Seguro de <?php echo ($l['activo'] == 1)? 'eliminar' : 'activar' ?> eliminar beneficiario <?php echo ' '.$l['nombre_completo']; ?>?" 
                       href="../../beneficiario/registro/activa_beneficiario.php?id_activo=<?php echo $l['id']; ?>"></a>
                </div>
                <?php } ?>
                <?php if(array_key_exists('alta_beneficiario_centro_particular',$central)){ ?>
                <?php if ($l['nombre_centro']==null){ ?>
                <div title="Agregar beneficiario a centro de atenci&oacute;n" class="ui-state-default ui-corner-all lista">
                  <a class="ui-icon ui-icon-circle-triangle-e" href="alta_beneficiario_centro_particular.php?id_centro_atencion=<?php echo $id_centro_atencion; ?>&id_beneficiario=<?php echo $l['id'];?>&id_localidad=<?php echo $id_localidad;?>"></a>                                  
                  <?php } ?>
                   <?php } ?>
                </div>
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
            
            <?php }else{
                echo 'rango de edad invalido';
            } ?>
        </tr>

        <?php endforeach; ?>      
        
    </tbody>
    </table>        
     <?php } ?>
     
     

      <!--  -->    




