@extends ('layout')

@section ('content')
<p class="top-logo">[RB]</p>

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

<div class="fab_wrapper">
    <button class="fab_btn" id="addboard" title="Add new sticky" data-toggle="modal" data-target="#addBoardModal""><i class="fas fa-plus"></i></button>
</div>

<!-- Board grid -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 mx-3 my-3">
    @foreach ($boards as $board)
        <div class="col mb-4">
            <div class="rb-card">
                <div class="rb-card-body">
                    <h5 class="card-title">{{ $board->board_name }}</h5>
                    <form class="board-form form-open" action="display/{{ $board->board_id }}/0" method="GET">
                        <button class="btn btn-light btn-rounded" type="submit" title="Open board"><i class="fas fa-sign-in-alt"></i></button>
                    </form>
                    <form class="board-form form-export" action="export/" method="POST">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" value="{{ $board->board_id }}" name="bid">
                        <button class="btn btn-outline-light btn-rounded" type="submit" disabled title="Export the contents of this board to .csv"><i class="fas fa-file-export"></i></button>
                    </form>
                    <form class="board-form form-delete">
                        <button type="button" class="btn btn-outline-light btn-rounded" data-toggle="modal" data-target="#deleteModal" data-boardname="{{ $board->board_name }}" data-bid="{{ $board->board_id }}" title="Delete board"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <div class="circle"></div>
            </div>
        </div>
    @endforeach
</div>
@endsection
