@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="alert alert-danger" role="alert" id="error-alert" style="display: none">
                {{ trans('colleague.passwordIncorrect') }}
            </div>
            <div class="alert alert-success" id="message-success-alert" role="alert" style="display: none">
                {{ trans('colleague.messageLoaded') }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <label>{{ trans('colleague.fillPassWord') }}</label>
            <input type="password"
                   id="password"
                   placeholder="{{ trans('colleague.password') }}"
                   class="form-control">
            <button type="button" class="btn btn-primary" style="margin-top: 5px;" id="load-message-button">
                {{ trans('colleague.showMessage') }}
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="message-box" style="display: none;">
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        #message-box {
            border: 1px solid;
            padding: 5px;
            margin-top: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('#load-message-button').on('click', function(){
            reset();

            let url = '{{ route('messages.getMessage', $message->id) }}?password=';
            url += $('#password').val();
            $.get(url,
                function(response){
                    $('#message-box')
                        .text(response.message)
                        .show();
                    $('#message-success-alert').show();

                    setTimeout(
                        function() {
                            reset();
                            $('#password').val("")
                        },
                        30 * 1000 //30 seconds
                    );
                }
            )
            .fail(
                function() {
                    $('#error-alert').show();
                }
            )
        });

        function reset() {
            $('#message-box')
                .text("")
                .hide();
            $('.alert').hide();
        }
    </script>
@endpush
