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
                        <th role="columnheader">{{ trans('translations.labels.courier') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.delivery_date') }}</th>
                    </tr>
                </thead>
                <tbody class="rowgroup">
                    <tr role="row" class="table-custom__row--highlight">
                        <td role="cell" data-header="Order #">WEDDFGF45D</td>
                        <td role="cell" data-header="Quantity" class="align-center">5</td>
                        <td role="cell" data-header="Courier #">Lalamove</td>
                        <td role="cell" data-header="Delivery Date #">March 5, 2020</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="user-orders__order-history">
            <h4 class="user-dashboard__content-subheading">Order History</h4>
            <table role="table" class="table-custom table-custom--borderless-sm">
                <thead role="rowgroup">
                    <tr role="row">
                        <th role="columnheader">{{ trans('translations.labels.order') }} #</th>
                        <th role="columnheader" class="align-center">{{ trans('translations.labels.quantity') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.courier') }}</th>
                        <th role="columnheader">{{ trans('translations.labels.date_delivered') }}</th>
                    </tr>
                </thead>
                <tbody role="rowgroup">
                    <tr role="row">
                        <td role="cell" data-header="Order #">WEDDFGF45D</td>
                        <td role="cell" data-header="Quantity" class="align-center">5</td>
                        <td role="cell" data-header="Courier">Lalamove</td>
                        <td role="cell" data-header="Delivery Date">March 5, 2020</td>
                    </tr>
                    <tr role="row">
                        <td role="cell" data-header="Order #">WEDDFGF45D</td>
                        <td role="cell" data-header="Quantity" class="align-center">5</td>
                        <td role="cell" data-header="Courier">Lalamove</td>
                        <td role="cell" data-header="Delivery Date">March 5, 2020</td>
                    </tr>
                    <tr role="row">
                        <td role="cell" data-header="Order #">WEDDFGF45D</td>
                        <td role="cell" data-header="Quantity" class="align-center">5</td>
                        <td role="cell" data-header="Courier">Lalamove</td>
                        <td role="cell" data-header="Delivery Date">March 5, 2020</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection