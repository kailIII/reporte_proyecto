<?php
$this->breadcrumbs=array(
	'Partidas',
);

$this->menu=array(
	array('label'=>'Crear Partida', 'url'=>array('create')),
	array('label'=>'Buscar Partida', 'url'=>array('admin')),
);
?>

<h1>Partidas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
