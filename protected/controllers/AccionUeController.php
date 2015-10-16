<?php

class AccionUeController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update','admin','delete','view','importar'),
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
	public function actionView($id,$accion,$proyecto)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'accion'=>$accion,
			'proyecto'=>$proyecto
		));
	}

	public function actionImportar()
	{
		$modelo=new AccionUe;

		//Variables para contar
		$exito=0;
		$fallo=0;
		
		//Verificar POST
		if(isset($_POST['AccionUe']))
		{
			//Obtenemos el archivo
			$archivo = file($_FILES['AccionUe']['tmp_name']['archivo']);
			
			foreach($archivo as $key => $valor)
			{				
				//Separar las columnas en un arreglo
				$exploded=explode(';', str_replace('"', '',$valor));

				$ue=UnidadEjecutora::model()->findByAttributes(array('codigo_uel'=>$exploded[0]));

				$accion=Acciones::model()->findByAttributes(array('codigo_accion'=>$exploded[1]));

				$accion_ue=AccionUe::model()->find(array(
					'condition'=>'codigo_ue=:ue AND codigo_accion=:accion',
					'params'=>array(':ue'=>$ue->codigo,':accion'=>$accion->codigo)
				));
				
				$presupuesto=Presupuesto::model()->find(array(
					'condition'=>'codigo_accion=:accion AND presupuesto=:presupuesto',
					'params'=>array(':accion'=>$accion->codigo, ':presupuesto'=>$exploded[2])
				));

				if($presupuesto==null)
				{
					print "Accion:".$accion->codigo;
					print "</br>";
					print "Presupuesto:".$exploded[2];
					exit;
				}

				$accion_ue->presupuesto=$presupuesto->codigo;
				
				if($accion_ue->save())
				{
					$exito++;
				}
				else
				{
					print "Errores: ";
					print_r($accion_ue->getErrors());
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
	public function actionCreate($accion,$proyecto)
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");
		
		$model=new AccionUe;
		$model->codigo_accion=$accion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccionUe']))
		{
			$model->attributes=$_POST['AccionUe'];
			if($model->save())
			{
				$historico=new HistoricoAue;
				$historico->accion_ue=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->operacion=1;//Operacion CREADO
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->save(); //Guardar

				$this->redirect(array('view','id'=>$model->codigo ,'accion'=>$accion, 'proyecto'=>$proyecto));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
			'accion'=>$accion,
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

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccionUe']))
		{
			$model->attributes=$_POST['AccionUe'];
			if($model->save())
			{
				$historico=new HistoricoAue;
				$historico->accion_ue=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->operacion=2; //Operacion MODIFICADO
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->save(); //Guardar

				$this->redirect(array('view','id'=>$model->codigo ,'accion'=>$accion, 'proyecto'=>$proyecto));
			}
				
		}

		$this->render('update',array(
			'model'=>$model,
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
			// we only allow deletion via POST request
			$model=$this->loadModel($id);

			$model->estatus=2;

			if($model->save())
			{
				$historico=new HistoricoAue;

				$historico->accion_ue=$model->codigo;
				$historico->codigo_usuario=Yii::app()->user->id;
				$historico->operacion=3; //Operacion ELIMINADO
				$historico->fecha=date('Y-m-d H:i:s');
				$historico->save(); //Guardar
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index','accion'=>$accion,'proyecto'=>$proyecto));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($accion,$proyecto)
	{
		$dataProvider=new CActiveDataProvider('AccionUe',array(
			'criteria'=>array(
				'condition'=>'codigo_accion=:codigo_accion AND estatus=:estatus',
				'params'=>array(':estatus'=>1, ':codigo_accion'=>$accion),
				'order'=>'codigo ASC'
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'accion'=>$accion,
			'proyecto'=>$proyecto
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($accion,$proyecto)
	{
		$model=new AccionUe('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccionUe']))
			$model->attributes=$_GET['AccionUe'];

		$this->render('admin',array(
			'model'=>$model,
			'accion'=>$accion,
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
		$model=AccionUe::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='accion-ue-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
