@extends('layouts.user')

@section('page-title', 'Step')

@section('content')
    <div class="user-dashboard__content-inner user-orders">
        <h3 class="user-dashboard__content-heading">Orders</h3>
        <div class="user-orders__pending mb-3">
            <h4 class="user-dashboard__content-subheading">Pending</h4>
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th class="text-center">Quantity</th>
                        <th>Courier</th>
                        <th>Delivery Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="spacer" colspan="4"></td></tr>
                    <tr class="table-custom__row--highlight">
                        <td>WEDDFGF45D</td>
                        <td class="text-center">5</td>
                        <td>Lalamove</td>
                        <td>March 5, 2020</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="user-orders__order-history">
            <h4 class="user-dashboard__content-subheading">Order History</h4>
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th class="text-center">Quantity</th>
                        <th>Courier</th>
                        <th>Delivery Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>WEDDFGF45D</td>
                        <td class="text-center">5</td>
                        <td>Lalamove</td>
                        <td>March 5, 2020</td>
                    </tr>
                    <tr>
                        <td>WEDDFGF45D</td>
                        <td class="text-center">5</td>
                        <td>Lalamove</td>
                        <td>March 5, 2020</td>
                    </tr>
                    <tr>
                        <td>WEDDFGF45D</td>
                        <td class="text-center">5</td>
                        <td>Lalamove</td>
                        <td>March 5, 2020</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection