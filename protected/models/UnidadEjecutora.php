<?php

/**
 * This is the model class for table "unidad_ejecutora".
 *
 * The followings are the available columns in table 'unidad_ejecutora':
 * @property integer $codigo
 * @property integer $codigo_uel
 * @property string $denominacion
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property AccionUe[] $accionUes
 * @property Estatus $estatus0
 * @property Usuario[] $usuarios
 */
class UnidadEjecutora extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UnidadEjecutora the static model class
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
		return 'unidad_ejecutora';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_uel, denominacion', 'required'),
			array('codigo_uel, estatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_uel, denominacion, estatus', 'safe', 'on'=>'search'),
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
			'accionUes' => array(self::HAS_MANY, 'AccionUe', 'codigo_ue'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'uel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'codigo_uel' => 'Código UEL',
			'denominacion' => 'Denominación',
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
		$criteria->compare('codigo_uel',$this->codigo_uel);
		$criteria->compare('denominacion',$this->denominacion,true);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}