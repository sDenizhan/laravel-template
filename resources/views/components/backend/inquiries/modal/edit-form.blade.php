<div class="row">
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $inquiry->name }}">
        </div>
        <div class="form-group mb-3">
            <label for="email">{{ __('Email Address') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $inquiry->email }}">
        </div>
        <div class="form-group mb-3">
            <label for="gender">{{ __('Gender') }}</label>
            @php($genders = \App\Enums\Gender::toArray())
            <select class="form-control" id="gender" name="gender">
                @foreach($genders as $key => $gender)
                    <option value="{{ $key }}" {{ $key == $inquiry->gender ? 'selected' : ''}}>{{ $gender }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="country">{{ __('Country') }}</label>
            @if ($countries->count() > 0)
            <select class="form-control" id="country_id" name="country_id">
                @foreach($countries as $country)
                    <option value="{{ $country->country_id }}" {{ $country->country_id == $inquiry->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="surname">{{ __('Surname') }}</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ $inquiry->surname }}">
        </div>
        <div class="form-group mb-3">
            <label for="phone">{{ __('Phone') }}</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $inquiry->phone }}">
        </div>
        <div class="form-group mb-3">
            <label for="treatment_id">{{ __('Treatment') }}</label>
            <select class="form-control" id="treatment_id" name="treatment_id">
                <option value="">{{ __('Select Treatment') }}</option>
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}" {{ $inquiry->treatment_id == $treatment->id ? 'selected' : '' }}>{{ $treatment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="status">{{ __('Language') }}</label>
            <select class="form-control" id="language_id" name="language_id">
                <option value="">{{ __('Select Language') }}</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}" {{ $inquiry->language_id == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="message">{{ __('Message') }}</label>
                <textarea class="form-control" id="message" name="message">{{ $inquiry->message }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="coordinator_id">{{ __('Coordinator') }}</label>
                <select class="form-control" id="coordinator_id" name="coordinator_id">
                    <option value="">{{ __('Select Coordinator') }}</option>
                    @foreach ($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}" {{ $inquiry->coordinator_id == $coordinator->id ? 'selected' : '' }} @class([
    'text-danger' => $coordinator->isOnline() == false,
    'text-success' => $coordinator->isOnline(),
])>
                            {{ $coordinator->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $inquiry->id }}"  />
</div>
