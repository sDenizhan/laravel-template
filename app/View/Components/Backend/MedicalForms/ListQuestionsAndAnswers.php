<?php

namespace App\View\Components\Backend\MedicalForms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListQuestionsAndAnswers extends Component
{
    public $questions;
    /**
     * Create a new component instance.
     */
    public function __construct(array|object $questions = [])
    {
        $this->questions = $questions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.medical-forms.list-questions-and-answers');
    }
}
