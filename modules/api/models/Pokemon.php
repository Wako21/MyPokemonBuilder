<?php

namespace modules\api\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $nameFr
 * @property string $form
 * @property int $type1Id
 * @property int $type2Id
 * @property string $image
 * @property integer $total
 * @property integer $hp
 * @property integer $attack
 * @property integer $defense
 * @property integer $spAtk
 * @property integer $spDef
 * @property integer $speed
 */
class Pokemon extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public function behaviors():array
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pokemons}}';
    }

    /**
     * {@inheritdoc}
     * Add FilterActiveQuery
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::class, [static::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_CREATE] = ['number', 'name', 'nameFr', 'type1', 'type2', 'image', 'total', 'hp', 'attack', 'defense', 'spAtk', 'spDef', 'speed'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getType1()
    {
        return $this->hasOne(Type::class, ['id' => 'type1Id']);
    }

    public function getType2()
    {
        return $this->hasOne(Type::class, ['id' => 'type2Id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'type1';
        $fields[] = 'type2';
        return $fields;
    }
}
