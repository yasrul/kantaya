<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;

//use app\models\TujuanSurat;
use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;
use app\models\UnitKerja;
use app\models\StatusTujuan;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelsTujuan app\models\SuratTujuan */
/* @var $modelRegister app\models\Register */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-keluar-form">
    <?php $form = ActiveForm::begin(['id' => 'surat-keluar-form']); ?>
    <?= $form->field($modelSurat, 'id_dari')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Surat Dari... ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    <?= $form->field($modelSurat, 'no_surat')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'tgl_surat')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Surat ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    
    <?= $form->field($modelSurat, 'perihal')->textarea(['row'=>'2', 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'lampiran')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'kecepatan_sampai')->dropDownList(KecepatanSampai::listKecepatan(), [
        'prompt' => '[ Pilih Kecepatan Sampai ]',
        'style' => 'width:300px',
    ]) ?>
    <?= $form->field($modelSurat, 'tingkat_keamanan')->dropDownList(TingkatKeamanan::listKeamanan(), [
        'prompt' => '[ Pilih Tingkat Keamanan ]',
        'style' => 'width : 300px',
    ]) ?>
    <?php if ($modelSurat->isNewRecord) : ?>
    <?= $form->field($modelSurat, 'filesup[]')->widget(FileInput::className(), [
        'options' => ['accept' => '*/*'],
        'pluginOptions' => [
            'allowedFileExtensions'=>['jpg','jpeg','png','pdf','zip','rar'], 
            'showUpload'=>FALSE,
            'showCaption'=>TRUE,
            'showRemove'=>true,
            'style' => 'width : 500px'
        ]
    ]) ?>
    <?php else : ?>
    <?= $form->field($modelSurat, 'filesup[]')->widget(FileInput::className(), [
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'showUpload' => FALSE,
            'initialPreview' => $urlFiles,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'initialPreviewConfig' => $previewConfig,
            'previewFileType' => 'any',
        ]
    ]); ?>
    <?php endif ?>
    <!--
    <?= $form->field($modelSurat, 'id_pengirim')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Pilih Pengirim ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    -->
    <div class="panel panel-default" style="width : 50%">
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
                'formId' => 'surat-keluar-form',
                'formFields' => [
                    'id_surat',
                    'id_penerima',
                    'status_tujuan'
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
                    <div class="row">
                        <div class="col-sm-8">
                            <?= $form->field($modelTujuan, "[{$i}]id_penerima")->widget(Select2::className(), [
                                'data' => UnitKerja::listUnit(1),
                                'options' => ['placeholder' => '[ Penerima Surat ]'],
                            ]); ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($modelTujuan, "[{$i}]status_tujuan")->dropDownList(StatusTujuan::listStatusTujuan(), [
                                'prompt' => '[Jenis Tujuan]',
                                'style' => 'width : 130px'
                            ]) ?>
                        </div>
                        <div class="col-sm-11 item-action">
                            <div class="pull-right">
	                    <button type="button" class="add-item btn btn-success btn-xs">
                                <i class="glyphicon glyphicon-plus"></i></button> 
	                    <button type="button" class="remove-item btn btn-danger btn-xs">
	                        <i class="glyphicon glyphicon-minus"></i></button>
                            </div>
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

