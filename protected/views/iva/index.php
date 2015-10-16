<?php
$this->breadcrumbs=array(
	'IVA',
);

$this->menu=array(
	array('label'=>'Crear IVA', 'url'=>array('create')),
	array('label'=>'Buscar IVA', 'url'=>array('admin')),
);
?>

<h1>Impuesto al Valor Agregado</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
