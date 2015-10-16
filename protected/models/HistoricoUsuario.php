<?php

/**
 * This is the model class for table "historico_usuario".
 *
 * The followings are the available columns in table 'historico_usuario':
 * @property integer $codigo
 * @property integer $usuario
 * @property integer $codigo_usuario
 * @property integer $operacion
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Operacion $operacion0
 * @property Usuario $usuario0
 * @property Usuario $codigoUsuario
 */
class HistoricoUsuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HistoricoUsuario the static model class
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
		return 'historico_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, codigo_usuario, operacion, fecha', 'required'),
			array('usuario, codigo_usuario, operacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, usuario, codigo_usuario, operacion, fecha', 'safe', 'on'=>'search'),
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
			'usuario0' => array(self::BELONGS_TO, 'Usuario', 'usuario'),
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
			'usuario' => 'Usuario',
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
		$criteria->compare('usuario',$this->usuario);
		$criteria->compare('codigo_usuario',$this->codigo_usuario);
		$criteria->compare('operacion',$this->operacion);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}