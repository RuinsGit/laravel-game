@extends('layouts.admin')

@section('content')
    <div class="admin-konteyner">
        <h1 class="admin-səhifə-başlıq">İstifadəçiləri İdarə Et</h1>

        <div class="admin-cədvəl-konteyneri">
            <table class="admin-cədvəl">
                <thead>
                <tr>
                    <th>Ad</th>
                    <th>Email</th>
                    <th>Əməliyyatlar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="admin-sil-formu">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ussil">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
