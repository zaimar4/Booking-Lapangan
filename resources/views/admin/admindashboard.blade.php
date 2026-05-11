@extends('layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')

<div class="flex">

    <div class="flex-1 p-8 ml-60">

        <h1 class="text-2xl font-bold mb-6">
            Dashboard Admin
        </h1>

        <div class="flex flex-row gap-4 mb-6">

            <div class="flex justify-center items-center bg-slate-400 rounded-xl border border-black px-4 py-4">
                <p>
                    Total Lapangan :
                    <span class="text-black font-bold">
                        {{ $totalLapangan }}
                    </span>
                </p>
            </div>

            <div class="flex justify-center items-center bg-slate-400 rounded-xl border border-black px-4 py-4">
                <p>
                    Total Booking :
                    <span class="text-black font-bold">
                        {{ $totalLapangan }}
                    </span>
                </p>
            </div>

        </div>

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

                            <td class="px-4 py-2 border">
                                {{ $item->nama_lapangan }}
                            </td>

                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                    {{ $item->jenisLapangan->nama_jenis }}
                                </span>
                            </td>

                            <td class="px-4 py-2 border">
                                <img
                                    src="{{ asset('images/' . $item->gambar_lapangan) }}"
                                    alt="{{ $item->nama_lapangan }}"
                                    class="w-20 h-12 object-cover rounded">
                            </td>

                            <td class="px-4 py-2 border text-sm">
                                {{ Str::limit($item->deskripsi_lapangan, 50) }}
                            </td>

                            <td class="px-4 py-2 border font-medium text-green-600">
                                Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-2 border">

                                <a
                                    href="{{ route('edit-lapangan', $item->id) }}"
                                    class="text-blue-500">
                                    Edit
                                </a>

                                <a
                                    href="{{ route('detail-lapangan', $item->id) }}"
                                    class="text-green-500 ml-2">
                                    Detail
                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Tidak ada data lapangan
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
