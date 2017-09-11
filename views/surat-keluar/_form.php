<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use mdm\widgets\TabularInput;

use app\models\TujuanSurat;
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
    <?= $form->field($modelSurat, 'no_surat')->textInput(['maxLength'=>true, 'style'=>'width : 500px']) ?>
    <?= $form->field($modelSurat, 'tgl_surat')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Surat ]', 'style' => 'width : 300px'],
        'pluginOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd'
        ],
        'removeButton' => false
    ]) ?>
    <?= $form->field($modelSurat, 'tgl_diterima')->widget(DatePicker::className(), [
        'options' => ['placeholder' => '[ Tanggal Diterima ]', 'style' => 'width : 300px'],
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
    <?= $form->field($modelSurat, 'id_pengirim')->widget(Select2::className(), [
        'data' => UnitKerja::listUnit(1),
        'options' => ['placeholder' => '[ Pilih Pengirim ]'],
        'pluginOptions' => ['allowClear' => true, 'width'=>'500px']
    ]) ?>
    
    <?php echo Collapse::widget([
        'items' => [
            [
                'label' => 'Pengirim Manual',
                'content' => [
                    $form->field($modelSurat, 'pengirim_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px']),
                    $form->field($modelSurat, 'alamat_manual')->textInput(['maxLength'=>true, 'style'=>'width : 500px'])
                ]
            ]
        ]
    ]) ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><a id="btn-add"><span class="glypicon glypicon-plus"></span></a></th>
            </tr>
        </thead>
    <?= 
        TabularInput::widget([
            'id' => 'detail-grid',
            'allModels' => $modelSurat->tujuan,
            'model' => TujuanSurat::className(),
            'tag' => 'tbody',
            'form' => $form,
            'itemOptions' => ['tag' => 'tr'],
            'itemView' => '_item_detil',
            'clientOptions' => [
            'btnAddSelector' => '#btn-add',
            ]
        ]);
    ?>
    </table>
      
    <div class="form-group">
        <?= Html::submitButton($modelSurat->isNewRecord ? 'Create' : 'Update', ['class'=>$modelSurat->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

