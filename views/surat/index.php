<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SuratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Surat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'no_surat',
            'tgl_surat',
            'perihal',
            'lampiran',
            // 'kecepatan_sampai',
            // 'tingkat_keamanan',
            // 'file_arsip',
            // 'id_pengirim',
            // 'pengirim_manual',
            // 'alamat_manual',
            // 'status_akses',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
