<div id="login_modal" class="ui mini modal">
    <i class="close icon"></i>
    <div class="content">
        <user-auth 
            :login-action="'{{ route('user.login.login') }}'"
            :forgot-password-action="'{{ route('user.password.link') }}'" 
            :redirect-to="'{{ route('user.index') }}'">
        </user-auth>
    </div>
</div>