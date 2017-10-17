<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\DisposisiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disposisi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_surat') ?>

    <?= $form->field($model, 'id_pemberi') ?>

    <?= $form->field($model, 'tgl_disposisi') ?>

    <?= $form->field($model, 'tgl_selesai') ?>

    <?php // echo $form->field($model, 'id_intruksi') ?>

    <?php // echo $form->field($model, 'pesan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
