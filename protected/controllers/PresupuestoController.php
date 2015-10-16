<?php

class PresupuestoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu2=array();

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','asignar', 'desasignar','accion'),
				'roles'=>array('1'),
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
	public function actionView($id)
	{
		//Incluir scripts
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui'); //jquery

		$model=$this->loadModel($id);

		$aue=new CActiveDataProvider('AccionUe', array(
			'criteria'=>array(
				'condition'=>'presupuesto=:presupuesto',
				'params'=>array(':presupuesto'=>$model->codigo),
			),
		));

		$this->render('view',array(
			'model'=>$model,
			'aue'=>$aue
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		$model=new Presupuesto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Presupuesto']))
		{
			$model->attributes=$_POST['Presupuesto'];
			$model->fecha_hora=date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('view','id'=>$model->codigo));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Presupuesto']))
		{
			$model->attributes=$_POST['Presupuesto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codigo));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Presupuesto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Presupuesto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Presupuesto']))
			$model->attributes=$_GET['Presupuesto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/*
	 * Asignar Unidad Ejecutora al presupuesto.
	 */
	public function actionAsignar($presupuesto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		//Layout
		$this->layout='//layouts/column1';

		//Modelos
		$modelo=$this->loadModel($presupuesto);
		$accion_ue=new AsignaFormulario;

		//Accion_Ue
		$aue=AccionUe::model()->findAll(array(
			'condition'=>'codigo_accion=:codigo_accion AND presupuesto is NULL',
			'params'=>array(':codigo_accion'=>$modelo->codigo_accion)
		));

		//arreglo para la lista de unidades ejecutoras
		$ue=array();

		foreach ($aue as $key => $value)
		{
			$ue[]=UnidadEjecutora::model()->findByPk($value->codigo_ue);
		}

		if(isset($_POST['AsignaFormulario']))
		{
			$accion_ue->attributes=$_POST['AsignaFormulario'];	

			if($accion_ue->validate()) //Validacion
			{
				//Obtener el registro de accion_ue para actualizar su presupuesto
				$AccionUe=AccionUe::model()->find(array(
					'condition'=>'codigo_accion=:codigo_accion AND codigo_ue=:codigo_ue',
					'params'=>array(':codigo_accion'=>$modelo->codigo_accion, ':codigo_ue'=>$_POST['AsignaFormulario']['codigo_ue'])
				));
				$AccionUe->presupuesto=$modelo->codigo; //Se asigna el codigo del presupuesto

				if($AccionUe->save()) //Guardar los cambios
				{
					//Historial
					$historico=new HistoricoAsignaPresupuesto;
					$historico->codigo_aue=$AccionUe->codigo;
					$historico->codigo_usuario=Yii::app()->user->id;
					$historico->fecha=date('Y-m-d H:i:s');
					$historico->asignacion=1; //Asignar

					$historico->save(); //Guardar

					$this->redirect(array('view','id'=>$modelo->codigo)); //Redireccionar a la vista
				
				}
				else //Si hay un problema al asignar
				{	
					print_r($AccionUe->getErrors());
				}
			}
			
		}

		$this->render('asignar',array(
			'modelo'=>$modelo,
			'aue'=>$aue,
			'ue'=>$ue,
			'accion_ue'=>$accion_ue
		));
	}

	/*
	 * Desasignar Unidad Ejecutora al presupuesto.
	 */
	public function actionDesasignar($aue,$presupuesto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		//modelo
		$modelo=AccionUe::model()->findByPk($aue);
		$modelo->presupuesto=NULL; //Deasignar

		if($modelo->save())
		{
			//Historial
			$historico=new HistoricoAsignaPresupuesto;
			$historico->codigo_aue=$modelo->codigo;
			$historico->codigo_usuario=Yii::app()->user->id;
			$historico->fecha=date('Y-m-d H:i:s');
			$historico->asignacion=2; //Desasignar

			$historico->save(); //Guardar
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$presupuesto));

	}

	public function actionAccion()
	{
		$accion=Acciones::model()->findAll(array(
			'condition'=>'codigo_proyecto=:codigo_proyecto',
			'params'=>array(':codigo_proyecto'=>$_POST['codigo_proyecto'])));
			
		$lista=CHtml::listData($accion, 'codigo', 'accion');
		$lista = array(''=>'(Seleccione una cadena)') + $lista;
		
		foreach($lista as $valor => $nombre)
		{
			echo CHtml::tag('option', array('value'=>$valor),CHtml::encode($nombre),TRUE);
		}
	} 

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Presupuesto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Presupuesto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Presupuesto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='presupuesto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
