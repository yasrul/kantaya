<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TujuanSurat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tujuan-surat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_surat')->textInput() ?>

    <?= $form->field($model, 'id_penerima')->textInput() ?>

    <?= $form->field($model, 'penerima_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_manual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
