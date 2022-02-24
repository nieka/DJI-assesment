@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="alert alert-success" role="alert" id="message-succes-alart" style="display: none">
                {{ trans('colleague.messageCreated') }} <span id="message-password"></span><br>
                <a href="" target="_blank" id="message-link"></a>
            </div>
        </div>
    </div>
    <div class="row">
        <form id="message-form">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <select name="colleague_email" id="colleague_select" class="form-control">
                            <option value="">{{ trans('colleague.selectColleague') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <textarea required
                              name="messagecontent"
                              class="form-control"
                              rows="5"
                              id="message"
                              placeholder="{{ trans('colleague.placeMessage') }}"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ trans('colleague.encryptMessage') }}</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('#message-form').on('submit', function(e){
            e.preventDefault();
            $('#message-succes-alart').hide();

            $.post(
                '{{ route('messages.store') }}',
                {
                    message: $('#message').val(),
                    email: $('#colleague_select').val()
                },
                function(response) {
                    $('#message-password').text(response.password);
                    $('#message-link')
                        .attr('href', '/' + response.uuid)
                        .text('{{url('')}}/' + response.uuid);

                    $('#message-succes-alart').show();

                }
            )
        });

        function loadColleagues (){
            $.get('{{ route('colleagues.get') }}', function(data) {
               let colleagueSelect = $('#colleague_select');
               colleagueSelect.empty();

               //add placeHolder
               colleagueSelect.append(
                   $('<option>')
                       .text("{{ trans('colleague.selectColleague') }}")
                       .val(null)
               )

               data.forEach(function(colleague) {
                   colleagueSelect.append(
                       $('<option>')
                            .text(colleague.name)
                            .val(colleague.email)
                   )
               });
            });
        }

        loadColleagues();
    </script>
@endpush
