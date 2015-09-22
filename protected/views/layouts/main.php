<!-- :: Shinigami Framework :: -->
<!-- :: v.2.0 :: -->
<!DOCTYPE html>
<html class="no-js" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Descripción de la Aplicación">   
        <meta name="author" content="Shinigami Framework">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <!--Stylesheet-->
        <!-- Bootstrap 3.2.0-->
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/css/bootstrap-select.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/css/bootstrap.min.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/css/jquery.smartmenus.bootstrap.css" rel="stylesheet" media="screen"/>
        <!-- Data Tables Css -->
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/DataTable/css/dataTables.bootstrap.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/DataTable/css/jquery.dataTables.min.css" rel="stylesheet" media="screen"/>

        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/addons/Datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet"/>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.css" rel="stylesheet"/>
        <link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.alerts.css" rel="stylesheet"/>
        <!-- JS JQUERY 1.11.1-->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js"></script>
        <!-- JS reloj v0.9-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/clock.js"></script>
        <!-- JS Bootstrap 3.2.0-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/js/bootstrap-select.js"></script>
        
        <!-- Examine JS -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/ex/bootstrap-filestyle.js"></script>

        <!-- JS general-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/Datetimepicker/moment.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/Datetimepicker/bootstrap-datetimepicker.js"></script>
  <style>    
  .ui-tooltip
{
    /* tooltip container box */
    max-width: 90% !important;
}  
        .mini-submenu{
  display:none;  
  background-color: rgba(0, 0, 0, 0);  
  border: 1px solid rgba(0, 0, 0, 0.9);
  border-radius: 4px;
  padding: 9px;  
  /*position: relative;*/
  width: 42px;

}

.mini-submenu:hover{
  cursor: pointer;
  
}

.mini-submenu .icon-bar {
  border-radius: 1px;
  display: block;
  height: 2px;
  width: 22px;
  margin-top: 3px;
}

.mini-submenu .icon-bar {
  background-color: #000;
}

#slide-submenu{
  background: rgba(0, 0, 0, 0.45);
  display: inline-block;
  padding: 0 8px;
  border-radius: 4px;
  cursor: pointer;
  
}
        </style>
        <script>
			var count=null;
			var contador;
        $(function(count){	
			window.alert = function() {};
			$('#slide-submenu').on('click',function() {			        
				$(this).closest('.list-group').fadeOut('slide',function(){
					$('.mini-submenu').fadeIn();	
				});
				
			  });
		
			$('.mini-submenu').on('click',function(){		
				$(this).next('.list-group').toggle('slide');
				$('.mini-submenu').hide();
			})
			
		})
	$(document).ready(	
		$(document).on("mousemove",function(){
			var sesion="<?php echo Yii::app()->user->isGuest?>";
			if(!sesion){
				 clearTimeout(count);
				 count = setTimeout('cerrarAp()',6000000000);//600000
			}
		})
	); 
		function cerrarAp(){
			jAlert("pasaron 5 minutos de inactividad, se cerrará la aplicación","Mensaje")
			window.location="<?php echo Yii::app()->createAbsoluteUrl('site/logout')?>";
		}
    </script>
         	 	<title><?php echo Yii::app()->user->getState('nombreSedeForjar');?></title>
    </head>
    <body>
        <!-- Cabecera  -->
        <div class="navbar navbar-default text-center app-head">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <img class="app-logo" src="http://aplicativos.sdis.gov.co/recursos/monkey/img/logo.png" /> 
                            </div>
                            <div class="col-lg-7 col-md-9 col-sm-6 col-xs-12">
                                <div class="text text-left">
                                    <div class="row">
                                        <div class="col-lg-12 app-title">Solución Informática para la Gestión de Información de Adolescentes de Forjar - SIGIAF</div>
                                        <div class="col-lg-12 app-sub-title">Secretaria Distrital de Integración Social</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right col-lg-6 col-md-4 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-1 col-lg-offset-6 col-md-2 col-sm-2 col-xs-2 col-xs-offset-1 text-center">
                                <a href="http://intranetsdis/" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/intra_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="http://www.integracionsocial.gov.co" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/web_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="https://www.facebook.com/integracionsocialbta" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/facebook_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="https://twitter.com/integracionbta" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/twitter_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="http://aplicativos.sdis.gov.co/login_sdis/contacto/" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/email_32.png" />
                                </a>
                            </div>
                        </div>
                        <div class="row app-user">
                            <div class="col-lg-12 hidden-xs">
                                Bienvenido, <b><?php
		if(Yii::app()->user->hasState('cedula')){
      		echo Yii::app()->user->getState('nombre');
			echo '</br>';
			echo Yii::app()->user->getState('nombreSedeForjar');
			//echo Yii::app()->user->getState('cedula');
			//Yii::app()->getSession()->remove('cedula');	
        }
     ?></b>
                            </div>
                            <div class="col-lg-12 col-xs-12">
                                <span class="glyphicon glyphicon-time"></span> 
                                <span class="clock"> </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Cabecera  -->



        <!-- Menu  -->
        <nav class="navbar navbar-default app-menu" role="navigation">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-10">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs white" href="#">  Bienvenido, <b><?php echo Yii::app()->user->getState('nombre');?></b></a>
            </div>
            <?php //ControlApController::actionIndex();?>
            <div class="collapse navbar-collapse app-menu-links" role="navigation" id="bs-example-navbar-collapse-10">
            <?php
				if(Yii::app()->user->hasState('cedula') && Yii::app()->user->hasState('sedeForjar')){
					$this->widget('zii.widgets.CMenu', Yii::app()->getSession()->get('menuPr'));
					?>
                        <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onClick="javascript:$('#alertaSigiaf').show()">Alertas <i id="i-alertasMenu"></i></a></li>                       
                      </ul>
                    <?php
				}
				else{
					$menuPr['items']=array();
					array_push($menuPr['items'],array('label'=>'Ingreso', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest));
					array_push($menuPr['items'],array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest));
					$menuPr['htmlOptions']=array('class'=>'nav navbar-nav');
					$menuPr['submenuHtmlOptions']=array('class' => 'dropdown-menu');
					$this->widget('zii.widgets.CMenu', $menuPr);
					
				}
			?>			
            </div>
        </nav>
        <!-- /Menu  -->
        
        <!-- Alertas  -->
	<?php
		if(Yii::app()->user->hasState('cedula')):?>
			<div class="row">
				<div class="col-sm-4 col-md-3 sidebar" style="position:absolute; z-index:100;">
                <!--    <div class="mini-submenu" style="display:block">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                -->    
					<div class="list-group" style=" display:none" id="alertaSigiaf">
                        <span href="#" class="list-group-item active">
                            Alertas
                            <span class="pull-right" id="slide-submenu">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                        <!--<a href="#" class="list-group-item">        						
                            <i class="glyphicon glyphicon-warning-sign"></i> Identificación y registro <span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="glyphicon glyphicon-ok"></i> Lorem ipsum <span class="badge">0</span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-user"></i> Lorem ipsum
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-folder-open-o"></i> Lorem ipsum <span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-bar-chart-o"></i> Lorem ipsumr <span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-envelope"></i> Lorem ipsum
                        </a>-->
    				</div>        
				</div>
			</div>
	<?php endif;?>
        <!-- /Alertas  -->

        <!-- Contenido  -->
        <div class="app-content-1">
            <div class="app-content-2">
                <div class="container">
  					<?php echo $content; ?>
                </div>
            </div>
        </div>
        <!-- /Contenido  -->


        <!-- Pie  -->
        <div class="navbar navbar-default app-footer  text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/logo_ufs_90x122.png" />
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
                                <div class="text-left app-footer-text">
                                    <div class="oneFooter">Secretaría Distrital de Integración Social</div>
                                    <div>Carrera 7 No. 32 - 16 Piso 10 Oficina 1006</div>
                                    <div>Mesadeservicio1035@sdis.gov.co</div>
                                    <div>Teléfono: 3 27 97 97</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right col-lg-6 col-md-4 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-1 col-lg-offset-6 col-md-2 col-sm-2 col-xs-2 col-xs-offset-1 text-center">
                                <a href="http://intranetsdis/" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/intra_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="http://www.integracionsocial.gov.co" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/web_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="https://www.facebook.com/integracionsocialbta" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/facebook_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="https://twitter.com/integracionbta" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/twitter_32.png" />
                                </a>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                                <a href="http://aplicativos.sdis.gov.co/login_sdis/contacto/" target="_blank">
                                    <img src="http://aplicativos.sdis.gov.co/recursos/monkey/img/circular/email_32.png" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 app-lineafooter">
                © Secretaria Distrital de Integración social / Unidad Factoria de Software / 2015
            </div>
        </div>
        <!-- /Pie  -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.smartmenus.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/bootstrap-3.1.0/js/jquery.smartmenus.bootstrap.js"></script>
     
     
   <?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	'id'=>'juiDialog',
	'options'=>array(
		'id'=>'a1',
		'title'=>'Show data',
		'autoOpen'=>false,
		'modal'=>'true',
		'width'=>'60%',
		'height'=>'400',
	),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>     
<?php $this->widget('application.extensions.loading.LoadingWidget');?>     
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/DataTable/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/addons/DataTable/js/dataTables.bootstrap.js"></script>

    </body>
         <!-- Data Tables JS -->
   
</html>

<?php 
if(Yii::app()->user->hasState('cedula')){
	//glyphicon glyphicon-warning-sign
	//glyphicon glyphicon-ok
	
	$icono="glyphicon glyphicon-ok";
	Yii::app()->getClientScript()->registerScript('scriptAlertas','
	
		$.ajax({
			url:"'.Yii::app()->createAbsoluteUrl('alertas/asociaAlertas').'",
			//data:$("#"+nombreForm).serialize()+"&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val(),
			dataType:"json",
			type: "post",
			//beforeSend:function (){Loading.show();},
			success: function(datos){
				if(typeof datos=="object" && !$.isEmptyObject(datos)){		
					var contenidoAlerta="";
					$("#i-alertasMenu").addClass(datos.alertaMenu);
					$.each(datos.alertaSlider, function(key) {
						contenidoAlerta+=" <a href=\"#\" onclick=\"js:muestraPopUpAlertas(\'"+datos.alertaSlider[key].url+"\');\" class=\"list-group-item\" type=\"POST\">";
						contenidoAlerta+="<i class=\""+datos.alertaSlider[key].icono+"\"></i> "+datos.alertaSlider[key].modulo+" <span class=\"badge\">"+datos.alertaSlider[key].numCasos+"</span> ";       						
						contenidoAlerta+="</a>";
					})
					$("#alertaSigiaf").append(contenidoAlerta)
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
				/*//0 para error en comunicación
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
				}	*/
			}
		});
		function muestraPopUpAlertas(modulo){
			$.ajax({
				data:"a=a&nombreModulo="+modulo,
				url:"'.Yii::app()->request->baseUrl.'/alertas/"+modulo,
				dataType:"json",
				type: "post",
				async:"false",
				beforeSend:function (){Loading.show();},
				success: function(faltantesAdol){
					Loading.hide();
					var table="<table class=\"table table-striped table-bordered table-responsive\">";
					table+="<thead><tr>";
					$.each(faltantesAdol.cabezote, function(key) {
						table+="<td><strong>"+faltantesAdol.cabezote[key]+"</strong></td>";
					})					
					table+="</tr></thead><tbody>";	
					$.each(faltantesAdol.infoFaltantes, function(key) {
						table+="<tr>";
						$.each(faltantesAdol.infoFaltantes[key], function(subkey) {
							table+="<td>"+faltantesAdol.infoFaltantes[key][subkey]+"</td>";
						})
						table+="</tr>";
					})
											
					table+="</tbody></table>";
					$(\'#ui-id-1\').text(faltantesAdol.titulo.titulo);$(\'#juiDialog\').addClass(\'panel panel-default\'); $(\'#juiDialog\').html(table); $(\'#juiDialog\').dialog(\'open\');
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					alert(thrownError);				
				}
			});
			
		}

	'
	,CClientScript::POS_END);
}
?>

