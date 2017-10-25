<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('+ Surat Masuk Manual', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_dari',
            ['attribute' => 'dari', 'value' => 'dari.unit_kerja'],
            'no_surat',                      
            ['attribute'=>'tgl_surat', 'contentOptions'=>['style'=>'width : 10%']],
            'perihal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
