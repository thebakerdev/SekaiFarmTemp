@extends('layouts.user')

@section('page-title', 'Step')

@section('content')
    <div class="user-dashboard__content-inner user-address">
        <h3 class="user-dashboard__content-heading mb-0">Address</h3>
        <div class="user-address__list">
            <table role="table" class="table-custom table-custom--borderless table-custom--spaced">
                <thead role="rowgroup">
                    <tr role="row">
                        <th role="columnheader">Name</th>
                        <th role="columnheader">Address</th>
                        <th role="columnheader">Postal</th>
                        <th role="columnheader">Phone</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="rowgroup">
                    <tr role="row" class="table-custom__row--raised active">
                        <td role="cell" data-header="Name">John Doe</td>
                        <td role="cell" data-header="Address">
                            <address class="w-50">
                                Iris Watson <br>
                                P.O. Box 283 8562 Fusce Rd.<br>
                                Frederick Nebraska 20620<br>
                                United States<br>
                                <small class="color--blue">Default Address</small>
                            </address>
                            
                        </td>
                        <td role="cell" data-header="Postal">12046</td>
                        <td role="cell" data-header="Phone">+3234434343</td>
                        <td><a class="link link--secondary" href="#">EDIT</a></td>
                    </tr>
                    <tr role="row" class="table-custom__row--raised">
                        <td role="cell" data-header="Name">John Riggs</td>
                        <td role="cell" data-header="Address">
                            <address class="w-50">
                                Iris Watson <br>
                                P.O. Box 283 8562 Fusce Rd.<br>
                                Frederick Nebraska 20620<br>
                                United States<br>
                                <small class="color--grey-4 c-pointer">Set as default</small>
                            </address>
                        </td>
                        <td role="cell" data-header="Postal">12046</td>
                        <td role="cell" data-header="Phone">+3234434343</td>
                        <td><a class="link link--secondary" href="#">EDIT</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-2 text-right">
                <button class="ui button button--primary">Add New Address</button>
            </div>
        </div>
    </div>
@endsection