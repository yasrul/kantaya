<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */
/* @var $modelRegister app\models\Register */
/* @var $modelTujuan app\models\TujuanSurat */

$this->title = 'Create Surat Masuk (manual)';
$this->params['breadcrumbs'][] = ['label'=>'Surat Masuk', 'url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-create">
    <h1><?= Html::encode($this->title)?></h1>
    
    <?= $this->render('_form', [
        'modelSurat'=>$modelSurat,
        'modelTujuan'=>$modelTujuan,
        'modelRegister'=>$modelRegister
    ]) ?>
</div>
