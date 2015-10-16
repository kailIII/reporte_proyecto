<?php

/**
 * This is the model class for table "estatus".
 *
 * The followings are the available columns in table 'estatus':
 * @property integer $codigo
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property AccionUe[] $accionUes
 * @property Acciones[] $acciones
 * @property MaterialesServicios[] $materialesServicioses
 * @property Partida[] $partidas
 * @property Presentacion[] $presentacions
 * @property Proyecto[] $proyectos
 * @property Reporte[] $reportes
 * @property UnidadEjecutora[] $unidadEjecutoras
 * @property UnidadMedida[] $unidadMedidas
 * @property Usuario[] $usuarios
 */
class Estatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Estatus the static model class
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
		return 'estatus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estatus', 'required'),
			array('estatus', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, estatus', 'safe', 'on'=>'search'),
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
			'accionUes' => array(self::HAS_MANY, 'AccionUe', 'estatus'),
			'acciones' => array(self::HAS_MANY, 'Acciones', 'estatus'),
			'materialesServicioses' => array(self::HAS_MANY, 'MaterialesServicios', 'estatus'),
			'partidas' => array(self::HAS_MANY, 'Partida', 'estatus'),
			'presentacions' => array(self::HAS_MANY, 'Presentacion', 'estatus'),
			'proyectos' => array(self::HAS_MANY, 'Proyecto', 'estatus'),
			'reportes' => array(self::HAS_MANY, 'Reporte', 'estatus'),
			'unidadEjecutoras' => array(self::HAS_MANY, 'UnidadEjecutora', 'estatus'),
			'unidadMedidas' => array(self::HAS_MANY, 'UnidadMedida', 'estatus'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'estatus'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
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
		$criteria->compare('estatus',$this->estatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}