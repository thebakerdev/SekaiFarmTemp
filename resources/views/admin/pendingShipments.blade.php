@extends('layouts.admin')

@section('page-title', 'Pending')

@section('content')
    <div class="ui card fluid">
        <div class="content">
            <div class="header">
                <h2 class="ui header">{{ __('translations.headings.pending_shipment') }}</h2>
            </div>
        </div>
        <div class="content">
            <table class="ui celled table table-break">
                <thead>
                    <th>{{ __('translations.labels.order_no') }}</th>
                    <th>{{ __('translations.headings.qty') }}</th>
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
                    @if($pending->count())
                        @foreach($pending as $shipment)
                            <tr>
                                <td class="break-word">{{ $shipment->order_number }}</td>
                                <td class="break-word">{{ $shipment->qty }}</td>
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
                                        <form method="POST" action="{{ route('shipment.sent') }}" id="sentForm-{{ $shipment->id }}" class="ui right floated">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="shipment_id" value="{{ $shipment->id }}">
                                            <input type="hidden" class="trackingNumber" name="tracking_number" value="0">
                                            <button class="mini ui teal button sent-button" type="button" data-id="{{ $shipment->id }}">{{ __('translations.buttons.sent') }}</button>
                                        </form>
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
                            <td colspan="11" class="text-center">{{ __('translations.texts.no_pending') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.modals.trackingNumberModal')
@endsection
@section('page-script-after')
    <script>
        $(document).ready(function(){

            var modalForm = $('.ui.form');

            //shows modal
            $('.sent-button').click(function(){

                //get parent form
                var parent = $(this).parent('form'),
                    id = $(this).attr('data-id');

                //set modal hidden field to get form id
                $('#shipmentFormId').val(parent.attr('id'));

                $('#tracking-number-modal').modal('show');
  
            });

            //set validation rules
            modalForm
                .form({
                    fields: {
                        trackingNumberInput: 'empty'
                    }
            });

            //checks the tracking number and submit form
            $('#trackingNumberButton').click(function(){

                var recordForm = $('#'+$('#shipmentFormId').val()),
                    trackingNumber = recordForm.find('.trackingNumber');

                if( modalForm.form('is valid', 'trackingNumberInput')) {

                    trackingNumber.val($('#trackingNumberInput').val());

                    recordForm.submit();
                } else {

                    modalForm.form('validate form');
                }
            });
        });
    </script>
@endsection
