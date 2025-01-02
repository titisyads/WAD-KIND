

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

        <li class="nav-item {{ Nav::isRoute('checkouts.index') }}">
            <a class="nav-link" href="{{ route('checkouts.index') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>{{ __('Transaksi') }}</span>
            </a>
        </li>
