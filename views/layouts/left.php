<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!--
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        -->
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Kantaya', 'options' => ['class' => 'header']],
                    ['label' => 'Surat Masuk', 'icon' => 'envelope', 'url' => '#', 'items' => [
                        ['label' => 'Surat Masuk', 'icon' => 'download', 'url' => ['surat-masuk/index']],
                        ['label' => 'Disposisi Masuk', 'icon' => 'hand-o-down', 'url' => ['disposisi/index', 'io' => 'in']]
                    ]],
                    ['label' => 'Surat Keluar', 'icon' => 'envelope-o', 'url' => '#', 'items' => [
                        ['label' => 'Surat Keluar', 'icon' => 'upload', 'url' => ['surat-keluar/index']],
                        ['label' => 'Disposisi Keluar', 'icon' => 'hand-o-up', 'url' => ['disposisi/index', 'io' => 'out']]
                    ]],
                    ['label' => 'Laporan', 'icon' => 'files-o', 'url' => '#'],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        ) ?>

    </section>

</aside>
