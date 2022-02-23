@extends('layout')

@section('content')
    <div class="row">

        <form action="" method="post">
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
                    <textarea required name="messagecontent" class="form-control" rows="5"
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
        function loadColleagues (){
            $.get('{{route('colleagues.get')}}', function(data) {
               console.log(data);
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
