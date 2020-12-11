@extends ('layout')

@section ('content')
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand mx-auto" href="#">Retro Board</a>
</nav>

<div id=app>
    <front-page></front-page>
</div>

<script src="{{ mix('js/app.js') }}"></script>

@endsection
