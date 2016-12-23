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
    <?= $form->field($modelSurat, 'perihal')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

