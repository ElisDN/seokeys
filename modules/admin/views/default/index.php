<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\User */

$this->title = Yii::t('admin', 'ADMIN');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('admin', 'ADMIN_USERS'), ['users/index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
