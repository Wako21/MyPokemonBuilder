<?php

namespace webapp\controllers;

use yii\web\Controller;
use Yii;
use Exception;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    /**
     * Action Index
     *
     * @return string
     * @throws Exception
     * @since XXX
     */
    public function actionIndex()
    {
        try {
            return $this->render('index', []);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }
}