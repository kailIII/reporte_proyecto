<?php
$this->breadcrumbs=array(
	'Materiales y Servicios',
);

$this->menu=array(
	array('label'=>'Crear Materiales/Servicios', 'url'=>array('create')),
	array('label'=>'Buscar Materiales/Servicios', 'url'=>array('admin')),
);
?>

<h1>Materiales y Servicios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
