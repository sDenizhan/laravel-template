@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Medical Forms'),
                'url' => route('admin.medical-forms.index')
            ],
            [
                'title' =>  $form->title,
                'url' => route('admin.medical-forms.show', $form->id)
            ],
            [
                'title' => __('Add Question'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Medical Forms') }}" :links="$data" />
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.medical-form-questions.store', $form->id) }}" method="POST" id="questionForm">
                        @csrf
                        <div class="mb-3">
                            <label for="question" class="form-label">{{ __('Question') }}</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="row col-12">
                            <div class="mb-3 col-3">
                                <label for="type" class="form-label">{{ __('Type') }}</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="text">{{ __('Text') }}</option>
                                    <option value="textarea">{{ __('Textarea') }}</option>
                                    <option value="radio">{{ __('Radio') }}</option>
                                    <option value="checkbox">{{ __('Checkbox') }}</option>
                                    <option value="select">{{ __('Select') }}</option>
                                    <option value="multiselect">{{ __('Multi Select') }}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-3">
                                <label for="required" class="form-label">{{ __('Required') }}</label>
                                <select class="form-select" id="isRequired" name="rules[isRequired]" required>
                                    <option value="yes">{{ __('Yes') }}</option>
                                    <option value="no">{{ __('No') }}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-3">
                                <label for="order" class="form-label">{{ __('Order') }}</label>
                                <input type="number" id="order" name="order" class="form-control" value="1" step="1" />
                            </div>
                            <div class="mb-3 col-3">
                                <label for="step" class="form-label">{{ __('Step') }}</label>
                                <input type="number" id="step" name="step" class="form-control" value="1" step="1" />
                            </div>
                        </div>
                        <input type="hidden" name="medical_form_id" value="{{ $form->id }}" />
                        <input type="hidden" name="treatment_id" value="{{ $form->treatment_id }}" />
                        <button type="submit" class="btn btn-primary addQuestion">{{ __('Add Question') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12" id="questionsList">
            <x-backend.medical-forms.list-questions-and-answers :questions="$questions" :steps="$form->steps" />
        </div>
    </div>

    <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="answerModal">Add Answer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('admin.medical-form-questions.answerStore')  }}" id="addAnswerForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <input type="text" class="form-control" id="answer" name="answer" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="medical_form_id" id="medical_form_id" value="" />
                        <input type="hidden" name="medical_form_question_id" id="question_id" value="" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            $(document).on('click', 'a.add_answer', function (e){
                e.preventDefault();
                let formId = $(this).data('formid');
                let questionId = $(this).data('questionid');

                console.log(formId, questionId);

                $('input#medical_form_id').val(formId);
                $('input#question_id').val(questionId);

                $('#answerModal').modal('show');
            });

            function getAllQuestions(){
                $.get('{{ route('admin.medical-form-questions.formQuestions', ['formId' => $form->id]) }}', function(response){
                    if ( response.status == 'success' ){
                        $('#questionsList').html(response.html);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                });
            }

            $('#questionForm').on('submit', function(e){
                e.preventDefault();
                let url = $(this).attr('action');
                let data = $(this).serialize();

                $.post(url, data, function(response){
                    if(response.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(function(){
                            getAllQuestions();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                });
            });

            $(document).on('submit', 'form#addAnswerForm', function (e){
                e.preventDefault();

                let url = $(this).attr('action');
                let data = $(this).serialize();

                $.post(url, data, function(response){
                    if(response.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(function(){
                            getAllQuestions();
                            $('#answerModal').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                });
            });

            $(document).on('click', 'a.remove_question', function (e){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        let formId = $(this).data('formid');
                        let questionId = $(this).data('questionid');
                        let url = "{{ route('admin.medical-form-questions.delete-question', ['formId' => ':formId']) }}";
                        url = url.replace(':formId', formId);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                questionId: questionId,
                                formId: formId
                            },
                            success: function(response){
                                if(response.status === 'success'){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(function(){
                                        getAllQuestions();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.message
                                    });
                                }
                            }
                        });
                    }
                });
            })
        });
    </script>
@endpush
