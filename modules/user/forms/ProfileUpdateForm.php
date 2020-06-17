<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;

class ProfileUpdateForm extends Model
{
    public $email;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->email = $user->email;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('user', 'ERROR_EMAIL_EXISTS'),
                'filter' => function (ActiveQuery $query) {
                        $query->andWhere(['<>', 'id', $this->_user->id]);
                    },
            ],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool
     */
    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->email = $this->email;
            return $user->save();
        } else {
            return false;
        }
    }
} 