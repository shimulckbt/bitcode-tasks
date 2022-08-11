<nav class="navbar bg-light">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">Bitcode Task</a>
        <div class="d-flex">
            <a style="text-decoration: none;color:black" href="{{ route('report.generate') }}"
                class="d-flex @if (!session()->has('apiToken')) mx-5 @endif">Task
                One</a>

            @if (session()->has('apiToken'))
                <a style="text-decoration: none;color:black" href="{{ route('all.boards') }}"
                    class="d-flex @if (session()->has('apiToken')) mx-5 @endif">All Boards</a>

                <a class="d-flex"style="text-decoration: none;color:black;" href="{{ route('logout') }}">Logout</a>
            @else
                <a style="text-decoration: none;color:black" href="{{ route('authorization.form') }}"
                    class="d-flex">Task
                    Two</a>
            @endif
        </div>
    </div>
</nav>
