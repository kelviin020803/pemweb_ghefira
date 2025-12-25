@extends('admin.layout')

@section('title', 'Daftar Users')
@section('header', 'Daftar Users')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Order</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $user->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->role === 'admin')
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">Admin</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold">{{ $user->orders()->count() }}</span> pesanan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Belum ada user terdaftar
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t">
        {{ $users->links() }}
    </div>
</div>

<div class="mt-6 p-4 bg-blue-50 rounded-lg">
    <p class="text-blue-800">
        <strong>💡 Tips:</strong> Untuk mengubah role user menjadi admin, edit langsung di database melalui HeidiSQL.
        Ubah field <code class="bg-blue-100 px-1 rounded">role</code> dari <code class="bg-blue-100 px-1 rounded">user</code>
        menjadi <code class="bg-blue-100 px-1 rounded">admin</code>.
    </p>
</div>
@endsection
