<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ejemplo">
    <thead>
        <tr>
            <th>Nombre Sede</th>
            <th>Dirección</th>
            <th>Teléfono(s)</th>
        </tr>
    </thead>
 	<tbody>
<?
//echo "<pre>";
//print_r($sedes);

foreach($sedes as $sede):
?>
    <tr class="odd gradeX">
        <td><?php echo $sede["nombre_sede"];?></td>
        <td><?php echo $sede["direccion_forjar"];?></td>
        <td>
	<?php
		$modeloCForjar->id_forjar=$sede["id_forjar"];
		$teleSede=$modeloCForjar->consultaTelefonoSede();
		foreach($teleSede as $pk=>$telefono):	
			$pk+=1;
	?>	
        <?php echo $pk.". ".$telefono["num_tel_forjar"]."<br>";?>
	<?php endforeach;?>
     </td>
     </tr>
<?php
endforeach;
?>
    </tbody>
</table>
<?php Yii::app()->getClientScript()->registerScript('tabla_script','
$(document).ready(function() {
 $("#ejemplo").dataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar: ",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});
'
,CClientScript::POS_END);
?>

