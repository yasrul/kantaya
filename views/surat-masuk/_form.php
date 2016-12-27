<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelTujuan app\models\TujuanSurat */
/* @var $modelRegin app\models\Regin */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-masuk-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($modelSurat, 'no_surat')->textInput() ?>
    <?= $form->field($modelSurat, 'tgl_surat')->textInput() ?>
    <?= $form->field($modelSurat, 'perihal')->textInput() ?>
    <?= $form->field($modelSurat, 'lampiran')->textInput() ?>
    <?= $form->field($modelSurat, 'kecepatan_tanggapan')->textInput() ?>
    <?= $form->field($modelSurat, 'tingkat_keamanan')->textInput() ?>
    <?= $form->field($modelSurat, 'file_arsip')->textInput() ?>
    <?= $form->field($modelSurat, 'id_pengirim')->textInput() ?>
    <?= $form->field($modelSurat, 'pengirim_manual')->textInput() ?>
    <?= $form->field($modelSurat, 'alamat_manual')->textInput() ?>
    
    <?= $form->field($modelTujuan, 'id_penerima')->textInput() ?>
    <?= $form->field($modelTujuan, 'penerima_manual')->textInput() ?>
    <?= $form->field($modelTujuan, 'alamat_manual')->textInput() ?>
    
    <?= $form->field($modelRegin, 'no_agenda')->textInput() ?>
    <?= $form->field($modelRegin, 'kode')->textInput() ?>
    <?= $form->field($modelRegin, 'tgl_terima')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

