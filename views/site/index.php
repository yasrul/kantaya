<?php

/* @var $this yii\web\View */
use yii\widgets\Block;

$this->title = 'Sel-Biru';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>SEL-BIRU</h1>

        <p class="lead">Surat Elektronik Biro Umum</p>
        
    </div>

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
