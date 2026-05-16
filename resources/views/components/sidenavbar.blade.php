<button
  id="hamburger-btn"
  onclick="toggleSidebar()"
  type="button"
  class="fixed top-3 left-3 z-50 sm:hidden flex items-center justify-center w-10 h-10 bg-white border border-zinc-200 rounded-lg"
  aria-label="Buka menu"
>
  <svg class="w-5 h-5 text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
  </svg>
</button>

<div
  id="sidebar-overlay"
  onclick="closeSidebar()"
  class="fixed inset-0 z-30 bg-black/40 hidden sm:hidden"
></div>

<aside
  id="main-sidebar"
  class="fixed top-0 left-0 z-40 w-64 h-full -translate-x-full sm:translate-x-0 transition-transform duration-300 ease-in-out"
  aria-label="Sidebar"
>
  <div class="h-full px-3 py-4 overflow-y-auto border-r border-zinc-200 bg-white flex flex-col">

    <div class="mb-6 px-2 font-bold text-xl tracking-tight text-zinc-900">
      Sport<span class="text-green-500">Field</span>
    </div>

    @if (Auth::user()->role == 'admin')
      <ul class="space-y-2 font-medium flex-1">

        <li class="{{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800 rounded-lg text-white' : 'text-zinc-500' }}">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg group hover:bg-zinc-100 hover:text-zinc-900 transition-colors">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/>
            </svg>
            <span class="ms-3">Dashboard</span>
          </a>
        </li>

        <p class="px-3 py-2 text-xs font-semibold text-zinc-400 uppercase tracking-wider mt-4">Kelola Booking/Pesanan</p>

        <li>
          <a href="{{ route('admin.daftar-booking') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Daftar Booking
              <span class="inline-flex items-center justify-center w-5 h-5 ms-10 text-xs font-bold text-white bg-zinc-900 rounded-full mr-5">
                {{ \App\Models\Booking::count() }}
              </span>
            </span>
          </a>
        </li>

        <p class="px-3 py-2 text-xs font-semibold text-zinc-400 uppercase tracking-wider mt-4">Kelola Lapangan</p>

        <li class="{{ request()->routeIs('admin.semua-lapangan') ? 'bg-zinc-800 rounded-lg text-white' : 'text-zinc-500' }}">
          <a href="{{ route('admin.semua-lapangan') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Daftar Lapangan
              <span class="inline-flex items-center justify-center w-5 h-5 ms-10 text-xs font-bold text-white bg-zinc-900 rounded-full mr-5">
                {{ \App\Models\Lapangan::count() }}
              </span>
            </span>
          </a>
        </li>

        <li>
          <a href="{{ route('jenis-lapangan') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Daftar Kategori
              <span class="inline-flex items-center justify-center w-5 h-5 ms-10 text-xs font-bold text-white bg-zinc-900 rounded-full mr-5">
                {{ \App\Models\JenisLapangan::count() }}
              </span>
            </span>
          </a>
        </li>

      </ul>
    @endif

    @if (Auth::user()->role == 'user')
      <ul class="space-y-2 font-medium flex-1">

        <li class="{{ request()->routeIs('user.dashboard') ? 'bg-zinc-800 rounded-lg text-white' : 'text-zinc-500' }}">
          <a href="{{ route('user.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5m7 0h7"/>
            </svg>
            <span class="ms-3">Dashboard</span>
          </a>
        </li>

        <li>
          <a href="{{ route('user.cari-lapangan') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="w-5 h-5 text-zinc-400 group-hover:text-zinc-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-2m-6 2V2m6 16l5.447-2.724A1 1 0 0021 16.382V5.618a1 1 0 00-.553-.894L15 2m0 16V2m-6 0l6 2"/>
            </svg>
            <span class="ms-3">Cari Lapangan</span>
          </a>
        </li>

        <li>
          <a href="{{ route('booking.index') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="w-5 h-5 text-zinc-400 group-hover:text-zinc-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="ms-3">Booking Saya</span>
          </a>
        </li>

        <p class="px-3 py-2 text-xs font-semibold text-zinc-400 uppercase tracking-wider mt-4">Account</p>

        <li>
          <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
            <svg class="w-5 h-5 text-zinc-400 group-hover:text-zinc-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="ms-3">Profile</span>
          </a>
        </li>

      </ul>
    @endif

    <div class="mt-auto pt-4">
      <a href="{{ route('logout') }}"
         class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg class="shrink-0 w-5 h-5 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
        </svg>
        <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
      </form>
    </div>

  </div>
</aside>

<script>
  function toggleSidebar() {
    document.getElementById('main-sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.toggle('hidden');
  }
  function closeSidebar() {
    document.getElementById('main-sidebar').classList.add('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.add('hidden');
  }
</script>