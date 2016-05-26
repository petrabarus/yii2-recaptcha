# Yii2 ReCaptcha

Google reCaptcha widget for Yii2.

[![Latest Stable Version](https://poser.pugx.org/petrabarus/yii2-recaptcha/v/stable.svg)](https://packagist.org/packages/petrabarus/yii2-recaptcha)
[![Total Downloads](https://poser.pugx.org/petrabarus/yii2-recaptcha/downloads.svg)](https://packagist.org/packages/petrabarus/yii2-recaptcha)
[![Latest Unstable Version](https://poser.pugx.org/petrabarus/yii2-recaptcha/v/unstable.svg)](https://packagist.org/packages/petrabarus/yii2-recaptcha)
[![Build Status](https://travis-ci.org/petrabarus/yii2-recaptcha.svg?branch=add-travis-ci)](https://travis-ci.org/petrabarus/yii2-recaptcha)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist petrabarus/yii2-recaptcha "*"
```

or add

```
"petrabarus/yii2-recaptcha": "*"
```

to the require section of your `composer.json` file.

## Requirement

This package require

- Latest Yii2
- PHP 5.4 or later

## Usage

Obtain the credentials in [Google reCaptch](https://www.google.com/recaptcha).
After that dd configuration in the params.

```
[
    'reCaptcha' => [
        'siteKey' => 'ABCDEFGHIJKLMN',
        'secretKey' => 'ABCDEFGHIJKLMN',
    ]
]
```

Make sure the configuration can be accessed via `Yii::$app->params['reCaptcha']['siteKey']`
and `Yii::$app->params['reCaptcha']['secretKey']`.

To use in the active form.

```
$form->field($model, 'captcha')->widget(\PetraBarus\Yii2\ReCaptcha\ReCaptcha::class);
```

To add validator in the rules

```
['captcha', \PetraBarus\Yii2\ReCaptcha\ReCaptchaValidator::class],
```