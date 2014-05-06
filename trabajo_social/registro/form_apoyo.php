<?php
session_start();
include_once($_SESSION['model_path'].'producto_servicio.php');
include_once($_SESSION['model_path'].'servicios_especificos.php');

//Si obtenemos los estatus
$estatus = $db->get('estatus'); 
//Obtenemos los apoyos otorgados
$sql = 'SELECT id, nombre  from trab_tipo_apoyo_solicitado';
$apoyo_solicitado = $db->query($sql); 

$tipo_servicio = Servicios_especificos::listaPadres();



//Obtemos los productos y servicios de Trabajo Social
  $programa = Producto_servicio::listaPys(null,null,18); 
 //Si editamos el registro 
    if(intval($id_edicion)>0){
        //Obtenemos el registro del trab_apoyo_otorgado
        $db->where('id',$id_edicion);
        $apoyo = $db->getOne('trab_apoyo_otorgado'); 
        $id_trab_expediente = $apoyo['id_trab_expediente'];  
        
        
        
        //Obtenemos el registro de trab_expediente
        $db->where('id',$id_trab_expediente);
        $trab_expediente = $db->getOne('trab_expediente'); 

        //Obtenemos el id del beneficiario
        $id_beneficiario = $trab_expediente['id_beneficiario'];

        //Obtenemos el registro de beneficiario_pys
        $db->where('id',$apoyo['id_beneficiario_pys']);
        $beneficiario_pys = $db->getOne('beneficiario_pys'); 
        $id_producto_servicio = $beneficiario_pys['id_producto_servicio'];
        $id_servicio_especifico = $beneficiario_pys['id_servicio_especifico'];
        //obtenemos informacion de los servicios especificos.
       $servicio_especifico = $db->where('id',$id_servicio_especifico)
                                  ->get_first('servicios_especificos'); 
       $padre = $servicio_especifico['padre'];
       
       $ser_espec= Servicios_especificos::listaServicios($padre);
       
       $sql = '
        SELECT nombre, id from servicios_especificos where id in (
        select 
        se.padre
        FROM relacion_servicios rs
        LEFT JOIN servicios_especificos se on se.id = rs.id_servicios_especificos
        where id_producto_servicio = ?
        GROUP BY se.padre
)
    ' ;
    $params = array($id_producto_servicio);
    $tipo_servicio = $db->rawQuery($sql,$params);
       
           
      
      
    }
 
?>

<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>jquery.maskedinput.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/filtro.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?><?php echo $_SESSION['module_name']?>/valida.js"></script>
<script lang="JavaScript" type="text/javascript" src="<?php echo $_SESSION['js_path']?>combobox.js"></script>

<form id='formApo' method="post" action='save_apoyo.php'>
 <fieldset> 
  <table>
    <legend>
       <label>
         Fuentes de Donativo
         
       </label>
     </legend>
     <tr>
       <td>
        <label class="obligatorio">*</label>
        <label for="aportacion_dif">Dif Jalisco</label>
      </td>
       <td>
       
        <label for="dif_municipal">Dif Municipal</label>
      </td>
      <td>
        
        <label for="familia">Familia</label>
      </td>
      <td>
        
        <label for="otros">Otros</label>
      </td>
     </tr>
     <tr>
      <td><input type = 'text' id = 'aportacion_dif' name = 'aportacion_dif' value="<?php echo $apoyo['aportacion_dif']; ?>" /></td>
      <td><input type = 'text' id = 'dif_municipal' name = 'dif_municipal' value="<?php echo $apoyo['dif_municipal']; ?>" /></td>
      <td><input type = 'text' id = 'familia' name = 'familia' value="<?php echo $apoyo['familia']; ?>" /></td>
      <td><input type = 'text' id = 'otros' name = 'otros' value="<?php echo $apoyo['otros']; ?>" /></td>
     </tr>
  </table>
 </fieldset>   
  <table>
 </fieldset>  
   <tr>
      <td>
          <label class="obligatorio">*</label>
          <label for="fecha_autorizacion">Fecha Autorizaci&oacute;n</label>
      </td>
      <td>
          <label class="obligatorio">*</label>
          <label for="cantidad">Cantidad</label>
      </td>
       
     <!--  
      <td>
         <label class="obligatorio">*</label>
         <label for="id_tipo_apoyo">Tipo De Apoyo</label>
      </td>
       -->
   </tr>
   <tr>
     <td>
       <input type="hidden" name="id_edicion" value="<?php echo $id_edicion; ?>" />
       <input type="hidden" id="id_trab_expediente" name="id_trab_expediente" value="<?php echo $id_trab_expediente;?>" />
       <input type="hidden" id="id_beneficiario" name="id_beneficiario" value="<?php echo $id_beneficiario;?>" />
       <input type='text' id = 'fecha_autorizacion' class="fecha" name = 'fecha_autorizacion'value="<?php echo $apoyo['fecha_autorizacion']; ?>" />
       <input type="button"  value="Hoy" id="btnToday_a"  />  
     </td>      
    <td>
       <input type = 'text' id = 'cantidad' name = 'cantidad' value="<?php echo $apoyo['cantidad']; ?>" />
    </td> 
   
    
   </tr>
   <tr>
     <td colspan='2'>
          <label class="obligatorio">*</label><label for="id_producto_servicio">Programas de Trabajo Social</label>
     </td>
   </tr>
   <tr>
      <td colspan="2">
            <select  id="id_producto_servicio" class="condicion" name="id_producto_servicio" >
            <option value=''>Seleccione Programa</option>
            <?php foreach($programa as $p): ?>
              <option value='<?php echo $p['id'] ?>' <?php echo ($p['id'] == $id_producto_servicio)? 'selected': '' ;?> > 
                  <?php echo $p['codigo_producto'].' - '.$p['nombre'];?>
              </option>
            <?php endforeach; ?>
          </select>
    </td>
     
   </tr>
   <tr>
     <td>
        <label class="obligatorio">*</label><label for="id_tipo_servicio">Tipo Servicio</label>
     </td>
   </tr>
   <tr id="tipo_servicio">
      <td colspan="3"> 
     <select id="id_tipo_servicio" class="combobox" name="id_tipo_servicio">
    <option value=''>Seleccione el tipo de servicio</option>

    <?php foreach($tipo_servicio as $l): 

        if($l['id'] == $padre){

            $selected = "selected";

        }else{

            $selected = "";
        }

    ?>                

    <option value='<?php echo $l['id'] ?>' <?php echo $selected;?> > <?php echo $l['nombre'];?></option>

    <?php endforeach; ?>
</select>
   </td>
   </tr>
   
   <tr>
     <td>
         <label class="obligatorio">*</label><label for="id_servicio_especifico">Servicio Especifico</label>
         <?php
               //echo $id_servicio_especifico ?>
     </td>
   </tr>
   <tr id="servicio_especifico">
     <td colspan="2">
      <select id="id_servicio_especifico" class="combobox" name="id_servicio_especifico">
    <option value=''>Seleccione el Servicio Especifico <?php echo $id_tipo_servicio; ?></option>

    <?php 
    // print_r ($servicio_especifico).'<br>';
    foreach($ser_espec as $l):
    
        if($l['id'] == $id_servicio_especifico){

            $selected = "selected";

        }else{

            $selected = "";
        } 

      
    ?>                

    <option value='<?php echo $l['id'] ?>' <?php echo $selected;?> > <?php echo $l['servicio'];?></option>

    <?php endforeach; ?>
</select>
     </td>
   </tr>
   <tr>
      <td>
        <label class="obligatorio">*</label>
        <label for="vale">Vale</label>
      </td>
      <td>
        <label class="obligatorio">*</label>
        <label for="proveedor">Proveedor</label>
      </td>
      <td>
        <label class="obligatorio">*</label>
        <label for="costo_total">Costo Total</label>
      </td>
     
      
      
   </tr>
   <tr>
     <td>
       <input type = 'text' id = 'vale' name = 'vale' class="nomnum" value="<?php echo $apoyo['vale']; ?>" />
     </td>
     <td>
       <input type = 'text' id = 'proveedor' name = 'proveedor' class="nomnum" value="<?php echo $apoyo['proveedor']; ?>" />
     </td>
     <td>
       <input type = 'text' id = 'costo_total' name = 'costo_total' class="valid" value="<?php echo $apoyo['costo_total']; ?>" />
     </td>
     
   </tr>
   <tr>
    <td>
        <label class="obligatorio">*</label>
        <label for="fecha_entrega">Fecha Entrega</label>
    </td>
    <td>
      <label class="obligatorio">*</label>
      <label for="fecha_verificacion">Fecha Verificaci&oacute;n</label> 
    </td>
    <td>
      <label class="obligatorio">*</label>
      <label for="contra_recibo">Contra Recibo</label> 
    </td>
    <td>
      <label class="obligatorio">*</label>
      <label for="numero_factura">N&uacute;mero Factura</label> 
    </td>
   </tr>
   <tr>
      <td>
         <input type='text' id = 'fecha_entrega' class="fecha" name = 'fecha_entrega'value="<?php echo $apoyo['fecha_entrega']; ?>" />
         <input type="button"  value="Hoy" id="btnToday_e"  />  
      </td>
      <td>
         <input type='text' id = 'fecha_verificacion' class="fecha" name = 'fecha_verificacion'value="<?php echo $apoyo['fecha_verificacion']; ?>" />
         <input type="button"  value="Hoy" id="btnToday_v"  />  
      </td>
      <td>
       <input type = 'text' id = 'contra_recibo' name = 'contra_recibo' class="nomnum" value="<?php echo $apoyo['contra_recibo']; ?>" />
     </td>
     <td>
       <input type = 'text' id = 'numero_factura' name = 'numero_factura' class="digits" value="<?php echo $apoyo['numero_factura']; ?>" />
     </td>
   </tr>
   <tr>
     <td>
        <label class="obligatorio">*</label>
        <label for="partida_presupuestal">Partida Presupuestal</label>
     </td>
     <td>
        <label class="obligatorio">*</label>
        <label for="numero_transferencia">N&uacute;mero de Transferencia</label>
     </td>
     <td>
        <label class="obligatorio">*</label>
        <label for="fecha_pago">Fecha Pago</label>
     </td>
   </tr>
   <tr>
     <td>
       <input type = 'text' id = 'partida_presupuestal' name = 'partida_presupuestal' class="nomnum" value="<?php echo $apoyo['partida_presupuestal']; ?>" /> 
     </td>
     <td>
       <input type = 'text' id = 'numero_transferencia' name = 'numero_transferencia' class="digits" value="<?php echo $apoyo['numero_transferencia']; ?>" /> 
     </td>
     <td>
         <input type='text' id = 'fecha_pago' class="fecha" name = 'fecha_pago'value="<?php echo $apoyo['fecha_pago']; ?>" />
         <input type="button"  value="Hoy" id="btnToday_p"  />  
      </td>
   </tr>
   <tr>
      <?php if($id_edicion > 0) { ?>

       
            <td>
                <label for="activo">Estatus</label>
            </td>
            <td>
                <select id="activo" name="activo" class="">
                    <option value="">Seleccione</option>
                    <?php foreach($estatus as $e){                         
                        if($e['valor'] == $apoyo['activo']){
                            $selected = "selected";
                        }else{
                            $selected = "";
                        }
                    ?>                
                    <option value='<?php echo $e['valor'] ?>' <?php echo $selected;?> > <?php echo $e['nombre'];?></option>
                    <?php } ?>
                </select>
            </td>
              
       <?php } ?>
        
        </tr>
        <tr>
          <td><input type = 'submit'  id = 'enviar' value = 'Enviar' /></td>
        </tr>   
  </table>    
   
</form>
