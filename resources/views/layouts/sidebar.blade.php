<!-- Sidebar -->
<div class="col-md-2 p-0 bg-dark text-white d-flex flex-column justify-content-between sidebar" style="min-height: 100vh;">
    <div>
        
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
        </a>
        <a href="{{ route('students.index') }}" class="sidebar-item {{ Request::is('students*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate fa-fw me-2"></i> Students
        </a>
        <a href="{{ route('coaches.index') }}" class="sidebar-item {{ Request::is('coaches*') ? 'active' : '' }}">
            <i class="fas fa-users fa-fw me-2"></i> Coaches
        </a>
        <a href="{{ route('schedules') }}" class="sidebar-item {{ Request::is('schedules*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt fa-fw me-2"></i> Schedules
        </a>
        <a href="{{ route('exercises.index') }}" class="sidebar-item {{ Request::is('exercises*') ? 'active' : '' }}">
            <i class="fas fa-dumbbell fa-fw me-2"></i> Exercises
        </a>
    </div>

    <div>
        <a href="{{ route('logout') }}"
           class="sidebar-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           <i class="fas fa-sign-out-alt fa-fw me-2"></i> Log out
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

