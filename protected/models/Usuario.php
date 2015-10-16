<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $codigo
 * @property string $usuario
 * @property string $clave
 * @property integer $nivel
 * @property integer $uel
 * @property string $fecha_creacion
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property HistoricoAccion[] $historicoAccions
 * @property HistoricoAsignaPresupuesto[] $historicoAsignaPresupuestos
 * @property HistoricoAue[] $historicoAues
 * @property HistoricoMaterialesServicios[] $historicoMaterialesServicioses
 * @property HistoricoPresentacion[] $historicoPresentacions
 * @property HistoricoProyecto[] $historicoProyectos
 * @property HistoricoReporte[] $historicoReportes
 * @property HistoricoUnidadEjecutora[] $historicoUnidadEjecutoras
 * @property HistoricoUnidadMedida[] $historicoUnidadMedidas
 * @property HistoricoUsuario[] $historicoUsuarios
 * @property HistoricoUsuario[] $historicoUsuarios1
 * @property Nivel $nivel0
 * @property UnidadEjecutora $uel0
 * @property Estatus $estatus0
 */
class Usuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
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
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, clave, nivel, fecha_creacion', 'required'),
			array('nivel, uel, estatus', 'numerical', 'integerOnly'=>true),
			array('usuario', 'length', 'max'=>15),
			array('clave', 'length', 'max'=>32),
			array('usuario', 'unique', 'attributeName'=> 'usuario', 'caseSensitive' => 'false'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, usuario, clave, nivel, uel, fecha_creacion, estatus', 'safe', 'on'=>'search'),
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
			'historicoAccions' => array(self::HAS_MANY, 'HistoricoAccion', 'codigo_usuario'),
			'historicoAsignaPresupuestos' => array(self::HAS_MANY, 'HistoricoAsignaPresupuesto', 'codigo_usuario'),
			'historicoAues' => array(self::HAS_MANY, 'HistoricoAue', 'codigo_usuario'),
			'historicoMaterialesServicioses' => array(self::HAS_MANY, 'HistoricoMaterialesServicios', 'codigo_usuario'),
			'historicoPresentacions' => array(self::HAS_MANY, 'HistoricoPresentacion', 'codigo_usuario'),
			'historicoProyectos' => array(self::HAS_MANY, 'HistoricoProyecto', 'codigo_usuario'),
			'historicoReportes' => array(self::HAS_MANY, 'HistoricoReporte', 'codigo_usuario'),
			'historicoUnidadEjecutoras' => array(self::HAS_MANY, 'HistoricoUnidadEjecutora', 'codigo_usuario'),
			'historicoUnidadMedidas' => array(self::HAS_MANY, 'HistoricoUnidadMedida', 'codigo_usuario'),
			'historicoUsuarios' => array(self::HAS_MANY, 'HistoricoUsuario', 'usuario'),
			'historicoUsuarios1' => array(self::HAS_MANY, 'HistoricoUsuario', 'codigo_usuario'),
			'nivel0' => array(self::BELONGS_TO, 'Nivel', 'nivel'),
			'uel0' => array(self::BELONGS_TO, 'UnidadEjecutora', 'uel'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
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
			'clave' => 'Clave',
			'nivel' => 'Nivel',
			'uel' => 'Uel',
			'fecha_creacion' => 'Fecha Creacion',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('nivel',$this->nivel);
		$criteria->compare('uel',$this->uel);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}