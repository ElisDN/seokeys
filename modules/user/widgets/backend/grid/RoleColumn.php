<?php

namespace app\modules\user\widgets\backend\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;

class RoleColumn extends DataColumn
{
    public $defaultRole = 'user';

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $label = $value ? $this->getRoleLabel($value) : $value;
        $class = $value == $this->defaultRole ? 'primary' : 'danger';
        $html = Html::tag('span', Html::encode($label), ['class' => 'label label-' . $class]);
        return $value === null ? $this->grid->emptyCell : $html;
    }

    /**
     * @param string $roleName
     * @return string
     */
    protected function getRoleLabel($roleName)
    {
        if ($role = Yii::$app->authManager->getRole($roleName)) {
            return $role->description;
        } else {
            return $roleName;
        }
    }
}