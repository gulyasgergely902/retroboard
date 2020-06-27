@extends ('layout')

@section ('content')
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark text-light">
    <a class="navbar-brand" href="/">Retro Board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Tab selectors -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-item nav-link {{ Request::is('display/*/0') ? 'active text-success' : ''}}" id="nav-wentwell-tab" href="/display/{{$bid}}/0" role="tab" aria-controls="nav-wentwell" aria-selected="true">Went well</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ Request::is('display/*/2') ? 'active text-danger' : ''}}" id="nav-needsimprovement-tab" href="/display/{{$bid}}/2" role="tab" aria-controls="nav-needsimprovement" aria-selected="false">Needs improvement</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ Request::is('display/*/1') ? 'active text-warning' : ''}}" id="nav-actionitem-tab" href="/display/{{$bid}}/1" role="tab" aria-controls="nav-actionitem" aria-selected="false">Action items</a>
            </li>
        </ul>
        <!-- Div toggle -->
        <form class="form-inline my-2 mr-2 my-lg-0">
            <label class="mr-2">Show stickies</label>
            <label for="hideStickyDiv" class="switch">
                <input class="ml-2" type="checkbox" name="hideStickyDiv" id="hideStickyDiv" {{ old('hideStickyDiv') }}>
                <span class="slider round"></span>
            </label>
        </form>
        <!-- Buttons -->
        @if($protected)
            <form class="form-inline my-2 mr-2 my-lg-0" method="GET" action="/lock">
                <input type="hidden" name="bid" value="{{ $bid }}">
                <button type="submit" class="btn btn-outline-warning" id="lockboard" title="Lock board"><i class="fas fa-lock pr-2"></i>Lock board</button>
            </form>
        @endif
        <form class="form-inline my-2 mr-2 my-lg-0">
            <button type="button" class="btn btn-success" id="addsingle" title="Add new sticky" data-toggle="modal" data-target="#addStickyModal" data-bid="{{ $bid }}"><i class="fas fa-plus-circle pr-2"></i>Add item</button>
        </form>
        <form class="form-inline my-2 my-lg-0" action="{{ url('remove/') }}" method="POST">
            <button type="button" class="btn btn-outline-danger" id="deleteall" title="Clear all stickies" data-toggle="modal" data-target="#clearAllStickyModal" data-bid="{{ $bid }}"><i class="fas fa-trash-alt pr-2"></i>Clear board</button>
        </form>
    </div>
</nav>

<!-- Add Modal -->
<div class="modal fade" id="addStickyModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add new sticky to: {{ $types[$tab] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('add/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="item" name="mode">
                    <input type="hidden" value="{{ $bid }}" name="bid">
                    <input type="hidden" name="sticky_type" value="{{ $tab }}">
                    <div class="form-group">
                        <label for="sticky-content">Sticky content</label>
                        <textarea class="form-control" id="sticky-content" name="sticky_content" aria-describedby="sticky-content-help" placeholder="Sticky content"></textarea>
                        <small id="sticky-content-charcount" class="form-text text-muted">Characters left: 500</small>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn {{ $button_color[$tab] }}">Create sticky</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Clear All Modal -->
<div class="modal fade" id="clearAllStickyModal" tabindex="-1" role="dialog" aria-labelledby="clearAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearAllModalLabel">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This will clear the board! All stickies will be gone!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form class="remove-board-form" action="{{ url('remove/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="full" name="mode">
                    <input type="hidden" name="bid" value="{{$bid}}">
                    <button type="submit" class="btn btn-danger">Clear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Stickies list -->
<div class="tab-content py-3 px-5 mt-5 mb-5" id="nav-tabContent">
    <div class="tab-pane fade {{ $tab == '0' ? 'show active' : ''}}" id="nav-wentwell" role="tabpanel" aria-labelledby="nav-wentwell-tab">
        <div class="card-columns">
            @foreach ($stickies as $sticky)
                @if($sticky->sticky_type==0)
                <div class="note-base mr-3 my-3" id="note-base">
                    <div class="note-base-actions note{{ $sticky->sticky_type }}-actions" id="note-base-header">
                        <form action="{{ url('remove/') }}" method="POST">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="single" name="mode">
                            <input type="hidden" value="{{$sticky->sticky_id}}" name="sticky_id">
                            <input type="hidden" value="{{ $bid }}" name="bid">
                            <button type="submit" id="delete-single" class="btn btn-outline-light"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                    <div class="note-base-content note{{$sticky->sticky_type}}-content">
                        {{ $sticky->sticky_content }}
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade {{ $tab == '2' ? 'show active' : ''}}" id="nav-needsimprovement" role="tabpanel" aria-labelledby="nav-needsimprovement-tab">
        <div class="card-columns">
            @foreach ($stickies as $sticky)
                @if($sticky->sticky_type==2)
                <div class="note-base mr-3 my-3" id="note-base">
                    <div class="note-base-actions note{{ $sticky->sticky_type }}-actions" id="note-base-header">
                        <form action="{{ url('remove/') }}" method="POST">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="single" name="mode">
                            <input type="hidden" value="{{$sticky->sticky_id}}" name="sticky_id">
                            <input type="hidden" value="{{ $bid }}" name="bid">
                            <button type="submit" id="delete-single" class="btn btn-outline-light"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                    <div class="note-base-content note{{$sticky->sticky_type}}-content">
                        {{$sticky->sticky_content}}
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade {{ $tab == '1' ? 'show active' : ''}}" id="nav-actionitem" role="tabpanel" aria-labelledby="nav-actionitem-tab">
        <div class="card-columns">
            @foreach ($stickies as $sticky)
                @if($sticky->sticky_type==1)
                <div class="note-base mr-3 my-3" id="note-base">
                    <div class="note-base-actions note{{ $sticky->sticky_type }}-actions" id="note-base-header">
                        <form action="{{ url('remove/') }}" method="POST">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="single" name="mode">
                            <input type="hidden" value="{{$sticky->sticky_id}}" name="sticky_id">
                            <input type="hidden" value="{{ $bid }}" name="bid">
                            <button type="submit" id="delete-single" class="btn btn-outline-light"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                    <div class="note-base-content note{{$sticky->sticky_type}}-content">
                        {{$sticky->sticky_content}}
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
