<?php

/**
 * This is the model class for table "partida".
 *
 * The followings are the available columns in table 'partida':
 * @property integer $codigo
 * @property string $partida
 * @property string $descripcion
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property Estatus $estatus0
 * @property Subpartida[] $subpartidas
 * @property UelPresupuestoPartida[] $uelPresupuestoPartidas
 */
class Partida extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partida the static model class
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
		return 'partida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partida', 'required'),
			array('estatus', 'numerical', 'integerOnly'=>true),
			array('partida', 'length', 'max'=>3),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, partida, descripcion, estatus', 'safe', 'on'=>'search'),
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
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'subpartidas' => array(self::HAS_MANY, 'Subpartida', 'partida'),
			'uelPresupuestoPartidas' => array(self::HAS_MANY, 'UelPresupuestoPartida', 'partida'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'partida' => 'Partida',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('partida',$this->partida,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('estatus',$this->estatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}