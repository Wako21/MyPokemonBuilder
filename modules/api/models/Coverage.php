<?php

namespace modules\api\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $mainTypeId
 * @property int $targetTypeId
 * @property string $status
 */
class Coverage extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    const STATUS_WEAK = 'weak';
    const STATUS_RESIST = 'resist';
    const STATUS_IMMUNE = 'immune';

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
        return '{{%coverages}}';
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
        $scenarios[static::SCENARIO_CREATE] = ['mainTypeId', 'targetType', 'status'];
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

    public function getMainType()
    {
        return $this->hasOne(Type::class, ['id' => 'mainTypeId']);
    }

    public function getTargetType()
    {
        return $this->hasOne(Type::class, ['id' => 'targetTypeId']);
    }
}
