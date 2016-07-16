<?php

use app\widgets\grid\ActionColumn;
use app\widgets\grid\LinkColumn;
use app\widgets\grid\SetColumn;
use app\modules\user\Module;
use app\modules\user\models\backend\User;
use app\modules\user\widgets\backend\grid\RoleColumn;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\user\forms\backend\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'ADMIN_USERS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Module::t('module', 'ADMIN_USERS_ADD'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
                ]),
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filterOptions' => [
                    'style' => 'max-width: 180px',
                ],
            ],
            [
                'class' => LinkColumn::className(),
                'attribute' => 'username',
            ],
            'email:email',
            [
                'class' => SetColumn::className(),
                'filter' => User::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    User::STATUS_ACTIVE => 'success',
                    User::STATUS_WAIT => 'warning',
                    User::STATUS_BLOCKED => 'default',
                ],
            ],
            [
                'class' => RoleColumn::className(),
                'filter' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
                'attribute' => 'role',
            ],

            ['class' => ActionColumn::className()],
        ],
    ]); ?>

</div>
