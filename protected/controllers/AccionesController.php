<?php

class AccionesController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('1'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	public function actionView($id,$proyecto)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		$model=new Acciones;
		$model->codigo_proyecto=$proyecto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Acciones']))
		{
			$model->attributes=$_POST['Acciones'];
			$historico=new HistoricoAccion;
			if($model->save())
			{
				$historico->codigo_accion=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=1;
				$historico->save();

				$this->redirect(array('view','id'=>$model->codigo,'proyecto'=>$proyecto));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Acciones']))
		{
			$model->attributes=$_POST['Acciones'];
			$historico=new HistoricoAccion;
			if($model->save())
			{
				$historico->codigo_accion=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=2;
				$historico->save();

				$this->redirect(array('view','id'=>$model->codigo,'proyecto'=>$proyecto));
			}
				
		}

		$this->render('update',array(
			'model'=>$model,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('proyecto/view','id'=>$proyecto));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($proyecto)
	{
		$dataProvider=new CActiveDataProvider('Acciones',array(
			'criteria'=>array(
				'condition'=>'estatus=:estatus',
				'params'=>array(':estatus'=>1),
				'order'=>'codigo ASC'
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin($proyecto)
	{
		$model=new Acciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Acciones']))
			$model->attributes=$_GET['Acciones'];

		$this->render('admin',array(
			'model'=>$model,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Acciones::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='acciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
