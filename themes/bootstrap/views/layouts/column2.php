<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operaciones',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        <?php
            //Si hay valores para este menu, crearlo
            if(isset($this->menu2))
            {
                $this->beginWidget('zii.widgets.CPortlet',array(
                    'title'=>'Opciones',
                ));
                $this->widget('zii.widgets.CMenu',array(
                    'items'=>$this->menu2,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                $this->endWidget();
            }           
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>