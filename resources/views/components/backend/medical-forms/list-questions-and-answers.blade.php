<div id="accordion" class="mb-3">
    @forelse($questions as $question)

        <div class="card mb-1">
            <div class="card-header" id="{{ 'heading'.$loop->index }}">
                <div class="card-widgets">

                    @if($question->type == 'select' || $question->type == 'multiselect' || $question->type == 'radio' || $question->type == 'checkbox')
                        <a href="#" class="btn btn-sm btn-primary text-white add_answer" data-formId="{{ $question->medical_form_id }}" data-questionId="{{ $question->id }}" style="font-size: unset !important;">
                            <i class="mdi mdi-plus"></i>
                        </a>
                    @endif

                    <a href="#" class="btn btn-sm btn-danger text-white remove_question" data-formId="{{ $question->medical_form_id }}" data-questionId="{{ $question->id }}" style="font-size: unset !important;">
                        <i class="mdi mdi-minus-circle"></i>
                    </a>
                </div>
                <h5 class="card-title m-0 text-white">
                    <a class="text-dark" data-bs-toggle="collapse" href="{{ '#collapse'.$loop->index }}" aria-expanded="true">
                        <i class="mdi mdi-help-circle me-1 text-primary"></i>
                        {{ $question->question }}
                        @if($question->rules['isRequired'] == 'yes')
                            <span class="text-danger">*</span>
                        @endif
                    </a>
                </h5>
            </div>

            @if($question->type == 'select' || $question->type == 'multiselect' || $question->type == 'radio' || $question->type == 'checkbox')
                <div id="{{ 'collapse'.$loop->index }}" class="collapse" aria-labelledby="{{ 'heading'.$loop->index }}" data-bs-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                        @forelse($question->answers as $answer)
                            <li class="list-group-item">{{ $answer->answer }}</li>
                        @empty
                            <li class="list-group-item">{{ __('No answers found') }}</li>
                        @endforelse
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="alert alert-danger">
            <p>{{ __('No questions found') }}</p>
        </div>
    @endforelse
</div>
