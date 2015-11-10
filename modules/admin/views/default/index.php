<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\User */

$this->title = Module::t('module', 'ADMIN');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Module::t('module', 'ADMIN_USERS'), ['users/index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
