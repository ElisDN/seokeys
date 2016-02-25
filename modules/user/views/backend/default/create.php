<?php

use app\modules\user\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\backend\User */

$this->title = Module::t('module', 'TITLE_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'ADMIN_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
