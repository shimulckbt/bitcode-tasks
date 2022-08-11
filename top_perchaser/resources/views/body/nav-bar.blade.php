<nav class="navbar bg-light">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">Bitcode Task</a>
        <div class="d-flex">
            <a style="text-decoration: none;color:black" href="{{ route('report.generate') }}"
                class="d-flex @if (!session()->has('apiToken')) mx-5 @endif">Task
                One</a>
            <a style="text-decoration: none;color:black" href="{{ route('authorization.form') }}"
                class="d-flex @if (session()->has('apiToken')) mx-5 @endif">Task
                Two</a>

            @if (session()->has('apiToken'))
                <a class="d-flex"style="text-decoration: none;color:black;" href="{{ route('logout') }}">Logout</a>
            @endif
        </div>
    </div>
</nav>
