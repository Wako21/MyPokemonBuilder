<?php
/**
 * Search.php
 *
 * PHP version 7.2+
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2018-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package modules\api\models
 */
namespace modules\api\models;

use yii\base\Model;
use yii\db\Query;
use Exception;
use Yii;

/**
 * This is the model Search
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2018-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package modules\api\models
 *
 * @property string $search
 * @property int $pole
 * @property int $schoolId
 * @property int $targetGradeId
 * @property string $status
 * @property int $step
 * @property bool $priority
 * @property bool $cooptation
 * @property string $page
 */
class Search extends Model
{
    const SCENARIO_SEARCH_POKEMON = 'searchPokemon';

    /**
     * @var string $search
     */
    public $search;

    /**
     * @var int $type1Id
     */
    public $type1Id;

    /**
     * @var int $type2Id
     */
    public $type2Id;

    public $generations;
    public $stats;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH_POKEMON] = ['search','type1Id', 'type2Id', 'generations', 'stats'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['search','type1Id', 'type2Id', 'generations', 'stats', 'upperStats'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'search' => 'search',
            'type1Id' => 'type1Id',
            'type2Id' => 'type2Id'
        ];
    }

    /**
     * Search User
     *
     * @param array $orderBy
     * @return Query
     * @since XXX
     */
    public function searchPokemon($orderBy = []) {
        $query = new Query();
        $query->select([Pokemon::tableName().'.*']);
        $query->from(Pokemon::tableName());

        if (empty($this->search) === false) {
            $query->where(['like', Pokemon::tableName() . '.nameFr', $this->search]);
        }

        if (empty($this->type1Id) === false) {
            $query->andWhere(['or',
                [Pokemon::tableName() . '.type1Id' => $this->type1Id],
                [Pokemon::tableName() . '.type2Id' => $this->type1Id]
            ]);
        }

        if (empty($this->type2Id) === false) {
            $query->andWhere(['or',
                [Pokemon::tableName() . '.type1Id' => $this->type2Id],
                [Pokemon::tableName() . '.type2Id' => $this->type2Id]
            ]);
        }

        if (empty($this->generations) === false) {
            $conditions = ['or'];
            foreach ($this->generations as $generations) {
                $conditions[] = [Pokemon::tableName() . '.generation' => $generations];
            }
            $query->andWhere($conditions);
        }

        if (empty($this->stats) === false) {
            foreach ($this->stats as $stat) {
                $query->andWhere([$stat[0], Pokemon::tableName() . '.'.$stat[1], $stat[2]]);
            }
        }

        $orderBy[Pokemon::tableName() . '.id'] = SORT_ASC;
        $query->orderBy($orderBy);
        return $query;
    }
}
