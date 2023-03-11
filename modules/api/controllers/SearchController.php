<?php
/**
 * AlertController.php
 *
 * PHP version 7.2+
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license http://www.ibitux.com/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package modules\api\controllers
 */
namespace modules\api\controllers;

use Exception;
use modules\api\models\Pokemon;
use modules\api\models\Search;
use modules\api\models\Type;
use Yii;
use yii\rest\Controller;

/**
 * AlertController class
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license http://www.ibitux.com/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package modules\api\controllers
 * @since XXX
 */
class SearchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actionSearchPokemon()
    {
        try {
            Yii::$app->response->statusCode = 422;
            $searchModel = Yii::createObject(Search::class);
            $searchModel->scenario = Search::SCENARIO_SEARCH_POKEMON;
            if (Yii::$app->request->isPost === true) {
                $body = Yii::$app->request->bodyParams;
                $searchModel->load($body,'');
                $query = $searchModel->searchPokemon();
                Yii::$app->response->statusCode = 200;
                Yii::$app->response->data = $query->all();
            }
            return Yii::$app->response;
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
