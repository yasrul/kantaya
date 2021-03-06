<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\UnitKerja;

/* @var $this yii\web\View */
/* @var $modelDispo app\models\Disposisi */
/* @var $modelDispoTujuan app\models\DisposisiTujuan */
/* @var $id_surat */

$this->title = 'Create Disposisi';
$this->params['breadcrumbs'][] = ['label'=>'View Surat', 'url'=>['view', 'id' => $id_surat]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-create">
    <h1><?= Html::encode($this->title)?></h1>
    
    <?php $form = ActiveForm::begin(['id' => 'disposisi-create-form']); ?>
    <?= $form->field($modelDispo, 'tgl_disposisi')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Disposisi ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    
    <?= $form->field($modelDispo, 'pesan')->textarea(['row'=>'2', 'style'=>'width : 500px']) ?>
    <?= $form->field($modelDispo, 'tgl_selesai')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Selesai ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    
    <div class="panel panel-default">
        <div class="panel-heading"><h5><i class="glyphicon glyphicon-th-list"></i> Penerima Disposisi </h5></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',  // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items',          // required: css class selector
                'widgetItem' => '.item',                     // required: css class
                'limit' => 99,                                // the maximum times, an element can be cloned (default 999)
                'min' => 1,                                  // 0 or 1 (default 1)
                'insertButton' => '.add-item',               // css class
                'deleteButton' => '.remove-item',            // css class
                'model' => $modelDispoTujuan[0],
                'formId' => 'disposisi-create-form',
                'formFields' => [
                    'id_disposisi',
                    'id_penerima',
                    'tgl_diterima',
                    'keterangan',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelDispoTujuan as $i => $dispoTujuan): ?>
                <div class="item row">    
                    <?php
                        // necessary for update action.
                        if (! $dispoTujuan->isNewRecord) {
                            echo Html::activeHiddenInput($dispoTujuan, "[{$i}]id");
                        }
                    ?>
                    <div class="col-sm-8 col-md-4">
                    <?= $form->field($dispoTujuan, "[{$i}]id_penerima")->widget(Select2::className(), [
                        'data' => UnitKerja::listUnit(Yii::$app->user->identity->unit_id),
                        'options' => ['placeholder' => '[ Penerima Disposisi ]'],
                        'pluginOptions' => ['allowClear' => true],
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
        <?= Html::submitButton($modelDispo->isNewRecord ? 'Create' : 'Update', ['class'=>$modelDispo->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>