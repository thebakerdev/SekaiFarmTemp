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
                </thead>
                <tbody>
                    <tr>
                        <td class="break-word">test</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
