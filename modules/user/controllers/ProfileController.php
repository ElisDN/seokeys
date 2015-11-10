<?php

namespace app\modules\user\controllers;

use app\modules\user\forms\PasswordChangeForm;
use app\modules\user\models\User;
<<<<<<< HEAD
<<<<<<< HEAD
use app\modules\user\forms\ProfileUpdateForm;
use app\modules\user\Module;
=======
=======
use app\modules\user\Module;
>>>>>>> 9bb1cc2... Added modules t method
use app\modules\user\models\form\ProfileUpdateForm;
>>>>>>> 4bd6e97... Extracted translations initialization
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->findModel();
        $model = new ProfileUpdateForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPasswordChange()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->getSession()->setFlash('success', Module::t('module', 'FLASH_PASSWORD_CHANGE_SUCCESS'));
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}
