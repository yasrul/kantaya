<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Surat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_surat')->textInput() ?>

    <?= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lampiran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kecepatan_sampai')->textInput() ?>

    <?= $form->field($model, 'tingkat_keamanan')->textInput() ?>

    <?= $form->field($model, 'file_arsip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pengirim')->textInput() ?>

    <?= $form->field($model, 'pengirim_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_akses')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
