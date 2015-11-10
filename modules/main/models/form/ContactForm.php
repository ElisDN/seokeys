<?php

namespace app\modules\main\models\form;

use Yii;
use yii\base\Model;
use app\modules\main\Module;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'captchaAction' => '/main/contact/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'CONTACT_NAME'),
            'email' => Module::t('module', 'CONTACT_EMAIL'),
            'subject' => Module::t('module', 'CONTACT_SUBJECT'),
            'body' => Module::t('module', 'CONTACT_MESSAGE'),
            'verifyCode' => Module::t('module', 'CONTACT_VERIFY_CODE'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        } else {
            return false;
        }
    }
}
