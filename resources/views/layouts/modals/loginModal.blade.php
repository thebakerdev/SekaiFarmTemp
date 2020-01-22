<div id="login_modal" class="ui mini modal">
    <i class="close icon"></i>
    <div class="content">
        <login-form :action="'{{ route('user.login.login') }}'" :redirect-to="'/dashboard'"></login-form>
    </div>
</div>