<?php

/**
 * This is the model class for table "reporte".
 *
 * The followings are the available columns in table 'reporte':
 * @property integer $codigo
 * @property integer $accion_ue
 * @property string $imputacion_presupuestaria
 * @property integer $material_servicio
 * @property integer $unidad_medida
 * @property integer $presentacion
 * @property integer $unidad_presentacion
 * @property string $precio_unitario
 * @property integer $iva
 * @property integer $trim_i
 * @property integer $trim_ii
 * @property integer $trim_iii
 * @property integer $trim_iv
 * @property string $sub_total
 * @property string $total_iva
 * @property string $total
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property HistoricoReporte[] $historicoReportes
 * @property MaterialesServicios $materialServicio
 * @property UnidadMedida $unidadMedida
 * @property Presentacion $presentacion0
 * @property Estatus $estatus0
 * @property AccionUe $accionUe
 */
class Reporte extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reporte the static model class
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
		return 'reporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accion_ue, imputacion_presupuestaria, material_servicio, unidad_medida, presentacion, precio_unitario, sub_total, total', 'required'),
			array('accion_ue, material_servicio, unidad_medida, presentacion, unidad_presentacion, iva, trim_i, trim_ii, trim_iii, trim_iv, estatus', 'numerical', 'integerOnly'=>true),
			array('precio_unitario, sub_total, total_iva, total, presupuesto_utilizado', 'numerical'),
			array('imputacion_presupuestaria', 'length', 'max'=>9),
			array('precio_unitario', 'match', 'pattern'=>'/^[0-9]{1,9}(\.[0-9]{0,2})?$/'),
			array('trim_i, trim_ii, trim_iii, trim_iv', 'validaTrim'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, accion_ue, imputacion_presupuestaria, material_servicio, unidad_medida, presentacion, unidad_presentacion, precio_unitario, iva, trim_i, trim_ii, trim_iii, trim_iv, sub_total, total_iva, total, estatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Para validar que ninguno de los campos trim esté vacío
	 */
	public function validaTrim($attribute, $params)
	{
		if(($this->trim_i == 0) && ($this->trim_ii == 0) && ($this->trim_iii == 0) && ($this->trim_iv == 0))
		{
			$this->addError('', 'Al menos uno de los trimestres debe ser mayor a cero (0).');
		}

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'historicoReportes' => array(self::HAS_MANY, 'HistoricoReporte', 'codigo_reporte'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'materialServicio' => array(self::BELONGS_TO, 'MaterialesServicios', 'material_servicio'),
			'unidadMedida' => array(self::BELONGS_TO, 'UnidadMedida', 'unidad_medida'),
			'presentacion0' => array(self::BELONGS_TO, 'Presentacion', 'presentacion'),
			'accionUe' => array(self::BELONGS_TO, 'AccionUe', 'accion_ue'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'accion_ue' => 'Accion UE',
			'imputacion_presupuestaria' => 'Imputacion Presupuestaria',
			'material_servicio' => 'Material/Servicio',
			'unidad_medida' => 'Unidad de Medida',
			'presentacion' => 'Presentación',
			'unidad_presentacion' => 'Unidad por Presentación',
			'precio_unitario' => 'Precio Unitario',
			'iva' => 'IVA',
			'trim_i' => 'Trim I',
			'total_trim_i'=>'Total Trim I',
			'trim_ii' => 'Trim II',
			'total_trim_ii'=>'Total Trim II',
			'trim_iii' => 'Trim III',
			'total_trim_iii'=>'Total Trim III',
			'trim_iv' => 'Trim IV',
			'total_trim_iv'=>'Total Trim IV',
			'sub_total' => 'Sub Total',
			'total_iva' => 'Total IVA',
			'total' => 'Total',
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
		/*
		$aue=AccionUe::model()->findAll(array(
			'condition'=>));
		*/
		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('accion_ue',$this->accion_ue);
		$criteria->compare('imputacion_presupuestaria',$this->imputacion_presupuestaria,true);
		$criteria->compare('material_servicio',$this->material_servicio);
		$criteria->compare('unidad_medida',$this->unidad_medida);
		$criteria->compare('presentacion',$this->presentacion);
		$criteria->compare('unidad_presentacion',$this->unidad_presentacion);
		$criteria->compare('precio_unitario',$this->precio_unitario,true);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('trim_i',$this->trim_i);
		$criteria->compare('trim_ii',$this->trim_ii);
		$criteria->compare('trim_iii',$this->trim_iii);
		$criteria->compare('trim_iv',$this->trim_iv);
		$criteria->compare('sub_total',$this->sub_total,true);
		$criteria->compare('total_iva',$this->total_iva,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Devuelve una lista de modelos según el filtro.
	 * @return CActiveDataProvider
	 */
	public function buscar($accion_ue)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('accion_ue',$accion_ue);
		$criteria->compare('imputacion_presupuestaria',$this->imputacion_presupuestaria,true);
		//$criteria->compare('material_servicio',$this->material_servicio);
		$criteria->compare('unidad_medida',$this->unidad_medida);
		$criteria->compare('presentacion',$this->presentacion);
		$criteria->compare('unidad_presentacion',$this->unidad_presentacion);
		$criteria->compare('precio_unitario',$this->precio_unitario,true);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('trim_i',$this->trim_i);
		$criteria->compare('trim_ii',$this->trim_ii);
		$criteria->compare('trim_iii',$this->trim_iii);
		$criteria->compare('trim_iv',$this->trim_iv);
		$criteria->compare('sub_total',$this->sub_total,true);
		$criteria->compare('total_iva',$this->total_iva,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('t.estatus',1);
		
		//Para buscar en Materiales y servicios
		$criteria->with= array('materialServicio'); 
		$criteria->addSearchCondition('materialServicio.descripcion',$this->material_servicio,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}