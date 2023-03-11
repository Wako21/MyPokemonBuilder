<?php
/**
 * StaticAsset.php
 *
 * PHP version 7.4+
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\assets
 */

namespace webapp\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Base static assets
 *
 * @author Jean-Philippe Isungu <jpisungu@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\assets
 * @since XXX
 */
class StaticAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@webapp/assets/static';

    /**
     * @inheritdoc
     */
    public $js = [
    ];

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
        'defer' => 'defer',
    ];

}
