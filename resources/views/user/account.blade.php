@extends('layouts.user')

@section('page-title', 'Step')

@section('content')
    <div class="user-dashboard__content-inner user-account">
        <h3 class="user-dashboard__content-heading">Account</h3>
        <div class="ui grid">
            <div class="sixteen wide mobile eight wide tablet eight wide computer column pb-0 user-dashboard__content-divider">
                <div class="form-display">
                    <div class="field">
                        <label for="name" class="field__item">Name</label>
                        <span id="name" class="field__item">John Doe</span>
                    </div>
                    <div class="field">
                        <label for="email" class="field__item">Email</label>
                        <span id="email" class="field__item">email@email.com</span>
                    </div>
                    <div class="field">
                        <label for="address" class="field__item">Address</label>
                        <div class="field__item">
                            <address id="address" class="mb-h">
                                Iris Watson <br>
                                P.O. Box 283 8562 Fusce Rd. <br>
                                Frederick Nebraska 20620<br>
                                United States
                            </address>
                            <a href="{{ route('user.address.index') }}" class="link link--secondary">EDIT</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sixteen wide mobile eight wide tablet eight wide computer column text-center">
                <button class="ui button button--primary  button--fixed mb-2">Edit Profile</button><br>
                <button class="ui button button--secondary button--fixed">Change Password</button>
            </div>
        </div>
    </div>
@endsection