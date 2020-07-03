@extends ('layout')

@section ('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Retro Board</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <form class="form-inline my-2 mr-2 my-lg-0 float-right">
        <button type="button" id="addboard" class="btn btn-success my-2 my-sm-0" title="Create new board" data-toggle="modal" data-target="#addBoardModal"><i class="fas fa-calendar-plus"></i></button>
    </form>
  </div>
</nav>

<!-- Add Modal -->
<div class="modal fade" id="addBoardModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Create new board</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('add/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="board" name="mode">
                    <div class="form-group">
                        <label for="board-name">Board name</label>
                        <input type="text" class="form-control" id="board_name" name="board_name" aria-describedby="board-name-help" placeholder="Board name">
                        <small id="max-charcount" class="form-text text-muted">Max. 60 characters</small>
                    </div>
                    <div class="form-group">
                        <label for="secure">Secure board</label>
                        <input type="checkbox" class="form-control" id="secure_board" name="secure_board" aria-describedby="secure-help" placeholder="Secure board">
                    </div>
                    <div class="form-group">
                        <label for="board-password">Board password</label>
                        <input type="password" class="form-control" id="board_password" name="board_password" aria-describedby="board-password-help" placeholder="Board password">
                        <small id="max-charcount" class="form-text text-muted">Max. 60 characters</small>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create board</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This will delete {boardname}! Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <form class="remove-board-form" action="{{ url('remove/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="board" name="mode">
                    <input class="hiddenBidBoxRemove" type="hidden" value="0" name="bid">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Enter password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('unlock/') }}" method="POST">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input class="hiddenBidBoxUnlock" type="hidden" value="0" name="bid">
                    <div class="form-group">
                        <label for="board-password">Board password</label>
                        <input type="password" class="form-control" id="password" name="password" aria-describedby="password-help" placeholder="Board password">
                        <small id="max-charcount" class="form-text text-muted">Max. 60 characters</small>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Unlock board</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Board list -->
<div id="wrapper" class="mt-3">
    <ul class="list-group">
        @foreach ($boards as $board)
        <a class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h3>{{ $board->board_name }}</h3>
                @if($board->secure == 1)
                    @if(\Cookie::get($board->board_id . '-unlocked') == 1)
                        <h3 class="faded"><i class="fas fa-unlock"></i></h3>
                    @else
                        <h3 class="faded"><i class="fas fa-lock"></i></h3>
                    @endif
                @endif
            </div>
            @if($board->secure == 1)
                @if(\Cookie::get($board->board_id . '-unlocked') == 1)
                    <form class="board-form" action="display/{{ $board->board_id }}/0" method="GET">
                        <button class="btn btn-warning btn-sm" type="submit" title="Open board">Open</button>
                    </form>
                @else
                    <form class="board-form">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#passwordModal" data-bid="{{ $board->board_id }}">Unlock</button>
                    </form>
                @endif
            @else
                <form class="board-form" action="display/{{ $board->board_id }}/0" method="GET">
                    <button class="btn btn-success btn-sm" type="submit" title="Open board">Open</button>
                </form>
            @endif
            
            <form class="board-form" action="export/" method="POST">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{ $board->board_id }}" name="bid">
                <button class="btn btn-outline-secondary btn-sm" type="submit" title="Export the contents of this board to .csv">Export</button>
            </form>
            <form class="board-form">
                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-boardname="{{ $board->board_name }}" data-bid="{{ $board->board_id }}" title="Delete board">Delete</button>
            </form>
        </a>
        @endforeach
    </ul>
</div>
@endsection
