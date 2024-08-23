<div class="row">
    <div class="col-lg-12 subject">
        <div class="form-group mb-3">
            <label for="name">{{ __('Subject') }}</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ $messageTemplate->title }}">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="message">{{ __('Message') }}</label>
                <textarea class="form-control summernote" id="message" name="message">{{ $messageTemplate->message }}</textarea>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{ $inquiry->id }}"  />
    <input type="hidden" name="userId" value="{{ $user->id }}" />
    <input type="hidden" name="newPassword" value="{{ $newPassword }}" />
    <input type="hidden" name="formHash" value="{{ $formHash  }}" />
    <input type="hidden" name="medicalFormId" value="{{ $medicalForm->id }}" />
</div>

@push('styles')
    <link href="{{ asset('themes/backend/default/assets/libs/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
@endpush


@push('scripts')
    <script src="{{ asset('themes/backend/default/assets/libs/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //summernote
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
