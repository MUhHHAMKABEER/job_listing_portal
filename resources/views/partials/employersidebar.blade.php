<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">Job Listing Portal</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('employerdashboard') }}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('applications')}}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Applications</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('showlisting')}}">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">My Listings</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

