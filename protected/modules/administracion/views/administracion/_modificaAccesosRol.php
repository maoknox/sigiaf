<div id="Mensaje" style="font-size:14px;" ></div>
<?php
/*	$menPr['MenPr']=array();
	$menPr['MenPr']['MenSec']=array();
	array_push($menPr['MenPr'],$menPr['MenPr']['MenSec']);
	array_push($menPr['MenPr'],'SMpr2');
	array_push($menPr['MenPr'],'SMpr3');
*/	
	//print_r($menu);
		$menPr=array();
		$modeloMenu->nivel_menu=$i;
		$menAux=$modeloMenu->consultaMenuPorNivel();
		//$modeloMenu->recursividad(0);
	//print_r($menPr);
?>
<?php $formCreaRol=$this->beginWidget('CActiveForm', array(
	//'action'=>'creaRol',
	'id'=>'formularioCreaRol',
	//'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<fieldset>
<?php
$serialMenu=serialize($menuRol);
?>
<!-- Form Name -->
<legend>Datos de la Sede</legend>
	<?php echo  $formCreaRol->errorSummary(array($modeloRol,$modeloRolMenu),'','',array('style' => 'font-size:14px;color:#F00')); ?>

<!-- Text input-->
    <div class="form-group">
	   	<?php echo CHtml::label('Nombre rol','Nombre rol',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-8">
			<?php  
				$modeloRol->descripcion_rol="aux";
				//print_r($dataInput);
				echo CHtml::label($modeloRol->nombre_rol,$modeloRol->nombre_rol,array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
           		<?php echo $formCreaRol->hiddenField($modeloRol,'nombre_rol');?>
           		<?php echo $formCreaRol->hiddenField($modeloRol,'descripcion_rol');?>
           		<?php echo $formCreaRol->hiddenField($modeloRol,'id_rol');?>
    	</div>
    </div>
    <div class="form-group">
	   	<?php echo $formCreaRol->labelEx($modeloRolMenu,'id_menu',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
		<?php echo $formCreaRol->error($modeloRolMenu,'id_menu',array('style' => 'color:#F00'));?>  

		<?php
			foreach($menAux as $menAuxAux){
				//echo $menAuxAux['id_menu']." Padre<br/>";
				$menPr[$menAuxAux['titulo_menu']]="";?><strong><?php echo $menAuxAux['titulo_menu'];?></strong><br/><?php
				$modeloMenu->id_menu=$menAuxAux['id_menu'];
				$menuHijo=$modeloMenu->consultaMenuPorIdPadre();
				if(!empty($menuHijo)){
					foreach($menuHijo as $menuHijoAux){
						$menPr[$menAuxAux['titulo_menu']][$menuHijoAux['titulo_menu']]="";
						$modeloMenu->id_menu=$menuHijoAux['id_menu'];
						$menuHijoHijo=$modeloMenu->consultaMenuPorIdPadre();
						if(!empty($menuHijoHijo)){
							echo "-<strong>".$menuHijoAux['titulo_menu']."</strong><br>";
							foreach($menuHijoHijo as $menuHijoHijoAux){
								$menPr[$menAuxAux['titulo_menu']][$menuHijoAux['titulo_menu']][$menuHijoHijoAux['titulo_menu']]="";
								$checked="";								
								if(strpos($serialMenu,$menuHijoHijoAux['id_menu'])){
									$checked="checked";
								}
								?>--<?php echo $menuHijoHijoAux['titulo_menu'];?><input type="checkbox" <?php echo $checked; ?> id="<?php echo $menAuxAux['id_menu'].$menuHijoAux['id_menu'].$menuHijoHijoAux['id_menu']?>" name="Menu[<?php echo $menAuxAux['id_menu'];?>][<?php echo $menuHijoAux['id_menu']?>][<?php echo $menuHijoHijoAux['id_menu']?>]" /><br /><?php
							}
						}
						else{
							$checked="";
							if(strpos($serialMenu,$menuHijoAux['id_menu'])){
								$checked="checked";
							}
							?>-<?php echo $menuHijoAux['titulo_menu'];?><input type="checkbox" <?php echo $checked; ?> id="<?php echo $menAuxAux['id_menu'].$menuHijoAux['id_menu']?>" name="Menu[<?php echo $menAuxAux['id_menu'];?>][<?php echo $menuHijoAux['id_menu']?>]" /><br /><?php
						}
					}
				}
			//echo "<hr/>";
				//$menHijo=$modeloMenu->consultaMenuPorIdPadre();
			}
			?>
            <?php echo $formCreaRol->hiddenField($modeloRolMenu,'id_menu',array('class'=>'form-control input-md'));?>
    	</div> 
    </div>
	<div class="form-group">
    <?php echo CHtml::label('','');?>
    <div class="col-md-4"> 
    	<?php
		        $boton=CHtml::ajaxSubmitButton (
					'Modificar accesos a Rol',   
					array('administracion/modificaAccesosRol'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){$("#btnFormCreaRol").hide();Loading.show();}',
						'success' => 'function(datosRef) {	
							Loading.hide();
							if(datosRef.estadoComu=="exito"){
								if(datosRef.resultado=="exito"){
									$("#formularioCreaRol #RolMenu_id_menu_em_").html("");
									//$("#MensajeRef").text("Rol creado satisfactoriamente");
									jAlert("Accesos modificados satisfactoriamente", "Mensaje");
									$("#formularioCreaRol #formularioCreaRol_es_").html("");      
								}
								else{
									jAlert("Ha habido un error en la modificación de accesos. Código del error: "+datosRef.resultado, "Mensaje");
								   // $("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
									//$("#formularioRef #formularioRef_es_").html("");                                                    
									//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
								}
							}
							else{						
								$("#btnFormCreaRol").show();
								var errores="Por favor corrija los siguientes errores<br/><ul>";
								$.each(datosRef, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formularioCreaRol #"+key+"_em_").text(val);                                                    
									$("#formularioCreaRol #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
								$("#formularioCreaRol #formularioCreaRol_es_").html(errores);                                                    
								$("#formularioCreaRol #formularioCreaRol_es_").show(); 
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							var StrippedString = xhr.responseText.replace(/(<([^>]+)>)/ig,"");
							Loading.hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");
								//$("#MensajeRef").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
								$("#btnFormRef").show();
							}
							else{
								if(xhr.status==500){	
									//var alertaError=alert(document.cookie);
									//var alertaStripped=alertaError.replace(/(<([^>]+)>)/ig,"");										
									jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información <br/>"+StrippedString, "Mensaje");
									//$("#MensajeRef").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
								}
								else{
									jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
								}	
							}
						}'
					),
					array('id'=>'btnFormCreaRol','class'=>'btn btn-default btn-sdis','name'=>'btnFormCreaRol')
			);

		
		?>
    
        
	    <?php echo $boton; ?>     
    </div>
</div>
<?php $this->endWidget();?>