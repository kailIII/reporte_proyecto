<?php
$this->breadcrumbs=array(
	'Opciones'=>Yii::app()->createUrl('site/opciones'),
	'Respaldos'
);?>
<h1>Respaldo de la Base de Datos</h1>

<p>
	Esta sección permite crear archivos de respaldo de la <b>Base de Datos</b>, así como restaurar y descargar los mismos.
</p>

<?php $this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
));
?>

<!-- Enlace para regresar -->
<?php echo CHtml::link('Volver',Yii::app()->createUrl('site/opciones')); ?>