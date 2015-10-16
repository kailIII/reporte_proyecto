<?php

/**
 * This is the model class for table "unidad_medida".
 *
 * The followings are the available columns in table 'unidad_medida':
 * @property integer $codigo
 * @property string $unidad_medida
 * @property string $id
 * @property integer $tipo
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property MaterialesServicios[] $materialesServicioses
 * @property Reporte[] $reportes
 * @property Estatus $estatus0
 * @property TipoUnidadMedida $tipo0
 */
class UnidadMedida extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UnidadMedida the static model class
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
		return 'unidad_medida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unidad_medida', 'required'),
			array('tipo, estatus', 'numerical', 'integerOnly'=>true),
			array('unidad_medida', 'length', 'max'=>30),
			array('id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, unidad_medida, id, tipo, estatus', 'safe', 'on'=>'search'),
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
			'materialesServicioses' => array(self::HAS_MANY, 'MaterialesServicios', 'unidad_medida'),
			'reportes' => array(self::HAS_MANY, 'Reporte', 'unidad_medida'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'tipo0' => array(self::BELONGS_TO, 'TipoUnidadMedida', 'tipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'unidad_medida' => 'Unidad de Medida',
			'id' => 'ID',
			'tipo' => 'Tipo',
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
		$criteria->compare('unidad_medida',$this->unidad_medida,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}