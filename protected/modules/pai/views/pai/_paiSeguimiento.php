<fieldset>
<div class="panel-heading color-sdis">Seguimiento PAI-Componente Derecho</div> 
<div id="Mensaje" style="font-size:14px;" ></div>
<table cellpadding="0" cellspacing="0" style=" border-collapse:collapse; width:100%" >
<td style=" border:1px solid #003; width:20%;">COMPONENTE / SITUACIÓN</td>
<td style=" border:1px solid #003; width:60%;">SEGUIMIENTO</td>
<td style=" border:1px solid #003; width:20%;">HISTÓRICO SEGUIMIENTO</td>
</table>
<?php 
	foreach($derechos as $pk=>$derecho):
	//echo $modeloCompDer->id_pai;
		$idPai=$modeloCompDer->id_pai;
		$modeloCompDer->unsetAttributes();
		$modeloCompDer->id_pai=$idPai;
		$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
		$modeloCompDer->num_doc=$numDocAdol;		
		$derechoAdolPai="";
		//echo $modeloCompDer->id_derechocespa;
		$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
		//print_r($derechoAdolPai);
		$modeloCompDer->attributes=$derechoAdolPai;
		$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
			//$modeloCompSanc,
		//print_r($modeloCompDer->attributes);
		if(!empty($derechoAdolPai)):?>
		<?php $formPaiSegDer=$this->beginWidget('CActiveForm', array(
			'id'=>'formPaiSegDer_'.$derecho["id_derechocespa"],
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));?>
		<table  cellpadding="0" cellspacing="0" style=" border-collapse:collapse; width:100%">
        <tr>
            <td style=" border:1px solid #003; width:20%;">
                <?php echo $derecho["derechocespa"];?><br /> <hr />
                <?php echo $modeloCompDer->derecho_compderecho;?>
            </td>
            <td style=" border:1px solid #003; width:60%;">
            <?php 			
				$modeloSegComDer->id_pai=$modeloCompDer->id_pai;
				$modeloSegComDer->id_derechocespa=$modeloCompDer->id_derechocespa;
				$modeloSegComDer->num_doc=$numDocAdol;
				$modeloSegComDer->fecha_estab_compderecho=$modeloCompDer->fecha_estab_compderecho;
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'id_pai');
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'id_derechocespa');
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'num_doc');
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'fecha_estab_compderecho');
			?>
            <?php if($modeloPAI->culminacion_pai!=1):?>
				<?php echo $formPaiSegDer->textArea($modeloSegComDer,'seguim_compderecho',array('class'=>'form-control'));?>
                <?php echo $formPaiSegDer->error($modeloSegComDer,'seguim_compderecho',array('style' => 'color:#F00'));?>
                
                <?php 
					echo CHtml::Button (
					'Registrar',   
					array('id'=>'btnSegPaiDer_'.$derecho["id_derechocespa"],'class'=>'btn btn-default btn-sdis','name'=>'btnSegPaiDer_'.$derecho["id_derechocespa"],'onclick'=>'js:regSegDer("'.$derecho["id_derechocespa"].'")'))
				?>
			<?php endif;?>       
            </td>
            <td style=" border:1px solid #003; width:20%;">
            	<div style="overflow-y:scroll; height:60px">
                
               
                	<?php $consSegCompDer=$modeloSegComDer->consultaSeguimientos();?>
					<?php foreach($consSegCompDer as $pk=>$segCompder): $item=$pk+1;echo $item."-";?>
                    <?php echo CHtml::link(
  						 $segCompder["fecha_seguim_compderecho"],
					  	'javascript:retorna();',
					  	array( // ajaxOptions
							'type' => 'POST',
							'onclick' => "js:								
								$('#ui-id-1').text('".CHtml::encode("Fecha de seguimiento: ".$segCompder["fecha_seguim_compderecho"])."');
								$('#juiDialogConsSeg').text(".CJavaScript::encode($segCompder["seguim_compderecho"]).");
							   	$('#juiDialogConsSeg').dialog('open');"							
					  	)
					);?> 
                    <br />
						
					<?php endforeach;?>
                </div>
            </td>
        </tr></table>
        <?php $this->endWidget();?>
		<?php endif;?>
       <?php endforeach;?>
    
        
</fieldset>
<hr />
<fieldset>
<div class="panel-heading color-sdis">Seguimiento PAI-Componente Sanción</div> 
<table cellpadding="0" cellspacing="0" style=" border-collapse:collapse; width:100%" >
<td style=" border:1px solid #003; width:20%;">COMPONENTE / SITUACIÓN</td>
<td style=" border:1px solid #003; width:60%;">SEGUIMIENTO</td>
<td style=" border:1px solid #003; width:20%;">HISTÓRICO SEGUIMIENTO</td>
</table>
<?php if(!empty($infJudicial)):?>

	<?php 
	foreach($infJudicial as $infJudicialPai)://revisar
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
		$modeloCompSanc->attributes=$consCompSancPai;
		$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
		//print_r($modeloCompSanc->attributes);
		if(!empty($consCompSancPai)): ?>
 	<?php $formSegPaiCompSanc=$this->beginWidget('CActiveForm', array(
			'id'=>'formSegPaiCompSanc_'.$modeloCompSanc->id_inf_judicial,
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
		));
		?>        
			<table cellpadding="0" cellspacing="0" style=" border-collapse:collapse; width:100%" >
            <td style=" border:1px solid #003; width:20%;">
            <?php
				$modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
				$delitos=$modeloInfJud->consultaDelito();  
				foreach($delitos as $delito){
					echo $delito["del_remcespa"]."<br/>";
				}
			?>
            </td>
            <td style=" border:1px solid #003; width:60%;">
            <?php 		
				$modeloSegComSanc->id_pai=$modeloCompSanc->id_pai;
				$modeloSegComSanc->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
				$modeloSegComSanc->fecha_establec_compsanc=$modeloCompSanc->fecha_establec_compsanc;
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'id_pai');
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'id_inf_judicial');
				$modeloSegComSanc->num_doc=$numDocAdol;
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'num_doc');
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'fecha_establec_compsanc');
			?>
            <?php if($modeloPAI->culminacion_pai!=1):?>            
				<?php echo $formSegPaiCompSanc->textArea($modeloSegComSanc,'seguim_compsancion',array('class'=>'form-control'));?>
                <?php echo $formSegPaiCompSanc->error($modeloSegComSanc,'seguim_compsancion',array('style' => 'color:#F00'));?>
                 <?php 
					echo CHtml::Button (
					'Registrar',   
					array('id'=>'btnSegPaiSeg_'.$modeloInfJud->id_inf_judicial,'class'=>'btn btn-default btn-sdis','name'=>'btnSegPaiSeg_'.$modeloInfJud->id_inf_judicial,'onclick'=>'js:regSegSanc("'.$modeloInfJud->id_inf_judicial.'")'))
				?>
            <?php endif;?>								
            </td>
            <td style=" border:1px solid #003; width:20%;">
              	<div style="overflow-y:scroll; height:60px">            
                	<?php 
						
						$consSegCompSanc=$modeloSegComSanc->consultaSeguimientos();?>
					<?php foreach($consSegCompSanc as $pk=>$segCompSanc): $item=$pk+1;echo $item."-";?>
                    <?php echo CHtml::link(
  						 $segCompSanc["fecha_seguim_compsancion"],
					  	'javascript:retorna();',
					  	array( // ajaxOptions
							'type' => 'POST',
							'onclick' => "js:								
								$('#ui-id-1').text('".CHtml::encode("Fecha de seguimiento: ".$segCompSanc["fecha_seguim_compsancion"])."');
								$('#juiDialogConsSeg').text(".CJavaScript::encode($segCompSanc["seguim_compsancion"]).");
							   	$('#juiDialogConsSeg').dialog('open');
							"							
					  	)
					);?> 
                    <br />
						
					<?php endforeach;?>
                </div>
            </td>
            </table>
			<?php $this->endWidget();?>
		<?php endif;
		endforeach;
?>
<?php else:?>
 <div class="panel panel-default">
 	<div class="panel-heading">
		<div class="panel-title">
			AVISO
        </div>
    </div>
  	<div class="panel-body">
		<div class="row">
        	 <div class="col-lg-3 text-center">
             	<img src="<?php echo Yii::app()->baseUrl?>/images/centroForjar.png" />
             </div>
             <div class="col-lg-9 text-justify">
               No se ha registrado la información judicial del adolescente.             
             </div>
        </div> 
 	</div>
 </div>        


<?php endif;?>

</fieldset>
                   <?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'juiDialogConsSeg',
                'options'=>array(
                    'title'=>'Show data',
                    'autoOpen'=>false,
                    'modal'=>'false',
                    'width'=>'60%',
                    'height'=>'400',
                ),
                ));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
Yii::app()->getClientScript()->registerScript('scripPai_2','
	
		/*$(window).bind("beforeunload", function(){
			//return "Va a dejar la página"
		});*/
		function retorna(){
			return;	
		}
		function regSegDer (idComponente){
			//jAlert($("#formPaiSegDer_"+idComponente).serialize(),"Mensaje"); return;
			$.ajax({
				url: "regSegPaiDer",
				data:$("#formPaiSegDer_"+idComponente).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
							$("#btnSegPaiDer_"+idComponente).removeAttr("onclick");
							$("#btnSegPaiDer_"+idComponente).hide();
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
		function regSegSanc (idSancion){
			$.ajax({
				url: "regSegPaiSanc",
				data:$("#formSegPaiCompSanc_"+idSancion).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
							$("#btnSegPaiSeg_"+idSancion).removeAttr("onclick");
							$("#btnSegPaiSeg_"+idSancion).hide();
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