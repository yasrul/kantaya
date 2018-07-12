<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelTujuan app\models\TujuanSurat */

$this->title = 'Update Surat Masuk : '.$modelSurat->id;
$this->params['breadcrumbs'][] = ['label' => 'Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSurat->id, 'url' =>['view', 'id' => $modelSurat->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="surat-masuk-update">
    <!--<h1> <?= Html::encode($this->title) ?></h1>-->
    
    <?= $this->render('_form', [
        'modelSurat' => $modelSurat,
        'modelTujuan' => $modelTujuan,
        'urlFiles' => $urlFiles,
        'previewConfig' => $previewConfig,
    ]) ?>
    
</div>