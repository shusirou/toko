@extends('layouts.app')

@section('title', __( 'user.edit_user' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'user.edit_user' )</h1>
</section>

<!-- Main content -->
<section class="content">
<div class="box">
    <div class="box-body">
    <div class="row">
    {!! Form::open(['url' => action('ManageUserController@update', [$user->id]), 'method' => 'PUT', 'id' => 'user_edit_form' ]) !!}
      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('surname', __( 'business.prefix' ) . ':') !!}
            {!! Form::text('surname', $user->surname, ['class' => 'form-control', 'placeholder' => __( 'business.prefix_placeholder' ) ]); !!}
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          {!! Form::label('first_name', __( 'business.first_name' ) . ':*') !!}
            {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'required', 'placeholder' => __( 'business.first_name' ) ]); !!}
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          {!! Form::label('last_name', __( 'business.last_name' ) . ':') !!}
            {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => __( 'business.last_name' ) ]); !!}
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-6">
        <div class="form-group">
          {!! Form::label('email', __( 'business.email' ) . ':*') !!}
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'required', 'placeholder' => __( 'business.email' ) ]); !!}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Inisial:*</label> 
          {!! Form::text('initial', $user->initial, ['class' => 'form-control', 'required', 'placeholder' =>'Inisial' ,'id'=>'initial']); !!}
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          {!! Form::label('role', __( 'user.role' ) . ':*') !!}
            {!! Form::select('role', $roles, $user->roles->first()->id, ['class' => 'form-control select2']); !!}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {!! Form::label('password', __( 'business.password' ) . ':') !!}
            {!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => __( 'business.password' ) ]); !!}
            <p class="help-block">@lang('user.leave_password_blank')</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {!! Form::label('confirm_password', __( 'business.confirm_password' ) . ':') !!}
            {!! Form::text('confirm_password', null, ['class' => 'form-control', 'placeholder' => __( 'business.confirm_password' ) ]); !!}
          
        </div>
      </div>
      <div class="clearfix"></div>
      
      <div class="col-md-4">
        <div class="form-group">
          {!! Form::label('cmmsn_percent', __( 'lang_v1.cmmsn_percent' ) . ':') !!} @show_tooltip(__('lang_v1.commsn_percent_help'))
            {!! Form::number('cmmsn_percent', $user->cmmsn_percent, ['class' => 'form-control', 'placeholder' => __( 'lang_v1.cmmsn_percent' ), 'step' => 0.01]); !!}
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
            <div class="checkbox">
            <br/>
              <label>
                {!! Form::checkbox('selected_contacts', 1, 
                $user->selected_contacts, 
                [ 'class' => 'input-icheck', 'id' => 'selected_contacts']); !!} {{ __( 'lang_v1.enable_selected_contacts' ) }}
              </label>
              @show_tooltip(__('lang_v1.tooltip_enable_selected_contacts'))
            </div>
        </div>
      </div>

      <div class="col-sm-4 selected_contacts_div @if(!$user->selected_contacts) hide @endif">
          <div class="form-group">
              {!! Form::label('selected_contacts', __('lang_v1.selected_contacts') . ':') !!}
              <div class="form-group">
                  {!! Form::select('selected_contact_ids[]', $contacts, $contact_access, ['class' => 'form-control select2', 'multiple', 'style' => 'width: 100%;' ]); !!}
              </div>
          </div>
      </div>

    </div>
    <div class="row">
     <div class="col-md-12">
      <button type="submit" class="btn btn-primary pull-right" id="submit_user_button">@lang( 'messages.update' )</button>
      </div>
    </div>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
  @stop
@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
    $('#selected_contacts').on('ifChecked', function(event){
      $('div.selected_contacts_div').removeClass('hide');
    });
    $('#selected_contacts').on('ifUnchecked', function(event){
      $('div.selected_contacts_div').addClass('hide');
    });
  });

  $('form#user_edit_form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    email: {
                        email: true
                    },
                    password: {
                        minlength: 5
                    },
                    confirm_password: {
                        equalTo: "#password",
                    }
                },
                messages: {
                    password: {
                        minlength: 'Password should be minimum 5 characters',
                    },
                    confirm_password: {
                        equalTo: 'Should be same as password'
                    },
                    username: {
                        remote: 'Invalid username or User already exist'
                    }
                }
            });
</script>
@endsection