@extends('layouts.admin')

@section('page-title', 'Users')

@section('content')
    <div class="ui card fluid">
        <div class="content">
            <div class="header">
                <h2 class="ui header">{{ __('translations.headings.users') }}</h2>
            </div>
        </div>
        <div class="content">
            <table class="ui celled table table-break">
                <thead>
                    <th>{{ __('translations.labels.email') }}</th>
                    <th>{{ __('translations.labels.name') }}</th>
                    <th>Stripe ID</th>
                    <th>Plan</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @if ($users->count())
                        @foreach($users as $user)
                        <tr>
                            <td class="break-word">{{ $user->email }}</td>
                            <td class="break-word">{{ $user->name }}</td>
                            <td class="break-word">{{ $user->stripe_id }}</td>
                            <td class="break-word">{{ $user->subscription()->stripe_plan }}</td>
                            <td class="break-word">{{ $user->subscription()->quantity }}</td>
                            <td class="break-word">{{ $user->subscription()->stripe_status }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
                                <em>{{ trans('translations.texts.no_users') }}</em>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
