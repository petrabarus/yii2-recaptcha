<?php
/**
 * ReCaptchaValidator class file.
 * @author Petra Barus <petra.barus@gmail.com>
 */

namespace PetraBarus\Yii2\ReCaptcha;

use yii\validators\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;

/**
 * ReCaptchaValidator validates reCaptcha input from server.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ReCaptchaValidator extends Validator
{
    /**
     * @var string
     */
    public $secretKey;
    
    /**
     * @inheritdoc
     * @var boolean
     */
    public $skipOnEmpty = false;
    
    public function init()
    {
        parent::init();
        if (!isset($this->secretKey)) {
            $this->secretKey = \Yii::$app->params['reCaptcha']['secretKey'];
            if (empty($this->secretKey)) {
                throw new InvalidConfigException("Required `secretKey` is not found.");
            }
        }
        if (!\Yii::$app->getRequest() instanceof \yii\web\Request) {
            throw new InvalidConfigException("Request has to be instance of '\yii\web\Request'");
        }
    }
    
    /**
     * Validates a value.
     * @param mixed $value the data value to be validated.
     */
    protected function validateValue($value)
    {
        $remoteIp = \Yii::$app->getRequest()->getUserIP();
        $recaptcha = new GoogleReCaptcha($this->secretKey);
        $response = $recaptcha->verify($value, $remoteIp);
        if ($response->isSuccess()) {
            return null;
        }
        \Yii::error(__METHOD__ . ': ' . serialize($response->getErrorCodes()), __CLASS__);
        return [$this->message];
    }
}
