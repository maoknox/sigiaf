<fieldset>
<div class="panel-heading color-sdis">Seguimiento PAI-Componente Derecho</div> 
<div id="Mensaje" style="font-size:14px;" ></div>
<table cellpadding="0" cellspacing="0" style=" border-collapse:collapse; width:100%" >
<td style=" border:1px solid #003; width:20%;">COMPONENTE / SITUACIÓN</td>
<td style=" border:1px solid #003; width:20%;">HISTÓRICO SEGUIMIENTO</td>
</table>
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
            <?php 			
				$modeloSegComDer->id_pai=$modeloCompDer->id_pai;
				$modeloSegComDer->id_derechocespa=$modeloCompDer->id_derechocespa;
				$modeloSegComDer->fecha_estab_compderecho=$modeloCompDer->fecha_estab_compderecho;
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'id_pai');
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'id_derechocespa');
				$modeloCompDer->num_doc=$numDocAdol;
				echo $formPaiSegDer->hiddenField($modeloCompDer,'num_doc');
				echo $formPaiSegDer->hiddenField($modeloSegComDer,'fecha_estab_compderecho');
			?>
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
								$('#juiDialogConsSeg').text(".CJavaScript::encode(CJavaScript::quote($segCompder["seguim_compderecho"])).");
							   	$('#juiDialogConsSeg').dialog('open');
							"							
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
<td style=" border:1px solid #003; width:20%;">HISTÓRICO SEGUIMIENTO</td>
</table>
	<?php foreach($infJudicialPai as $infJudicialPai)://revisar
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$modeloCompSanc->num_doc=$numDocAdol;
		$modeloCompSanc->id_pai=$idPai;
		$consCompSancPai=$modeloCompSanc->consultaPaiSanc();	
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
            <?php 		
				$modeloSegComSanc->id_pai=$modeloCompSanc->id_pai;
				$modeloSegComSanc->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
				$modeloSegComSanc->fecha_establec_compsanc=$modeloCompSanc->fecha_establec_compsanc;
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'id_pai');
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'id_inf_judicial');
				$modeloCompSanc->num_doc=$numDocAdol;
				echo $formSegPaiCompSanc->hiddenField($modeloCompSanc,'num_doc');
				echo $formSegPaiCompSanc->hiddenField($modeloSegComSanc,'fecha_establec_compsanc');
			?>
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
								$('#juiDialogConsSeg').text(".CJavaScript::encode(CJavaScript::quote($segCompSanc["seguim_compsancion"])).");
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
</fieldset>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	'id'=>'juiDialogConsSeg',
	'options'=>array(
		'title'=>'Show data',
		'autoOpen'=>false,
		'modal'=>'true',
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
',CClientScript::POS_END);

