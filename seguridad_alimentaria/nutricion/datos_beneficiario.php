
 <h2 class="centro">Seguimiento del Beneficiario</h2>    


   <fieldset>

      <table>

      <legend><label>Datos de identificaci&oacute;n del Beneficiario</label></legend>

      

      <tr>        

        <td colspan="4">&nbsp;</td>

      </tr>



      <tr>

        <td><label>Nombre(s)</label></td>

        <td><label>Apellido Paterno</label></td>

        <td><label>Apellido Materno</label></td>

      </tr>



      <tr>    

        <td><?php echo $lista['nombres']; ?></td>

        <td><?php echo $lista['paterno']; ?></td>

        <td><?php echo $lista['materno']; ?></td>

      </tr>



      <tr>

        <td><label>Fecha Nacimiento</label></td>

        <td><label>&iquest;Es Fecha Aproximada?</label></td>

        <td><label>CURP</label></td>

        <td><label>ID DIF</label></td>

      </tr>



      <tr>    

        <td><?php echo $lista['fecha_nacimiento']; ?></td>

        <td><?php echo $lista['fecha_a']; ?></td>

        <td><?php echo $lista['curp']; ?></td>

        <td><?php echo $lista['curp_generada']; ?></td>

      </tr>

    </table>

    </fieldset>



    <fieldset>

    <table>

    <legend><label>Domicilio</label></legend>

    

    <tr>

      <td><label>Municipio</label></td>

      <td><label>Localidad</label></td>      

    </tr>

    <tr>

      <td><?php echo $lista['municipio_residencia']; ?></td>

      <td><?php echo $lista['localidad']; ?></td>      

    </tr>



    <tr>      

      <td><label>Tipo Vialidad</label></td>

      <td><label>Vialidad</label></td>

      <td><label>No. Interior</label></td>

      <td><label>No. Exterior</label></td>

      <td><label>Asentamiento</label></td>

    </tr>



    <tr> 

      <td><?php echo $lista['tipo_via_prin']; ?></td>

      <td><?php echo $lista['via_prin']; ?></td>

      <td><?php echo $lista['numero_interior']; ?></td>

      <td><?php echo $lista['numero_exterior']; ?></td>

      <td><?php echo $lista['asentamiento']; ?></td>

    </tr>

    </table>

</fieldset>



<fieldset>

    <table>

    <legend><label>Datos Adicionales</label></legend>

    <tr>

       <td><label>Escolaridad</label></td>

       <td><label>Ocupaci&oacute;n</label></td>

    </tr>

    <tr>

       <td><?php echo $lista['escolaridad']; ?></td>

       <td><?php echo $lista['ocupacion']; ?></td>

    </tr>

    

    <tr>

       <td><label>Ind&iacute;gena</label></td>

       <td><label>Comunidad Ind&iacute;gena</label></td>

       <td><label>Dialecto</label></td>  

    </tr>

    <tr>

       <td><?php echo $lista['indigena']; ?></td>

       <td><?php echo $lista['comunidad_indigena']; ?></td>

       <td><?php echo $lista['dialecto']; ?></td>

    </tr>



    <tr>

      <td><label>Pa&iacute;s de Nacimiento</label></td>

      <td><label>Estado de Nacimiento</label></td>

    </tr>



    <tr>

       <td><?php echo $lista['pais']; ?></td>

       <td><?php echo $lista['estado_de_nacimiento']; ?></td>

    </tr>



    <tr>

      <td><label>Municipio de Nacimiento</label></td>

      <td><label>&iquest;Es ciudadano mexicano?</label></td>

    </tr>



    <tr>

      <td><?php echo $lista['municipio_nacimiento']; ?></td>

      <td><?php echo $lista['ciudadano']; ?></td>

    </tr>

    

    <tr>

      <td><label>Fecha de Creaci&oacute;n</label></td>

      <td><label>&Uacute;ltima Modificaci&oacute;n</label></td>

    </tr>



    <tr>

      <td><?php echo $lista['fecha_creado']; ?></td>

      <td><?php echo $lista['fecha_ultima_mod']; ?></td>

    </tr>



    <tr>

      <td colspan="8">&nbsp;</td>

    </tr>

    

    <tr>

      <td colspan="4" >

      <?php

          //Verificamos si tiene permiso de edición

          if(Permiso::accesoAccion('seguimiento_beneficiario', 'registro', $_SESSION['module_name'])){ ?>                

              <a href="edita_beneficiario.php?id_edicion=<?php echo $lista['id']; ?>"><input type="submit" class="button" value="editar"/></a>

      <?php } ?>   

      </td>

    </tr>

</table>

</fieldset>

