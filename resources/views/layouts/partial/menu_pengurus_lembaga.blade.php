        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('kegiatan_volunteers.index') }}">
            <a class="nav-link" href="{{ route('kegiatan_volunteers.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Kegiatan Volunteer CRUD') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Nav::isRoute('volunteers.index') }}">
            <a class="nav-link" href="{{ route('volunteers.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Volunteer CRUD') }}</span>
            </a>
        </li>