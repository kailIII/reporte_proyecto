<?php
$this->breadcrumbs=array(
	'Historico Reportes',
);

$this->menu=array(
	array('label'=>'Buscar Historico Reporte', 'url'=>array('admin')),
);
?>

<h1>Histórico Reportes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
