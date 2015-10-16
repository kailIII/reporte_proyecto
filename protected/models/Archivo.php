<?php
	
	class Archivo extends CFormModel
	{
	    public $archivo;
	 
		// Define rules for file uploads
		// In this example, we want images of size less than 1MB
	    public function rules()
	    {
	        return array(
	            array('archivo', 'file', 'allowEmpty' => true, 'safe' => true, 'types' => 'csv')
	        );
	    }
	}

?>