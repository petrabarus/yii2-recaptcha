<?php
/**
 * ReCaptchaAsset class file.
 * @author Petra Barus <petra.barus@gmail.com>
 */

namespace PetraBarus\Yii2\ReCaptcha;

use yii\web\AssetBundle;

/**
 * ReCaptchaAsset registers reCaptcha javascript.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ReCaptchaAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $baseUrl = 'https://www.google.com/recaptcha';
    
    public function init()
    {
        $lang = \Yii::$app->language;
        $this->js[] = "api.js?hl={$lang}";
    }
}
