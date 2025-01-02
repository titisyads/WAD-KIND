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
        <li class="nav-item {{ Nav::isRoute('reviews.index') }}">
            <a class="nav-link" href="{{ route('reviews.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Review CRUD') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Nav::isRoute('dokumentasis.index') }}">
            <a class="nav-link" href="{{ route('dokumentasis.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Dokumentasi CRUD') }}</span>
            </a>
        </li>






