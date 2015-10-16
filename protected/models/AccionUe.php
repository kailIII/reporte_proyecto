<?php

/**
 * This is the model class for table "accion_ue".
 *
 * The followings are the available columns in table 'accion_ue':
 * @property integer $codigo
 * @property integer $codigo_accion
 * @property integer $codigo_ue
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property Acciones $codigoAccion
 * @property UnidadEjecutora $codigoUe
 * @property Estatus $estatus0
 * @property HistoricoAue[] $historicoAues
 * @property Reporte[] $reportes
 */
class AccionUe extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccionUe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accion_ue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_accion', 'required'),
			array('codigo_accion, codigo_ue, estatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_accion, codigo_ue, estatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'codigoAccion' => array(self::BELONGS_TO, 'Acciones', 'codigo_accion'),
			'codigoUe' => array(self::BELONGS_TO, 'UnidadEjecutora', 'codigo_ue'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'historicoAues' => array(self::HAS_MANY, 'HistoricoAue', 'accion_ue'),
			'reportes' => array(self::HAS_MANY, 'Reporte', 'accion_ue'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'codigo_accion' => 'Codigo Accion',
			'codigo_ue' => 'Codigo Ue',
			'estatus' => 'Estatus',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('codigo_accion',$this->codigo_accion);
		$criteria->compare('codigo_ue',$this->codigo_ue);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function nombreUel($data,$row)
	{
		$nombreUe=UnidadEjecutora::model()->findByPk($data->codigo_ue);
		
		if($nombreUe==NULL)
		{
			return false;
		}
		else
		{
			return $nombreUe->denominacion;
		}
	}
}