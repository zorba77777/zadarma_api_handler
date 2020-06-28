<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CallSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-call-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'mentor_id') ?>

    <?= $form->field($model, 'sip_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'success') ?>

    <?php // echo $form->field($model, 'cost_per_minute') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
