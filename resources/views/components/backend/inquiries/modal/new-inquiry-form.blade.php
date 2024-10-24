<div class="row">
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="">
            <div class="results mt-1 bg-secondary p-1" style="z-index: 9999;position: absolute;width: 23rem; display: none">
                <ul class="list-group list-group-flush bg-primary">
                </ul>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="email">{{ __('Email Address') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="">
        </div>
        <div class="form-group mb-3">
            <label for="gender">{{ __('Gender') }}</label>
            @php($genders = \App\Enums\Gender::toArray())
            <select class="form-control" id="gender" name="gender">
                @foreach($genders as $key => $gender)
                    <option value="{{ $key }}">{{ $gender }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="country">{{ __('Country') }}</label>
            <input type="text" class="form-control" id="country" name="country" value="">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="surname">{{ __('Surname') }}</label>
            <input type="text" class="form-control" id="surname" name="surname" value="">
        </div>
        <div class="form-group mb-3">
            <label for="phone">{{ __('Phone') }}</label>
            <input type="text" class="form-control" id="phone" name="phone" value="">
        </div>
        <div class="form-group mb-3">
            <label for="treatment_id">{{ __('Treatment') }}</label>
            <select class="form-control" id="treatment_id" name="treatment_id">
                <option value="">{{ __('Select Treatment') }}</option>
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="status">{{ __('Language') }}</label>
            <select class="form-control" id="language_id" name="language_id">
                <option value="">{{ __('Select Language') }}</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="message">{{ __('Message') }}</label>
                <textarea class="form-control" id="message" name="message"></textarea>
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
                        <option value="{{ $coordinator->id }}" {{ $coordinator->id == auth()->user()->id ? 'selected="selected"' : '' }}>{{ $coordinator->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value=""  />
    <input type="hidden" name="user_id" value="" />
</div>
