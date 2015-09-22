<?php if($modeloPAI->culminacion_pai==1):?>
   <hr />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                AVISO
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <img src="/login_sdis/public/img/logo.svg" />
                </div>
                <div class="col-lg-9 text-justify">
					Este PAI ya se culminó.  Si desea consultarlo genere el reporte de PAI.
                </div>
            </div>
        </div>
    </div>
<hr />
<?php else:?>
<fieldset>
<legend>Concepto Integral</legend>
<?php 
	echo $conceptoInt["concepto_integral"];
?>
</fieldset>
<fieldset>
<legend>PAI-Componente Derecho</legend>
<div id="Mensaje" style="font-size:14px;" ></div>
<table style="width:100%">
	<tr>
    	<td>Componente/Situación</td>
        <td>Objetivo</td>
        <td>Actividades</td>
        <td>Indicador</td>
        <td>Responsable</td>
        <td>Botón</td>
    </tr></table>  
<?php 
	foreach($derechos as $pk=>$derecho):
		$idPai=$modeloCompDer->id_pai;
		$modeloCompDer->unsetAttributes();
		$modeloCompDer->id_pai=$idPai;
		$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
		$derechoAdolPai="";
		$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
		$modeloCompDer->attributes=$derechoAdolPai;
		$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
		//print_r($modeloCompDer->attributes);
		$action="creaDerPai";	
		$funcion='js:creaRegPai("'.$derecho["id_derechocespa"].'","creaDerPai","formularioCompDer_")';
		?>
       
        <?php $formPaiCompDer=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompDer_'.$derecho["id_derechocespa"],
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
		));
		?><table>
        <tr>
       	<td><?php echo $derecho["derechocespa"];?><br /> <hr />
            <?php echo $formPaiCompDer->textArea($modeloCompDer,'derecho_compderecho');?>
        	<?php echo $formPaiCompDer->error($modeloCompDer,'derecho_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'objetivo_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'objetivo_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'actividades_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'actividades_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'indicadores_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'indicadores_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'responsable_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'responsable_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php 			
			echo $formPaiCompDer->hiddenField($modeloCompDer,'id_pai');
			echo $formPaiCompDer->hiddenField($modeloCompDer,'id_derechocespa');
			$modeloCompDer->num_doc=$numDocAdol;
			echo $formPaiCompDer->hiddenField($modeloCompDer,'num_doc');
			echo $formPaiCompDer->hiddenField($modeloCompDer,'fecha_estab_compderecho');
			echo CHtml::Button (
				'Registrar',   
				array('id'=>'btnPaiDer_'.$derecho["id_derechocespa"],'name'=>'btnPaiDer_'.$derecho["id_derechocespa"],'onclick'=>$funcion)
			);
			
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
			
		</td>
       
        </tr>
        </table><?php $this->endWidget(); ?>
        <?php endforeach; ?>
 
</fieldset>
<div id="Mensaje" style="font-size:14px;" ></div>
<fieldset>
<legend>PAI-Componente Sanción</legend>
<?php if(empty($infJudicial)):?>
	<p>Aún no se ha registrado la información judicial del adolescente</p>
<?php else:?>
<table style="width:100%">
	<tr>
    	<td>Componente/Situación</td>
        <td>Objetivo</td>
        <td>Actividades</td>
        <td>Indicador</td>
        <td>Responsable</td>
        <td>Botón</td>
    </tr></table>  

	<?php foreach($infJudicial as $infJudicialPai):
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$modeloCompSanc->num_doc=$numDocAdol;
		
		$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
		$modeloCompSanc->attributes=$consCompSancPai;
		
		
		$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
		//print_r($consCompSancPai);
			$action="creaSancPai";	
			$funcion='js:creaRegPaiSanc("'.$modeloCompSanc->id_inf_judicial.'","creaRegPaiSanc","formularioCompSancPai_")';			
	?>
    <?php $formPaiCompSanc=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompSancPai_'.$modeloCompSanc->id_inf_judicial,
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
		));
		?><table>
        <tr>
       	<td><?php
			$modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
			$delitos=$modeloInfJud->consultaDelito();  
			foreach($delitos as $delito){
				echo $delito["del_remcespa"]."<br/>";
			}
		?>
		</td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'objetivo_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'objetivo_compsanc',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'actividades_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'actividades_compsanc',array('style' => 'color:#F00'));?></td>
        <td>
			<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'indicador_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'indicador_compsanc',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'responsable_compsancion');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'responsable_compsancion',array('style' => 'color:#F00'));?></td>
        <td><?php 			
			echo $formPaiCompSanc->hiddenField($modeloCompSanc,'id_pai');
			echo $formPaiCompSanc->hiddenField($modeloCompSanc,'id_inf_judicial');
			echo $formPaiCompDer->hiddenField($modeloCompSanc,'num_doc');
			echo $formPaiCompDer->hiddenField($modeloCompSanc,'fecha_establec_compsanc');
			echo CHtml::Button (
				'Registrar',   
				array('id'=>'btnPaiSanc_'.$modeloInfJud->id_inf_judicial,'name'=>'btnPaiSanc_'.$modeloInfJud->id_inf_judicial,'onclick'=>$funcion)
			);
?>
			
		</td>
       
        </tr>
        </table><?php $this->endWidget(); ?>	
	<?php endforeach;?>
<?php endif;?>
</fieldset>

<?php
Yii::app()->getClientScript()->registerScript('scripPai_1','
	
		/*$(window).bind("beforeunload", function(){
			//return "Va a dejar la página"
		});*/
		function creaRegPai(idComponente,accion,nombreForm){
			$.ajax({
				url: "creaActDerPai",
				data:$("#"+nombreForm+idComponente).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
							$("#btnPaiDer_"+idComponente).removeAttr("onclick");
							$("#"+nombreForm+idComponente+" #ComponenteDerecho_fecha_estab_compderecho").val(datos.fechaRegPai);
							$("#btnPaiDer_"+idComponente).click(function (){
								modificaRegPai(idComponente,accion,nombreForm,datos.fechaRegPai);	
							});
						}
						else{
							$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#Mensaje").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
		function modificaRegPai(idComponente,accion,nombreForm){
			$.ajax({
				url: "modificaRegPai",
				data:$("#"+nombreForm+idComponente).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
						}
						else{
							$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#Mensaje").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
		function creaRegPaiSanc(idComponente,accion,nombreForm){
			$.ajax({
				url: "creaRegPaiSanc",
				data:$("#"+nombreForm+idComponente).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#MensajeSan").text("exito");
							$("#btnPaiSanc_"+idComponente).removeAttr("onclick");
							$("#"+nombreForm+idComponente+" #ComponenteSancion_fecha_establec_compsanc").val(datos.fechaRegPai);
							$("#btnPaiSanc_"+idComponente).click(function (){
								modificaRegPaiSanc(idComponente,accion,nombreForm,datos.fechaRegPai);	
							});
						}
						else{
							$("#MensajeSan").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#MensajeSan").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#MensajeSan").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#MensajeSan").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
		function modificaRegPaiSanc(idComponente,accion,nombreForm){
			$.ajax({
				url: "modificaRegPaiSanc",
				data:$("#"+nombreForm+idComponente).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
						}
						else{
							$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#Mensaje").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
'
,CClientScript::POS_END);
?>
<?php endif;?>