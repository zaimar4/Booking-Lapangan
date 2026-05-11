@extends('layouts.layout')

@section('title','Jenis Lapangan')

@section('content')
<div class="p-6 ml-60">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        TAMBAH JENIS ATAU KATEGORI LAPANGAN
    </h1>

    <div class="flex gap-3 mb-6">
        <a href="{{ route('tambah-jenis') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Jenis
        </a>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
            Dashboard
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">Nama Jenis Lapangan</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @foreach ($JenisLapangan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4">{{ $item->nama_jenis }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection