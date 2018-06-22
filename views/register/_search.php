<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\RegisterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="register-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_unit') ?>

    <?= $form->field($model, 'id_surat') ?>

    <?= $form->field($model, 'tgl_trans') ?>

    <?= $form->field($model, 'no_agenda') ?>

    <?php // echo $form->field($model, 'kode') ?>

    <?php // echo $form->field($model, 'status_surat') ?>

    <?php // echo $form->field($model, 'status_reg') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
