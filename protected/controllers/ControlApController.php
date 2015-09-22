<?php
class ControlApController extends Controller
{
	private $_muestraMenu;
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
	public function actionIndex(){
		Yii::app()->getSession()->add('id_modulo',"");
		$sedesForjar=Yii::app()->user->getState('sedesForjar');//nombreSedeForjar
		$menuPr['items']=array();
		array_push($menuPr['items'],array('label'=>'Inicio', 'url'=>array('controlAp/index'), 'visible'=>!Yii::app()->user->isGuest));
		if(Yii::app()->user->getState('numSedes')==1){
			array_push($menuPr['items'],array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest));
			array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
			$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
			$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
			Yii::app()->getSession()->add('menuPr',$menuPr);
			Yii::app()->user->setState('sedeForjar',$sedesForjar[0]["id_forjar"]);
			Yii::app()->user->setState('nombreSedeForjar',$sedesForjar[0]["nombre_sede"]);	
			//$this->setState('sedeForjar',$persona->_idSedeForjar);
			$this->render('index');
		}
		else{
			if(count($sedesForjar)>=2){
				$vista='sedesForjar';
			}
			else{
				$vista="index";
				if(Yii::app()->user->getState('numSedes')>=2){
					array_push($menuPr['items'],array('label'=>'Cambiar Sede', 'url'=>Yii::app()->request->baseUrl.'/controlAp/cambiarSede', 'visible'=>!Yii::app()->user->isGuest));
				}
				array_push($menuPr['items'],array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest));
			}
			array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
			$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
			$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
			Yii::app()->getSession()->add('menuPr',$menuPr);
			$sedesForjar=Yii::app()->user->getState('sedesForjar');
			$this->render($vista);
		}
	}
	public function actionSeleccionSede(){
		if(Yii::app()->user->hasState('sedeForjar')){
			if(Yii::app()->user->getState('numSedes')==2){
				Yii::app()->getSession()->add('menuPr','');
				$menuPr['items']=array();
				array_push($menuPr['items'],array('label'=>'Inicio', 'url'=>array('controlAp/index'), 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Cambiar Sede', 'url'=>Yii::app()->request->baseUrl.'/controlAp/cambiarSede', 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
				$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
				$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
				Yii::app()->getSession()->add('menuPr',$menuPr);
			}
			$this->render('index');
		}
		else{			
			$dataInput=Yii::app()->input->post();
			if(isset($dataInput["sedeForjar"]) && !empty($dataInput["sedeForjar"]) && isset($dataInput["nombreSedeForjar"]) && !empty($dataInput["nombreSedeForjar"])){
				Yii::app()->user->setState('sedesForjar',array(array('id_forjar'=>$dataInput["sedeForjar"],'nombre_sede'=>$dataInput["nombreSedeForjar"])));
				Yii::app()->getSession()->add('menuPr','');
				$menuPr['items']=array();
				array_push($menuPr['items'],array('label'=>'Inicio', 'url'=>array('controlAp/index'), 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Cambiar Sede', 'url'=>Yii::app()->request->baseUrl.'/controlAp/cambiarSede', 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest));
				array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
				$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
				$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
				Yii::app()->getSession()->add('menuPr',$menuPr);
				$sedesForjar=Yii::app()->user->getState('sedesForjar');//nombreSedeForjar
				Yii::app()->user->setState('sedeForjar',$dataInput["sedeForjar"]);
				Yii::app()->user->setState('nombreSedeForjar',$dataInput["nombreSedeForjar"]);	
				//$this->setState('sedeForjar',$persona->_idSedeForjar);
				$this->render('index');
			}
			else{
				$this->render('sedesForjar');
			}			
		}
	}
	public function actionModulos(){
		$idSedeForjar=Yii::app()->user->getState('sedeForjar');
		if(!empty($idSedeForjar)){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["id_modulo"])&& !empty($datosInput["id_modulo"])){
				Yii::app()->getSession()->add('id_modulo',$datosInput["id_modulo"]);
			}
			else{
				Yii::app()->getSession()->add('id_modulo','');
			}
			$contAp=new ControlApp();
			$modulo=$contAp->consultaModulo();
			Yii::app()->getSession()->remove('numDocAdol');
			$this->llamaMenu();
			$this->render('modulos',array('modulo'=>$modulo));	
		}
		else{
			$this->render('sedesForjar');	
		}
	}
	public function accessRules(){   
		return array(
			
			array('deny',  // deny all users
				'actions'=>'index',
				'roles'=>array('*'),
			),
		);
	}
	
	public function actionMenu(){		
			$id_modulo=CHtml::encode(($_POST['id_modulo']));
			$this->_muestraMenu=new ControlApp();
			$menuPr=$this->creaMenu($this->_muestraMenu->consultaMenu($id_modulo));
			Yii::app()->getSession()->add('id_modulo',$id_modulo);
		 	$this->widget('zii.widgets.CMenu', $menuPr);
	}
	public function llamaMenu(){
		//$id_modulo=CHtml::encode($id_modulo);
		Yii::app()->getSession()->add('menuPr',"");
		$this->_muestraMenu=new ControlApp();
		if(Yii::app()->getSession()->get('id_modulo')!=""){	
			$menuPr=$this->creaMenu($this->_muestraMenu->consultaMenu(Yii::app()->getSession()->get('id_modulo')));
		}
		else{
			$menuPr['items']=array();
			array_push($menuPr['items'],array('label'=>'Inicio', 'url'=>array('controlAp/index'), 'visible'=>!Yii::app()->user->isGuest));
			if(Yii::app()->user->getState('numSedes')>1){
				array_push($menuPr['items'],array('label'=>'Cambiar Sede', 'url'=>Yii::app()->request->baseUrl.'/controlAp/cambiarSede', 'visible'=>!Yii::app()->user->isGuest));
			}
			array_push($menuPr['items'],array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest));
			array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
			$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
			$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
		}
		Yii::app()->getSession()->add('menuPr',$menuPr);			
	}
	public function creaMenu($menuPrin){
		$menuPr['items'][0]=array('label'=>'Ingreso', 'url'=>Yii::app()->request->baseUrl.'/site/login', 'visible'=>Yii::app()->user->isGuest);
		$menuPr['items'][1]=array('label'=>'Inicio', 'url'=>Yii::app()->request->baseUrl.'/controlAp/index', 'visible'=>!Yii::app()->user->isGuest);
		if(Yii::app()->user->getState('numSedes')>1){
				array_push($menuPr['items'],array('label'=>'Cambiar Sede', 'url'=>Yii::app()->request->baseUrl.'/controlAp/cambiarSede', 'visible'=>!Yii::app()->user->isGuest));
		}		
		$menuPr['items'][3]=array('label'=>'Módulos', 'url'=>Yii::app()->request->baseUrl.'/controlAp/modulos', 'visible'=>!Yii::app()->user->isGuest);
		foreach($menuPrin as $pk=>$menu){
			if($menu['accion']=='#'){
				$k=0;
				$consSubMenuNi=$this->_muestraMenu->consultaSubMenu($menu['id_menu']);
				$targetMenu="_self";
				if(!empty($consSubMenuNi[$i]['target'])){
					$targetMenu=$consSubMenuNi[$i]['target'];
				}	
				$menuPr['items'][$pk+4]=array('label'=>$menu['titulo_menu'], 'url'=>'#','linkOptions'=>array('target'=>$targetMenu), 'items'=>array());
				for($i=0;$i<=count($consSubMenuNi)-1;$i++){
					$target="_self";
					if(!empty($consSubMenuNi[$i]['target'])){
						$target=$consSubMenuNi[$i]['target'];
					}
					if($consSubMenuNi[$i]['accion']=='#'){
						$menuPr['items'][$pk+4]['items'][$k]=array('label'=>$consSubMenuNi[$i]['titulo_menu'], 'url'=>$consSubMenuNi[$i]['accion'],'linkOptions'=>array('target'=>$target), 'items'=>array());
						//array_push($menuPr['items'][$pk]['items'],array('label'=>$menu['titulo_menu'], 'url'=>$menu['accion'], 'items'=>array()));
						$j=$i;
						while($consSubMenuNi[$j+1]['men_id_menu']==$consSubMenuNi[$i]['id_menu']){								
							array_push($menuPr['items'][$pk+4]['items'][$k]['items'],array('label'=>$consSubMenuNi[$j+1]['titulo_menu'], 'url'=>Yii::app()->request->baseUrl.'/'.$consSubMenuNi[$j+1]['accion'],'linkOptions'=>array('target'=>$target), 'visible'=>true));	
							$j++;
						}
						$i=$j;
						$k++;
					}
					else{
						$target="_self";
						if(!empty($consSubMenuNi[$i]['target'])){
							$target=$consSubMenuNi[$i]['target'];
						}						
						$menuPr['items'][$pk+4]['items'][$k]=array('label'=>$consSubMenuNi[$i]['titulo_menu'], 'url'=>Yii::app()->request->baseUrl.'/'.$consSubMenuNi[$i]['accion'],'linkOptions'=>array('target'=>$target), 'visible'=>true);
						$k++;
						//array_push($menuPr['items'][$pk]['items'],array('label'=>$menu['titulo_menu'], 'url'=>$menu['accion'], 'visible'=>true));
					}
				}
			}
			else{
				$menuPr['items'][$pk+4]=array('label'=>$menu['titulo_menu'], 'url'=>array($menu['accion']),'visible'=>true);
			}
		}
		array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>Yii::app()->request->baseUrl.'/site/logout', 'visible'=>!Yii::app()->user->isGuest));
		$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
		$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
		return $menuPr;
	}
	public function actionCambiarSede(){
		$modeloPersona=new Persona();
		$modeloPersona->_cedula=Yii::app()->user->getState('cedula');
		$sedesForjar=$modeloPersona->consultaSedeForjar();
		Yii::app()->user->setState('sedeForjar',null);
		Yii::app()->user->setState('nombreSedeForjar',null);
		Yii::app()->user->setState('sedesForjar',$sedesForjar);
		$this->render('sedesForjar');	
	}

	// Uncomment the following methods and override them if needed
	/*
			$res['bla1']=$id_modulo;
			$res['bla2']=$id_rol;
			header("Content-type: application/json");
       		echo CJSON::encode($res);
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}