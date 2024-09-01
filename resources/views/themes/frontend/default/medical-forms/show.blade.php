@extends('layouts.empty')


@section('content')

@if(!empty($form->steps))
    <div class="row mt-4">
        <div class="col-xl-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">{{ __('Medical Form For :treatment', ['treatment' => $form->treatment->name]) }}</h4>
                    <form action="" method="post" id="medicalForm">
                        @method('POST')
                        @csrf
                        <input type="hidden" id="formId" name="formId" value="{{ $patientAnswers->code  }}">
                        <div id="basicwizard">
                            @foreach($form->steps as $stepNo => $stepTitle)
                                <h3>{{ $stepTitle }}</h3>
                                <section>
                                    @foreach($form->questions->filter(function ($query) use ($stepNo){
                                                            return $query->step == $stepNo;
                                                        }) as $question)
                                        @php($component = 'html.forms.'.$question->type)

                                        <x-dynamic-component :component="$component"
                                                             :name="'questions['.$question->id.']'"
                                                             :id="'question_'. $question->id .''"
                                                             :label="$question->question"
                                                             :value="$patientAnswers->answers[$question->id] ?? ''"
                                                             :required="$question->rules['isRequired']"
                                                             :data="$question->answers"
                                        />
                                    @endforeach
                                </section>
                            @endforeach
                            <h3>{{ __('Summary') }}</h3>
                            <section>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{ __('Summary of the Form') }}</h4>
                                        <p>{{ __('Please Review the Form Before Submitting') }}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Question') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($form->questions as $question)
                                                        <tr class="odd">
                                                            <td>{{ $question->question }}</td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td>{{ $patientAnswers->answers[$question->id] ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
@endif
@endsection

@push('styles')
    <link href="{{ asset('themes/backend/default/assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet" type="text/css" />
    <style>
        tr.odd {
            background-color: #ebebeb;
            font-weight: bold;
        }
    </style>
@endpush


@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            var wizard = $('#basicwizard').steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                onStepChanged: function (event, currentIndex, priorIndex){

                    if (currentIndex === 3) {
                        var height = $('div.table-responsive').height();

                        $('div.content').css('min-height', height + 100);
                    }

                    let data = $('form').serialize();
                    $.post('{{ route('medical-forms.update') }}', data, function (response){

                    });
                },
                onFinished : function (event, currentIndex, priorIndex) {
                    Swal.fire({
                        title : '{{ __('Are You Sure You Want to Submit the Form?') }}',
                        text : '{{ __('By Submitting the Form You Will Be Agreeing That All Information Is Correct!') }}',
                        icon : 'warning',
                        showCancelButton : true,
                        confirmButtonColor : '#34c38f',
                        cancelButtonColor : '#f46a6a',
                        confirmButtonText : '{{ __('Yes') }}',
                        cancelButtonText : '{{ __('No!') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post('{{ route('medical-forms.finishUpdate') }}', {
                                _token : '{{ csrf_token() }}',
                                _method : 'POST',
                                formId : $('#formId').val(),
                                submit : true
                            } , function (response){
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title : '{{ __('Form Submitted Successfully') }}',
                                        text : '{{ __('The Form Has Been Submitted Successfully. You can close this page!') }}',
                                        icon : 'success',
                                        confirmButtonColor : '#34c38f'
                                    });
                                } else {
                                    Swal.fire({
                                        title : '{{ __('Form Submission Failed') }}',
                                        text : '{{ __('The Form Submission Failed') }}',
                                        icon : 'error',
                                        confirmButtonColor : '#f46a6a'
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
