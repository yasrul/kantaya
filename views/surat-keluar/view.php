
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View  */
/* @var $modelSurat app\models\Surat */

$this->title = $modelSurat->id;
$this->params['breadcrumbs'][] = ['label' => 'Surat Keluar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="surat-keluar-view">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('Update', ['update', 'id' => $modelSurat->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Delete', ['delete', 'id' => $modelSurat->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are You sure you want to delete this item ?',
                'method' => 'post',
            ]
        ]); ?>
    </p>
    
    <?= DetailView::widget([
        'model' => $modelSurat,
        'attributes' => [
            'id',
            'no_surat',
            'tgl_surat',
            'perihal',
            'lampiran',
            'kecepatan_sampai',
            'tingkat_keamanan',
            'id_pengirim',
            'pengirim_manual',
            'alamat_manual',
        ]
    ]) ?>
    
    <?= GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider([
            'query' => $modelSurat->getTujuan(),
            'pagination' => false,
        ]),
        'columns' => [
            'id_penerima',
            'tgl_diterima',
            'penerima_manual',
            'alamat_manual',
            'status_tujuan',
        ]
    ]) ?>
</div>
   