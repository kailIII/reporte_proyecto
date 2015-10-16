<?php

/**
 * This is the model class for table "historico_proyecto".
 *
 * The followings are the available columns in table 'historico_proyecto':
 * @property integer $codigo
 * @property integer $codigo_proyecto
 * @property integer $codigo_usuario
 * @property integer $operacion
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Operacion $operacion0
 * @property Proyecto $codigoProyecto
 * @property Usuario $codigoUsuario
 */
class HistoricoProyecto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HistoricoProyecto the static model class
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
		return 'historico_proyecto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_proyecto, codigo_usuario, operacion, fecha', 'required'),
			array('codigo_proyecto, codigo_usuario, operacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_proyecto, codigo_usuario, operacion, fecha', 'safe', 'on'=>'search'),
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
			'operacion0' => array(self::BELONGS_TO, 'Operacion', 'operacion'),
			'codigoProyecto' => array(self::BELONGS_TO, 'Proyecto', 'codigo_proyecto'),
			'codigoUsuario' => array(self::BELONGS_TO, 'Usuario', 'codigo_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'codigo_proyecto' => 'Codigo Proyecto',
			'codigo_usuario' => 'Codigo Usuario',
			'operacion' => 'Operacion',
			'fecha' => 'Fecha',
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
		$criteria->compare('codigo_proyecto',$this->codigo_proyecto);
		$criteria->compare('codigo_usuario',$this->codigo_usuario);
		$criteria->compare('operacion',$this->operacion);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}