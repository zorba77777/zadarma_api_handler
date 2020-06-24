<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserCallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Calls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-call-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Call', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'account_id',
            'mentor_id',
            'sip_id',
            'created_at',
            'city',
            'success',
            'cost_per_minute',
            'duration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?= Html::a('Fetch statistic', ['user-call/fetch-stat'], ['class' => 'btn btn-success']) ?>
