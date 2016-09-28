<?php

class ProyectoController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'reporteTotalPartidas',
					'reporteTotalPartidasExcel',
					'imprimirTotalPartidas',
					'porUeAccion',
					'unidadEjecutora',
				),
				'roles'=>array('2'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'create',
					'update',
					'admin',
					'delete',
					'totalProyectosPorPartida',
					'TotalProyectosPorPartidaSelect',
					'reporteTotalPartidas',
					'imprimirTotalPartidas',
					'imprimirTotalProyectosPorPartida',
					'imprimirTotalProyectosPorPartidaExcel',
					'reportePorUe',
					'porUeAccion',
					'unidadEjecutora',
					'imprimirPorUe',
					'totalProyectoAccionesPorPartida',
					'imprimirTotalProyectoAccionesPorPartida',
					'reporteGeneral',
					'imprimirReporteGeneral',
					'reporteGeneralExcel',
					'generalPartidaSubPartida',
					'generalPartidaSubpartidaPDF',
					'generalPartidaSubpartidaExcel',
					'reporteTrimestral',
					'trimestralPdf',
					'trimestralExcel',
					'generalTrimestral',
					'generalTrimestralExcel',
					'consolidadoProyectosPorPartida',
					'imprimirConsolidadoProyectosPorPartida',
					'imprimirConsolidadoProyectosPorPartidaExcel'
				),
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

		$model=new Proyecto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Proyecto']))
		{
			$model->attributes=$_POST['Proyecto'];
			$historico=new HistoricoProyecto;

			if($model->save())
			{
				$historico->codigo_proyecto=$model->codigo;
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

		if(isset($_POST['Proyecto']))
		{
			$model->attributes=$_POST['Proyecto'];
			$historico=new HistoricoProyecto;
			if($model->save())
			{
				$historico->codigo_proyecto=$model->codigo;
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
			$this->loadModel($id)->delete();

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
		if(Yii::app()->user->checkAccess('1')) //Si es administrador
		{
			$dataProvider=new CActiveDataProvider('Proyecto');
		}
		else //Sino
		{
			$uel=Yii::app()->user->uel;
			//Contador para la paginacion
			$count=Yii::app()->db->createCommand("SELECT COUNT(*) FROM proyecto p, acciones a, accion_ue aue, unidad_ejecutora ue
				WHERE p.codigo=a.codigo_proyecto AND a.codigo=aue.codigo_accion AND aue.codigo_ue=ue.codigo AND ue.codigo=$uel
				AND p.estatus=1
				AND aue.estatus=1
				GROUP BY p.codigo")->queryAll();
			//Query
			$sql="SELECT p.* FROM proyecto p, acciones a, accion_ue aue, unidad_ejecutora ue
				WHERE p.codigo=a.codigo_proyecto AND a.codigo=aue.codigo_accion AND aue.codigo_ue=ue.codigo AND ue.codigo=$uel
				AND p.estatus=1
				AND aue.estatus=1
				GROUP BY p.codigo";
			
			$dataProvider=new CSqlDataProvider($sql,array(
				'totalItemCount'=>count($count),
				'keyField'=>'codigo',
				'sort'=>array(
					'attributes'=>array(
						'codigo'
					)
				),
				'pagination'=>array(
			        'pageSize'=>10,
			    ),
			));
		}

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Proyecto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proyecto']))
			$model->attributes=$_GET['Proyecto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionTotalProyectosPorPartidaSelect()
	{
		//Layout
		$this->layout='//layouts/column1';

		$this->render('_totalProyectosPorPartida');
	}

	/**
	 * Total de los proyectos
	 * por partidas
	 **/
	public function actionTotalProyectosPorPartida($tipo)
	{
		//Layout
		$this->layout='//layouts/column1';

		//Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
	
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		$totalesProyectosAcciones="";
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		$this->render('totalProyectosPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'tipo'=>$tipo,
			'PRYACC'=>$PRYACC
		));
	}

	/**
	 * Imprimir reporte del total de los proyectos
	 * por partida
	 **/
	public function actionImprimirTotalProyectosPorPartida($tipo)
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		//Definir el timezone
		date_default_timezone_set("America/Caracas");
		$mPDF1->SetFooter(date('d/m/Y H:i:s'));
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirTotalProyectosPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'PRYACC'=>$PRYACC
		),true));

		//Imprimir
		$mPDF1->Output('TotalProyectosPorPartida.pdf','D');
	}

	public function actionImprimirTotalProyectosPorPartidaExcel($tipo)
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "2048M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes

		 //Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
	
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		$this->renderPartial('_totalProyectosPorPartidaExcel',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'tipo'=>$tipo,
			'PRYACC'=>$PRYACC
		));
	}

	/**
	 * Consolidado por partidas
	 * @param  int $tipo
	 * @return  mixed
	 **/
	public function actionConsolidadoProyectosPorPartida($tipo)
	{
		//Layout
		$this->layout='//layouts/column1';

		//Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
	
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		$this->render('consolidadoProyectosPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'tipo'=>$tipo,
			'PRYACC'=>$PRYACC
		));
	}

	/**
	 * Imprimir reporte consolidado de los proyectos por partida
	 * @param int $tipo
	 **/
	public function actionImprimirConsolidadoProyectosPorPartida($tipo)
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		//Definir el timezone
		date_default_timezone_set("America/Caracas");
		$mPDF1->SetFooter(date('d/m/Y H:i:s'));
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirConsolidadoProyectosPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'PRYACC'=>$PRYACC
		),true));

		//Imprimir
		$mPDF1->Output('TotalProyectosPorPartida.pdf','D');
	}

	/**
	 * Imprimir reporte excel consolidado de los proyectos por partida
	 * @param  int $tipo
	 * @return mixed
	 */
	public function actionImprimirConsolidadoProyectosPorPartidaExcel($tipo)
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "2048M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes

		 //Variable para filtrar la busqueda
		switch ($tipo) 
		{
			case 1:
				$q = '%'; //todos
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
			case 2:
				$q = 'P%'; //proyectos
				$PRYACC = 'Proyectos';
				break;
			case 3:
				$q = 'A%'; //acciones centralizadas
				$PRYACC = 'Acciones Centralizadas';
				break;
			default:
				$q = '%';
				$PRYACC = 'Proyectos y Acciones Centralizadas';
				break;
		}
	
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll(array(
			'condition'=>'codigo_sne LIKE :q',
			'params'=>array(':q'=>$q),
			'order'=>'codigo_sne'
		));
		//Total de los proyectos
		$totalProyectos=0.00;
		//
		$pP=array();
		$iva=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$pP[$valor->codigo]=$this->partidaGeneralPorProyecto($valor->codigo);

			//IVA del proyecto
			$iva[$valor->codigo]=$this->devolverIvaProyecto($valor->codigo);			

			//Totales
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		$this->renderPartial('_consolidadoProyectosPorPartidaExcel',array(
			'totalProyectos'=>$totalProyectos,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
			'tipo'=>$tipo,
			'PRYACC'=>$PRYACC
		));
	}

	/**
	 * Total de los proyectos y acciones
	 * por partida
	 **/	
	public function actionTotalProyectoAccionesPorPartida()
	{
		//Layout
		$this->layout='//layouts/column1';
	
		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll();
		//Total de los proyectos
		$totalProyectos=0.00;
		//Variables para sumar y contar
		$pP=array();
		$iva=array();
		$totalAccion=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$valor->codigo));

			foreach($acciones as $key => $accion)
			{
				//Partidas Generales por accion
				$pP[$accion->codigo]=$this->partidaGeneralPorAccion($accion->codigo,$valor->codigo);

				//IVA del proyecto
				$iva[$accion->codigo]=$this->devolverIvaAccion($accion->codigo);
			}						

			//Total del proyecto
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			//Total de la accion
			$totalAccion[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			//Total de todo
			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		$this->render('totalProyectoAccionesPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalAccion'=>$totalAccion,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
		));
	}

	/**
	 * Imprimir total de los proyectos y acciones
	 * por partida
	 **/
	public function actionImprimirTotalProyectoAccionesPorPartida()
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Lista de proyectos
		$proyectos=Proyecto::model()->findAll();
		//Total de los proyectos
		$totalProyectos=0.00;
		//Variables para sumar y contar
		$pP=array();
		$iva=array();
		$totalAccion=array();

		//Por cada proyecto
		foreach($proyectos as $llave => $valor)
		{
			$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$valor->codigo));

			foreach($acciones as $key => $accion)
			{
				//Partidas Generales por accion
				$pP[$accion->codigo]=$this->partidaGeneralPorAccion($accion->codigo,$valor->codigo);

				//IVA del proyecto
				$iva[$accion->codigo]=$this->devolverIvaAccion($accion->codigo);
			}						

			//Total del proyecto
			$totalesProyectosAcciones[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			//Total de la accion
			$totalAccion[$valor->codigo]=$this->totalProyectoAcciones($valor->codigo);

			//Total de todo
			$totalProyectos=$totalProyectos+$totalesProyectosAcciones[$valor->codigo]['proyecto'];
		}

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirTotalProyectoAccionesPorPartida',array(
			'totalProyectos'=>$totalProyectos,
			'totalAccion'=>$totalAccion,
			'totalesProyectosAcciones'=>$totalesProyectosAcciones,
			'proyectos'=>$proyectos,
			'pP'=>$pP,
			'iva'=>$iva,
		),true));

		//Imprimir
		$mPDF1->Output('TotalProyectoAccionesPorPartida.pdf','D');
	}

	/**
	 * El total del proyecto, sus acciones
	 * y el total por partida en cada accion
	 * @param int $proyecto codigo del proyecto
	 **/
	public function actionReporteTotalPartidas($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';
		//Instancia del proyecto
		$pro=Proyecto::model()->findByPk($proyecto);
		//Acciones del proyecto
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto));
		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$pro['codigo']]=$this->totalProyectoAcciones($proyecto);

		//Inicializar variables
		$partidaAccion=array();
		$partidaGeneral=array();

		//IVA
		$iva=array();

		$ue=Yii::app()->user->uel;

		foreach($acciones as $llave => $accion)
		{
			$partidaAccion[$accion['codigo']]=$this->devolverTotalPartidas($accion['codigo'],$ue);

			foreach($partidaAccion[$accion['codigo']] as $i => $j)
			{
				$partida=$j['imputacion_presupuestaria'];
				$partida=$partida[0].$partida[1].$partida[2];
				$partidaGeneral[$accion['codigo']][$i]=$this->devolverTotalPartidaPrincipal($accion['codigo'],$partida,$ue);
			}

			//El IVA
			$iva[$accion['codigo']]=$this->devolverIva($accion['codigo'],$ue);
		}

		//Unidad Ejecutora
		$unidadEjecutora=UnidadEjecutora::model()->findByPk($ue);


		//La vista
		$this->render('reporteTotalPartidas',array(
			'proyecto'=>$pro,
			'acciones'=>$acciones,
			'totalesProyectosAcciones'=>$totalProyectoAcciones,
			'partidaAccion'=>$partidaAccion,
			'partidaGeneral'=>$partidaGeneral,
			'ue'=>$unidadEjecutora,
			'iva'=>$iva,
		));

	}

	public function actionReporteTotalPartidasExcel($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';
		//Instancia del proyecto
		$pro=Proyecto::model()->findByPk($proyecto);
		//Acciones del proyecto
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto));
		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$pro['codigo']]=$this->totalProyectoAcciones($proyecto);

		//Inicializar variables
		$partidaAccion=array();
		$partidaGeneral=array();

		//IVA
		$iva=array();

		$ue=Yii::app()->user->uel;

		foreach($acciones as $llave => $accion)
		{
			$partidaAccion[$accion['codigo']]=$this->devolverTotalPartidas($accion['codigo'],$ue);

			foreach($partidaAccion[$accion['codigo']] as $i => $j)
			{
				$partida=$j['imputacion_presupuestaria'];
				$partida=$partida[0].$partida[1].$partida[2];
				$partidaGeneral[$accion['codigo']][$i]=$this->devolverTotalPartidaPrincipal($accion['codigo'],$partida,$ue);
			}

			//El IVA
			$iva[$accion['codigo']]=$this->devolverIva($accion['codigo'],$ue);
		}

		//Unidad Ejecutora
		$unidadEjecutora=UnidadEjecutora::model()->findByPk($ue);


		//La vista
		$this->renderPartial('reporteTotalPartidasExcel',array(
			'proyecto'=>$pro,
			'acciones'=>$acciones,
			'totalesProyectosAcciones'=>$totalProyectoAcciones,
			'partidaAccion'=>$partidaAccion,
			'partidaGeneral'=>$partidaGeneral,
			'ue'=>$unidadEjecutora,
			'iva'=>$iva,
		));

	}

	/**
	 * El total del proyecto, sus acciones
	 * y el total por partida en cada accion
	 * y por unidad ejecutora
	 * @param int $proyecto codigo del proyecto
	 */

	public function actionReportePorUe($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';
		//Instancia del proyecto
		$pro=Proyecto::model()->findByPk($proyecto);
		//Acciones del proyecto
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto));

		//Total del proyecto
		$totalProyecto=$this->totalProyectoAcciones($proyecto);

		//La vista
		$this->render('reportePorUe',array(
			'proyecto'=>$pro,
			'acciones'=>$acciones,
			'totalProyecto'=>$totalProyecto
		));

	}

	/**
	 * El total de la accion por unidad ejecutora
	 * @param int $proyecto codigo del proyecto
	 */

	public function actionPorUeAccion($proyecto)
	{
		if(isset($_POST['unidad_ejecutora']) && !empty($_POST['unidad_ejecutora']))
		{
			//Unidad Ejecutora
			$ue=$_POST['unidad_ejecutora'];
			//Accion
			$acc=$_POST['accion'];
			//Arreglo con los totales por accion
			$totalProyectoAcciones=array();

			//Instancia del modelo Acciones
			$accion=Acciones::model()->findByPk($acc);
			
			$totalProyectoAcciones=$this->totalProyectoAcciones($proyecto);

			$partidaAccion=array();
			$partidaGeneral=array();

			$partidaAccion[$accion['codigo']]=$this->devolverTotalPartidas($accion['codigo'],$ue);

			foreach($partidaAccion[$accion['codigo']] as $i => $j)
			{
				$partida=$j['imputacion_presupuestaria'];
				$partida=$partida[0].$partida[1].$partida[2];
				$partidaGeneral[$accion['codigo']][$i]=$this->devolverTotalPartidaPrincipal($accion['codigo'],$partida,$ue);
			}

			//El IVA
			$iva[$accion['codigo']]=$this->devolverIva($accion['codigo'],$ue);			

			$this->renderPartial('_porUeAccion',array(
				'proyecto'=>$proyecto,
				'accion'=>$accion,
				'partidaAccion'=>$partidaAccion,
				'totalProyectoAcciones'=>$totalProyectoAcciones,
				'partidaGeneral'=>$partidaGeneral,
				'iva'=>$iva
			),false,true);
		}
		else
		{
			//Nada
		}

	}

	/**
	 * Devuelve un arreglo con los totales
	 * por cada accion y el total del proyecto
	 * @param array $proyecto codigo del proyecto
	 * @return array $totales
	 */
	public function totalProyectoAcciones($proyecto)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		//Totales de las acciones
		$totales=array('proyecto'=>'','acciones'=>array());

		//Total del proyecto
		$totalProyecto=0.00;

		//Acciones del proyecto
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto));

		//Por cada accion
		foreach($acciones as $llave => $valor)
		{
			//Query
			$totales['acciones'][$valor->codigo]=$row->select('SUM(ROUND(total)) as total') //La cantidad está redondeada
			->from('reporte r, accion_ue aue')
			->where('aue.codigo_accion=:accion AND r.accion_ue=aue.codigo AND r.estatus=1', array(':accion'=>$valor->codigo))
			->queryRow();

			//Sumar para totalizar
			$totalProyecto=$totalProyecto+$totales['acciones'][$valor->codigo]['total'];
		}

		//Agregar el total del proyecto al arreglo
		$totales['proyecto']=$totalProyecto;

		return $totales;
	}

	/**
	 * Total de las partidas generales
	 * por proyecto
	 * @return array $partidaGeneralProyecto
	 */
	public function partidaGeneralPorProyecto($proyecto)
	{

		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$partidaGeneralProyecto=$row->select('imputacion_presupuestaria, SUM(ROUND(sub_total)) as total')
			->from('reporte r, proyecto p, accion_ue aue, acciones a')
			->where('r.estatus=1 AND
				 	r.accion_ue = aue.codigo AND 
				 	aue.codigo_accion=a.codigo AND
				 	a.codigo_proyecto=p.codigo AND
				 	p.codigo='.$proyecto)
			->group('imputacion_presupuestaria')
			->queryAll();

		return $partidaGeneralProyecto;
	}

	/**
	 * Total de las partidas generales
	 * por accion
	 * @return array $partidaGeneralAccion
	 */
	public function partidaGeneralPorAccion($accion,$proyecto)
	{

		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$partidaGeneralAccion=$row->select('imputacion_presupuestaria, SUM(ROUND(sub_total)) as total')
			->from('reporte r, proyecto p, accion_ue aue, acciones a')
			->where('r.estatus=1 AND
				 	r.accion_ue = aue.codigo AND 
				 	aue.codigo_accion=a.codigo AND
				 	a.codigo_proyecto=.p.codigo AND
				 	p.codigo='.$proyecto.' AND
				 	a.codigo='.$accion)
			->group('imputacion_presupuestaria')
			->queryAll();

		return $partidaGeneralAccion;
	}

	/**
	 * Total general que muestra los totales por partida
	 * y subpartida.
	 */
	public function actionGeneralPartidaSubPartida()
	{
		//Layout
		$this->layout='//layouts/column1';
		//Proyectos y ACC
		$proyectos=Proyecto::model()->findAll();
		//Acciones
		$acciones=Acciones::model()->findAll();
		//Accion_UnidadEjecutora
		$aue=AccionUe::model()->findAllByAttributes(array('estatus'=>1));
		//Total general
		$totalGeneral=$this->devolverTotalGeneral();
		//Total de cada subpartida
		$totalSubpartidas=$this->devolverTotalSubpartida();
		//Total partida
		foreach ($this->listarPartidas() as $key => $value)
		{
			$totalPartida[$value['partida']]=Reporte::model()->findBySql(
				'SELECT SUM(ROUND(r.sub_total)) AS total FROM reporte r WHERE estatus = :estatus AND r.imputacion_presupuestaria LIKE "'.$value['partida'].'%"', 
				array(':estatus'=>1)
			);
		}
		//IVA
		$iva=Reporte::model()->findBySql(
			'SELECT SUM(ROUND(total_iva)) AS iva FROM `reporte` WHERE estatus = :estatus', 
			array(':estatus'=>1)
		);	
		

		$this->render('generalPartidaSubpartida',array(
			'proyectos'=>$proyectos,
			'acciones'=>$acciones,
			'totalGeneral'=>$totalGeneral,
			'totalPartida'=>$totalPartida,
			'totalSubpartidas'=>$totalSubpartidas,
			'iva'=>$iva
		));
	}

	/*
	 * Imprimir PDF del total general que muestra los totales por partida
	 * y subpartida.
	 */
	public function actionGeneralPartidaSubpartidaPDF()
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "2048M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes

		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		/* Se calcula el reporte */
		//Proyectos y ACC
		$proyectos=Proyecto::model()->findAll();
		//Acciones
		$acciones=Acciones::model()->findAll();
		//Accion_UnidadEjecutora
		$aue=AccionUe::model()->findAllByAttributes(array('estatus'=>1));
		//Total general
		$totalGeneral=$this->devolverTotalGeneral();
		//Total de cada subpartida
		$totalSubpartidas=$this->devolverTotalSubpartida();
		//Total partida
		foreach ($this->listarPartidas() as $key => $value)
		{
			$totalPartida[$value['partida']]=Reporte::model()->findBySql(
				'SELECT SUM(ROUND(r.sub_total)) AS total FROM reporte r WHERE estatus = :estatus AND r.imputacion_presupuestaria LIKE "'.$value['partida'].'%"', 
				array(':estatus'=>1)
			);
		}
		//IVA
		$iva=Reporte::model()->findBySql(
			'SELECT SUM(ROUND(total_iva)) AS iva FROM `reporte` WHERE estatus = :estatus', 
			array(':estatus'=>1)
		);	

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('generalPartidaSubpartidaPDF',array(
			'proyectos'=>$proyectos,
			'acciones'=>$acciones,
			'totalGeneral'=>$totalGeneral,
			'totalPartida'=>$totalPartida,
			'totalSubpartidas'=>$totalSubpartidas,
			'iva'=>$iva
		),true));

		//Imprimir
		$mPDF1->Output('GeneralPartidasSubpartidas.pdf','D');
	}

	/*
	 * Imprimir Hoja de calculo del total general que muestra los totales por partida
	 * y subpartida.
	 */
	public function actionGeneralPartidaSubpartidaExcel()
	{
		//Proyectos y ACC
		$proyectos=Proyecto::model()->findAll();
		//Acciones
		$acciones=Acciones::model()->findAll();
		//Accion_UnidadEjecutora
		$aue=AccionUe::model()->findAllByAttributes(array('estatus'=>1));
		//Total general
		$totalGeneral=$this->devolverTotalGeneral();
		//Total de cada subpartida
		$totalSubpartidas=$this->devolverTotalSubpartida();
		//Total partida
		foreach ($this->listarPartidas() as $key => $value)
		{
			$totalPartida[$value['partida']]=Reporte::model()->findBySql(
				'SELECT SUM(ROUND(r.sub_total)) AS total FROM reporte r WHERE estatus = :estatus AND r.imputacion_presupuestaria LIKE "'.$value['partida'].'%"', 
				array(':estatus'=>1)
			);
		}
		//IVA
		$iva=Reporte::model()->findBySql(
			'SELECT SUM(ROUND(total_iva)) AS iva FROM `reporte` WHERE estatus = :estatus', 
			array(':estatus'=>1)
		);

		$this->renderPartial('generalPartidaSubpartidaExcel',array(
			'proyectos'=>$proyectos,
			'acciones'=>$acciones,
			'totalGeneral'=>$totalGeneral,
			'totalPartida'=>$totalPartida,
			'totalSubpartidas'=>$totalSubpartidas,
			'iva'=>$iva
		));
	}

	/**
	 * Total de material/servicio por trimestre y partida
	 * @param int $proyecto
	 */
	public function actionReporteTrimestral($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';
		//Proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);
		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));
		
		//Montos trimestrales
		$trimestral=$this->devolverTrimestral($acciones);
		//Iva trimestral
		$iva=$this->devolverTrimestralIva($acciones);
		//La vista
		$this->render('trimestral',array('proyecto'=>$proyecto,'trimestral'=>$trimestral,'iva'=>$iva));
	}

	/**
	 * PDF del reporte trimestral
	 */
	public function actionTrimestralPdf($proyecto)
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		/* BD query */
		//Proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);
		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));
		
		//Montos trimestrales
		$trimestral=$this->devolverTrimestral($acciones);
		//Iva trimestral
		$iva=$this->devolverTrimestralIva($acciones);

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_trimestralPdf',array(
			'trimestral'=>$trimestral,
			'iva'=>$iva,
			'proyecto'=>$proyecto
		),true));

		//Imprimir
		$mPDF1->Output('Trimestral.pdf','D');
	}

	public function actionTrimestralExcel($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';
		//Proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);
		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));
		
		//Montos trimestrales
		$trimestral=$this->devolverTrimestral($acciones);
		//Iva trimestral
		$iva=$this->devolverTrimestralIva($acciones);
		//La vista
		$this->renderPartial('_trimestralExcel',array('proyecto'=>$proyecto,'trimestral'=>$trimestral,'iva'=>$iva));
	}

	public function actionGeneralTrimestral()
	{
		//Layout
		$this->layout='//layouts/column1';
		//Proyecto
		$proyectos=Proyecto::model()->findAll();		
		//La vista
		$this->render('generalTrimestral',array('proyectos'=>$proyectos));
	}

	public function actionGeneralTrimestralExcel()
	{
		//Layout
		$this->layout='//layouts/column1';
		//Proyecto
		$proyectos=Proyecto::model()->findAll();		
		//La vista
		$this->renderPartial('generalTrimestralExcel',array('proyectos'=>$proyectos));
	}

	/**
	 * Calcular y devolver los montos por trimestre de cada accion
	 * @param array $acciones acciones del proyecto
	 * @return array $trimestral
	 */
	public function devolverTrimestral($acciones)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		//Arreglo para almacenar el resultado del query
		$trimestral=array();

		foreach ($acciones as $key => $value)
		{
			//$value->codigo=accion.codigo
			$trimestral[$value->codigo]=$row->select("a.codigo, a.codigo_accion, a.accion, p.partida, p.descripcion,
		 						SUM(r.trim_i*precio_unitario) AS trim_i, 
		 						SUM(r.trim_ii*precio_unitario) AS trim_ii, 
		 						SUM(r.trim_iii*precio_unitario) AS trim_iii, 
		 						SUM(r.trim_iv*precio_unitario) AS trim_iv, 
		 						SUM(r.trim_i*precio_unitario + r.trim_ii*precio_unitario + r.trim_iii*precio_unitario + r.trim_iv*precio_unitario) AS total")
			->from("reporte r, subpartida sp, materiales_servicios ms, partida p, accion_ue aue, acciones a")
			->where("r.material_servicio=ms.codigo AND ms.subpartida=sp.codigo AND sp.partida=p.partida AND 
					r.accion_ue=aue.codigo AND aue.codigo_accion=a.codigo AND a.codigo=:accion", array(":accion"=>$value->codigo))
			->group("sp.partida")
			->order("sp.partida")
			->queryAll();
		}

		/* La partida 403 debe incluirse para colocar el IVA,
		 * si el query no devuelve ningun registro con dicha partida
		 * hay que agregarla con valores en 0 para sumarle el IVA posteriormente 
		 */

		//Operador logico para verificar
		$boolPartida=false;		

		foreach ($trimestral as $key => &$accion)
		{
			foreach($accion as $valor)
			{
				//Buscar la partida 403
				$boolPartida= $boolPartida || $this->in_array_r('403',$valor)? 1:0;
			}

			
			//Si la accion no posee 403 incluirla
			if(!$boolPartida)
			{	
				//PHP 5.3
				if(empty($valor))
				{
					$valor['codigo_accion']=''; $valor['accion']=""; 
				}

				$v=array();
				$v['codigo_accion']=$valor['codigo_accion'];
				$v['accion']=$valor['accion'];
				$v['partida']='403';
				$v['descripcion']='Servicios no Personales';
				$v['trim_i']=0; //Montos en 0
				$v['trim_ii']=0;
				$v['trim_iii']=0;
				$v['trim_iv']=0;
				$v['total']=0;

				//Agregar a la accion
				$accion[] = $v;
				//Reordenar el arreglo
				usort($accion, function($a, $b) {
				    return $a['partida'] - $b['partida'];
				});
			}

			//Reiniciar el operador logico
			$boolPartida=false;
			
		}


		//devolver los montos trimestrales
		return $trimestral;
	}

	/**
	 * Calcular y devolver el iva por trimestre de cada accion
	 * @param array $acciones acciones del proyecto
	 * @return array $iva 
	 */
	function devolverTrimestralIva($acciones)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		//Arreglo para almacenar el resultado del query
		$iva=array();

		foreach ($acciones as $key => $value)
		{
			//$value->codigo=accion.codigo
			$iva[$value->codigo]=$row->select("ROUND(SUM(((r.trim_i*r.precio_unitario)/100)*r.iva)) AS iva_trim_i,
					ROUND(SUM(((r.trim_ii*r.precio_unitario)/100)*r.iva)) AS iva_trim_ii,
					ROUND(SUM(((r.trim_iii*r.precio_unitario)/100)*r.iva)) AS iva_trim_iii,
					ROUND(SUM(((r.trim_iv*r.precio_unitario)/100)*r.iva)) AS iva_trim_iv,
					ROUND(SUM((r.sub_total/100)*r.iva)) AS iva_total")
			->from("reporte r, accion_ue aue, acciones a")
			->where("r.accion_ue=aue.codigo AND aue.codigo_accion=a.codigo AND a.codigo=:accion", array(":accion"=>$value->codigo))
			->queryRow();
		}

		//Devolver el iva calculado
		return $iva;
	}

	/**
	 * El total general.
	 */
	public function devolverTotalGeneral()
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$total=$row->select('(SUM(ROUND(sub_total))+SUM(ROUND(total_iva))) as total')
			->from('reporte r')
			->where('r.estatus=1')
			->queryRow();

		return $total['total'];
	}

	/**
	 * El total de cada subpartida
	 * @return  array
	 */
	public function devolverTotalSubpartida()
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$total=$row->select('r.imputacion_presupuestaria, sp.descripcion AS descripcion, SUM(ROUND(r.total)) AS total')
			->from('reporte r, materiales_servicios ms, subpartida sp')
			->where('r.material_servicio = ms.codigo AND ms.subpartida = sp.codigo AND r.estatus=1')
			->group('sp.descripcion')
			->order('r.imputacion_presupuestaria')
			->queryAll();

		/* Agregar las partidas principales que el query no devuelve */
		$partidas=$this->listarPartidas();

		foreach ($partidas as $key => $partida)
		{
			$total[]=array(
				'imputacion_presupuestaria'=>$partida['partida'].'000000',
				'descripcion'=>'',
				'total'=>0
			);

			//Reordenar el arreglo
			usort($total, function($a, $b) {
			    return $a['imputacion_presupuestaria'] - $b['imputacion_presupuestaria'];
			});
		}		

		/* La partida 403 debe incluirse para colocar el IVA,
		 * si el query no devuelve ningun registro con dicha partida
		 * hay que agregarla con valores en 0 para sumarle el IVA posteriormente 
		 */

		//Operador logico para verificar
		$boolPartida=false;		

		foreach ($total as $key => &$value)
		{
			foreach($total as $valor)
			{
				//Buscar la partida 403
				$boolPartida= $boolPartida || $this->in_array_r('403180100',$valor)? 1:0;
			}
			
			//Si la accion no posee 403 incluirla
			if(!$boolPartida)
			{
				$v=array();
				$v['imputacion_presupuestaria']='403180100';
				$v['descripcion']='Impuesto al Valor Agregado';
				$v['total']=0; //Montos en 0

				//Agregar a la accion
				$total[] = $v;
				//Reordenar el arreglo
				usort($total, function($a, $b) {
				    return $a['imputacion_presupuestaria'] - $b['imputacion_presupuestaria'];
				});
			}

			//Reiniciar el operador logico
			$boolPartida=false;
			
		}

		return $total;
	}

	/*
	 * Obtener una lista con las partidas utilizadas.
	 */
	function listarPartidas()
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		//obtener las partidas
		$partidas=$row->select('sp.partida AS partida')
			->from('reporte r, materiales_servicios ms, subpartida sp')
			->where('r.material_servicio = ms.codigo AND ms.subpartida = sp.codigo')
			->group('sp.partida')
			->order('sp.partida')
			->queryAll();

		return $partidas;
	}

	/**
	 * Para obtener las partidas y el total de cada una por unidad ejecutora
	 * @param int $accion codigo de la accion
	 * @return array $total arreglo con imputacion presupuestaria y  el total
	 */
	public function devolverTotalPartidas($accion,$ue)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		/*
		//El codigo de la partida
		$codigoPartida=$partida[0].$partida[1].$partida[2];
		//Arreglo con las subpartidas
		$subpartida=str_split(substr($partida, 3),2);
		*/


		$total=$row->select('imputacion_presupuestaria, SUM(ROUND(sub_total)) as total')
			->from('reporte r, accion_ue aue')
			->where('aue.codigo_accion=:accion AND r.accion_ue=aue.codigo AND aue.codigo_ue=:ue AND r.estatus=1', array(
				':accion'=>$accion,
				':ue'=>$ue))
			->group('imputacion_presupuestaria')
			->queryAll();

		return $total;
	}

	public function devolverTotalPartidaPrincipal($accion,$partida,$ue)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();


		$total=$row->select('imputacion_presupuestaria, SUM(ROUND(sub_total)) as total')
			->from('reporte r, accion_ue aue')
			->where('aue.codigo_accion='.$accion.' AND r.accion_ue=aue.codigo AND r.estatus=1 AND aue.codigo_ue='.$ue.' AND r.imputacion_presupuestaria LIKE "'.$partida.'%"')
			->queryRow();

		return $total;
	}

	/**
	 * Devuelve el IVA total
	 * @param int $accion codigo de la accion
	 * @param int $ue codigo de la unidad ejecutora
	 * @return decimal $iva total del iva
	 */
	public function devolverIva($accion,$ue)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$iva=$row->select('SUM(ROUND(total_iva)) as iva')
			->from('reporte r, accion_ue aue')
			->where('aue.codigo_accion='.$accion.' AND r.accion_ue=aue.codigo AND r.estatus=1 AND aue.codigo_ue='.$ue.'')
			->queryRow();

		return $iva;

	}

	/**
	 * Devuelve el IVA por proyecto
	 * @param int $proyecto codigo del proyecto
	 * @return decimal $iva total del iva
	 */
	public function devolverIvaProyecto($proyecto)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$iva=$row->select('SUM(ROUND(total_iva)) as iva')
			->from('reporte r, accion_ue aue, acciones a, proyecto p')
			->where('r.estatus=1 AND r.accion_ue=aue.codigo AND aue.codigo_accion=a.codigo AND a.codigo_proyecto = p.codigo AND p.codigo ='.$proyecto)
			->queryRow();

		return $iva;
	}

	/**
	 * Devuelve el IVA por accion
	 * @param int $accion codigo de la accion
	 * @return decimal $iva total del iva
	 */
	public function devolverIvaAccion($accion)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		$iva=$row->select('SUM(ROUND(total_iva)) as iva')
			->from('reporte r, accion_ue aue, acciones a')
			->where('r.estatus=1 AND r.accion_ue=aue.codigo AND aue.codigo_accion=a.codigo AND a.codigo='.$accion)
			->queryRow();

		return $iva;
	}

	/**
	 * Imprime el reporte de un usuario (sus acciones asociadas, partidas, proyecto, etc)
	 */
	public function actionImprimirTotalPartidas()
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Codigo del proyecto
		$proyecto=$_POST['proyecto'];

		//Instancia del proyecto
		$pro=Proyecto::model()->findByPk($proyecto);
		//Acciones del proyecto
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto));
		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$pro['codigo']]=$this->totalProyectoAcciones($proyecto);

		//Inicializar variables
		$partidaAccion=array();
		$partidaGeneral=array();

		//IVA
		$iva=array();

		$ue=Yii::app()->user->uel;

		foreach($acciones as $llave => $accion)
		{
			$partidaAccion[$accion['codigo']]=$this->devolverTotalPartidas($accion['codigo'],$ue);

			foreach($partidaAccion[$accion['codigo']] as $i => $j)
			{
				$partida=$j['imputacion_presupuestaria'];
				$partida=$partida[0].$partida[1].$partida[2];
				$partidaGeneral[$accion['codigo']][$i]=$this->devolverTotalPartidaPrincipal($accion['codigo'],$partida,$ue);
			}

			//El IVA
			$iva[$accion['codigo']]=$this->devolverIva($accion['codigo'],$ue);
		}

		//Unidad Ejecutora
		$unidadEjecutora=UnidadEjecutora::model()->findByPk($ue);
		
		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirTotalPartidas',array(
			'proyecto'=>$pro,
			'acciones'=>$acciones,
			'totalesProyectosAcciones'=>$totalProyectoAcciones,
			'partidaAccion'=>$partidaAccion,
			'partidaGeneral'=>$partidaGeneral,
			'ue'=>$unidadEjecutora,
			'iva'=>$iva,
		),true));

		//Imprimir
		$mPDF1->Output('TotalPartidas.pdf','D');

	}

	/**
	 * Imprime el reporte total por unidad ejecutora seleccionada
	 */
	public function actionImprimirPorUe($proyecto)
	{
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		if(isset($_POST['unidad_ejecutora']) && !empty($_POST['unidad_ejecutora']))
		{
			//Proyecto
			$proyecto=Proyecto::model()->findByPk($proyecto);
			//Unidad Ejecutora
			$ue=UnidadEjecutora::model()->findByPk($_POST['unidad_ejecutora']);
			//Accion
			$acc=$_POST['accion'];
			//Arreglo con los totales por accion
			$totalProyectoAcciones=array();

			//Instancia del modelo Acciones
			$accion=Acciones::model()->findByPk($acc);
			
			$totalProyectoAcciones=$this->totalProyectoAcciones($proyecto->codigo);

			$partidaAccion=array();
			$partidaGeneral=array();

			$partidaAccion[$accion['codigo']]=$this->devolverTotalPartidas($accion['codigo'],$ue->codigo);

			foreach($partidaAccion[$accion['codigo']] as $i => $j)
			{
				$partida=$j['imputacion_presupuestaria'];
				$partida=$partida[0].$partida[1].$partida[2];
				$partidaGeneral[$accion['codigo']][$i]=$this->devolverTotalPartidaPrincipal($accion['codigo'],$partida,$ue->codigo);
			}

		}

		//El IVA
		$iva[$accion['codigo']]=$this->devolverIva($accion['codigo'],$ue->codigo);

		//Pagina completa
		$mPDF1->WriteHTML($this->renderPartial('_imprimirPorUe',array(
			'proyecto'=>$proyecto,
			'accion'=>$accion,
			'ue'=>$ue,
			'partidaAccion'=>$partidaAccion,
			'totalProyectoAcciones'=>$totalProyectoAcciones,
			'partidaGeneral'=>$partidaGeneral,
			'iva'=>$iva
		),true));

		//Imprimir
		$mPDF1->Output('PorUE.pdf','D');
	}

	/**
	 * Imprimir proyecto, acciones, unidades ejecutoras y
	 * registros asociados
	 * @param int $proyecto codigo del proyecto
	 */
	public function actionReporteGeneral($proyecto)
	{
		//Layout
		$this->layout='//layouts/column1';

		//Instancia del proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);

		//Total del proyecto
		$totalProyecto=$this->totalProyectoAcciones($proyecto->codigo);

		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));

		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$proyecto->codigo]=$this->totalProyectoAcciones($proyecto->codigo);

		//Arreglo para Accion_Ue
		$aue=array();

		//Arreglo para registros
		$registros=array();

		foreach($acciones as $key => $accion)
		{
			//Relacion Unidad Ejecutora - Accion
			$aue[$accion->codigo]=AccionUe::model()->findAllByAttributes(array('codigo_accion'=>$accion->codigo));

			//Registros
			$registros[$accion->codigo]=$this->registrosPorAccion($accion->codigo);

		}		

		$this->render('general', array(
			'proyecto'=>$proyecto,
			'acciones'=>$acciones,
			'totalProyecto'=>$totalProyecto,
			'totalProyectoAcciones'=>$totalProyectoAcciones,
			'aue'=>$aue,
			'registros'=>$registros,
		));
	}

	public function actionImprimirReporteGeneral($proyecto,$accion)
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "2048M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		 
		//mPDF
		$mPDF1 = Yii::app()->ePdf->mpdf();

		$mPDF1->useSubstitutions=false;
		$mPDF1->simpleTables = true;

		//Formato y orientacion de la pagina
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L');

		//Estilo
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/imprimir.css');
		$mPDF1->WriteHTML($stylesheet, 1);

		//Banner
		$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.images') . '/banner.svg' ));

		//Codigo de la accion
		$ac=$accion;

		//Instancia del proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);

		//Total del proyecto
		$totalProyecto=$this->totalProyectoAcciones($proyecto->codigo);

		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));

		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$proyecto->codigo]=$this->totalProyectoAcciones($proyecto->codigo);

		//Arreglo para Accion_Ue
		$aue=array();

		//Arreglo para registros
		$registros=array();

		foreach($acciones as $key => $accion)
		{
			//Relacion Unidad Ejecutora - Accion
			$aue[$accion->codigo]=AccionUe::model()->findAllByAttributes(array('codigo_accion'=>$accion->codigo));

			//Registros
			$registros[$accion->codigo]=$this->registrosPorAccion($accion->codigo);

		}		

		$mPDF1->WriteHTML($this->renderPartial('_imprimirGeneral', array(
			'proyecto'=>$proyecto,
			'acciones'=>$acciones,
			'totalProyecto'=>$totalProyecto,
			'totalProyectoAcciones'=>$totalProyectoAcciones,
			'accion'=>$ac,
			'aue'=>$aue,
			'registros'=>$registros,
		),true));

		//Imprimir
		$mPDF1->Output('General.pdf', 'D');
	}

	/**
	**/
	public function actionReporteGeneralExcel($proyecto,$accion)
	{
		//Incrementar la memoria y el tiempo de espera para el script
		 ini_set("memory_limit", "2048M");
		 ini_set('max_execution_time', 300); //300 seconds = 5 minutes

		 //Codigo de la accion
		$ac=$accion;

		//Instancia del proyecto
		$proyecto=Proyecto::model()->findByPk($proyecto);

		//Total del proyecto
		$totalProyecto=$this->totalProyectoAcciones($proyecto->codigo);

		//Acciones
		$acciones=Acciones::model()->findAllByAttributes(array('codigo_proyecto'=>$proyecto->codigo));

		//Arreglo con los totales por accion
		$totalProyectoAcciones=array();
		//Por cada accion
		$totalProyectoAcciones[$proyecto->codigo]=$this->totalProyectoAcciones($proyecto->codigo);

		//Arreglo para Accion_Ue
		$aue=array();

		//Arreglo para registros
		$registros=array();

		foreach($acciones as $key => $accion)
		{
			//Relacion Unidad Ejecutora - Accion
			$aue[$accion->codigo]=AccionUe::model()->findAllByAttributes(array('codigo_accion'=>$accion->codigo));

			//Registros
			$registros[$accion->codigo]=$this->registrosPorAccion($accion->codigo);

		}

		$this->renderPartial('_generalExcel', array(
			'proyecto'=>$proyecto,
			'acciones'=>$acciones,
			'totalProyecto'=>$totalProyecto,
			'totalProyectoAcciones'=>$totalProyectoAcciones,
			'accion'=>$ac,
			'aue'=>$aue,
			'registros'=>$registros,
		));	
	}

	/**
	 * Devuelve los registros segun la accion
	 * @param int $accion codigo de la accion
	 * @return array $registros
	 **/
	public function registrosPorAccion($accion)
	{
		//Instancia de la conexion a BD
		$row=Yii::app()->db->createCommand();

		//Relacion Accion - Unidad Ejecutora
		$aue=AccionUe::model()->findAllByAttributes(array('codigo_accion'=>$accion));

		//Para almacenar los registros
		$registros=array();

		foreach($aue as $llave => $valor)
		{
			$registros[$valor->codigo]=$row->select('r.*')
			->from('reporte r, accion_ue aue')
			->where('r.estatus=1 AND r.accion_ue=aue.codigo AND aue.codigo=:aue', array(':aue'=>$valor->codigo))
			->queryAll();
		}

		return $registros;
	}

	/**
	 * Solicitud AJAX para devolver una lista de unidades ejecutoras
	 * asociadas a una acción
	 * @param int $accion codigo de la accion
	 */
	public function actionUnidadEjecutora()
	{
		if(isset($_POST['accion']))
		{
			//Codigo de la accion
			$accion=$_POST['accion'];

			$accionUe=AccionUe::model()->findAll(array(
				'condition'=>'codigo_accion=:codigo_accion',
				'params'=>array(':codigo_accion'=>$accion)
			));

			//Arreglo para la lista de unidades ejecutoras
			$uE=array();

			foreach($accionUe as $llave => $valor)
			{
				$ue[$llave]=UnidadEjecutora::model()->findByPk($valor['codigo_ue']);
			}

			$lista=CHtml::listData($ue,'codigo','denominacion');
			$lista=array('0'=>'(Seleccione una Unidad Ejecutora)')+$lista;
			
			foreach($lista as $valor => $nombre)
			{
				echo CHtml::tag('option', array('value'=>$valor),CHtml::encode($nombre),TRUE);
			}
		}	

	}

	/**
	 * Buscar dentro de un arreglo multidimensional
	 * @param mixed $needle, array $haystack, boolean $strict
	 * @return boolean
	 */
	public function in_array_r($needle, $haystack, $strict = false)
	{
	    foreach ($haystack as $item)
	    {
	        if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict)))
	        {
	            return true;
	        }
	    }

	    return false;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Proyecto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='proyecto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
