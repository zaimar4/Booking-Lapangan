@extends("layouts.layout")

@section('title', 'Daftar Lapangan')

@section('content')
<div class="p-4 sm:p-6">

    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4">
        SEMUA LAPANGAN
    </h1>

    <div class="flex flex-wrap gap-3 mb-4">
        <a href="{{ route('admin.tambah-lapangan') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow text-sm">
            + Tambah Lapangan
        </a>

        <a href="{{ route('jenis-lapangan') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow text-sm">
            Kategori Lapangan
        </a>
    </div>

    <div class="mb-4">
        <span class="text-gray-700 font-medium text-sm">Total lapangan:</span>
        <span class="font-bold text-blue-600">{{ $totalLapangan }}</span>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Nama</th>
                        <th class="px-4 py-3 whitespace-nowrap">Jenis</th>
                        <th class="px-4 py-3 whitespace-nowrap">Gambar</th>
                        <th class="px-4 py-3 whitespace-nowrap">Deskripsi</th>
                        <th class="px-4 py-3 whitespace-nowrap">Harga</th>
                        <th class="px-4 py-3 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($lapangan as $item)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-4 py-3 font-medium whitespace-nowrap">
                            {{ $item->nama_lapangan }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="bg-gray-200 px-2 py-1 rounded text-xs whitespace-nowrap">
                                {{ $item->JenisLapangan->nama_jenis }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <img src="{{ $item->gambar_lapangan }}"
                                 class="w-20 h-16 object-cover rounded">
                        </td>

                        <td class="px-4 py-3 max-w-xs">
                            {{ Str::limit($item->deskripsi_lapangan, 50) }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded whitespace-nowrap
                                {{ $item->status == 'tersedia' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex gap-1.5 flex-wrap">

                                <a href="{{ route('edit-lapangan', $item->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs whitespace-nowrap">
                                    Edit
                                </a>

                                <a href="{{ route('detail-lapangan', $item->id) }}"
                                   class="bg-blue-400 hover:bg-blue-500 text-white px-2 py-1 rounded text-xs whitespace-nowrap">
                                    Detail
                                </a>

                                <form action="{{ route('delete-lapangan', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs whitespace-nowrap">
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
