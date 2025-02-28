@extends('themes.backend.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <select class="form-select" id="filterUser">
                                <option value="">{{ __('All Users') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" id="addEvent">
                                {{ __('Add New Event') }}
                            </button>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Event Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Start Date') }}</label>
                            <input type="datetime-local" class="form-control" id="start" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('End Date') }}</label>
                            <input type="datetime-local" class="form-control" id="end" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('User') }}</label>
                            <select class="form-select" id="user_id" required>
                                <option value="">{{ __('Select User') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-danger d-none" id="deleteEvent">{{ __('Delete') }}</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: "{{ route('admin.calendar.events') }}",
                    method: 'GET',
                    extraParams: function() {
                        return {
                            user_id: $('#filterUser').val()
                        };
                    },
                    failure: function() {
                        alert('{{ __("There was an error while fetching events!") }}');
                    }
                },
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                select: function(arg) {
                    $('#eventId').val('');
                    $('#start').val(arg.startStr);
                    $('#end').val(arg.endStr);
                    $('#deleteEvent').addClass('d-none');
                    $('#eventModal').modal('show');
                },
                eventClick: function(arg) {
                    $('#eventId').val(arg.event.id);
                    $('#title').val(arg.event.title);
                    $('#description').val(arg.event.extendedProps.description);
                    $('#start').val(arg.event.startStr);
                    $('#end').val(arg.event.endStr);
                    $('#user_id').val(arg.event.extendedProps.user_id);
                    $('#deleteEvent').removeClass('d-none');
                    $('#eventModal').modal('show');
                },
                eventDrop: function(arg) {
                    updateEvent(arg.event);
                }
            });
            calendar.render();

            // Add Event Button
            $('#addEvent').click(function() {
                $('#eventForm')[0].reset();
                $('#deleteEvent').addClass('d-none');
                $('#eventModal').modal('show');
            });

            // Save Event
            $('#saveEvent').click(function() {
                var eventId = $('#eventId').val();
                var data = {
                    title: $('#title').val(),
                    description: $('#description').val(),
                    start: $('#start').val(),
                    end: $('#end').val(),
                    user_id: $('#user_id').val(),
                    _token: '{{ csrf_token() }}'
                };

                var url = eventId ? 
                    "{{ route('admin.calendar.update', '') }}/" + eventId :
                    "{{ route('admin.calendar.store') }}";

                $.ajax({
                    url: url,
                    type: eventId ? 'PUT' : 'POST',
                    data: data,
                    success: function(response) {
                        $('#eventModal').modal('hide');
                        calendar.refetchEvents();
                    }
                });
            });

            // Delete Event
            $('#deleteEvent').click(function() {
                var eventId = $('#eventId').val();
                if (confirm('{{ __("Are you sure you want to delete this event?") }}')) {
                    $.ajax({
                        url: "{{ route('admin.calendar.destroy', '') }}/" + eventId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#eventModal').modal('hide');
                            calendar.refetchEvents();
                        }
                    });
                }
            });

            // Filter
            $('#filterUser').change(function() {
                calendar.refetchEvents();
            });
        });
    </script>
@endpush 