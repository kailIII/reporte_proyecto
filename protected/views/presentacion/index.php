<?php
$this->breadcrumbs=array(
	'Presentación',
);

$this->menu=array(
	array('label'=>'Crear Presentación', 'url'=>array('create')),
	array('label'=>'Buscar Presentación', 'url'=>array('admin')),
);
?>

<h1>Presentación</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
