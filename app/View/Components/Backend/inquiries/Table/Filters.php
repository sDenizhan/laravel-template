<?php

namespace App\View\Components\Backend\Inquiries\Table;

use App\Models\CountryTranslation;
use App\Models\Language;
use App\Models\Treatments;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filters extends Component
{
    public $languages;
    public $treatments;
    public $countries;
    public $coordinators;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->languages = Language::all();
        $this->treatments = Treatments::all();
        $this->countries = CountryTranslation::where('locale', session()->get('locale') ?? 'tr')->orderBy('name', 'asc')->get();
        $this->coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'Coordinator');
        })->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $languages = $this->languages;
        $treatments = $this->treatments;
        $countries = $this->countries;
        $coordinators = $this->coordinators;
        return view('components.backend.inquiries.table.filters', compact('languages', 'treatments', 'countries', 'coordinators'));
    }
}
