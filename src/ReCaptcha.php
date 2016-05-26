<?php
/**
 * ReCaptcha class file.
 * @author Petra Barus <petra.barus@gmail.com>
 */

namespace PetraBarus\Yii2\ReCaptcha;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\helpers\Inflector;

/**
 * ReCaptcha is the input widget for Google reCaptcha.
 * 
 * To use this widget in the active form.
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ReCaptcha extends InputWidget
{
    /**
     * @var string
     */
    public $siteKey;
    
    /**
     * @var array
     * @see https://developers.google.com/recaptcha/docs/display#config
     */
    public $captchaOptions = [];
    
    /**
     * @var string
     */
    public $template = '{captcha} {input}';
    
    /**
     * @var string
     */
    private $_callback;
    
    public function init()
    {
        parent::init();
        if (!isset($this->siteKey)) {
            $this->siteKey = \Yii::$app->params['reCaptcha']['siteKey'];
            if (empty($this->siteKey)) {
                throw new InvalidConfigException("Required `siteKey` is not found.");
            }
        }
        Html::addCssClass($this->captchaOptions, 'g-recaptcha');
        $this->captchaOptions['data']['sitekey'] = $this->siteKey;
        $this->captchaOptions['id'] = $this->options['id'] . '_captcha';
        $this->_callback = Inflector::variablize($this->options['id'] . '_callback');
        $this->captchaOptions['data']['callback'] = $this->_callback;
    }
    
    public function run()
    {
        $this->registerJs();
        return strtr($this->template, [
            '{captcha}' => Html::tag('div', '', $this->captchaOptions),
            '{input}' => $this->renderInput(),
        ]);
    }
    
    private function renderInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::hiddenInput($this->name, $this->value, $this->options);
        }
    }
    
    private function registerJs()
    {
        $view = $this->getView();
        ReCaptchaAsset::register($view);
        $view->registerJs(<<<JS
;(function() {
    window.{$this->_callback} = function (response) {
        var input = $('#{$this->options['id']}');
        input.val(response);
        input.trigger('reCaptcha.success', [response]);
    };
})();        
JS
        );
        
    }
}
