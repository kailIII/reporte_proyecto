<?php

class ReporteController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=proyecto/imprimir&view=FileName
			'imprimir'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' actions
				'actions'=>array('admin'),
				'roles'=>array('1','2'),
			),
			array('allow', 
				'actions'=>array('create','devuelveMaterial','update','buscar'),
				'roles'=>array('1','2'),
			),
			array('allow',
				'actions'=>array('general','imprimirGeneral','excelGeneral'),
				'roles'=>array('2','3'),
			),
			array('allow',
				'actions'=>array('delete'),
				'roles'=>array('1','2'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id,$accion,$proyecto)
	{
		$this->layout='//layouts/column2';

		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'accion'=>$accion,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($accion,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		//Incluir scripts
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui'); //jquery
		$cs->registerScriptFile($baseUrl.'/js/sumatoria.js');

		/* 
		*Los modelos a utilizar
		*/
		//Reporte
		$model=new Reporte;

		//Para el contenido del campo materialServicio
		$value="";

		if(Yii::app()->user->nivel==1) //Si es administrador
		{
			Yii::app()->user->setFlash('admin','El Administrador no puede crear registros.');
		}
		else
		{
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Reporte']))
			{
				$model->attributes=$_POST['Reporte'];
				$model->sub_total=round($_POST['Reporte']['sub_total']);
				$model->total_iva=round($_POST['Reporte']['total_iva']);
				$model->total=round($_POST['Reporte']['total']);
				
				//Validar el formulario
				if($model->validate(array('imputacion_presupuestaria')))
				{
					//accion_ue
					$aue=AccionUe::model()->findByPk($model->accion_ue);
					
				}
				
				//Materiales y servicios
				$value=$_POST['materialServicio'];


				if($model->save()) //Guardar el reporte
				{
					//Historico
					$historico=new HistoricoReporte;
					$historico->codigo_reporte=$model->codigo;
					$historico->codigo_usuario=Yii::app()->user->id;
					$historico->fecha=date('Y-m-d H:i:s');
					$historico->operacion=1; //Creado
					
					if($historico->save()) //Guardar en el historial
					{
						Yii::app()->user->setFlash('usuario','Registro guardado exitosamente.');
						$this->refresh();
					}
					
				}
					
			}
		}		

		$this->render('create',array(
			'model'=>$model,
			'accion'=>$accion,
			'value'=>$value,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$accion,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		//Incluir scripts
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui'); //jquery
		$cs->registerScriptFile($baseUrl.'/js/sumatoria.js');

		/* 
		*Los modelos a utilizar
		*/
		//Reporte
		$model=$this->loadModel($id);

		//Para el contenido del campo materialServicio
		$value=MaterialesServicios::model()->findByPk($model->material_servicio)->descripcion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reporte']))
		{
			//Asignar valores al modelo
			$model->attributes=$_POST['Reporte'];
			$model->sub_total=round($_POST['Reporte']['sub_total']);
			$model->total_iva=round($_POST['Reporte']['total_iva']);
			$model->total=round($_POST['Reporte']['total']);

			//Validar el formulario
			if($model->validate(array('imputacion_presupuestaria')))
			{
				/** Nada **/
			}

			//Materiales y servicios
			$value=$_POST['materialServicio'];

			
			if($model->save())
			{
				//Historico
				$historico=new HistoricoReporte;
				$historico->codigo_reporte=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=2;  //Modificado
				$historico->save();
				
				$this->redirect(array('view','id'=>$model->codigo,'accion'=>$accion, 'proyecto'=>$proyecto));
				
			}
				
		}

		$this->render('update',array(
			'model'=>$model,
			'value'=>$value,
			'accion'=>$accion,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$accion,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		if(Yii::app()->request->isPostRequest)
		{
			//El modelo
			$model=$this->loadModel($id)->delete();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('acciones/view','id'=>$accion,'proyecto'=>$proyecto));			
				
		}
		else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($accion,$proyecto)
	{
		if(Yii::app()->user->nivel==1)
		{
			Yii::app()->user->setFlash('admin','Esta opción no está disponible para el administrador.');

			$this->render('index',array(
				'proyecto'=>$proyecto,
				'accion'=>$accion
			));
		}
		else
		{
			$aue=AccionUe::model()->findAll(array(
				'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
				'params'=>array(':codigo_accion'=>$accion, ':codigo_ue'=>Yii::app()->user->uel)
			));

			//string sql
			$sql = ' estatus = 1'; //ACTIVO
			
			//construir la condicion de busqueda
			foreach($aue as $key => $valor)
			{
				if($valor != NULL){$codigo=$valor->codigo;}else{$codigo='NULL';}
				
				if(count($aue)==1)
				{
					$sql .= ' AND accion_ue='.$codigo;
				}
				else
				{
					if($key == 0){ $sql .= ' AND (accion_ue='.$codigo;}
					elseif($key == count($aue)-1){ $sql .= ' OR accion_ue='.$codigo.')';}
					else{ $sql.= ' OR accion_ue='.$codigo;}
				}		
				
			}

			$dataProvider=new CActiveDataProvider('Reporte',array(
				'criteria'=>array(
					'condition'=>$sql,
					'order'=>'codigo ASC'
				)
			));

			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'accion'=>$accion,
				'proyecto'=>$proyecto
			));
		}		
		
	}

	/**
	 * Buscar registros.
	 */
	public function actionBuscar($proyecto,$accion)
	{
		$model=new Reporte('buscar');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reporte']))
		{
			$model->attributes=$_GET['Reporte'];
		}
			

		$this->render('buscar',array(
			'model'=>$model,
			'proyecto'=>$proyecto,
			'accion'=>$accion
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reporte('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reporte']))
			$model->attributes=$_GET['Reporte'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionGeneral($proyecto)
	{
		//Cambiar el layout
		$this->layout='//layouts/column1';

		//Obtener la instancia de 'proyecto'
		$pro=Proyecto::model()->findByPk($proyecto);

		if(Yii::app()->user->nivel==1) //Si es administrador
		{
			Yii::app()->user->setFlash('admin','El Administrador no puede ver los reportes generales.');

			$this->render('general',array(
				'proyecto'=>$pro
			));
		}
		else
		{
			//Lista de acciones para buscar los reportes
			$acciones=Acciones::model()->findAll(array(
				'condition'=>'codigo_proyecto=:proyecto',
				'params'=>array(':proyecto'=>$pro->codigo))			
			);

			//Para almacenar accion_ue
			$aue=array();

			foreach($acciones as $key => $accion)
			{
				$aue[$key]=AccionUe::model()->find(array(
					'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
					'params'=>array(':codigo_accion'=>$accion->codigo, ':codigo_ue'=>Yii::app()->user->uel),
				));
			}		
			
			//La vista
			$this->render('general',array(
				'acciones'=>$acciones,
				'proyecto'=>$pro,
				'aue'=>$aue
			));
		}

		
	}

	public function actionExcelGeneral()
	{
		//Para completar el query
		$sql=$_GET['sql'];

		//El data provider
		$dataProvider=new CActiveDataProvider('Reporte',array(
			'criteria'=>array(
				'condition'=>$sql,
				'order'=>'imputacion_presupuestaria, material_servicio ASC',
			)
		));

		//Widget para exportar a hoja de calculo(excel)
		$factory = new CWidgetFactory(); 
		Yii::import('ext.EExcelView.EExcelView',true);  
        $widget = $factory->createWidget($this,'EExcelView', array(
            'dataProvider'=>$dataProvider,
            'grid_mode'=>'export',
            'title'=>'Reporte',
            'creator'=>'TNC',
            'autoWidth'=>true,
            'filename'=>'Reporte',
            'stream'=>true,
            'disablePaging'=>true,
            'exportType'=>'Excel2007',
            'showTableOnEmpty' => false,
            'columns'=>array(
				array(
					'name'=>'Codigo',
					'type'=>'raw', //Tipo raw, el link se crea en la funcion
					'value'=>function($data,$proyecto){
						$aue=AccionUe::model()->findByPk($data->accion_ue);
						$accion=Acciones::model()->findByPk($aue->codigo_accion);
						//return Chtml::link($data->codigo,Yii::app()->createUrl('reporte/view',array('id'=>$data->codigo,'accion'=>$aue->codigo_accion,'proyecto'=>$accion->codigo_proyecto)));
						return $data->codigo;
					}
				),
				array(
					'name'=>'Nombre Acción',
					'type'=>'raw', //Tipo raw para poder renderizar la propiedad overflow
					'value'=>function($data,$row){
						$aue=AccionUe::model()->findByPk($data->accion_ue);
						$val=Acciones::model()->findByPk($aue->codigo_accion)->accion;
						return "<div style='width:160px;white-space:nowrap;overflow:hidden' title='$val'>".$val."</div>";
					}, 	
				),
				'imputacion_presupuestaria', //La partida
				array(
					'name'=>'Producto o Servicio',
					'type'=>'raw',
					'value'=>function($data){
						$val= MaterialesServicios::model()->findByPk($data->material_servicio)->descripcion;
						return "<div style='width:160px;overflow:hidden;white-space:nowrap' title='$val'>".$val."</div>";
					}
				),
				array(
					'name'=>'Unidad de Medida',
					'value'=>function($data){
						$val=UnidadMedida::model()->findByPk($data->unidad_medida);
						return $val->unidad_medida;
					}
				),
				array(
					'name'=>'Presentación',
					'value'=>function($data){
						$val=Presentacion::model()->findByPk($data->presentacion);
						return $val->presentacion;
					}
				),
				'precio_unitario',
				'iva',
				'trim_i',
				array(
					'name'=>'total_trim_i', //Etiqueta definida en el modelo
					'type'=>'raw',
					'value'=>function($data){
						$val=$data->trim_i*$data->precio_unitario;
						return $val;
					}
				),
				'trim_ii',
				array(
					'name'=>'total_trim_ii', //Etiqueta definida en el modelo
					'type'=>'raw',
					'value'=>function($data){
						$val=$data->trim_ii*$data->precio_unitario;
						return $val;
					}
				),
				'trim_iii',
				array(
					'name'=>'total_trim_iii', //Etiqueta definida en el modelo
					'type'=>'raw',
					'value'=>function($data){
						$val=$data->trim_iii*$data->precio_unitario;
						return $val;
					}
				),
				'trim_iv',
				array(
					'name'=>'total_trim_iv', //Etiqueta definida en el modelo
					'type'=>'raw',
					'value'=>function($data){
						$val=$data->trim_iv*$data->precio_unitario;
						return $val;
					}
				),
				'sub_total',
				'total_iva',
				'total',
			),
        ));

        $widget->init();
        $widget->run();
      
		Yii::app()->end();
	}


	/**
	 * Imprimir reporte general por unidad ejecutora
	 *
	 */
	public function actionImprimirGeneral($proyecto)
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "1024M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		 
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimirGridView.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);

		//Lista de acciones para buscar los reportes
		$acciones=Acciones::model()->findAll(array(
			'condition'=>'codigo_proyecto=:proyecto',
			'params'=>array(':proyecto'=>$proyecto->codigo))			
		);

		foreach($acciones as $key => $accion)
		{
			$aue[$key]=AccionUe::model()->find(array(
				'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
				'params'=>array(':codigo_accion'=>$accion->codigo, ':codigo_ue'=>Yii::app()->user->uel)
			));
		}

		//Para almacenar los dataProvider
		$proveedor=array();

		$nombreAccion=array();

		foreach($aue as $llave => $valor)
		{
			//DataProvider
			$proveedor[$llave]['dataProvider']=new CActiveDataProvider('Reporte',array(
				'criteria'=>array(
					'condition'=>'estatus = 1 AND accion_ue=:accion_ue',
					'params'=>array(':accion_ue'=>$valor->codigo),
					'order'=>'imputacion_presupuestaria, material_servicio ASC',
				)
			));

			//Desactivar paginacion
			$proveedor[$llave]['dataProvider']->setPagination(false);

			//Nombre de la acción para imprimir
			$nombreAccion[$llave]=Acciones::model()->findByPk($valor->codigo_accion)->accion;
		}
		/*
		$this->render('_imprimirGeneral',array(
			'proveedor'=>$proveedor,
			'proyecto'=>$proyecto,
			'aue'=>$aue,
		));
		*/

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirGeneral',array(
			'proveedor'=>$proveedor,
			'proyecto'=>$proyecto,
			'aue'=>$aue,
			'nombreAccion'=>$nombreAccion,
		),true,true));

		//Imprimir
		$mPDF1->Output('Registros.pdf','D');
		
	}

	/**
	 * AJAX para devolver un material o servicio
	 * @return JSON string
	 */	
	public function actionDevuelveMaterial()
	{
		$aue=AccionUe::model()->find(array(
			'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
			'params'=>array(':codigo_accion'=>$_GET['accion'], ':codigo_ue'=>Yii::app()->user->uel)
		));
		$busq=$_GET['term'];
		
		if($busq!='')
		{
			$sql="SELECT ms.codigo, ms.descripcion as value,
				ms.precio1 as precio1,
				ms.unidad_medida as unidad_medida,
				um.unidad_medida as um_descripcion,
				ms.presentacion as presentacion, 
				p.presentacion as p_presentacion,
				CONCAT(s.partida,s.ge,s.es,s.se) as Imputacion, 
				s.partida as partida
				FROM materiales_servicios ms, subpartida s, unidad_medida um, presentacion p
				WHERE ms.descripcion LIKE :busq 
				AND s.codigo = ms.subpartida
				AND um.codigo = ms.unidad_medida
				AND p.codigo = ms.presentacion
				AND ms.estatus = 1
				LIMIT 20";
			$busq="%".$busq."%";
			
			$resul=Yii::app()->db->createCommand($sql)->queryAll(true,array(':busq'=>$busq));
			
			echo CJSON::encode($resul);
			
			Yii::app()->end();
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reporte::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reporte-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
