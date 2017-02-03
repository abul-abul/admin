{!! Form::open(array('action' => 'AdminController@postLogin', 'class' => 'login-form')) !!}       
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              {!! Form::text('login', null, [ 'class' => 'form-control' , 'placeholder' => 'Username']) !!}
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                {!! Form::password('password', [ 'class' => 'form-control' , 'placeholder' => 'Password']) !!}
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
        </div>
{!! Form::close() !!} 