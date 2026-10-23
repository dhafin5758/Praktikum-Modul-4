@extends('layout')

@section('judul', 'Kelola Role')

@section('isi')
    <h2>Kelola Role Pengguna</h2>
    <table>
        <thead>
        <tr><th>ID</th><th>Nama</th><th>Username</th><th>Role</th><th>Ubah</th></tr>
        </thead>
        <tbody>
        @foreach ($users as $u)
            <tr>
                <td>{{ $u->id_user }}</td>
                <td>{{ $u->nama_lengkap }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if ($u->role !== 'admin')
                        <form class="inline" method="POST" action="{{ route('admin.users.role.update', $u->id_user) }}">
                            @csrf
                            @method('PATCH')
                            <select name="role">
                                <option value="customer" @selected($u->role === 'customer')>customer</option>
                                <option value="staff" @selected($u->role === 'staff')>staff</option>
                            </select>
                            <button type="submit">Simpan</button>
                        </form>
                    @else
                        <span class="kecil">dikunci</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection