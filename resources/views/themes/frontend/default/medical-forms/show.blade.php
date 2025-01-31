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

                                        @if ( $stepNo == 1 && $form->settings['calculateBMI'] == "yes")
                                            <div class="mt-3">
                                                <h5 class="page-title">{{ __('BMI Calculator') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('Height (cm)') }}</label>
                                                            <input type="number" class="form-control" id="height" name="height" min="1" max="300">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('Weight (kg)') }}</label>
                                                            <input type="number" class="form-control" id="weight" name="weight" min="1" max="500">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="alert alert-info" id="bmiResult" style="display: none;">
                                                            <strong>{{ __('Your BMI') }}: </strong> <span id="bmiValue"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="bmi_result" id="bmi_result">
                                            <input type="hidden" name="bmi_category" id="bmi_category">
                                        @endif

                                        @if ( $stepNo == 1 && $form->settings['emergencyContactName'] == "yes")
                                            <div class="mt-3">
                                                <h5 class="page-title">{{ __('Emergency Contact Data') }} </h5>
                                            </div>
                                            <x-html.forms.text name="emergencyContactName" label="Name Surname" required="yes" name="emergencyContactName" id="question_99991" :value="$patientAnswers->answers[$question->id] ?? ''" />
                                            <x-html.forms.text name="emergencyContactRelationship" label="Relationship" required="yes" name="emergencyContactRelationship" id="question_99992" :value="$patientAnswers->answers[$question->id] ?? ''" />
                                            <x-html.forms.text name="emergencyContactPhone" label="Phone Number" required="yes" name="emergencyContactPhone" id="question_99993" :value="$patientAnswers->answers[$question->id] ?? ''" />
                                            <x-html.forms.text name="emergencyContactEmail" label="Email Address" required="yes" name="emergencyContactEmail" id="question_99994" :value="$patientAnswers->answers[$question->id] ?? ''" />
                                            <x-html.forms.text name="emergencyContactAddress" label="Address" name="emergencyContactAddress" id="question_99995" :value="$patientAnswers->answers[$question->id] ?? ''" />
                                        @endif
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
        .has-error input,
        .has-error select,
        .has-error textarea {
            border-color: #dc3545;
        }
        .error-message {
            font-size: 0.875em;
        }
        .wizard > .content {
            transition: min-height 0.3s ease;
        }
    </style>
@endpush


@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('themes/backend/default/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            console.log('Script çalışıyor');
            
            // Event delegation kullanarak BMI hesaplama
            $(document).on('change', '#height, #weight', function() {
                var height = $('#height').val();
                var weight = $('#weight').val();
                
                console.log('Height:', height);
                console.log('Weight:', weight);
                
                if (height > 0 && weight > 0) {
                    var heightInMeters = height / 100;
                    var bmi = (weight / (heightInMeters * heightInMeters)).toFixed(2);
                    
                    var category = '';
                    if (bmi < 18.5) category = '{{ __("Underweight") }}';
                    else if (bmi < 25) category = '{{ __("Normal weight") }}';
                    else if (bmi < 30) category = '{{ __("Overweight") }}';
                    else category = '{{ __("Obese") }}';
                    
                    // Görünür alanlara değerleri yazalım
                    $('#bmiValue').text(bmi);
                    $('#bmiCategory').text(category);
                    $('#bmiResult').show();
                    
                    // Hidden input'lara değerleri yazalım
                    $('#bmi_result').val(bmi);
                    $('#bmi_category').val(category);
                    
                    console.log('BMI calculated:', bmi);
                    console.log('Category:', category);
                }
            });

            // Wizard yüksekliğini ayarlama fonksiyonu
            function adjustWizardHeight(stepIndex) {
                var currentStep = $('#basicwizard').find('section').eq(stepIndex);
                var stepHeight = currentStep.outerHeight();
                currentStep.css('min-height', stepHeight);
                $('.content').css('min-height', stepHeight + 100);
            }

            // Wizard kodu
            var wizard = $('#basicwizard').steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                // Init yükseklik ayarı
                onInit: function (event, currentIndex) {
                    setTimeout(function() {
                        adjustWizardHeight(currentIndex);
                    }, 100);
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    // Geri gitmeye her zaman izin ver
                    if (currentIndex > newIndex) {
                        return true;
                    }
                    
                    // Mevcut adımdaki tüm required alanları kontrol et
                    var currentStep = $(this).find('section').eq(currentIndex);
                    var isValid = true;
                    var firstInvalidField = null;

                    // Önce tüm hata mesajlarını temizle
                    $('.error-message').remove();
                    $('.has-error').removeClass('has-error');

                    currentStep.find('input[required], select[required], textarea[required]').each(function() {
                        if (!$(this).val()) {
                            isValid = false;
                            if (!firstInvalidField) {
                                firstInvalidField = $(this);
                            }
                            // Input'un üst div'ine error class'ı ekle
                            $(this).closest('.mb-3').addClass('has-error');
                            // Input'un altına hata mesajı ekle
                            if (!$(this).next('.error-message').length) {
                                $(this).after('<div class="error-message text-danger mt-1">{{ __("This field is required") }}</div>');
                            }
                        }
                    });

                    // Hata mesajları eklendikten sonra wizard yüksekliğini güncelle
                    if (!isValid) {
                        var currentContent = currentStep.find('.content');
                        var newHeight = currentStep.outerHeight();
                        currentStep.css('min-height', newHeight + 50); // 50px extra space
                        
                        firstInvalidField.focus();
                        
                        Swal.fire({
                            title: '{{ __("Warning") }}',
                            text: '{{ __("Please fill in all required fields") }}',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6'
                        });

                        // Wizard container'ın yüksekliğini güncelle
                        setTimeout(function() {
                            var wizardHeight = $('#basicwizard').outerHeight();
                            $('.content').css('min-height', wizardHeight + 100);
                        }, 100);
                    }

                    return isValid;
                },
                onStepChanged: function (event, currentIndex, priorIndex) {
                    // Her adım değiştiğinde yüksekliği resetle
                    $('.content').css('min-height', '');
                    adjustWizardHeight(currentIndex);

                    let data = $('form').serialize();
                    $.post('{{ route('medical-forms.update') }}', data, function (response){
                        // Handle response if needed
                    });
                },
                onFinished: function (event, currentIndex) {
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

            // Sayfa yüklendiğinde ve resize olduğunda yüksekliği güncelle
            $(window).on('load resize', function() {
                var currentIndex = $('#basicwizard').steps('getCurrentIndex');
                adjustWizardHeight(currentIndex);
            });
        });
    </script>
@endpush
