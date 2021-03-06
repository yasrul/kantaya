<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Surat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Surats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no_surat',
            'tgl_surat',
            'perihal',
            'lampiran',
            'kecepatan_sampai',
            'tingkat_keamanan',
            'file_arsip',
            'id_pengirim',
            'pengirim_manual',
            'alamat_manual',
            'status_akses',
        ],
    ]) ?>

</div>
