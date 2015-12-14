<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('seguimientoAdol/seguimientoAdol/registrarSeg'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<?php
	if(empty($paiAdol)){
		$seguimiento=array("Seguimiento del Adolescente"=>$this->renderPartial("_segForm", 
		array(
			'numDocAdol'=>$numDocAdol,	
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,
			'modeloInfJud'=>$modeloInfJud,
			'infJudicial'=>$infJudicial,
			'modeloSeguimiento'=>$modeloSeguimiento,
			'tipoSeguimiento'=>$tipoSeguimiento,
			'areaDisc'=>$areaDisc,
			'seguimientos'=>$seguimientos,
			'operaciones'=>$operaciones
		),true,false));
	}
	else{
		if($paiAdol["culminacion_pai"]==1){
			$seguimiento=array("Seguimiento Pos Egreso"=>$this->renderPartial("_segPosEgrForm", 
			array(
				'numDocAdol'=>$numDocAdol,	
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientosPosEgreso'=>$seguimientoPosEgreso			
			),true,false));			
		}
		else{			
			$seguimiento=array("Seguimiento del Adolescente"=>$this->renderPartial("_segForm", 
			array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientos'=>$seguimientos,
				'operaciones'=>$operaciones
			),true,false));			
		}		
	}


	$tabs=$seguimiento;                                                                                     
	//print_r($infJudicial);
/*	$psc=false;
	foreach($infJudicial as $infJudicial){
		if($infJudicial["id_tipo_sancion"]==3){
			$psc=true;
		}
	}
	if($psc==true){
		$tabs["Seguimiento Psc"]=$this->renderPartial("_consultaPSC", 
				array(
					'numDocAdol'=>$numDocAdol,	
					//'modeloInfJud'=>$modeloInfJud,
					//'infJudicial'=>$infJudicial,
					//'modeloSeguimiento'=>$modeloSeguimiento,
					'modeloPsc'=>$modeloPsc,
					//'pscSinCulm'=>$pscSinCulm,
					//'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
					//'modeloPsc'=>$modeloPsc,
					//'modeloAsistenciaPsc'=>$modeloAsistenciaPsc
					'pscDes'=>$pscDes,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset
				),true,false); 				
	}
*/	$this->widget('zii.widgets.jui.CJuiTabs', 
		array(
			'id'=>'article_tab',
			'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
			'tabs'=>$tabs, 
			'options'=>array('collapsible'=>false)
		)
	);        
?>
<?php endif?>   
        
        