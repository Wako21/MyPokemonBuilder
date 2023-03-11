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
class TypeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actionIndex()
    {
        try {
            return Type::find()->orderBy('id')->all();
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}
