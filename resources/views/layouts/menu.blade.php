@role(App\Models\Role::ROLE_ADMIN)
@include('layouts.partial.menu_admin')
@endrole

@role(App\Models\Role::ROLE_PENGURUS)
@include('layouts.partial.menu_pengurus')
@endrole

