<?php
	$this->breadcrumbs=array(
		'Proyecto'=>array('proyecto/view','id'=>$proyecto->codigo),
		'Reporte General',
);
?>

<h1>Registros cargados Proyecto #<?php echo $proyecto->codigo."(SNE".$proyecto->codigo_sne.")"; ?></h1>

<?php if(Yii::app()->user->hasFlash('admin')): ?> <!-- Si es administrador -->

<div class="flash-notice">
	<?php echo Yii::app()->user->getFlash('admin'); ?>
</div>

<?php else: ?> <!-- Sino es administrador -->

<!-- El formulario -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proyecto-form',
	'enableAjaxValidation'=>false,
	'action'=>CController::createUrl('reporte/imprimirGeneral',array('proyecto'=>$proyecto->codigo))
)); ?>

<?php
	//Buscar la unidad ejecutora
	$ue=UnidadEjecutora::model()->findByPk(Yii::app()->user->uel);
?>
<div class="row">
	<h4><?php echo $ue->codigo_uel." - ".$ue->denominacion; ?></h4><!-- Nombre y codigo de la UE -->
</div>

<?php
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
	
	//El data provider
	$dataProvider=new CActiveDataProvider('Reporte',array(
		'criteria'=>array(
			'condition'=>$sql,
			'order'=>'imputacion_presupuestaria, material_servicio ASC',
		)
	));
	//Desactivar la paginacion
	$dataProvider->setPagination(false);

?>
<?php
	Yii::app()->clientScript->registerScript('search', "
		$('#btnButton').click(function(){
			$.ajax({
				url:'".CController::createUrl('reporte/excelGeneral', array('sql'=>$sql))."',
			});
			return false;
		});
	");
?>

<div id="prinicipio" class="simple right"><a href="#final">Ir al final</a></div><!-- Ir al final de la pagina -->
<br>
<div class="simple big"></div>

<?php
	
	//widget con los registros
	$this->widget('zii.widgets.grid.CGridView',array(
		'id'=>'reportes-grid',
		'cssFile'=>Yii::app()->baseUrl.'/css/gridview.css', //Archivo CSS
		'dataProvider'=>$dataProvider,
		'enablePagination'=>false, //Deshabilitar la paginación
		'enableSorting'=>false, //Deshabilitar el ordenamiento
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
					$val=Yii::app()->format->number($data->trim_i*$data->precio_unitario);
					return $val;
				}
			),
			'trim_ii',
			array(
				'name'=>'total_trim_ii', //Etiqueta definida en el modelo
				'type'=>'raw',
				'value'=>function($data){
					$val=Yii::app()->format->number($data->trim_ii*$data->precio_unitario);
					return $val;
				}
			),
			'trim_iii',
			array(
				'name'=>'total_trim_iii', //Etiqueta definida en el modelo
				'type'=>'raw',
				'value'=>function($data){
					$val=Yii::app()->format->number($data->trim_iii*$data->precio_unitario);
					return $val;
				}
			),
			'trim_iv',
			array(
				'name'=>'total_trim_iv', //Etiqueta definida en el modelo
				'type'=>'raw',
				'value'=>function($data){
					$val=Yii::app()->format->number($data->trim_iv*$data->precio_unitario);
					return $val;
				}
			),
			'sub_total',
			'total_iva',
			'total',
			array(
				'name'=>'Subtotal+iva',
				'type'=>'raw',
				'value'=>function($data){
					$val=$data->sub_total+$data->total_iva;
					return $val;
				},
			),
			array(
				'name'=>'Comprobación',
				'type'=>'raw',
				'value'=>function($data){
					if($data->sub_total+$data->total_iva==$data->total){
						$s='<span>Válido</span>';
					}else{
						$s='<span>Inválido</span>';
					}
					return $s;
				}
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{view}'
			),
			//'presupuesto_utilizado',
			/*
			array(
				'name'=>'Presupuesto Total',
				'type'=>'raw',
				'value'=>function($data){
					$p=Presupuesto::model()->findByPk(AccionUe::model()->findByPk($data->accion_ue)->presupuesto);
					return $p->presupuesto;
				}
			),
			*/
		),
		'htmlOptions'=>array(
			'style'=>'overflow-x:scroll;margin-bottom:20px'
		),
	));
	
?>

<div id="final" class="simple right"><a href="#banner">Ir al principio</a></div><!-- Ir al principio de la pagina -->
<br>

 <div class="row buttons">
	<?php 
		$this->widget('zii.widgets.jui.CJuiButton', array(
		    'buttonType'=>'submit',
		    'name'=>'btnSubmit',
		    'value'=>'1',
		    'caption'=>'Imprimir',
		));
	?>
	<?php 
		$this->widget('zii.widgets.jui.CJuiButton', array(
		    'buttonType'=>'button',
		    'name'=>'btnExcel',
		    'value'=>'1',
		    'caption'=>'Hoja de cálculo',
		    'onclick'=>new CJavaScriptExpression('function(){window.location = "'.CController::createUrl('reporte/excelGeneral', array('sql'=>$sql)).'";}'),
		));
	?>
</div>

<?php $this->endWidget(); ?> <!-- Termina el formulario -->

<?php endif; ?><!-- Termina la condicion -->

<br><!-- Espacio -->

<!-- Enlace para regresar -->
<div class="row buttons">
	<?php echo CHtml::link('Volver',Yii::app()->createUrl('proyecto/view',array('id'=>$proyecto->codigo))); ?>
</div>