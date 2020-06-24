<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserCall */

$this->title = 'Create User Call';
$this->params['breadcrumbs'][] = ['label' => 'User Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-call-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
