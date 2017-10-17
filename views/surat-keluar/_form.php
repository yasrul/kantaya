<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
//use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
//use mdm\widgets\TabularInput;

//use app\models\TujuanSurat;
use app\models\KecepatanSampai;
use app\models\TingkatKeamanan;
use app\models\UnitKerja;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelTujuan app\models\TujuanSurat */
/* @var $modelRegister app\models\Register */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="surat-keluar-form">
    <?php $form = ActiveForm::begin(['id' => 'surat-masuk-form']); ?>
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
    
    <?= $form->field($modelSurat, 'file_arsip')->textInput() ?>
    <!--
    <?= $form->field($modelSurat, 'id_pengirim')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Pilih Pengirim ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    -->
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
                'model' => $modelTujuan[0],
                'formId' => 'surat-masuk-form',
                'formFields' => [
                    'id_surat',
                    'id_penerima',
                    'penerima_manual',
                    'alamat_manual',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelTujuan as $i => $tujuan): ?>
                <div class="item row">    
                    <?php
                        // necessary for update action.
                        if (! $tujuan->isNewRecord) {
                            echo Html::activeHiddenInput($tujuan, "[{$i}]id");
                        }
                    ?>
                    <div class="col-sm-8 col-md-4">
                    <?= $form->field($tujuan, "[{$i}]id_penerima")->widget(Select2::className(), [
                        'data' => UnitKerja::listUnit(Yii::$app->user->identity->unit_id),
                        'options' => ['placeholder' => '[ Penerima Surat... ]'],
                        'pluginOptions' => ['allowClear' => true],
                    ]); ?>
                    </div>
                                       
                    <!--
                        <?php echo Collapse::widget([
                        'items' => [
                            [
                                'label' => 'Pengirim Manual',
                                'content' => [
                                    $form->field($tujuan, "[{$i}]penerima_manual")->textInput(['maxLength'=>true]),
                                    $form->field($tujuan, "[{$i}]alamat_manual")->textInput(['maxLength'=>true])
                                ]
                            ]
                        ]
                        ]) ?>
                    -->
                          
                                       
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

