<?php

/**
 * This is the model class for table "subpartida".
 *
 * The followings are the available columns in table 'subpartida':
 * @property integer $codigo
 * @property string $partida
 * @property string $ge
 * @property string $es
 * @property string $se
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Partida $partida0
 */
class Subpartida extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Subpartida the static model class
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
		return 'subpartida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partida, ge, es, se, descripcion', 'required'),
			array('partida', 'length', 'max'=>3),
			array('ge, es, se', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, partida, ge, es, se, descripcion', 'safe', 'on'=>'search'),
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
			'partida0' => array(self::BELONGS_TO, 'Partida', 'partida'),
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
			'ge' => 'Ge',
			'es' => 'Es',
			'se' => 'Se',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('ge',$this->ge,true);
		$criteria->compare('es',$this->es,true);
		$criteria->compare('se',$this->se,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}