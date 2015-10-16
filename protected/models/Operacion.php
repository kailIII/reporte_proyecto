<?php

/**
 * This is the model class for table "operacion".
 *
 * The followings are the available columns in table 'operacion':
 * @property integer $codigo
 * @property string $operacion
 *
 * The followings are the available model relations:
 * @property HistoricoReporte[] $historicoReportes
 */
class Operacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Operacion the static model class
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
		return 'operacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operacion', 'required'),
			array('operacion', 'length', 'max'=>22),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, operacion', 'safe', 'on'=>'search'),
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
			'historicoReportes' => array(self::HAS_MANY, 'HistoricoReporte', 'operacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'operacion' => 'Operacion',
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
		$criteria->compare('operacion',$this->operacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}