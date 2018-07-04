<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DisposisiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$io == 'in' ? $label = 'Disposisi Masuk' : $label = 'Disposisi Keluar'; 
$this->title = $label;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Create Disposisi', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>
    <div class="panel panel-info">
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    //'id_surat',
                    ['attribute'=>'no_surat', 'value'=>'surat.no_surat'],
                    ['attribute'=>'pemberi', 'value'=>'pemberi.unit_kerja'],
                    'tgl_disposisi',
                    'tgl_selesai',
                    // 'id_intruksi',
                    // 'pesan',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
    
</div>
