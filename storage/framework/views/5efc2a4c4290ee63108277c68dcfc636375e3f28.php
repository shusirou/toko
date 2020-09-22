<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo e(config('app.name', 'ultimatePOS')); ?></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.css?v='.$asset_v)); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/full.css?v='.$asset_v)); ?>">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #fff;
                font-family: 'Raleway', sans-serif;
                height: 100vh;
                margin: 0;
                background-color: #ffffff;
                background-image: url("./../public/images/wall3.jpg");
                
                background-repeat: no-repeat;
            }
/*
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .tagline{
                font-size:25px;
                font-weight: 300;
            }*/
        </style>
    </head>
    <body>
            <nav class="navbar navbar-fixed-top navbar-inverse" style="background: #3c8dbc;border: 1px solid #3c8dbc; color: #fff;" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo e(config('app.name', 'ultimatePOS')); ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <?php if(Route::has('login')): ?>
                        <?php if(Auth::check()): ?>
                            <li><a href="<?php echo e(action('HomeController@index')); ?>"><?php echo app('translator')->getFromJson('home.home'); ?></a></li>
                        <?php else: ?>
                           <li> <a href="<?php echo e(action('Auth\LoginController@login')); ?>"><?php echo app('translator')->getFromJson('lang_v1.login'); ?></a></li>
                            <?php if(env('ALLOW_REGISTRATION', true)): ?>
                                <li><a href="<?php echo e(route('business.getRegister')); ?>"><?php echo app('translator')->getFromJson('lang_v1.register'); ?></a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(Route::has('pricing') && config('app.env') != 'demo'): ?>
                       <li> <a href="<?php echo e(action('\Modules\Superadmin\Http\Controllers\PricingController@index')); ?>"><?php echo app('translator')->getFromJson('superadmin::lang.pricing'); ?></a></li>
                    <?php endif; ?>
                </ul>
                

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
      <!--   <div class="flex-center position-ref full-height">
            <div class="top-right links">

                <?php if(Route::has('login')): ?>
                    <?php if(Auth::check()): ?>
                        <a href="<?php echo e(action('HomeController@index')); ?>"><?php echo app('translator')->getFromJson('home.home'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo e(action('Auth\LoginController@login')); ?>"><?php echo app('translator')->getFromJson('lang_v1.login'); ?></a>
                        <?php if(env('ALLOW_REGISTRATION', true)): ?>
                            <a href="<?php echo e(route('business.getRegister')); ?>"><?php echo app('translator')->getFromJson('lang_v1.register'); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(Route::has('pricing') && config('app.env') != 'demo'): ?>
                    <a href="<?php echo e(action('\Modules\Superadmin\Http\Controllers\PricingController@index')); ?>"><?php echo app('translator')->getFromJson('superadmin::lang.pricing'); ?></a>
                <?php endif; ?>
            </div>

            <div class="content">
                <div class="title m-b-md" style="font-weight: 600 !important">
                    <?php echo e(config('app.name', 'ultimatePOS')); ?>

                </div>
                <p class="tagline">
                    <?php echo e(env('APP_TITLE', '')); ?>

                </p>
            </div> -->
        </div>
    </body>
</html>
