        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('basic.index') }}">
            <a class="nav-link" href="{{ route('basic.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('User CRUD') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Nav::isRoute('lembagas.index') }}">
            <a class="nav-link" href="{{ route('lembagas.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Lembaga CRUD') }}</span>
            </a>
        </li>

        

        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('kegiatan_volunteers.index') }}">
            <a class="nav-link" href="{{ route('kegiatan_volunteers.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Kegiatan Volunteer CRUD') }}</span>
            </a>
        </li>
