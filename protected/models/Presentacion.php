<?php

/**
 * This is the model class for table "presentacion".
 *
 * The followings are the available columns in table 'presentacion':
 * @property integer $codigo
 * @property string $presentacion
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property MaterialesServicios[] $materialesServicioses
 * @property Estatus $estatus0
 * @property Reporte[] $reportes
 */
class Presentacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Presentacion the static model class
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
		return 'presentacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('presentacion', 'required'),
			array('estatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, presentacion, estatus', 'safe', 'on'=>'search'),
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
			'materialesServicioses' => array(self::HAS_MANY, 'MaterialesServicios', 'presentacion'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'reportes' => array(self::HAS_MANY, 'Reporte', 'presentacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'presentacion' => 'Presentación',
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
		$criteria->compare('presentacion',$this->presentacion,true);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}