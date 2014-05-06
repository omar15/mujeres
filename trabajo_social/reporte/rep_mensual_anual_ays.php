<?php
session_start();//Habilitamos uso de variables de sesión
//Incluimos cabecera
include('../../inc/header.php'); 

//Incluimos modelos
include_once($_SESSION['model_path'].'apoyo_otorgado.php');

//Listado de servicios específicos
$datos = Apoyo_otorgado::TotalesMesAys();

?>

<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.min.js"></script>
<script lang="javascript" type="text/javascript" src="<?php echo $_SESSION['js_path'];?>jquery.tablesorter.pager.js"></script>
<script type="text/javascript">
	$(function() {
    $("table") 
    .tablesorter({widthFixed: true, widgets: ['zebra']}) 
    .tablesorterPager({container: $("#pager")}); 

	$( "#tabs" ).tabs();

	}); 
</script>
<style type="text/css">
	.tabla_reporte{
		overflow:auto;
	}
</style>

<div id="principal">
    <div id="contenido">
          <div class="centro">        

          <h2>Concentrado Mensual y Anual de Actividades, Apoyos y Servicios Otorgados.</h2>

          <div class="genera">
          	<form id='formReporte' method="post" target="_blank" action="imprimir_reporte.php">
	          <input type="hidden" name="nom_reporte" value="concentrado_mensual" />
	          <input type = 'submit'  id = 'enviar'value = 'Generar Reporte' />
            </form>
          </div>          

          <div id="pager" style="margin-top:20px;" class="pager">
			<form>
				<img src="<?php echo $_SESSION['img_path'];?>/icons/first.png" class="first"/>
				<img src="<?php echo $_SESSION['img_path'];?>/icons/prev.png" class="prev"/>
				<input type="text" class="pagedisplay"/>
				<img src="<?php echo $_SESSION['img_path'];?>/icons/next.png" class="next"/>
				<img src="<?php echo $_SESSION['img_path'];?>/icons/last.png" class="last"/>
				<select class="pagesize">
					<option selected="selected"  value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option  value="100">100</option>
				</select>
			</form>
		   </div>

<div class="tabla_reporte">
	<table class="tablesorter">
				<thead>
					<tr>
						<th rowspan="2">Apoyos Existenciales</th>
						<th colspan="2">Enero</th>
						<th colspan="2">Febrero</th>
						<th colspan="2">Marzo</th>
						<th colspan="2">Abril</th>
						<th colspan="2">Mayo</th>
						<th colspan="2">Junio</th>
						<th colspan="2">Julio</th>
						<th colspan="2">Agosto</th>
						<th colspan="2">Septiembre</th>
						<th colspan="2">Octubre</th>
						<th colspan="2">Noviembre</th>
						<th colspan="2">Diciembre</th>
					</tr>
					<tr>						
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($datos as $key => $d): ?>
					<tr>						
						<?php if($d['padre'] != 0){ ?>
							<td><?php echo $d['nombre_serv']; ?></td>
							<td><?php echo $d['cantidad_tot_ene']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_ene'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_feb']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_feb'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_mar']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_mar'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_abr']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_abr'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_may']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_may'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_jun']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_jun'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_jul']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_jul'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_ago']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_ago'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_sep']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_sep'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_oct']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_oct'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_nov']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_nov'], 2, ".", ",")?></td>
							<td><?php echo $d['cantidad_tot_dic']; ?></td>
							<td>$<?php echo number_format($d['monto_tot_dic'], 2, ".", ",")?></td>
						<?php }else{ ?>
						<th colspan="25"><?php echo $d['nombre_serv']; ?></th>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			  </table>
</div>
          	

<div class="tabla_reporte">
	<table class="tablesorter">
			  	<thead>
			  	<tr>
			  		<th rowspan="2">Apoyos Existenciales</th>
			  		<th colspan="2">Enero</th>
			  		<th colspan="2">Febrero</th>
			  		<th colspan="2">Marzo</th>
			  		<th colspan="2">Abril</th>
			  		<th colspan="2">Mayo</th>
			  		<th colspan="2">Junio</th>
			  		<th colspan="2">Julio</th>
			  		<th colspan="2">Agosto</th>
			  		<th colspan="2">Septiembre</th>
			  		<th colspan="2">Octubre</th>
			  		<th colspan="2">Noviembre</th>
			  		<th colspan="2">Diciembre</th>
				</tr>	
				<tr>					
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
						<th>Cantidad</th>
						<th>Monto</th>
					</tr>	
			  	</thead>
			  	<tbody>
			  		
			  	</tbody>
			  	
			  	<tr>
			  		<th>Totales</th>
			  		<?php 
			  		
			  		//Obtenemos los totales por servicio
					$totales_mes = Apoyo_otorgado::repTotalesPorMeses();

			  		foreach ($totales_mes as $key => $t): ?>
					<td><?php echo $t['total_cantidad']; ?></td>
					<td>$<?php echo number_format($t['total_monto'], 2, ".", ",")?></td>
			  		<?php endforeach; ?>
			  	</tr>
			  </table>
</div>
			  
          </div>
    </div>
</div>

<?php 
//Incluimos pie
include($_SESSION['inc_path']. 'footer.php'); 		
?>  