<?php


namespace modules\api\models;


use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_CREATE = 'create';
    public const SCENARIO_CREATE_ONLINE = 'create_online';
    public const SCENARIO_UPDATE = 'update';

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $checkPassword;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors():array
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'dateCreate',
            'updatedAtAttribute' => 'dateUpdate',
            'value' => Yii::createObject(Expression::class, ['NOW()']),
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_LOGIN] = ['email', 'password'];
        $scenarios[static::SCENARIO_CREATE] = ['email', 'password'];
        $scenarios[static::SCENARIO_CREATE_ONLINE] = ['email', 'nom', 'prenom', 'telephone', 'code', 'newPassword', 'checkPassword', 'caisse', 'active'];
        $scenarios[static::SCENARIO_UPDATE] = ['email', 'nom', 'prenom', 'telephone', 'code', 'newPassword', 'checkPassword', 'caisse', 'active'];
        return $scenarios;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->active()->one();
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritDoc}
     */
    public function validateAuthKey($authKey)
    {
        return empty($this->authKey) === false && $this->authKey === $authKey;
    }

}