<?php $__env->startSection('title', __('lang_v1.my_profile')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->getFromJson('lang_v1.my_profile'); ?></h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-sm-6">
        <?php echo Form::open(['url' => action('UserController@updateProfile'), 'method' => 'post', 'id' => 'edit_user_profile_form',
            'class' => 'form-horizontal', 'files' => true ]); ?>

            <div class="box box-solid"> <!--business info box start-->
                <div class="box-header">
                    <div class="box-header">
                        <h3 class="box-title"> <?php echo app('translator')->getFromJson('user.edit_profile'); ?></h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php echo Form::label('surname', __('business.prefix') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <?php echo Form::text('surname', $user->surname, ['class' => 'form-control','placeholder' => __('business.prefix_placeholder')]);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('first_name', __('business.first_name') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <?php echo Form::text('first_name', $user->first_name, ['class' => 'form-control','placeholder' => __('business.first_name'), 'required']);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('last_name', __('business.last_name') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <?php echo Form::text('last_name', $user->last_name, ['class' => 'form-control','placeholder' => __('business.last_name')]);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('email', __('business.email') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <?php echo Form::email('email',  $user->email, ['class' => 'form-control','placeholder' => __('business.email') ]);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('language', __('business.language') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <?php echo Form::select('language',$languages, $user->language, ['class' => 'form-control select2']);; ?>

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo app('translator')->getFromJson('messages.update'); ?></button>
                </div>
            </div>
        <?php echo Form::close(); ?>

    </div>
    <div class="col-sm-6">
        <?php echo Form::open(['url' => action('UserController@updatePassword'), 'method' => 'post', 'id' => 'edit_password_form',
            'class' => 'form-horizontal' ]); ?>

            <div class="box box-solid"> <!--business info box start-->
                <div class="box-header">
                    <div class="box-header">
                        <h3 class="box-title"> <?php echo app('translator')->getFromJson('user.change_password'); ?></h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php echo Form::label('current_password', __('user.current_password') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <?php echo Form::password('current_password', ['class' => 'form-control','placeholder' => __('user.current_password'), 'required']);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('new_password', __('user.new_password') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <?php echo Form::password('new_password', ['class' => 'form-control','placeholder' => __('user.new_password'), 'required']);; ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('confirm_password', __('user.confirm_new_password') . ':', ['class' => 'col-sm-3 control-label']); ?>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <?php echo Form::password('confirm_password', ['class' => 'form-control','placeholder' =>  __('user.confirm_new_password'), 'required']);; ?>

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo app('translator')->getFromJson('messages.update'); ?></button>
                </div>
            </div>
        <?php echo Form::close(); ?>

    </div>
</div>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>