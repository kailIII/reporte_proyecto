<?php
	
class AsignaFormulario extends CFormModel
{
    public $codigo_ue;

    public function rules()
    {
    	return array(
    		array('codigo_ue','required'),
    	);
    }

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo_ue'=>'Unidad Ejecutora a asignar'
		);
	}

}

?>