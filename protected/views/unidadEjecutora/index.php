<?php
$this->breadcrumbs=array(
	'Unidad Ejecutoras',
);

$this->menu=array(
	array('label'=>'Create UnidadEjecutora', 'url'=>array('create')),
	array('label'=>'Manage UnidadEjecutora', 'url'=>array('admin')),
);
?>

<h1>Unidad Ejecutoras</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
