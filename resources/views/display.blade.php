@extends ('layout')

@section ('content')
<nav class="navbar navbar-expand-sm fixed-top navbar-light bg-light">
    <!-- Tab selectors -->
    <ul class="navbar-nav">
        <div class="btn-group" role="group" aria-label="Sticky categories">
            <a class="nav-item nav-link {{ Request::is('display/*/0') ? 'active text-success' : ''}} width-1 btn btn-light" id="nav-wentwell-tab" href="/display/{{$bid}}/0" role="tab" aria-controls="nav-wentwell" aria-selected="true" title="Went Well"><i class="fas fa-thumbs-up"></i></a>
            <a class="nav-item nav-link {{ Request::is('display/*/2') ? 'active text-danger' : ''}} width-1 btn btn-light" id="nav-needsimprovement-tab" href="/display/{{$bid}}/2" role="tab" aria-controls="nav-needsimprovement" aria-selected="false" title="Needs Improvement"><i class="fas fa-thumbs-down"></i></a>
            <a class="nav-item nav-link {{ Request::is('display/*/1') ? 'active text-warning' : ''}} width-1 btn btn-light" id="nav-actionitem-tab" href="/display/{{$bid}}/1" role="tab" aria-controls="nav-actionitem" aria-selected="false" title="Action Item"><i class="fas fa-exclamation"></i></a>
        </div>
    </ul>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand mx-auto" href="/">Retro Board</a>
    </div>
    <!-- Div toggle -->
    <form class="form-inline my-2 mr-2 my-lg-0">
        <label for="hideStickyDiv" class="switch">
            <input class="ml-2" type="checkbox" name="hideStickyDiv" id="hideStickyDiv" title="Toggle sticky visibility" {{ old('hideStickyDiv') }}>
            <span class="slider round"></span>
        </label>
    </form>
    <!-- Buttons -->
    @if($protected)
        <form class="form-inline my-2 mr-2 my-lg-0" method="GET" action="/lock">
            <input type="hidden" name="bid" value="{{ $bid }}">
            <button type="submit" class="btn btn-outline-warning btn-lock-board width-2" id="lockboard" title="Lock board"></button>
        </form>
    @endif
    <ul class="nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-secondary" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-lg-right">
                <button type="button" class="btn btn-link text-danger" id="deleteall" title="Clear board" data-toggle="modal" data-target="#clearAllStickyModal" data-bid="{{ $bid }}"><i class="fas fa-quidditch mr-2"></i>Clear board</button>
            </div>
        </li>
    </ul>
</nav>

<div id=app>
    <display-page></display-page>
</div>

@endsection
