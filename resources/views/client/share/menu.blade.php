<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Car<span>Book</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
        </button>
        @php
            $check = Auth::guard('khach_hang')->user();
            // dd($check);
        @endphp
        <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a  href="/client/route"  class="nav-link">Home</a></li>
            <li class="nav-item"><a href="/client/route" class="nav-link">Route</a></li>

            <li class="nav-item"><a href="/client/contact" class="nav-link">Contact</a></li>
            @if ($check)
                <li class="nav-item"><a href="/logout" class="nav-link">Logout</a></li>
            @else
                <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
            @endif
        </ul>
        </div>
    </div>
</nav>
