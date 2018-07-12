<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelsTujuan app\models\SuratTujuan */

$this->title = 'Update Surat Keluar : '.$modelSurat->id;
$this->params['breadcrumbs'][] = ['label' => 'Surat Keluar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSurat->id, 'url' =>['view', 'id' => $modelSurat->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="surat-keluar-update">
    <h1> <?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'modelSurat' => $modelSurat,
        'modelsTujuan' => $modelsTujuan,
        'urlFiles' => $urlfiles,
        'previewConfig' => $previewConfig,
    ]) ?>
    
</div>