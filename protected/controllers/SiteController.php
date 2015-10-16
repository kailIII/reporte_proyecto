<?php

class SiteController extends Controller
{
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
			array('allow',  // allow all users to perform
				'actions'=>array('index','view','login','logout','sessionUnset'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user
				'actions'=>array(
					'opciones',
					'historial',
					'cargaProyectoAccion',
					'registrarBd',
					'registrar'
				),
				'roles'=>array('1'),
			),
			array('allow',
				'actions'=>array('index','login','logout'),
				'users'=>array('?')

			),
			/*
			array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
	}

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
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{			
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionOpciones()
	{
		$this->render('opciones');
	}

	public function actionHistorial()
	{
		$this->render('historial');
	}

	/**
	 * Modulo de carga de proyectos y sus acciones asociadas.
	 */
	public function actionCargaProyectoAccion()
	{
		$modelo=new Archivo;

		//Variables para contar
		$exito=0;

		//Verificar POST
		if(isset($_POST['Archivo']))
		{
			//Obtenemos el archivo
			$archivo = file($_FILES['Archivo']['tmp_name']['archivo']);

			foreach($archivo as $key => $valor)
			{
				if($key==0) //Saltar la primera linea
				{
					//
				}
				else
				{
					//Separar las columnas en un arreglo
					$exploded=str_getcsv($valor,',','"');

					//Buscar el proyecto
					$proyecto=$this->obtenerProyecto($exploded[0]);
					//Datos del proyecto
					$proyecto->nombre=$exploded[1];
					if($proyecto->save())
					{
						
						//Buscar la accion
						$accion=$this->obtenerAccion($exploded[2]);
						
						//Datos de la accion
						$accion->accion=$exploded[3];
						$accion->codigo_proyecto=$proyecto->codigo;

						if($accion->save())
						{							
							//Buscar la unidad ejecutora
							$uel=$this->obtenerUEL($exploded[4]);
							//Datos de la unidad
							$uel->denominacion=$exploded[5];
							if($uel->save())
							{
								//Buscar la relacion accion-unidad ejecutora
								$aue=$this->obtenerAUE($accion->codigo,$uel->codigo);
								if($aue->save())
								{
									$exito++; //exito
								}
								else
								{
									print_r($aue->getErrors()); //fallo
									print "Línea: ".$key;
								}
							}
							else
							{
								print_r($uel->getErrors()); //fallo
								print "Línea: ".$key;
							}
						}
						else
						{
							print_r($accion->getErrors()); //fallo
							print "Línea: ".$key;
						}
					}
					else
					{
						print_r($proyecto->getErrors()); //fallo
						print "Línea: ".$key;
					}
				}
				
			}
		}

		$this->render('proyectoAccion',array(
			'modelo'=>$modelo,
			'exito'=>$exito
		));
	}
	
	/**
	 * Buscar un proyecto, si no existe crear un modelo nuevo sino,
	 * devolver el modelo encontrado
	 * @param  string $codigo_sne
	 * @return mixed $proyecto
	 */
	function obtenerProyecto($codigo_sne)
	{
		$proyecto=Proyecto::model()->findByAttributes(array('codigo_sne'=>$codigo_sne));

		if($proyecto==null || $proyecto=='')
		{
			$proyecto=new Proyecto;
			$proyecto->codigo_sne=$codigo_sne;
		}

		return $proyecto;
	}
	/**
	 * Buscar una accion, si no existe crear un modelo nuevo sino,
	 * devolver el modelo encontrado
	 * @param string $codigo_accion
	 * @return mixed $accion
	 */
	function obtenerAccion($codigo_accion)
	{
		$accion=Acciones::model()->findByAttributes(array('codigo_accion'=>$codigo_accion));

		if($accion==null || $accion=='')
		{
			$accion=new Acciones;
			$accion->codigo_accion=$codigo_accion;
		}

		return $accion;
	}

	/**
	 * Buscar la unidad ejecutora local, si no existe crear un modelo nuevo sino,
	 * devolver el modelo encontrado.
	 * @param string $codigo_uel
	 * @return mixed $uel
	 */
	function obtenerUEL($codigo_uel)
	{
		$uel=UnidadEjecutora::model()->findByAttributes(array('codigo_uel'=>$codigo_uel));

		if($uel==null || $uel=='')
		{
			$uel=new UnidadEjecutora;
			$uel->codigo_uel=$codigo_uel;
		}

		return $uel;
	}

	/**
	 * Buscar la relacion accion-unidad ejecutora, si no existe crear un modelo nuevo sino,
	 * devolver el modelo encontrado.
	 * @param int $codigo_accion el codigo de la accion
	 * @param int $codigo_ue el codigo de la unidad ejecutora
	 * @return mixed $uel
	 */
	function obtenerAUE($codigo_accion,$codigo_ue)
	{
		$aue=AccionUe::model()->findByAttributes(array('codigo_accion'=>$codigo_accion, 'codigo_ue'=>$codigo_ue));

		if($aue==null || $aue=='')
		{
			$aue=new AccionUe;
			$aue->codigo_accion=$codigo_accion;
			$aue->codigo_ue=$codigo_ue;
		}

		return $aue;
	}

	/**
	 * Para registrar una base de datos
	 */
	public function actionRegistrarBd()
	{
		//path
		$path = './protected/respaldos/db.json';
		//El archivo 
		$archivo=json_decode(file_get_contents($path),true);

		if(isset($_POST['base_datos']))
		{			
			$bd = $_POST['base_datos'];

			foreach ($bd as $key => $value)
			{
				foreach(array_keys($archivo, $value) as $llave)
				{
					try
					{
						unset($archivo[$llave]);
					}
					catch( Exception $e)
					{
						print $e;
						exit;
					}
				}				
			}
			
			try
			{
				file_put_contents($path, json_encode($archivo));
			}
			catch( Exception $e)
			{
				print $e;
				exit;
			}

		}

		$this->render('registrarBd',array('archivo'=>$archivo));
	}

	public function actionRegistrar()
	{
		//path
		$path = './protected/respaldos/db.json';
		//El archivo 
		$archivo=json_decode(file_get_contents($path),true);

		if(isset($_POST['nombre_base']))
		{
			$nombre=$_POST['nombre_base'];

			$archivo[$nombre]=$nombre;

			try
			{
				file_put_contents($path, json_encode($archivo));
				echo "exito";
			}
			catch( Exception $e)
			{
				print $e;
			}
		}

		$this->renderPartial('_registrar');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		session_unset();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSessionUnset()
	{
		session_unset();
		$this->redirect(Yii::app()->homeUrl);
	}
}