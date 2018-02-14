<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DisposisiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disposisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Disposisi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_surat',
            'id_pemberi',
            'tgl_disposisi',
            'tgl_selesai',
            // 'id_intruksi',
            // 'pesan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
