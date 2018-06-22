<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Register', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_unit',
            'id_surat',
            'tgl_trans',
            'no_agenda',
            // 'kode',
            // 'status_surat',
            // 'status_reg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
