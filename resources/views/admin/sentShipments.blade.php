@extends('layouts.admin')

@section('page-title', 'Sent')

@section('content')
    <div class="ui card fluid">
        <div class="content">
            <div class="header">
                <h2 class="ui header">{{ __('translations.headings.sent_shipment') }}</h2>
            </div>
        </div>
        <div class="content">
            <table class="ui celled table table-break">
                <thead>
                    <th>{{ __('translations.labels.order_no') }}</th>
                    <th>{{ __('translations.headings.qty') }}</th>
                    <th>{{ __('translations.labels.tracking_number') }}</th>
                    <th>{{ __('translations.labels.name') }}</th>
                    <th>{{ __('translations.labels.country') }}</th>
                    <th>{{ __('translations.labels.state') }}</th>
                    <th>{{ __('translations.labels.city') }}</th>
                    <th>{{ __('translations.labels.postal') }}</th>
                    <th>{{ __('translations.labels.address_1') }}</th>
                    <th>{{ __('translations.labels.address_2') }}</th>
                    <th>{{ __('translations.labels.phone') }}</th>
                    <th class="right aligned three wide">{{ __('translations.labels.options') }}</th>
                </thead>
                <tbody>
                    @if($sent->count())
                        @foreach($sent as $shipment)
                            <tr>
                                <td class="break-word">{{ $shipment->order_number }}</td>
                                <td class="break-word">{{ $shipment->qty }}</td>
                                <td class="break-word">{{ $shipment->tracking_number }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->name }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->country }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->state }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->city }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->postal }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->address1 }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->address2 }}</td>
                                <td class="break-word">{{ $shipment->user->default_address->phone }}</td>
                                <td>
                                    <div class="group content flex align-right">
                                        @if ($shipment->date_delivered === null)
                                            <button class="mini ui teal button delivered_button" type="button" data-id="{{ $shipment->id }}">{{ __('translations.buttons.delivered') }}</button>
                                        @endif
                                        <form method="POST" action="{{ route('shipment.destroy') }}" class="ui right floated" onSubmit="return confirm('{{ __('translations.texts.delete_confirm') }} {{ $shipment->name }}');">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="shipment_id" value="{{ $shipment->id }}" />
                                            <button class="mini ui red button">{{ __('translations.buttons.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" class="text-center"><em>{{ __('translations.texts.no_sent') }}</em></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.modals.ordersInfoModal')
@endsection
@section('page-script-after')
    <script>
        $(document).ready(function(){

            $('.delivered_button').click(function() {

                var id = $(this).attr('data-id');

                axios.put('/shipment/delivered',{id: id}).then(function(response){
                    
                    if (response.data.status === 'success') {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection