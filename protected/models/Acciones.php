<?php

/**
 * This is the model class for table "acciones".
 *
 * The followings are the available columns in table 'acciones':
 * @property integer $codigo
 * @property string $codigo_accion
 * @property string $accion
 * @property integer $codigo_proyecto
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property AccionUe[] $accionUes
 * @property Proyecto $codigoProyecto
 * @property Estatus $estatus0
 * @property HistoricoAccion[] $historicoAccions
 */
class Acciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Acciones the static model class
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
		return 'acciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_accion, accion, codigo_proyecto', 'required'),
			array('codigo_proyecto, estatus', 'numerical', 'integerOnly'=>true),
			array('codigo_accion', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_accion, accion, codigo_proyecto, estatus', 'safe', 'on'=>'search'),
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
			'accionUes' => array(self::HAS_MANY, 'AccionUe', 'codigo_accion'),
			'codigoProyecto' => array(self::BELONGS_TO, 'Proyecto', 'codigo_proyecto'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'historicoAccions' => array(self::HAS_MANY, 'HistoricoAccion', 'codigo_accion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'codigo_accion' => 'Código Acción',
			'accion' => 'Acción',
			'codigo_proyecto' => 'Código Proyecto',
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
		$criteria->compare('codigo_accion',$this->codigo_accion,true);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('codigo_proyecto',$this->codigo_proyecto);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}