<?php
$this->breadcrumbs=array(
	'Subpartidas',
);

$this->menu=array(
	array('label'=>'Crear Subpartida', 'url'=>array('create')),
	array('label'=>'Buscar Subpartida', 'url'=>array('admin')),
);
?>

<h1>Subpartidas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
