
<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View  */
/* @var $modelSurat app\models\Surat */

$this->title = $modelSurat->id;
$this->params['breadcrumbs'][] = ['label' => 'Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="surat-masuk-view">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?php if (Yii::$app->user->identity->unit_id == $modelSurat->id_perekam) : ?>
        <?= Html::a('Update', ['update', 'id' => $modelSurat->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Delete', ['delete', 'id' => $modelSurat->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are You sure you want to delete this item ?',
                'method' => 'post',
            ]
        ]); ?>
        <?php endif; ?>
        
        <?= Html::a('Buat Disposisi', ['disposisi/create', 'id' => $modelSurat->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Teruskan', ['teruskan', 'id' => $modelSurat->id], ['class' => 'btn btn-success', 'data-toggle' => "modal", 'data-target' => "#teruskanModal"]) ?>
    </p>
    
    <?= DetailView::widget([
        'model' => $modelSurat,
        'attributes' => [
            'id',
            'no_surat',
            'tgl_surat',
            'perihal',
            'lampiran',
            'kecepatanSampai.nama_kecepatan',
            'tingkatKeamanan.nama_tingkat',
            'pengirim.unit_kerja',
            //'pengirim_manual',
            //'alamat_manual',
        ]
    ]) ?>
    
    <div class="panel panel-success">
        <div class="panel-heading">Tujuan Surat</div>        
        <div class="panel-body">
            <?= GridView::widget([
            'dataProvider' => new yii\data\ActiveDataProvider([
                'query' => $modelSurat->getTujuan(),
                'pagination' => false,
            ]),
            'columns' => [
                'penerima.unit_kerja',
                'tgl_diterima',
                //'penerima_manual',
                //'alamat_manual',
                ['attribute'=>'status_tujuan', 'value'=>'statusTujuan.status_name'],
            ]
        ]) ?>
        </div>
    </div>
    
    <div class="panel panel-info">
        <div class="panel-heading">Disposisi Surat</div>
        <div class="panel-body">
            <?= GridView::widget([
            'dataProvider' => new yii\data\ActiveDataProvider([
                'query' => $modelSurat->getDisposisi(),
                'pagination' => FALSE
            ]),
            'columns' => [
                'id_pemberi',
                'tgl_disposisi',
                'tgl_selesai',
                'pesan'
        ]
    ]) ?>
        </div>
    </div>
    
</div>

<?php
 Modal::begin([
     'header' => '<h4>Tujuan Terusan</h4>',
     'id' => 'teruskanModal',
     'size' => 'modal-lg'
 ]);
    Pjax::begin([
        'id'=>'pjax-modal', 'timeout'=>false,
        'enablePushState'=>false,
        'enableReplaceState'=>false,
    ]);
    
    Pjax::end();
 
 Modal::end();
?>

<?php 
$this->registerJs('
    $("#teruskanModal").on("shown.bs.modal", function(event) {
            var button = $(event.relatedTarget)
            var href = button.attr("href")
            $.pjax.reload("#pjax-modal", {
                "timeout":false,
                "url":href,
                "replace":false,
            });
    })
');
?>