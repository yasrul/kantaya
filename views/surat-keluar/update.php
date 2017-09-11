<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelSurat app\models\Surat */

$this->title = 'Update Surat Masuk : '.$modelSurat->id;
$this->params['breadcrumbs'][] = ['label' => 'Surat Keluar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSurat->id, 'url' =>['view', 'id' => $modelSurat->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="surat-keluar-update">
    <h1> <?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'modelSurat' => $modelSurat,
    ]) ?>
    
</div>