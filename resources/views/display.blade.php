@extends ('layout')

@section ('content')

<!-- Add Modal -->
<div class="modal fade" id="addStickyModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add new sticky to: {{ $types[$tab] }}</h5>
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
            </div>
            <div class="modal-body">
                This will clear the board including the stickies and the groups you've created!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form class="remove-board-form" action="{{ url('remove/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="allsticky" name="mode">
                    <input type="hidden" name="bid" value="{{$bid}}">
                    <button type="submit" class="btn btn-danger">Clear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create Group Modal -->
<div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGroupLabel">Create new group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('group/create/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="bid" value="{{ $bid }}">
                    <input type="hidden" name="sticky_type" value="{{ $tab }}">
                    <div class="form-group">
                        <label for="sticky-content">Group name</label>
                        <input type="text" class="form-control" id="group-name" name="group_name" aria-describedby="group-name-help" placeholder="Group name">
                        <small class="form-text text-muted">Max. length: 60 characters</small>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn {{ $button_color[$tab] }}">Create group</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="fab_wrapper">
    <button class="fab_btn fab{{ $tab }}" title="Add new sticky" data-toggle="modal" data-target="#addStickyModal" data-bid="{{ $bid }}"><i class="fas fa-plus"></i></button>
</div>

<!-- Header buttons -->
<div class="header-buttons px-5 pt-5">
    <a class="rounded-button {{ Request::is('display/*/0') ? 'active note0' : 'text-dark'}}" id="nav-wentwell-tab" href="/display/{{$bid}}/0" aria-controls="nav-wentwell" aria-selected="true" title="Went Well"><i class="fas fa-thumbs-up"></i></a>
    <a class="rounded-button {{ Request::is('display/*/2') ? 'active note2 ' : 'text-dark'}}" id="nav-needsimprovement-tab" href="/display/{{$bid}}/2" aria-controls="nav-needsimprovement" aria-selected="false" title="Needs Improvement"><i class="fas fa-thumbs-down"></i></a>
    <a class="rounded-button {{ Request::is('display/*/1') ? 'active note1 ' : 'text-dark'}}" id="nav-actionitem-tab" href="/display/{{$bid}}/1" aria-controls="nav-actionitem" aria-selected="false" title="Action Item"><i class="fas fa-exclamation"></i></a>
    <p class="header-spacer">|</p>
    <form class="form-toggle-visibility my-lg-0">
        <label for="hideStickyDiv" class="switch">
            <input class="ml-2" type="checkbox" name="hideStickyDiv" id="hideStickyDiv" title="Toggle sticky visibility" {{ old('hideStickyDiv') }}>
            <span class="slider round"></span>
        </label>
    </form>
    <button type="button" class="btn btn-link rounded-button danger-button" id="deleteall" title="Clear board" data-toggle="modal" data-target="#clearAllStickyModal" data-bid="{{ $bid }}"><span><i class="fas fa-quidditch mr-2"></i></span></button>
</div>

<!-- Stickies list -->
<div class="tab-content py-3 px-5 mt-2 mb-5" id="nav-tabContent">
    <div class="card-columns">
        @foreach ($stickies as $sticky)
            <div class="note-base note{{ $sticky->sticky_type }} mr-3 my-3" id="note-base">
                <div class="upper-shadow hover-display"></div>
                <div class="delete-sticky-form hover-display">
                    <form action="{{ url('remove/') }}" method="POST">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="mode" value="singlesticky">
                        <input type="hidden" name="sticky_id" value="{{ $sticky->sticky_id }}">
                        <input type="hidden" name="bid" value="{{ $bid }}">
                        <button type="submit" id="new-group" class="btn btn-light btn-sm delete-sticky-button" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <div class="note-base-content">
                    {{ $sticky->sticky_content }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
