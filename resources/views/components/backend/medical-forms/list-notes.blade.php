<ul class="conversation-list">
    @if ( ! empty($notes))
        @foreach($notes as $note)
            <li @class([
                'clearfix',
                'odd' => $note->user_id == auth()->user()->id,
                ])>
                <div class="conversation-text">
                    <div class="ctext-wrap" style="width: 75%">
                        <div style="display: flex; @if($note->user_id == auth()->user()->id) flex-direction:row-reverse @endif">
                            <div class="note col">
                                <p style="font-size: 16px" class="message-{{$note->id}}">
                                    {{ $note->note }}
                                </p>

                                <i>{{ $note->user->name ?? ''}} - {{ $note->created_at->format('d/m/Y H:i') }}</i>
                            </div>
                            <div class="actions col-auto">
                                @if( $note->user_id == auth()->user()->id || auth()->user()->role('Super Admin') )
                                    <a href="" class="btn btn-sm bg-gray" data-noteId="{{ $note->id }}">
                                        <i class="mdi mdi-dots-grid"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    @endif
</ul>
