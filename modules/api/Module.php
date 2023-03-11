<?php

namespace modules\api;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;
use yii\web\UrlRule;

class Module extends BaseModule implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@modules\api', __DIR__);
        if ($app instanceof ConsoleApplication) {
            $this->bootstrapConsole($app);
        } elseif ($app instanceof WebApplication) {
            $this->bootstrapWeb($app);
        }
    }
    /**
     * Bootstrap console stuff
     *
     * @param ConsoleApplication $app
     * @since XXX
     */
    protected function bootstrapConsole(ConsoleApplication $app)
    {

    }

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    protected function bootstrapWeb(WebApplication $app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => GroupUrlRule::class,
                'prefix' => $this->id,
                'rules' => [
                    [
                        'class' => UrlRule::class,
                        'mode' => UrlRule::PARSING_ONLY,
                        'pattern' => 'pokemons',
                        'verb' => 'GET',
                        'route' => 'pokemon'
                    ],
                    [
                        'class' => UrlRule::class,
                        'mode' => UrlRule::PARSING_ONLY,
                        'pattern' => 'types',
                        'verb' => 'GET',
                        'route' => 'type'
                    ],
                    [
                        'class' => UrlRule::class,
                        'mode' => UrlRule::PARSING_ONLY,
                        'pattern' => 'search/pokemon',
                        'verb' => 'POST',
                        'route' => 'search/search-pokemon'
                    ],
                    ['class' => UrlRule::class, 'pattern' => '<controller:[\w\-]+>', 'route' => '<controller>'],
                    ['class' => UrlRule::class, 'pattern' => '<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => '<controller>/<action>'],
                ],
            ]
        ], false);
    }


}