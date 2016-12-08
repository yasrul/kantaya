<?php

/* @var $this yii\web\View */
use yii\widgets\Block;

$this->title = 'E-AdminKada';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>E-AdminKada</h1>

        <p class="lead">Sistem Elektronik Administrasi Perkantoran Pemerintah Daerah</p>
        
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
