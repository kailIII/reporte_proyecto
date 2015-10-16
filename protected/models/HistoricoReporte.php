<?php

/**
 * This is the model class for table "historico_reporte".
 *
 * The followings are the available columns in table 'historico_reporte':
 * @property integer $codigo
 * @property integer $codigo_reporte
 * @property integer $codigo_usuario
 * @property integer $operacion
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Reporte $codigoReporte
 * @property Usuario $codigoUsuario
 * @property Operacion $operacion0
 */
class HistoricoReporte extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HistoricoReporte the static model class
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
		return 'historico_reporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_reporte, codigo_usuario, operacion, fecha', 'required'),
			array('codigo_reporte, codigo_usuario, operacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_reporte, codigo_usuario, operacion, fecha', 'safe', 'on'=>'search'),
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
			'codigoReporte' => array(self::BELONGS_TO, 'Reporte', 'codigo_reporte'),
			'codigoUsuario' => array(self::BELONGS_TO, 'Usuario', 'codigo_usuario'),
			'operacion0' => array(self::BELONGS_TO, 'Operacion', 'operacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'codigo_reporte' => 'Codigo Reporte',
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
		$criteria->compare('codigo_reporte',$this->codigo_reporte);
		$criteria->compare('codigo_usuario',$this->codigo_usuario);
		$criteria->compare('operacion',$this->operacion);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}