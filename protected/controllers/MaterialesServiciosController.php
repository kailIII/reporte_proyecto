<?php

class MaterialesServiciosController extends Controller
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//Definir el timezone
		date_default_timezone_set("America/Caracas");

		$model=new MaterialesServicios;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaterialesServicios']))
		{
			$model->attributes=$_POST['MaterialesServicios'];
			$historico=new HistoricoMaterialesServicios;
			if($model->save())
			{
				$historico->codigo_material_servicio=$model->codigo;
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

		if(isset($_POST['MaterialesServicios']))
		{
			$model->attributes=$_POST['MaterialesServicios'];
			$historico=new HistoricoMaterialesServicios;
			if($model->save())
			{
				$historico->codigo_material_servicio=$model->codigo;
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
				$historico=new HistoricoMaterialesServicios;

				$historico->codigo_material_servicio=$model->codigo;
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
	
	public function actionImportar()
	{
		$modelo=new MaterialesServicios;
		
		//Variables para contar
		$exito=0;
		$fallo=0;
		//Verificar POST
		if(isset($_POST['MaterialesServicios']))
		{
			//Obtenemos el archivo
			$archivo = file($_FILES['MaterialesServicios']['tmp_name']['archivo']);
			
			foreach($archivo as $key => $valor)
			{
				
				//Separar las columnas en un arreglo
				$exploded=str_getcsv($valor,',','"');
				
				//Buscar el codigo de la subpartida
				$subpartida=Subpartida::model()->find(
					'partida=:partida AND ge=:ge AND es=:es AND se=:se',
					array(':partida'=>$exploded[0],':ge'=>$exploded[1],':es'=>$exploded[2],':se'=>$exploded[3])
				);

				if($subpartida == null || $subpartida == '')
				{
					print "Partida no encontrada. Línea ".($key+1);
					Yii::app()->end();
				}
				
				//Buscar codigo de la unidad de medida
				$unidad_medida=UnidadMedida::model()->find(
					"unidad_medida LIKE '%".trim($exploded[5])."%'"
				);


				if($unidad_medida==null || $unidad_medida=='')
				{
					$unidad_medida=new UnidadMedida;
					$unidad_medida->unidad_medida=trim($exploded[5]);
					$unidad_medida->save();
				}
				
				//Buscar el codigo de la presentacion
				$presentacion=Presentacion::model()->find(
					"presentacion LIKE '%".trim($exploded[6])."%'"
				);

				if($presentacion==null || $presentacion=='')
				{
					$presentacion=new Presentacion;
					$presentacion->presentacion=trim($exploded[6]);
					$presentacion->save();
				}

				//Modelo para el INSERT o UPDATE
				$materiales_servicios=$this->cargarMaterialServicio($exploded[7],$presentacion->codigo,$unidad_medida->codigo,$subpartida->codigo,$exploded[4]);
				
				//Agregar los valores al modelo
				$materiales_servicios->descripcion=$exploded[4];
				$materiales_servicios->unidad_medida=$unidad_medida['codigo'];
				$materiales_servicios->presentacion=$presentacion['codigo'];
				$materiales_servicios->precio1=str_replace('.','',$exploded[7]);
				//$materiales_servicios->precio2=$exploded[8];
				//$materiales_servicios->precio3=$exploded[9];
				//$materiales_servicios->precio4=$exploded[10];
				$materiales_servicios->subpartida=$subpartida['codigo'];
				
				if($materiales_servicios->save())
				{
					$exito++;
				}
				else
				{
					print "Errores: ";
					print_r($materiales_servicios->getErrors());
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MaterialesServicios',array(
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
		$model=new MaterialesServicios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaterialesServicios']))
		{	
			$model->attributes=$_GET['MaterialesServicios'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Buscar material o servicio
	 * si se encuentra el registro, devolver
	 * sino devolver un modelo nuevo
	 * @param integer subpartida
	 * @param string descripcion
	 */
	function cargarMaterialServicio($precio1,$presentacion,$unidad_medida,$subpartida, $descripcion)
	{
		$materialServicio=MaterialesServicios::model()->findByAttributes(array('precio1'=>$precio1, 'presentacion'=>$presentacion, 'unidad_medida'=>$unidad_medida, 'subpartida'=>$subpartida,'descripcion'=>$descripcion));

		if($materialServicio == '' || $materialServicio == null)
		{
			$materialServicio = new MaterialesServicios;
		}

		return $materialServicio;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MaterialesServicios::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='materiales-servicios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
