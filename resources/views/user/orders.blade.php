@extends('layouts.user')

@section('page-title', 'Step')

@section('content')
    <div class="user-dashboard__content-inner user-orders">
        <h3 class="user-dashboard__content-heading">Orders</h3>
        <div class="user-orders__pending mb-3">
            <h4 class="user-dashboard__content-subheading">Pending</h4>
            <table role="table" class="table-custom table-custom--borderless">
                <thead role="rowgroup">
                    <tr role="row">
                        <th role="columnheader">Order #</th>
                        <th role="columnheader" class="align-center">Quantity</th>
                        <th role="columnheader">Courier</th>
                        <th role="columnheader">Delivery Date</th>
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
                        <th role="columnheader">Order #</th>
                        <th role="columnheader" class="align-center">Quantity</th>
                        <th role="columnheader">Courier</th>
                        <th role="columnheader">Delivery Date</th>
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