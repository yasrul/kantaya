<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\SuratSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'perihal') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'kecepatan_sampai') ?>

    <?php // echo $form->field($model, 'tingkat_keamanan') ?>

    <?php // echo $form->field($model, 'file_arsip') ?>

    <?php // echo $form->field($model, 'id_pengirim') ?>

    <?php // echo $form->field($model, 'pengirim_manual') ?>

    <?php // echo $form->field($model, 'alamat_manual') ?>

    <?php // echo $form->field($model, 'status_akses') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
