<x-app-layout>
    

    <x-slot name="header">
        <div class="flex flex-auto justify-between">
            <h2 class="font-black text-xl text-blue-900 dark:text-blue-900">
                {{ __('Register SLIK') }}
            </h2>
            <div class="mb-2">
                <button onclick="return addData()" class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Tambah Data
                </button>
            </div>
        </div>
    </x-slot>

    

    <div class="w-auto mx-auto relative overflow-x-auto shadow-sm sm:rounded-lg mt-2 px-4 py-4">
        <x-message></x-message>
        <table style="width:100%" class="w-full text-sm text-center rtl:text-right text-white dark:text-black rounded-md shadow-xl">
            <thead class="text-md font-extrabold text-white uppercase bg-blue-900 dark:bg-blue-900 dark:text-white">
                <tr>
                    <th scope="col" class="px-4 py-3">
                        No
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Kantor
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Account Officer
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Nama Calon Debitur
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Alamat
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Sumber Berkas
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Supply Berkas
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Plafond Pengajuan
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Di Registrasi Oleh
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Dibuat Pada
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @php
                $no = 1;
                @endphp
                @forelse ($regsliks as $regslik)
                    <tr >
                        <td class="px-7 py-3">{{ $regslik->id }}</td>
                        <td class="px-7 py-3">{{ $regslik->kantor }}</td>
                        <td class="px-7 py-3">{{ $regslik->nama_ao }}</td>
                        <td class="px-7 py-3">{{ $regslik->nama_cadeb }}</td>
                        <td class="px-7 py-3">{{ $regslik->alamat_cadeb }}</td>
                        <td class="px-7 py-3">{{ $regslik->sumber_berkas }}</td>
                        <td class="px-7 py-3">{{ $regslik->supply_berkas }}</td>
                        <td class="px-7 py-3">{{ $regslik->sumber_supply }}</td>
                        <td class="px-7 py-3">{{ $regslik->plafond_pengajuan }}</td>
                        <td class="px-7 py-3">{{ $regslik->status_cadeb }}</td>
                        <td class="px-7 py-3">{{ $regslik->id_user }}</td>
                        <td class="px-7 py-3">
                            {{\Carbon\Carbon::parse($regslik->created_at)->format('d M, Y')  }}</td>
                        <td>
                            <button
                            onclick="return updateData('{{ $regslik->id }}','{{ $regslik->pernyataan_kesediaan }}','{{ $regslik->kantor }}',
                            '{{ $regslik->nama_ao }}','{{ $regslik->nama_cadeb }}','{{ $regslik->alamat_cadeb }}'
                            ,'{{ $regslik->sumber_berkas }}','{{ $regslik->supply_berkas }}','{{ $regslik->sumber_supply }}'
                            ,'{{ $regslik->plafond_pengajuan }}','{{ $regslik->status_cadeb }}','{{ $regslik->usaha_cadeb }}'
                            ,'{{ $regslik->id_user }}','{{ route('regsliks.update', $regslik->id) }}')" 
                            class="bg-gray-600 text-white font-bold px-3 py-1 rounded-lg hover:bg-gray-700 transition">Edit</button>
                            <button
                            onclick="return deleteData('{{ $regslik->id }}','{{ $regslik->kantor }}', '{{ route('regsliks.destroy', $user->id) }}')"
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
            {{ $regsliks->links() }}
        </div>
        
    </div>

    {{-- MODAL ADD DATA --}}
        <div id="modal-addData" class="hidden fixed inset-0 flex justify-center items-center m-4">
            <div class="bg-white rounded-lg p-4 w-1/2 shadow-xl">
                <h2 class="text-xl font-bold mb-4 bg-blue-200 p-3 rounded-xl">Tambah Register SLIK</h2>
                <form id="addForm" action="{{ route('regsliks.store') }}" method="post" class="w-full">
                    @csrf
                    <p id="modal-content"></p>
                    <div class="text-center">
                        <button type="submit" id="submitAdd" class="bg-blue-800 text-white px-4 py-1 rounded-md">
                            Simpan
                        </button>
                        <button type="button" onclick="closeModalAdd(event)"
                            class="bg-red-500 text-white px-4 py-1 rounded-md">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>

    {{-- MODAL UPDATE DATA --}}
        <div id="modal-updateData" class="hidden fixed inset-0 flex justify-center items-center m-4">
            <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
                <h2 class="text-lg font-bold mb-4 bg-amber-100 p-2 rounded-xl">Perbarui Register SLIK</h2>
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

  
    {{-- SCRIPT MODAL ADD --}}
        <script>
            function addData() {
                const modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = `
                <div class="grid grid-cols-2"> 
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Upload File<span class="text-red-500">*</span></label>
                        <div class="my-3">
                        <input class="border-blue-300 shadow-sm w-full rounded-lg" name="pernyataan_kesediaan" id="pernyataan_kesediaan" type="file">
                            @error('pernyataan_kesediaan')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Kantor<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="kantor" name="kantor" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Kantor">
                                <option value="">Pilih...</option>
                                <option value="Ciawi">Kantor Ciawi</option>
                                <option value="Rajapolah">Kantor Rajapolah</option>
                                <option value="Manonjaya">Kantor Manonjaya</option>
                                <option value="KPO">Kantor Pusat Operasional Singaparna</option>
                            </select>
                        </div>
                        @error('kantor')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Kantor<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="nama_ao" name="nama_ao" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Account Officer">
                                <option value="">Pilih...</option>
                                <option value="Warif">Warif</option>
                                <option value="Senja">Senja</option>
                                <option value="Ryan">Ryan</option>
                                <option value="Heru">Heru</option>
                            </select>
                        </div>
                        @error('nama_ao')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Nama Calon Debitur</label>
                        <div class="my-3">
                        <input name="nama_cadeb" id="nama_cadeb" type="text" placeholder="Isi nama cadeb" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('nama_cadeb')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Alamat Calon Debitur</label>
                        <div class="my-3">
                        <input name="alamat_cadeb" id="alamat_cadeb" type="text" placeholder="Isi e-mail" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('alamat_cadeb')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Sumber Berkas<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="sumber_berkas" name="sumber_berkas" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Existing">Existing 40-50%</option>
                                <option value="Lunas">Debitur Lunas</option>
                                <option value="Suplai Map">Suplai Map Karyawan</option>
                                <option value="Pasar & Penabung">Pasar & Penabung Aktif</option>
                                <option value="Baru">Nasabah Baru / Datang ke Kantor</option>
                            </select>
                        </div>
                        @error('sumber_berkas')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Supply Berkas<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="supply_berkas" name="supply_berkas" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Warif">Warif</option>
                                <option value="Senja">Senja</option>
                                <option value="Heru">Heru</option>
                                <option value="Anggi">Anggi</option>
                                <option value="Fachrul">Fachrul</option>
                                <option value="Rebbiya">Rebbiya</option>
                                <option value="Delia">Delia</option>
                                <option value="Dian H">Dian H</option>
                                <option value="Dian W">Dian W</option>
                            </select>
                        </div>
                        @error('supply_berkas')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Sumber Supply<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="sumber_supply" name="sumber_supply" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Promosi">Promosi / Brosur</option>
                                <option value="Datang ke Kantor">Datang ke Kantor</option>
                                <option value="Karyawan">Karyawan</option>
                                <option value="Customer Get Customer">Customer Get Customer</option>
                                <option value="Media Sosial">Media Sosial</option>
                            </select>
                        </div>
                        @error('sumber_supply')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Plafond Pengajuan</label>
                        <div class="my-3">
                        <input name="plafond_pengajuan" id="plafond_pengajuan" type="text" placeholder="Isi nama cadeb" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('plafond_pengajuan')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Status Nasabah<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="status_cadeb" name="status_cadeb" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Mengulang">Mengulang</option>
                                <option value="Baru">Baru</option>
                                <option value="Restruk">Restruk</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>
                        @error('status_cadeb')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Usaha Calon Debitur</label>
                        <div class="my-3">
                        <input name="usaha_cadeb" id="usaha_cadeb" type="text" placeholder="Isi nama cadeb" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('usaha_cadeb')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Di Registrasi Oleh</label>
                        <div class="my-3">
                        <input value="{{Auth::user()->name }}" id="id_user" name="id_user" type="text" placeholder="" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('id_user')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
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

    {{-- SCRIPT MODAL UPDATE
        <script>
            function updateData(id, name, email, password, role, status_p, routeUrl) {
                const modal = document.getElementById("modal-updateData");
                modal.classList.remove("hidden");

                const modalContent = document.getElementById("modal-content-update");
                modalContent.innerHTML = `
                <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Nama Pengguna</label>
                        <div class="my-3">
                        <input value="${name}" id="names" name="names" type="text" placeholder="Isi nama pengguna" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('name')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Email</label>
                        <div class="my-3">
                        <input value="${email}" id="emails" name="emails" type="email" placeholder="Isi e-mail" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('email')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Password</label>
                        <div class="my-3">
                        <input value="${password}" id="passwords" name="passwords" type="password" placeholder="Isi password" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('password')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Role<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="roles" name="roles" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="A" ${role === 'A' ? 'selected' : ''}>Admin</option>
                                <option value="CS" ${role === 'CS' ? 'selected' : ''}>Customer Service</option>
                                <option value="AO" ${role === 'AO' ? 'selected' : ''}>Account Officer</option>
                            </select>
                        </div>
                        @error('role')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Role<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="status_p" name="status_p" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Aktif" ${status_p === 'Aktif' ? 'selected' : ''}>Aktif</option>
                                <option value="Non-Aktif" ${status_p === 'Non-Aktif' ? 'selected' : ''}>Non-Aktif Service</option>
                            </select>
                        </div>
                        @error('status_p')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
            `;
                const updateForm = document.getElementById("updateForm");
                updateForm.action = routeUrl;
            }

            function closeModalUpdate(event) {
                event.preventDefault();
                document.getElementById("modal-updateData").classList.add("hidden");
            }
        </script> --}}

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


</x-app-layout>