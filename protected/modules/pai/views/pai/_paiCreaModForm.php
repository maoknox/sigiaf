
<?php if($modeloPAI->culminacion_pai==1):?>
<fieldset>
	Este PAI ya se culminó.  Si desea consultarlo genere el reporte de PAI.
</fieldset>
<?php else:?>
<fieldset>
<div class="panel-heading color-sdis">Concepto Integral</div> 
<?php 
	echo CHtml::encode($conceptoInt["concepto_integral"]);
?>
</fieldset>
<hr />
<fieldset>
<div class="panel-heading color-sdis">PAI-Componente Derecho</div> 
<div id="Mensaje" style="font-size:14px;" ></div>
    <div class="form-group">
    	<div class="col-sm-2">
        	Componente/Derecho
		</div>
    	<div class="col-sm-2">
        	Objetivo
		</div>
    	<div class="col-sm-2">
        	Actividades
		</div>
    	<div class="col-sm-2">
        	Indicador
		</div>
    	<div class="col-sm-2">
        	Responsable
		</div>
    	<div class="col-sm-2">
        	Botón
		</div>
</div>
<hr />
<?php 
	foreach($derechos as $pk=>$derecho):
		$idPai=$modeloCompDer->id_pai;
		$modeloCompDer->unsetAttributes();
		$modeloCompDer->id_pai=$idPai;
		$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
		$modeloCompDer->num_doc=$modeloPAI->num_doc;
		$derechoAdolPai="";
		$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
		$modeloCompDer->attributes=$derechoAdolPai;
		$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
		//print_r($modeloCompDer->attributes);
		if(!empty($derechoAdolPai)){
			$action="modifDerPai";	
			$funcion='js:modificaRegPai("'.$derecho["id_derechocespa"].'","modificaRegPai","formularioCompDer_")';			
		}
		else{
			$action="creaDerPai";	
			$funcion='js:creaRegPai("'.$derecho["id_derechocespa"].'","creaDerPai","formularioCompDer_")';
		}
		?>
       
        <?php $formPaiCompDer=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompDer_'.$derecho["id_derechocespa"],
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
		?>  
            <div class="form-group">
                <div class="col-sm-2">
                    <?php echo $derecho["derechocespa"];?>
                    <?php echo $formPaiCompDer->textArea($modeloCompDer,'derecho_compderecho',array('class'=>'form-control'));?>
                    <?php echo $formPaiCompDer->error($modeloCompDer,'derecho_compderecho',array('style' => 'color:#F00'));?>
       			</div>
                <div class="col-sm-2">
					<?php echo $formPaiCompDer->textArea($modeloCompDer,'objetivo_compderecho',array('class'=>'form-control'));?>
                    <?php echo $formPaiCompDer->error($modeloCompDer,'objetivo_compderecho',array('style' => 'color:#F00'));?>
       			</div>
                <div class="col-sm-2">
					<?php echo $formPaiCompDer->textArea($modeloCompDer,'actividades_compderecho',array('class'=>'form-control'));?>
                    <?php echo $formPaiCompDer->error($modeloCompDer,'actividades_compderecho',array('style' => 'color:#F00'));?>
       			</div>
                <div class="col-sm-2">
					<?php echo $formPaiCompDer->textArea($modeloCompDer,'indicadores_compderecho',array('class'=>'form-control'));?>
                    <?php echo $formPaiCompDer->error($modeloCompDer,'indicadores_compderecho',array('style' => 'color:#F00'));?>
       			</div>
                <div class="col-sm-2">
					<?php echo $formPaiCompDer->textArea($modeloCompDer,'responsable_compderecho',array('class'=>'form-control'));?>
                    <?php echo $formPaiCompDer->error($modeloCompDer,'responsable_compderecho',array('style' => 'color:#F00'));?>
       			</div>
                <div class="col-sm-1">
					<?php 			
                    echo $formPaiCompDer->hiddenField($modeloCompDer,'id_pai');
                    echo $formPaiCompDer->hiddenField($modeloCompDer,'id_derechocespa');
                    $modeloCompDer->num_doc=$numDocAdol;
                    echo $formPaiCompDer->hiddenField($modeloCompDer,'num_doc');
                    echo $formPaiCompDer->hiddenField($modeloCompDer,'fecha_estab_compderecho');
                    echo CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnPaiDer_'.$derecho["id_derechocespa"],'class'=>'btn btn-default btn-sdis','name'=>'btnPaiDer_'.$derecho["id_derechocespa"],'onclick'=>$funcion)
                    );
                    ?>
                    <?php echo $boton; //CHtml::submitButton('Crear');?>
       			</div>
            </div>
            <hr />
        	<?php $this->endWidget(); ?>
        <?php endforeach; ?>
 
</fieldset>
<div id="Mensaje" style="font-size:14px;" ></div>
<fieldset>
<div class="panel-heading color-sdis">PAI-Componente Sanción</div> 
<?php if(empty($infJudicial)):?>
	<p>Aún no se ha registrado la información judicial del adolescente</p>
<?php else:?>
<div class="form-group">
    <div class="col-sm-2">
        Componente/Sanción
    </div>
    <div class="col-sm-2">
        Objetivo
    </div>
    <div class="col-sm-2">
        Actividades
    </div>
    <div class="col-sm-2">
        Indicador
    </div>
    <div class="col-sm-2">
        Responsable
    </div>
    <div class="col-sm-2">
        Botón
    </div>
</div>
<hr />
	
	<?php 
	$modeloCompSanc->num_doc=$numDocAdol;
	foreach($infJudicial as $infJudicialPai):
		$infJudActual=array();					 
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		//echo $modeloComponenteSancion->num_doc."||".$modeloComponenteSancion->id_inf_judicial."-";
		$infJudActual=$modeloCompSanc->consultaInfJudComponenteSanc();
		if($infJudActual["pai_actual"]=="true" or empty($infJudActual)){

			$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
			$modeloCompSanc->num_doc=$numDocAdol;
			$modeloCompSanc->creaCompSancion();
			
			$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
			$modeloCompSanc->attributes=$consCompSancPai;
			
			
			$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
			//print_r($consCompSancPai);
			if(!empty($consCompSancPai)){
				$action="modifSancPai";			
				$funcion='js:modificaRegPaiSanc("'.$modeloCompSanc->id_inf_judicial.'","modificaRegPaiSanc","formularioCompSancPai_")';			
					
			}
			else{
				$action="creaSancPai";	
				$funcion='js:creaRegPaiSanc("'.$modeloCompSanc->id_inf_judicial.'","creaRegPaiSanc","formularioCompSancPai_")';			
			}
		?>
		<?php $formPaiCompSanc=$this->beginWidget('CActiveForm', array(
				'id'=>'formularioCompSancPai_'.$modeloCompSanc->id_inf_judicial,
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>false,
				),
				'htmlOptions' => array('class' => 'form-horizontal')
			));
			?>
			<div class="form-group">
				<div class="col-sm-2">
					<?php
                    $modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
                    $delitos=$modeloInfJud->consultaDelito();  
					$consSancion=$modeloInfJud->consultaSancion(); 	
                   // foreach($delitos as $delito):?>
               		<?php
						
						echo $consSancion["tipo_sancion"];
						//echo $delito["del_remcespa"];
					?>
                       
                    
                <?php //endforeach;?>
				</div>
				<div class="col-sm-2">
					<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'objetivo_compsanc',array('class'=>'form-control'));?>
					<?php echo $formPaiCompSanc->error($modeloCompSanc,'objetivo_compsanc',array('style' => 'color:#F00'));?>
				</div>
				<div class="col-sm-2">
					<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'actividades_compsanc',array('class'=>'form-control'));?>
					<?php echo $formPaiCompSanc->error($modeloCompSanc,'actividades_compsanc',array('style' => 'color:#F00'));?>
				</div>
				<div class="col-sm-2">
					<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'indicador_compsanc',array('class'=>'form-control'));?>
					<?php echo $formPaiCompSanc->error($modeloCompSanc,'indicador_compsanc',array('style' => 'color:#F00'));?>
				</div>
				<div class="col-sm-2">
					<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'responsable_compsancion',array('class'=>'form-control'));?>
					<?php echo $formPaiCompSanc->error($modeloCompSanc,'responsable_compsancion',array('style' => 'color:#F00'));?>
				</div>
				<div class="col-sm-2">
					<?php 			
						echo $formPaiCompSanc->hiddenField($modeloCompSanc,'id_pai');
						echo $formPaiCompSanc->hiddenField($modeloCompSanc,'id_inf_judicial');
						echo $formPaiCompDer->hiddenField($modeloCompSanc,'num_doc');
						echo $formPaiCompDer->hiddenField($modeloCompSanc,'fecha_establec_compsanc');
						echo CHtml::Button (
							'Registrar',   
							array('id'=>'btnPaiSanc_'.$modeloInfJud->id_inf_judicial,'class'=>'btn btn-default btn-sdis','name'=>'btnPaiSanc_'.$modeloInfJud->id_inf_judicial,'onclick'=>$funcion)
						);
					?>
				</div>
			</div>
		   <hr /><?php $this->endWidget(); 
		}
	?>	
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
				url: "creaDerPai",
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