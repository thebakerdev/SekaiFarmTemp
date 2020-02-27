@extends('layouts.user')

@section('page-title', trans('translations.labels.orders'))

@section('content')
    <div class="user-dashboard__content-inner user-orders">
        <h3 class="user-dashboard__content-heading">{{ trans('translations.labels.orders') }}</h3>
        <div class="user-orders__pending mb-3">
            <h4 class="user-dashboard__content-subheading">{{ trans('translations.headings.pending') }}</h4>
            <table role="table" class="table-custom table-custom--borderless">
                <thead role="rowgroup">
                    <tr role="row">
                        <th role="columnheader">{{ trans('translations.labels.order') }} #</th>
                        <th role="columnheader" class="align-center">{{ trans('translations.labels.quantity') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.delivery_date') }}</th>
                    </tr>
                </thead>
                <tbody class="rowgroup">
                    @if ($user->undelivered()->count() > 0)
                        <tr role="row" class="table-custom__row--highlight">
                            <td role="cell" data-header="{{ trans('translations.labels.order') }} #">{{ $user->undelivered[0]->order_number }}</td>
                            <td role="cell" data-header="{{ trans('translations.labels.quantity') }}" class="align-center">{{ $user->undelivered[0]->qty }}</td>
                            <td role="cell" data-header="{{ trans('translations.labels.delivery_date') }} #">{{ $user->undelivered[0]->delivery_date }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="text-center">
                                <em>{{ trans('translations.texts.no_pending_deliveries') }}</em>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="user-orders__order-history">
            <h4 class="user-dashboard__content-subheading">{{ trans('translations.headings.order_history') }}</h4>
            <table role="table" class="table-custom table-custom--borderless-sm">
                <thead role="rowgroup">
                    <tr role="row">
                        <th role="columnheader">{{ trans('translations.labels.order') }} #</th>
                        <th role="columnheader" class="align-center">{{ trans('translations.labels.quantity') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.status') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.date_delivered') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.invoice') }}</th>
                    </tr>
                </thead>
                <tbody role="rowgroup">
                    @if ($user->delivered()->count() > 0)
                        @foreach($user->delivered as $delivered) 
                            <tr role="row">
                                <td role="cell" data-header="{{ trans('translations.labels.order') }} #">{{ $delivered->order_number }}</td>
                                <td role="cell" data-header="{{ trans('translations.labels.quantity') }}" class="align-center">{{ $delivered->qty }}</td>
                                <td role="cell" data-header="{{ trans('translations.labels.status') }}">{{ $delivered->status }}</td>
                                <td role="cell" data-header="{{ trans('translations.labels.date_delivered') }}">{{ $delivered->date_delivered }}</td>
                                <td role="cell" data-header="{{ trans('translations.labels.invoice') }}"><a href="{{ $delivered->invoice_url }}" target="_blank"><i class="file alternate outline icon"></i></a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">
                                <em>{{ trans('translations.texts.no_order_history') }}</em>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection