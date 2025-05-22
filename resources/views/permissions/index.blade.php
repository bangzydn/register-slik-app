{{-- <x-app-layout>
    

    <x-slot name="header">
        <div class="flex flex-auto justify-between">
            <h2 class="font-black text-xl text-blue-900 dark:text-blue-900">
                {{ __('Data Hak Akses') }}
            </h2>
            <div class="mb-2">
                <button onclick="return addData()" class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Tambah Data
                </button>
            </div>
        </div>
    </x-slot>

    

    <div class="w-1/2 mx-auto relative overflow-x-auto shadow-sm sm:rounded-lg mt-2 px-4 py-4">
        <x-message-app></x-message-app>
            <
        <table style="width:100%" class="w-full text-sm text-center rtl:text-right text-white dark:text-black rounded-md shadow-xl">
            <thead class="text-md font-extrabold text-white uppercase bg-blue-900 dark:bg-blue-900 dark:text-white">
                <tr>
                    <th scope="col" class="px-7 py-3">
                        No
                    </th>
                    <th scope="col" class="px-7 py-3">
                        Hak Akses
                    </th>
                    <th scope="col" class="px-7 py-3">
                        Dibuat Pada
                    </th>
                    <th scope="col" class="px-7 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @php
                $no = 1;
                @endphp
                @forelse ($permissions as $permission)
                    <tr >
                        <td class="px-7 py-3">{{ $permission->id }}</td>
                        <td class="px-7 py-3">{{ $permission->name }}</td>
                        <td class="px-7 py-3">
                            {{\Carbon\Carbon::parse($permission->created_at)->format('d M, Y')  }}</td>
                        <td>
                            <button
                            onclick="return updateData('{{ $permission->id }}','{{ $permission->name }}','{{ route('permissions.update', $permission->id) }}')" 
                            class="bg-gray-600 text-white font-bold px-3 py-1 rounded-lg hover:bg-gray-700 transition">Edit</button>
                            <button
                            onclick="return deleteData('{{ $permission->id }}','{{ $permission->name }}', '{{ route('permissions.destroy', $permission->id) }}')"
                            class="bg-red-600 text-white font-bold px-3 py-1 rounded-lg hover:bg-red-700 transition">Hapus</button>
                        </td>
                    </tr>
                    <!-- forelse empty row mimic -->
                    <tr class="empty-row" style="display:none;">
                    <td colspan="3">No matching records found.</td>
                    </tr>
                @empty
                    <tr>
                        <td>Data Not Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="my-3">
            {{ $permissions->links() }}
        </div>
        
    </div>

    {{-- MODAL ADD DATA --}}
    <div id="modal-addData" class="hidden fixed inset-0 flex justify-center items-center m-4">
        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
            <h2 class="text-lg font-bold mb-4 bg-blue-200 p-2 rounded-xl">Tambah Hak Akses</h2>
            <form id="addForm" action="{{ route('permissions.store') }}" method="post" class="w-full">
                @csrf
                <p id="modal-content"></p>
                <button type="submit" id="submitAdd" class="mt-2 bg-blue-800 text-white px-4 py-1 rounded-md">
                    Simpan
                </button>
                <button type="button" onclick="closeModalAdd(event)"
                    class="mt-2 bg-red-500 text-white px-4 py-1 rounded-md">
                    Tutup
                </button>
            </form>
        </div>
    </div>

    {{-- MODAL UPDATE DATA --}}
    <div id="modal-updateData" class="hidden fixed inset-0 flex justify-center items-center m-4">
        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
            <h2 class="text-lg font-bold mb-4 bg-amber-100 p-2 rounded-xl">Perbarui Hak Akses</h2>
            <form id="updateForm" action="" method="post" class="w-full">
                @csrf
                @method('PATCH')
                <p id="modal-content-update"></p>
                <button type="submit" id="submitUpdate" class="mt-4 bg-sky-500 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <button type="button" onclick="closeModalUpdate(event)"
                    class="mt-4 bg-red-500 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE DATA --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 flex justify-center items-center m-4 bg-black/30 z-50">
        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
            <h2 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h2>
            <form id="deleteForm" action="" method="post" class="w-full">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800"></p>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 text-white px-4 py-2 rounded">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- KODE DATA --}}
    {{-- <script>
        const kodekoleksiBaru = @json($codeData);
    </script> --}}

    {{-- SCRIPT MODAL ADD --}}
    <script>
        function addData() {
            const modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = `
                <div class="px-2 py-3">
                    <label for="" class="text-lg font-medium">Nama Hak Akses</label>
                    <div class="my-3">
                    <input name="name" type="text" placeholder="Isi nama hak akses" 
                    class="border-blue-300 shadow-sm w-1/2 rounded-lg">
                        @error('name')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                </div>
            `;
            const modal = document.getElementById("modal-addData");
            modal.classList.remove("hidden");
        }

        function closeModalAdd() {
            const modal = document.getElementById("modal-addData");
            modal.classList.add("hidden");
        }
    </script>

 {{-- SCRIPT MODAL UPDATE --}}
    <script>
        function updateData(id, name, routeUrl) {
            const modal = document.getElementById("modal-updateData");
            modal.classList.remove("hidden");

            const modalContent = document.getElementById("modal-content-update");
            modalContent.innerHTML = `
            <div class="px-2 py-3">
                    <label for="" class="text-lg font-medium">Nama Hak Akses</label>
                    <div class="my-3">
                    <input value="${name}" name="name" type="text" placeholder="Isi nama hak akses" 
                    class="border-gray-300 shadow-sm w-1/2 rounded-lg mb-2">
                        @error('name')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                </div>
        `;
            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl;
        }

        function closeModalUpdate(event) {
            event.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }
    </script>

    {{-- SCRIPT MODAL DELETE --}}
    <script>
        function deleteData(id, judul, routeUrl) {
            const modal = document.getElementById("modal-deleteData");
            modal.classList.remove("hidden");

            const message = document.getElementById("delete-message");
            message.textContent = `Apakah kamu yakin ingin menghapus hak akses dengan nama "${name}"?`;

            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl;
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }
    </script>

    {{-- SCRIPT SEARCH --}}
    <script>
  const searchInput = document.getElementById('searchInput');
  const tableBody = document.getElementById('tableBody');
  const emptyRow = tableBody.querySelector('tr.empty-row');
  searchInput.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase().trim();
    let visibleCount = 0;
    // Iterate all rows except the empty message row
    Array.from(tableBody.rows).forEach(row => {
      if (row.classList.contains('empty-row')) {
        return;
      }
      // Check if any cell contains the filter text
      const text = row.textContent.toLowerCase();
      if (text.indexOf(filter) > -1) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });
    // Show or hide empty-row depending on visible rows count
    if (visibleCount === 0) {
      emptyRow.style.display = '';
    } else {
      emptyRow.style.display = 'none';
    }
  });
  </script>
</x-app-layout> --}}