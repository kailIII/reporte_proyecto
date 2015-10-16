<?php

class UnidadEjecutoraController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','create','update','admin','delete','importar'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionImportar()
	{
		$modelo=new UnidadEjecutora;

		//Variables para contar
		$exito=0;
		$fallo=0;
		
		//Verificar POST
		if(isset($_POST['UnidadEjecutora']))
		{
			//Obtenemos el archivo
			$archivo = file($_FILES['UnidadEjecutora']['tmp_name']['archivo']);
			
			foreach($archivo as $key => $valor)
			{

				//Separar las columnas en un arreglo
				$exploded=explode(';', str_replace('"', '',$valor));

				$ue=UnidadEjecutora::model()->find(array(
					'condition'=>'codigo_uel=:codigo_uel',
					'params'=>array(':codigo_uel'=>$exploded[0])
				));

				$ue->denominacion=$exploded[1];
				
				if($ue->save())
				{
					$exito++;
				}
				else
				{
					print "Errores: ";
					print_r($ue->getErrors());
					print "<br/>";
					print "Datos: ";
					print_r($exploded);
					$fallo++;
					exit;
				}
				
			}
		}
		
		$this->render('importar',array(
			'modelo'=>$modelo,
			'exito'=>$exito,
			'fallo'=>$fallo
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

		$model=new UnidadEjecutora;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UnidadEjecutora']))
		{
			$model->attributes=$_POST['UnidadEjecutora'];
			$historico=new HistoricoUnidadEjecutora;

			if($model->save())
			{
				$historico->codigo_unidad_ejecutora=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=1;
				$historico->save();
				$this->redirect(array('view','id'=>$model->codigo));
			}				
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
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UnidadEjecutora']))
		{
			$model->attributes=$_POST['UnidadEjecutora'];
			$historico=new HistoricoUnidadEjecutora;
			if($model->save())
			{
				$historico->codigo_unidad_ejecutora=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=2;
				$historico->save();

				$this->redirect(array('view','id'=>$model->codigo));
			}
				
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
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
			$model->estatus=2;

			if($model->save())
			{
				$historico=new HistoricoUnidadEjecutora;

				$historico->codigo_unidad_ejecutora=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->operacion=3;
				$historico->save();
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UnidadEjecutora',array(
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
	public function actionAdmin()
	{
		$model=new UnidadEjecutora('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UnidadEjecutora']))
			$model->attributes=$_GET['UnidadEjecutora'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=UnidadEjecutora::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidad-ejecutora-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
