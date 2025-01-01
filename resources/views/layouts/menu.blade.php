@role(App\Models\Role::ROLE_ADMIN)
@include('layouts.partial.menu_admin')
@endrole

@role(App\Models\Role::ROLE_PENGURUS_LEMBAGA)
@include('layouts.partial.menu_pengurus_lembaga')
@endrole

@role(App\Models\Role::ROLE_PENGURUS_KEGIATAN)
@include('layouts.partial.menu_pengurus_kegiatan')
@endrole

