<x-app-layout>
    

    <x-slot name="header">
        <div class="flex flex-auto justify-between">
            <h2 class="font-black text-2xl text-blue-900 dark:text-blue-900">
                {{ __('Laporan Hasil SLIK') }}
            </h2>
            @cannot('role-CS')
            @cannot('role-A')
            <div class="mb-2">
                <button onclick="return addData()" class="bg-blue-600 text-white font-bold px-6 py-1 rounded-lg hover:bg-blue-700 transition">
                    + Tambah Data
                </button>
            </div>
            @endcannot
            @endcannot
        </div>
    </x-slot>

    

    <div class="w-auto mx-auto relative overflow-x-auto shadow-sm sm:rounded-lg mt-2 px-4 py-4">
        <x-message></x-message>
        <div class="flex justify-between items-center mb-3">
            <!-- Filter -->
            <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-2">
                <label for="filter" class="text-sm font-medium text-gray-700">Filter Status:</label>
                <select name="status_slik" id="filter" class="rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">Semua</option>
                    @foreach ($statusList as $status_slik)
                        <option value="{{ $status_slik }}" @if(request('status_slik') == $status_slik) selected @endif>{{ $status_slik }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700">Terapkan</button>
            </form>
            <a href="{{ route('report-export', ['status_slik' => request('status_slik')]) }}" type="submit" class="bg-yellow-600 text-white px-6 py-1 rounded-md hover:bg-yellow-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            <!-- Optional: Add another button or search on the right side -->
        </div>
        <table style="width:100%" class="w-full text-sm text-center rtl:text-right text-white dark:text-black rounded-md shadow-xl">
            <thead class="text-md font-extrabold text-white uppercase bg-blue-900 dark:bg-blue-900 dark:text-white">
                <tr>
                    <th scope="col" class="px-4 py-3">
                        No
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Nama Nasabah
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Alamat Nasabah
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Status SLIK
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Di Laporkan Oleh
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Dibuat Pada
                    </th>
                    @cannot('role-CS')
                    @cannot('role-A')
                    <th scope="col" class="px-4 py-3">
                        Aksi
                    </th>
                    @endcannot
                    @endcannot
                </tr>
            </thead>
            <tbody id="tableBody">
                @php
                $no = 1;
                @endphp
                @forelse ($reports as $report)
                    <tr >
                        <td class="px-7 py-3">{{ $report->id }}</td>
                        <td class="px-7 py-3">{{ $report->nama_nasabah }}</td>
                        <td class="px-7 py-3">{{ $report->alamat_nasabah }}</td>
                        <td class="px-7 py-3">{{ $report->status_slik }}</td>
                        <td class="px-7 py-3">{{ $report->id_user }}</td>
                        <td class="px-7 py-3">
                            {{\Carbon\Carbon::parse($report->created_at)->format('d M, Y')  }}</td>
                        <td>
                            @cannot('role-CS')
                            @cannot('role-A')
                            <button
                            onclick="return updateData('{{ $report->id }}','{{ $report->file_hasil }}','{{ $report->nama_nasabah }}',
                            '{{ $report->alamat_nasbah }}','{{ $report->status_slik }}','{{ $report->id_user }}','{{ route('reports.update', $report->id) }}')" 
                            class="bg-gray-600 text-white font-bold px-3 py-1 rounded-lg hover:bg-gray-700 transition">Edit</button>
                            <button
                            onclick="return deleteData('{{ $report->id }}','{{ route('reports.destroy', $report->id) }}')"
                            class="bg-red-600 text-white font-bold px-3 py-1 rounded-lg hover:bg-red-700 transition">Hapus</button>
                            @endcannot
                            @endcannot
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
            {{ $reports->appends(request()->query())->links() }}
        </div>
        
    </div>

    {{-- MODAL ADD DATA --}}
        <div id="modal-addData" class="hidden fixed inset-0 flex justify-center items-center m-4">
            <div class="bg-white rounded-lg p-4 w-1/2 max-h-[90vh] overflow-y-auto shadow-xl">
                <h2 class="text-xl font-bold mb-4 bg-blue-200 p-3 rounded-xl">Tambah Laporan</h2>
                <form enctype="multipart/form-data" id="addForm" action="{{ route('reports.store') }}" method="post" class="w-full">
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
        {{-- <div id="modal-updateData" class="hidden fixed inset-0 flex justify-center items-center m-4">
            <div class="bg-white rounded-lg p-6 w-1/2 max-h-[90vh] overflow-y-auto shadow-xl">
                <h2 class="text-lg font-bold mb-4 bg-blue-200 p-2 rounded-xl">Perbarui Laporan Hasil</h2>
                <form enctype="multipart/form-data" id="updateForm" action="" method="post" class="w-full">
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
        </div> --}}

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
        //     function previewImage() {
        //     const logo = document.querySelector('#file_hasil');
        //     const imgPreview = document.querySelector('.img-preview');


        //     const oFReader = new FileReader();
        //     oFReader.readAsDataURL(logo.files[0]);

        //     oFReader.onload = function(oFREvent) {
        //         imgPreview.src = oFREvent.target.result;
        //     imgPreview.style.display = 'block';

        //     }    
        // }
            function addData() {
                const modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = `
                <div class="grid grid-cols-2"> 
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Upload File<span class="text-red-500">*</span></label>
                        <div class="my-3">
                        <input class="border-blue-300 shadow-sm w-full rounded-lg mb-3" 
                        name="file_hasil" id="file_hasil" type="file">
                            @error('file_hasil')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Nama Calon Debitur</label>
                        <div class="my-3">
                        <input name="nama_nasabah" id="nama_nasabah" type="text" placeholder="Isi nama nasabah" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('nama_nasabah')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Alamat Calon Debitur</label>
                        <div class="my-3">
                        <input name="alamat_nasabah" id="alamat_nasabah" type="text" placeholder="Isi alamat cadeb" 
                        class="border-blue-300 shadow-sm w-full rounded-lg">
                            @error('alamat_nasabah')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Status Nasabah<span class="text-red-500">*</span></label>
                        <div class="my-3">
                            <select id="status_slik" name="status_slik" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Bagian">
                                <option value="">Pilih...</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        @error('status_slik')
                            p class="text-red-500 font-medium"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="px-2 py-3">
                        <label for="" class="text-lg font-medium">Di Laporkan Oleh</label>
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
            function previewImage() {
            const logo = document.querySelector('#pernyataan_kesediaan');
            const imgPreview = document.querySelector('.img-preview');


            const oFReader = new FileReader();
            oFReader.readAsDataURL(logo.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            imgPreview.style.display = 'block';

            }
        }

            function updateData(id, pernyataan_kesediaan, kantor, nama_ao, nama_cadeb, alamat_cadeb, sumber_berkas, supply_berkas
            ,sumber_supply, plafond_pengajuan, status_cadeb, usaha_cadeb, id_user, routeUrl) {
                const modal = document.getElementById("modal-updateData");
                modal.classList.remove("hidden");

                const modalContent = document.getElementById("modal-content-update");
                modalContent.innerHTML = `
                    <div class="grid grid-cols-2"> 
                        @foreach ($regsliks as $regslik)
                            <div class="px-2 py-3">
                                <label for="" class="text-lg font-medium">Upload File<span class="text-red-500">*</span></label>
                                <div class="my-3">
                                <input value=${pernyataan_kesediaan} class="border-blue-300 shadow-sm w-full rounded-lg" 
                                name="pernyataan_kesediaan" id="pernyataan_kesediaan" type="file" onchange="previewImage()">
                                <img class="img-preview img-fluid mb-3 col-sm-2 text-center" 
                                src="{{ asset('storage/' . $regslik->pernyataan_kesediaan) }}" style="width:150px">
                                    @error('pernyataan_kesediaan')
                                        p class="text-red-500 font-medium"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="px-2 py-3">
                            <label for="" class="text-lg font-medium">Kantor<span class="text-red-500">*</span></label>
                            <div class="my-3">
                                <select id="kantor" name="kantor" class="form-control border-blue-300 shadow-sm w-full rounded-lg"  data-placeholder="Pilih Kantor">
                                    <option value="">Pilih...</option>
                                    <option value="Ciawi" ${kantor === 'Ciawi' ? 'selected' : ''}>Kantor Ciawi</option>
                                    <option value="Rajapolah" ${kantor === 'Rajapolah' ? 'selected' : ''}>Kantor Rajapolah</option>
                                    <option value="Manonjaya" ${kantor === 'Manonjaya' ? 'selected' : ''}>Kantor Manonjaya</option>
                                    <option value="KPO" ${kantor === 'KPO' ? 'selected' : ''}>Kantor Pusat Operasional Singaparna</option>
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
                                    <option value="Warif" ${nama_ao === 'Warif' ? 'selected' : ''}>Warif</option>
                                    <option value="Senja" ${nama_ao === 'Senja' ? 'selected' : ''}>Senja</option>
                                    <option value="Ryan" ${nama_ao === 'Ryan' ? 'selected' : ''}>Ryan</option>
                                    <option value="Heru" ${nama_ao === 'Heru' ? 'selected' : ''}>Heru</option>
                                </select>
                            </div>
                            @error('nama_ao')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="px-2 py-3">
                            <label for="" class="text-lg font-medium">Nama Calon Debitur</label>
                            <div class="my-3">
                            <input value="${nama_cadeb}" name="nama_cadeb" id="nama_cadeb" type="text" placeholder="Isi nama cadeb" 
                            class="border-blue-300 shadow-sm w-full rounded-lg">
                                @error('nama_cadeb')
                                    p class="text-red-500 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="px-2 py-3">
                            <label for="" class="text-lg font-medium">Alamat Calon Debitur</label>
                            <div class="my-3">
                            <input value="${alamat_cadeb}" name="alamat_cadeb" id="alamat_cadeb" type="text" placeholder="Isi e-mail" 
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
                                    <option value="Existing" ${sumber_berkas === 'Existing' ? 'selected' : ''}>Existing 40-50%</option>
                                    <option value="Lunas" ${sumber_berkas === 'Lunas' ? 'selected' : ''}>Debitur Lunas</option>
                                    <option value="Suplai Map" ${sumber_berkas === 'Suplai Map' ? 'selected' : ''}>Suplai Map Karyawan</option>
                                    <option value="Pasar & Penabung" ${sumber_berkas === 'Pasar & Penabung' ? 'selected' : ''}>Pasar & Penabung Aktif</option>
                                    <option value="Baru" ${sumber_berkas === 'Baru' ? 'selected' : ''}>Nasabah Baru / Datang ke Kantor</option>
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
                                    <option value="Warif" ${supply_berkas === 'Warif' ? 'selected' : ''}>Warif</option>
                                    <option value="Senja" ${supply_berkas === 'Senja' ? 'selected' : ''}>Senja</option>
                                    <option value="Heru" ${supply_berkas === 'Heru' ? 'selected' : ''}>Heru</option>
                                    <option value="Anggi" ${supply_berkas === 'Anggi' ? 'selected' : ''}>Anggi</option>
                                    <option value="Fachrul" ${supply_berkas === 'Fachrul' ? 'selected' : ''}>Fachrul</option>
                                    <option value="Rebbiya" ${supply_berkas === 'Rebbiya' ? 'selected' : ''}>Rebbiya</option>
                                    <option value="Delia" ${supply_berkas === 'Delia' ? 'selected' : ''}>Delia</option>
                                    <option value="Dian H" ${supply_berkas === 'Dian H' ? 'selected' : ''}>Dian H</option>
                                    <option value="Dian W" ${supply_berkas === 'Dian W' ? 'selected' : ''}>Dian W</option>
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
                                    <option value="Promosi" ${sumber_supply === 'Promosi' ? 'selected' : ''}>Promosi / Brosur</option>
                                    <option value="Datang ke Kantor" ${sumber_supply === 'Datang ke Kantor' ? 'selected' : ''}>Datang ke Kantor</option>
                                    <option value="Karyawan" ${sumber_supply === 'Karyawan' ? 'selected' : ''}>Karyawan</option>
                                    <option value="Customer Get Customer" ${sumber_supply === 'Customer Get Customer' ? 'selected' : ''}>Customer Get Customer</option>
                                    <option value="Media Sosial" ${sumber_supply === 'Media Sosial' ? 'selected' : ''}>Media Sosial</option>
                                </select>
                            </div>
                            @error('sumber_supply')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="px-2 py-3">
                            <label for="" class="text-lg font-medium">Plafond Pengajuan</label>
                            <div class="my-3">
                            <input value="${plafond_pengajuan}" name="plafond_pengajuan" id="plafond_pengajuan" type="text" placeholder="Isi nama cadeb" 
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
                                    <option value="Mengulang"${status_cadeb === 'Mengulang' ? 'selected' : ''}>Mengulang</option>
                                    <option value="Baru" ${status_cadeb === 'Baru' ? 'selected' : ''}>Baru</option>
                                    <option value="Restruk" ${status_cadeb === 'Restruk' ? 'selected' : ''}>Restruk</option>
                                    <option value="Karyawan" ${status_cadeb === 'Karyawan' ? 'selected' : ''}>Karyawan</option>
                                </select>
                            </div>
                            @error('status_cadeb')
                                p class="text-red-500 font-medium"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="px-2 py-3">
                            <label for="" class="text-lg font-medium">Usaha Calon Debitur</label>
                            <div class="my-3">
                            <input value="${usaha_cadeb}" name="usaha_cadeb" id="usaha_cadeb" type="text" placeholder="Isi nama cadeb" 
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
            function deleteData(id, routeUrl) {
                const modal = document.getElementById("modal-deleteData");
                modal.classList.remove("hidden");

                const message = document.getElementById("delete-message");
                message.textContent = `Apakah kamu yakin ingin menghapus register ini ?`;

                const deleteForm = document.getElementById("deleteForm");
                deleteForm.action = routeUrl;
            }

            function closeModalDelete() {
                document.getElementById("modal-deleteData").classList.add("hidden");
            }
        </script>


</x-app-layout>