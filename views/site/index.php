<?php

/* @var $this yii\web\View */
use yii\widgets\Block;

$this->title = 'Sel-Biru';
?>
<div class="site-index">
  
    <h1 align="center">SeL-BirU</h1>
    <h2 align="center">SURAT ELEKTRONIK BIRO UMUM</h2>
    <img src="kantorgubntb.jpg" class="img-responsive center-block">

    <div class="body-content">

            <?php Block::begin([
                'id' => 'sidebar'
            ]); ?>
            <h1>Menu</h1>
            <ul>
                <li>Home</li>
                <li>About</li>
                <li>Contack</li>
            </ul>
            <?php Block::end(); ?>
            
    </div>
</div>
