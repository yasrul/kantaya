<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disposisi */

$this->title = 'Update Disposisi: ' . $modelDispo->id;
$this->params['breadcrumbs'][] = ['label' => 'Disposisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelDispo->id, 'url' => ['view', 'id' => $modelDispo->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disposisi-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'modelDispo' => $modelDispo,
        'modelsTujuan' => $modelsTujuan,
    ]) ?>

</div>
