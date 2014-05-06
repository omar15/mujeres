<?php
session_start();

//Eliminamos variable de sesión de carrito
unset($_SESSION['arrayArt']);

//definimos variables
$programa = array();

/* Al utilizar ajax y refrescar este formulario
necesitaremos obtener tanto el objeto $db (instancia de conexión)
como el id del beneficiario. Verificamos que, si no están creadas
las variables, las obtendremos*/

if(!isset($db)){

  //Incluimos librería de permiso
  include ($_SESSION['inc_path'] . "conecta.php");

}

    //Si editamos el registro    
    if(intval($id_edicion)>0){

        //Obtenemos el registro del pys_beneficiario
        $db->where('id',$id_edicion);
        $beneficiario_pys = $db->get_first('beneficiario_pys');  

        //Obtenemos el programa ligado al beneficiario 
        $id_beneficiario = $beneficiario_pys["id_beneficiario"];

    }

   //Obtemos los componentes (programas)
   include_once($_SESSION['model_path'].'componente.php');
   $programa = Componente::listaComponentes();
?>

<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>productos_servicios/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>productos_servicios/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>/combobox.js"></script>

<form id='formBen_pys' method="post" action='save_beneficiario_pys.php'>
 <tr>
  <td>
   <label class="obligatorio">* Campos OBLIGATORIOS</label>
  </td>
 </tr>
 <fieldset>
  <table>
   <legend>
    <label>
     Datos de identificaci&oacute;n del Beneficiario
    </label>  
   </legend>
    <tr>        
        <td colspan="4">&nbsp;</td>        
    </tr>
   <!--
   <tr>
      <td>
            <label class="obligatorio">*</label><label for="id_beneficiario">Beneficiario</label>
      </td>
    </tr>
   -->
    <tr>
      <td>
            <label class="obligatorio">*</label><label for="id_componente">Programa</label>
      </td>
    </tr>
    <tr>
      <td>
      <input type="hidden" name="id_beneficiario" id="id_beneficiario" value="<?php echo (isset($id_beneficiario))? $id_beneficiario: '';?>"/>      
            <select class="combobox" id="id_componente" name="id_componente">
            <option value=''>Seleccione Programa</option>
              <?php foreach($programa as $p): ?>
                <option value='<?php echo $p['id'] ?>' >
                  <?php echo $p['codigo'].' - '.$p['nombre'];?>
                </option>
              <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
      <td>
            <label for="id_producto_servicio">Productos y Servicios</label>
      </td>
    </tr>
    <tr>
      <td id="pys">
            <select class="combobox" id="id_producto_servicio" name="id_producto_servicio">
            <option value=''>Seleccione Producto/Servicio</option>                   
            </select>
        </td>
    </tr>
<!--

<tr>

  <td><label>Fecha en que fue otorgado</label></td>

</tr>

<tr>

  <td>

  <input type = 'text' id ='fecha_asignado' class="fecha date" name ='fecha_asignado' />

  <input type="button"  value="Hoy" id="" class="today"  />

  </td>

</tr>

-->

    <tr>
      <td><label>Observaciones</label></td>      
    </tr>
    <tr>
      <td>
        <textarea id='observaciones' name = 'observaciones' class="nomnum" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td id="servicios"></td>
    </tr>    
    <tr>
    <td colspan="4" >
    &nbsp;
    </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
        <td colspan="4">
          <input type="submit" value="Guardar" id="guardar" />
        </td>
    </tr>  
  </table>
 </fieldset>
</form>