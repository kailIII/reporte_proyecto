<?php

/**
 * This is the model class for table "historico_asigna_presupuesto".
 *
 * The followings are the available columns in table 'historico_asigna_presupuesto':
 * @property integer $codigo
 * @property integer $codigo_aue
 * @property integer $codigo_usuario
 * @property integer $asignacion
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Asignacion $asignacion0
 * @property AccionUe $codigoAue
 * @property Usuario $codigoUsuario
 */
class HistoricoAsignaPresupuesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HistoricoAsignaPresupuesto the static model class
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
		return 'historico_asigna_presupuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo_aue, codigo_usuario, asignacion, fecha', 'required'),
			array('codigo_aue, codigo_usuario, asignacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, codigo_aue, codigo_usuario, asignacion, fecha', 'safe', 'on'=>'search'),
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
			'asignacion0' => array(self::BELONGS_TO, 'Asignacion', 'asignacion'),
			'codigoAue' => array(self::BELONGS_TO, 'AccionUe', 'codigo_aue'),
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
			'codigo_aue' => 'Codigo Aue',
			'codigo_usuario' => 'Codigo Usuario',
			'asignacion' => 'Asignacion',
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
		$criteria->compare('codigo_aue',$this->codigo_aue);
		$criteria->compare('codigo_usuario',$this->codigo_usuario);
		$criteria->compare('asignacion',$this->asignacion);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}