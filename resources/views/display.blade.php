<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Retro Board</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark text-light">
            <a class="navbar-brand">Retro Board</a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-item nav-link" href="/">Home</a>
                </li>
            </ul>
            <form class="form-inline my-2 mr-2 my-lg-0">
                <button type="button" class="btn btn-outline-success" id="addsingle" title="Add new sticky" data-placement="left" data-content="You can add new stickies to the board..." data-toggle="modal" data-target="#addStickyModal" data-bid="{{ $bid }}"><i class="fas fa-plus-circle"></i>&nbspAdd item</button>
            </form>
            <form class="form-inline my-2 my-lg-0" action="{{ url('remove/') }}" method="POST">
                <input type="hidden" value="full" name="mode">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{ $bid }}" name="bid">
                <button type="submit" class="btn btn-outline-danger" id="deleteall" title="Clear all stickies" data-placement="bottom" data-content="...or you can delete them alltogether."><i class="fas fa-trash-alt"></i>&nbspClear board</button>
            </form>
        </nav>

        <!-- Add Modal -->
        <div class="modal fade" id="addStickyModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add new sticky</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('add/') }}" method="POST">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="item" name="mode">
                            <input class="hiddenBidBoxAddSticky" type="hidden" value="0" name="bid">
                            <div class="form-group">
                                <label for="sticky-type">Sticky type</label>
                                <select class="form-control" id="sticky-type" name="sticky_type">
                                    <option value="0">Went well</option>
                                    <option value="2">Needs improvement</option>
                                    <option value="1">Action item</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sticky-content">Sticky content</label>
                                <input type="text" class="form-control" id="sticky-content" name="sticky_content" aria-describedby="sticky-content-help" placeholder="Sticky content">
                            </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create sticky</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="stickies-accordion">
            <!-- Went well stickies -->
            @if($stickies != null)
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-success" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-chevron-down"></i>&nbspOpen: Went well
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#stickies-accordion">
                    
                    <div class="grid-container">
                        @foreach ($stickies as $sticky)
                            @if($sticky->sticky_type==0)
                            <div class="note-base" id="note-base">
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
            @endif

            <!-- Needs improvement stickies -->
            @if($stickies != null)
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-danger" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-chevron-down"></i>&nbspOpen: Needs improvement
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#stickies-accordion">
                    <div class="grid-container">
                        @foreach ($stickies as $sticky)
                            @if($sticky->sticky_type==2)
                            <div class="note-base" id="note-base">
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
            @endif

            <!-- Action items stickies -->
            @if($stickies != null)
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-warning" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <i class="fas fa-chevron-down"></i>&nbspOpen: Action items
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#stickies-accordion">
                    <div class="grid-container">
                        @foreach ($stickies as $sticky)
                            @if($sticky->sticky_type==1)
                            <div class="note-base" id="note-base">
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
        </div>
        @endif

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/1eaaf45e00.js" crossorigin="anonymous"></script>
        <script src="../js/script.js"></script>
    </body>
</html>
