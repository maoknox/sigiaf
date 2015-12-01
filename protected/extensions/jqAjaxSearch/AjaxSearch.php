<?php
/*
by Paul
inspired from http://www.ibm.com/developerworks/opensource/library/os-php-jquery-ajax/index.html by Thomas Myer
*/
class AjaxSearch extends CWidget {
	public $action = '';
	public $target = '';
	public $minChar = 1;
	private $id = '';
	public $numDocAdol;
	public $url;
	public $datosAdol;
	public $edad;
	public $telefonoAdol;
		
    public function init()
    {
   	
    	if(empty($this->id)){
            $this->id = 2;//'ltjqas'.rand(1, 1000);
        }
        $this->registerClientScript();
        parent::init();
    }

    protected function registerClientScript()
    {
    	$juiBaseUrl=Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/'.'js');
    	
        $cs=Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        //$cs->registerCoreScript('jquery.form.js');
        $cs->registerScriptFile($juiBaseUrl.'/jquery.form.js');
    }

    public function run(){
    	Yii::app()->clientScript->registerScript('searchEnabler', 
        	'$("#'.$this->target.'").slideUp();$("#search_term_'.$this->numDocAdol.'").keyup(function(e){e.preventDefault(); '.
				'if($("#search_term_'.$this->numDocAdol.'").val().length >= '.$this->minChar.'){ '.
					'$("#searchform_'.$this->numDocAdol.'").ajaxSubmit({
						dataType:"json",
						type:"post",
						success:function (datos){
							var contenido="";
							if(datos!=null){
								$.each(datos,function(key){
									contenido+="<div id=\""+datos[key].numDocAdol+"\" onclick=\"javascript:cargaDatos("+datos[key].idDocAdolBd+","+datos[key].numDocAdol+",\'"+datos[key].nombre+"\')\"";
									contenido+=" onmouseover=\"javascript:searchOver("+datos[key].numDocAdol+")\"";
									contenido+=" onmouseout=\"javascript:searchOut("+datos[key].numDocAdol+")\" style=\"cursor:pointer\">";
									contenido+=datos[key].idDocAdolBd+" "+datos[key].nombre+"</div>";
								});
								$("#'.$this->target.'").html(contenido)
								$("#'.$this->target.'").slideDown();
							}
							else{
								$("#'.$this->target.'").hide();
							}
						},
						error:function (xhr, ajaxOptions, thrownError) {
							Loading.hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
								$("#btnFormRef").show();
							}
							else{
								if(xhr.status==500){
									jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
								}
								else{
									jAlert("Ha habido un error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
								}	
							}
							
						}
					}); 
					
				}
				else {
					$("#'.$this->target.'").html("");
					$("#'.$this->target.'").hide("slow");
				}
			});
			function searchOver(elemento){
				$("#"+elemento).css("background","#06F");
			}
			function searchOut(elemento){
				$("#"+elemento).css("background","#FFF");
			}
			function cargaDatos(idDocAdolBd,numDocAdol,nombre){
				$("#search_term_'.$this->numDocAdol.'").val(idDocAdolBd+" "+nombre)
				$("#datosAdol #numDocAdol").val(numDocAdol);
				 $("#'.$this->target.'").hide("slow");
			}
			',
            CClientScript::POS_END);
        $this->render('view',array(
			'action'=>$this->action,
			'target'=>$this->target,
			'numDocAdol'=>$this->numDocAdol,
			'url'=>$this->url,
			'datosAdol'=>$this->datosAdol,
			'edad'=>$this->edad,
			'telefonoAdol'=>$this->telefonoAdol
		));
    }
}