@extends('layouts.layout')

@section('title','Jenis Lapangan')

@section('content')
<div class="p-4 sm:p-6">

    <h1 class="text-xl sm:text-2xl font-bold mb-5 sm:mb-6 text-gray-800">
        TAMBAH JENIS ATAU KATEGORI LAPANGAN
    </h1>

    <div class="flex flex-wrap gap-3 mb-5 sm:mb-6">
        <a href="{{ route('tambah-jenis') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow text-sm">
            + Tambah Jenis
        </a>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow text-sm">
            Dashboard
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="py-3 px-4 whitespace-nowrap">No</th>
                        <th class="py-3 px-4 whitespace-nowrap">Nama Jenis Lapangan</th>
                        <th class="py-3 px-4 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jenisLapangan as $index => $jenis)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium">{{ $jenis->nama_jenis }}</td>
                        <td class="py-3 px-4">
                            <form action="{{ route('hapus-jenis', $jenis->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus jenis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs whitespace-nowrap">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
