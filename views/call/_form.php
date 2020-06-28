<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Call */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-call-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_id')->textInput() ?>

    <?= $form->field($model, 'mentor_id')->textInput() ?>

    <?= $form->field($model, 'sip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'success')->textInput() ?>

    <?= $form->field($model, 'cost_per_minute')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
