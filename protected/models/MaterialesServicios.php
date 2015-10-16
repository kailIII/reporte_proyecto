<?php

/**
 * This is the model class for table "materiales_servicios".
 *
 * The followings are the available columns in table 'materiales_servicios':
 * @property integer $codigo
 * @property string $descripcion
 * @property double $precio1
 * @property double $precio2
 * @property double $precio3
 * @property double $precio4
 * @property integer $subpartida
 * @property integer $unidad_medida
 * @property integer $presentacion
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property HistoricoMaterialesServicios[] $historicoMaterialesServicioses
 * @property Subpartida $subpartida0
 * @property UnidadMedida $unidadMedida
 * @property Presentacion $presentacion0
 * @property Estatus $estatus0
 * @property Reporte[] $reportes
 */
class MaterialesServicios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaterialesServicios the static model class
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
		return 'materiales_servicios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, subpartida, unidad_medida, presentacion', 'required'),
			array('subpartida, unidad_medida, presentacion, estatus', 'numerical', 'integerOnly'=>true),
			array('precio1, precio2, precio3, precio4', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, descripcion, precio1, precio2, precio3, precio4, subpartida, unidad_medida, presentacion, estatus', 'safe', 'on'=>'search'),
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
			'historicoMaterialesServicioses' => array(self::HAS_MANY, 'HistoricoMaterialesServicios', 'codigo_material_servicio'),
			'subpartida0' => array(self::BELONGS_TO, 'Subpartida', 'subpartida'),
			'unidadMedida' => array(self::BELONGS_TO, 'UnidadMedida', 'unidad_medida'),
			'presentacion0' => array(self::BELONGS_TO, 'Presentacion', 'presentacion'),
			'estatus0' => array(self::BELONGS_TO, 'Estatus', 'estatus'),
			'reportes' => array(self::HAS_MANY, 'Reporte', 'material_servicio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'descripcion' => 'Descripción',
			'precio1' => 'Precio 1',
			'precio2' => 'Precio 2',
			'precio3' => 'Precio 3',
			'precio4' => 'Precio 4',
			'subpartida' => 'Subpartida',
			'unidad_medida' => 'Unidad de Medida',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('precio1',$this->precio1);
		$criteria->compare('precio2',$this->precio2);
		$criteria->compare('precio3',$this->precio3);
		$criteria->compare('precio4',$this->precio4);
		$criteria->compare('subpartida',$this->subpartida);
		$criteria->compare('unidad_medida',$this->unidad_medida);
		$criteria->compare('presentacion',$this->presentacion);
		$criteria->compare('estatus',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}