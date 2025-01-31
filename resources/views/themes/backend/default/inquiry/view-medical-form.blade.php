@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Review Medical Form') }}" :links="$data"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Medical Form') }}</h4>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table dt-responsive nowrap w-100">
                        <tbody>
                            @foreach($medicalForm->medicalForm->questions as $question)
                                <tr>
                                    <td><strong>{{ $question->question }}</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $medicalForm->answers[$question->id] ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @hasrole('Coordinator|Anaesthetist|Super Admin')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">{{ __('Notes') }}</h4>

                        <div class="chat-conversation">
                            <div data-simplebar id="list-notes">

                            </div>
                        </div>
                        <!-- end .chat-conversation-->
                        @hasrole('Anaesthetist|Super Admin')
                        <form action="{{ route('admin.inquiries.save-notes') }}" class="needs-validation" novalidate name="chat-form" id="chat-form">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="notes" id="notes" class="form-control chat-input" placeholder="" required>
                                </div>
                                <div class="col-auto d-grid">
                                    <button type="submit" class="btn btn-danger chat-send waves-effect waves-light">{{ __('Send') }}</button>
                                </div>
                            </div>

                            <input type="hidden" name="inquiry_id" value="{{ $medicalForm->inquiry_id }}">
                            <input type="hidden" name="answer_id" value="{{ $medicalForm->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </form>
                        @endhasrole
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    @endhasrole
@endsection

@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            //simplebar
            new SimpleBar(document.getElementsByClassName('chat-conversation')[0]);

            $('form#chat-form').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        form.find('.chat-input').val('');
                        getNotes();
                    }
                });
            });

            var getNotes = function () {
                $.ajax({
                    url: '{{ route('admin.inquiries.get-notes') }}',
                    type: 'POST',
                    data : {
                        '_token': '{{ csrf_token() }}',
                        inquiry_id: '{{ $medicalForm->inquiry_id }}',
                        medical_form_id : '{{ $medicalForm->id }}',
                        user_id: '{{ auth()->user()->id }}'
                    },
                    success: function (response) {
                        $('#list-notes').html(response.html);
                    }
                });
            }

            $(document).on('click', 'a.btn-edit', function (e) {
                e.preventDefault();

                let noteId = $(this).data('noteid');
                let message = $('.message-' + noteId).text().trim();
                let el = $('p.message-'+noteId);

                let form = '<form action="" class="needs-validation" novalidate name="chat-form" id="chat-form">';
                form += '<div class="row">';
                form += '<div class="col">';
                form += '<input type="text" name="notes" id="notes" class="form-control chat-input" placeholder="" required value="'+message+'">';
                form += '</div>';
                form += '<div class="col-auto d-grid">';
                form += '<button type="submit" class="btn btn-danger btn-save chat-send waves-effect waves-light">{{ __('Update') }}</button>';
                form += '</div>';
                form += '</div>';
                form += '<input type="hidden" name="inquiry_id" value="{{ $medicalForm->inquiry_id }}">';
                form += '<input type="hidden" name="answer_id" value="{{ $medicalForm->id }}">';
                form += '<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">';
                form += '<input type="hidden" name="note_id" value="'+noteId+'">';
                form += '</form>';


                el.html(form);
            });

            getNotes();
        });
    </script>
@endpush
