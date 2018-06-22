<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelDispo app\models\Disposisi */
/* @var $modelDispoTujuan app\models\DisposisiTujuan */

$this->title = 'Create Disposisi';
$this->params['breadcrumbs'][] = ['label'=>'View Surat', 'url'=>['surat-masuk/view', 'id' => $id_surat]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposisi-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'modelDispo' => $modelDispo,
        'modelDispoTujuan' => $modelDispoTujuan,
    ]) ?>

</div>
