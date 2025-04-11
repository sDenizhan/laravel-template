<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-dark py-3 text-light">
                <div class="card-widgets">
                    <a data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="false" aria-controls="filters" class="collapsed">
                        <i class="mdi mdi-minus"></i>
                    </a>
                </div>
                <h5 class="card-title mb-0 text-light">{{ __('Filters') }}</h5>
            </div>
            <div id="filters" class="collapsed collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="id" class="form-label">{{ __('ID') }}</label>
                                <input type="text" class="form-control form-control-sm" id="id" placeholder="{{ __('#') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="language" class="form-label">{{ __('Languages') }}</label>
                                <select id="language" class="form-select form-select-sm">
                                    <option value="">{{ __('Select Language') }}</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="country" class="form-label">{{ __('Country') }}</label>
                                <select id="country" class="form-select form-select-sm">
                                    <option value="">{{ __('Select Country') }}</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="treatment" class="form-label">{{ __('Treatment') }}</label>
                                <select id="treatment" class="form-select form-select-sm">
                                    <option value="">{{ __('Select Treatment') }}</option>
                                    @foreach($treatments as $treatment)
                                        <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="text" class="form-control form-control-sm" id="start_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                <input type="text" class="form-control form-control-sm" id="end_date" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="coordinator" class="form-label">{{ __('Coordinator') }}</label>
                                <select name="coordinator" class="form-select form-select-sm">
                                    <option value="">{{ __('Select Coordinator') }}</option>
                                    @foreach($coordinators as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="query" class="form-label">{{ __('Search') }}</label>
                                <input type="text" class="form-control form-control-sm" name="query" id="query" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
