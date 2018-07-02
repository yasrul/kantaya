<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

//use app\models\TujuanSurat;
use app\models\UnitKerja;

/* @var $this yii\web\View */
/* @var $modelsTujuan app\models\SuratTujuan */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-teruskan-form">
    <?php $form = ActiveForm::begin(['id' => 'surat-teruskan-form']); ?>
    
    <div class="panel panel-default">
        <div class="panel-heading"><h5><i class="glyphicon glyphicon-th-list"></i> Tujuan Surat</h5></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',  // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items',          // required: css class selector
                'widgetItem' => '.item',                     // required: css class
                'limit' => 99,                                // the maximum times, an element can be cloned (default 999)
                'min' => 1,                                  // 0 or 1 (default 1)
                'insertButton' => '.add-item',               // css class
                'deleteButton' => '.remove-item',            // css class
                'model' => $modelsTujuan[0],
                'formId' => 'surat-teruskan-form',
                'formFields' => [
                    'id_penerima',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsTujuan as $i => $modelTujuan): ?>
                <div class="item row">    
                    <?php
                        // necessary for update action.
                        if (! $modelTujuan->isNewRecord) {
                            echo Html::activeHiddenInput($modelTujuan, "[{$i}]id");
                        }
                    ?>
                    <div class="col-sm-8 col-md-4">
                    <?= $form->field($modelTujuan, "[{$i}]id_penerima")->widget(Select2::className(), [
                        'data' => UnitKerja::listUnit(1),
                        'options' => ['placeholder' => '[ Penerima Surat ]'],
                    ]); ?>                  
                    </div>              
                                       
                    <div class="col-sm-2 col-md-1 item-action">
                    	<div class="pull-right">
	                    <button type="button" class="add-item btn btn-success btn-xs">
                                <i class="glyphicon glyphicon-plus"></i></button> 
	                    <button type="button" class="remove-item btn btn-danger btn-xs">
	                        <i class="glyphicon glyphicon-minus"></i></button>
                    	</div>
                    </div>
                    
                </div><!-- .row -->

            <?php endforeach; ?>
            </div>

            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
      
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

