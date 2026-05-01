<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto border-r border-zinc-200 bg-white">
      <div class="mb-6 px-2 font-bold text-xl tracking-tight text-zinc-900">
          BOOKING<span class="text-zinc-500">LAPANGAN</span>
      </div>

      <ul class="space-y-2 font-medium">
         <li class="{{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800 rounded-lg text-white' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-whiterounded-lg group  ">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         <p class="px-3 py-2 text-xs font-semibold text-zinc-400 uppercase tracking-wider mt-4">Kelola Booking/Pesanan</p>

         <li>
            <a href="#" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Daftar Booking</span>
            </a>
         </li>

         <li>
            <a href="#" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Atur Jadwal Lapangan</span>
            </a>
         </li>

         <p class="px-3 py-2 text-xs font-semibold text-zinc-400 uppercase tracking-wider mt-4">Kelola Lapangan</p>

          <li>
            <a href="{{ route('admin.semua-lapangan') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Daftar Lapangan</span>
            </a>
         </li>
          <li>
            <a href="{{ route('jenis-lapangan') }}" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 transition duration-75 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Daftar Kategori <span class="inline-flex items-center justify-center w-5 h-5 ms-10 text-xs font-bold text-white bg-zinc-900 rounded-full mr-5">{{\App\Models\Jenislapangan::count()}}</span></span>
            </a>
         </li>

         <li>
            <a href="#" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
               <span class="inline-flex items-center justify-center w-5 h-5 ms-2 text-xs font-bold text-white bg-zinc-900 rounded-full">2</span>
            </a>
         </li>

         <li>
            <a href="#" class="flex items-center px-3 py-2 text-zinc-600 rounded-lg hover:bg-zinc-100 hover:text-zinc-900 transition-colors group">
               <svg class="shrink-0 w-5 h-5 text-zinc-400 group-hover:text-zinc-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
            </a>
         </li>
      </ul>
   </div>
</aside>