@extends('layouts.layout')
@section('title', 'Dashboard Admin')
@section('content')

<div class="flex">
    <x-sidenavbar />
    
    <div class="flex-1 p-8 ml-60"> 
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        {{-- <div class="flex gap-4 mb-8">
            <a href="{{ route('admin.tambah-lapangan') }}" class="bg-zinc-900 hover:bg-zinc-800 text-white px-4 py-2 rounded\0">Tambah Lapangan</a>
            <a href="{{ route('jenis-lapangan') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">Kategori Lapangan</a>
            <a href="{{ route('admin.semua-lapangan') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Lihat Semua</a>
        </div> --}}

        <div class="bg-white shadow-md rounded-lg p-6">
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2 border">Nama Lapangan</th>
                            <th class="px-4 py-2 border">Jenis</th>
                            <th class="px-4 py-2 border">Gambar</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Harga Sewa</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lapangan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $item->nama_lapangan }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 bg-gray-200 rounded text-xs">{{ $item->jenis_lapangan }}</span>
                            </td>
                            <td class="px-4 py-2 border">
                                <img src="{{ asset('images/' . $item->gambar_lapangan) }}" 
                                     alt="{{ $item->nama_lapangan }}" 
                                     class="w-20 h-12 object-cover rounded">
                            </td>
                            <td class="px-4 py-2 border text-sm">{{ Str::limit($item->deskripsi_lapangan, 50) }}</td>
                            <td class="px-4 py-2 border font-medium text-green-600">
                                Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                            </td>
                             <td>
                                <a href="{{ route('edit-lapangan', $item->id) }}">Edit</a>
                                <a href="{{ route('detail-lapangan', $item->id) }}">detail</a>

                                <form action="{{ route('delete-lapangan', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                                </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 italic">
                                Belum ada data lapangan tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection