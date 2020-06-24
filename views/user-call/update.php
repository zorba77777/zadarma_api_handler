<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserCall */

$this->title = 'Update User Call: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-call-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
