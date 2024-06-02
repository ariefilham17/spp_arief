<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
                <li class="breadcrumb-item active" aria-current="page">Administrator</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="text-end">
                    <button onclick="addAdministrator()" class="btn btn-primary mb-2 ms-auto _effect--ripple waves-effect waves-light w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg><span class="icon-name"></span>
                        <span class="btn-text-inner">Administrator</span>
                    </button>
                </div>
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-administrator" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form onsubmit="saveAdministrator(); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="mb-2">
                            <label for="nama">Nama</label>
                            <input id="nama" type="text" name="nama" placeholder="Masukkan Nama" class="form-control" required="" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Username</label>
                            <input id="user" type="text" name="user" placeholder="Masukkan Username" class="form-control" required="" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">Pilih Role</option>
                                <?php foreach ($data['role'] ?? [] as $value) { ?>
                                    <option value="<?= $value ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="nama">Akses</label>
                            <div>
                                <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" onclick="$(this).closest('form').find('input[type=\'checkbox\']').prop('checked', true);">Select All</button>
                                <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" onclick="$(this).closest('form').find('input[type=\'checkbox\']').prop('checked', false);">Unselect All</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="pembayaran" name="pembayaran">
                                        <label class="form-check-label" for="pembayaran">Pembayaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="pengeluaran" name="pengeluaran">
                                        <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="pemasukan" name="pemasukan">
                                        <label class="form-check-label" for="pemasukan">Pemasukan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="laporan_keuangan" name="laporan/keuangan">
                                        <label class="form-check-label" for="laporan_keuangan">Laporan - Keuangan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="siswa" name="siswa">
                                        <label class="form-check-label" for="siswa">Data - Siswa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="kelas" name="kelas">
                                        <label class="form-check-label" for="kelas">Data - Kelas</label>
                                    </div>
                                </div>
                                <div class="col-6">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="jenis_siswa" name="jenis_siswa">
                                        <label class="form-check-label" for="jenis_siswa">Kategori - Jenis Siswa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="jenis_biaya" name="jenis_biaya">
                                        <label class="form-check-label" for="jenis_biaya">Kategori - Jenis Biaya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="biaya" name="biaya">
                                        <label class="form-check-label" for="biaya">Kategori - Biaya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="kategori" name="kategori">
                                        <label class="form-check-label" for="kategori">Kategori - Lainnya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="administrator" name="administrator">
                                        <label class="form-check-label" for="administrator">Pengguna - Administrator</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="setting" name="setting">
                                        <label class="form-check-label" for="setting">Pengaturan - Sekolah</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" data-bs-dismiss="modal">Discard</button>
                    <button class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-password" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form onsubmit="savePasswordAdministrator(); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="mb-2">
                            <label for="nama">Nama</label>
                            <input id="nama" type="text" placeholder="Masukkan Nama" class="form-control" readonly autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Password</label>
                            <input id="pass" type="password" name="pass" placeholder="Masukkan Password" class="form-control" required="" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Confirm Password</label>
                            <input id="repass" type="password" name="repass" placeholder="Masukkan Konfirmasi Password" class="form-control" required="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" data-bs-dismiss="modal">Discard</button>
                    <button class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        var tables = $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 25, 50],
            "columnDefs": [{
                "width": "1%",
                "targets": 0
            }, {
                "orderable": false,
                "width": "10%",
                "targets": [4]
            }, {
                "width": "20%",
                "targets": [1, 2, 3]
            }],
            "pageLength": 10,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url + 'api/administrator',
            },
            createdRow: function(row, data, index) {
                $('td', row).eq(3).addClass('text-center');
            }
        });

        tables.on('draw', function() {
            feather.replace();
        });

        $('#zero-config').on('click', '.edit', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;
            if (!id || !nama) {
                return;
            }

            editAdministrator(id, nama);
        });

        $('#zero-config').on('click', '.pass', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama) {
                return;
            }

            editPassAdministrator(id, nama);
        });

        $('#zero-config').on('click', '.delete', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama) {
                return;
            }

            deleteAdministrator(id, nama);
        });
    })

    const addAdministrator = () => {
        $('#modal-administrator .modal-title').text('Tambah Administrator');
        $('#modal-administrator form').trigger('reset');
        $('#modal-administrator form #id').val('');
        $('#modal-administrator').modal('show');
    }

    const editAdministrator = (id, nama) => {
        $.get(`${base_url}/api/administrator/edit/${id}`).then((res) => {
            $('#modal-administrator .modal-title').text('Edit Administrator');
            $('#modal-administrator form').trigger('reset');
            $('#modal-administrator form #id').val(res?.id);
            $('#modal-administrator form #nama').val(res?.nama);
            $('#modal-administrator form #user').val(res?.user);
            $('#modal-administrator form #role').val(res?.role);
            res?.akses?.map((e) => {
                $('#modal-administrator form input[name="' + e + '"]').prop('checked', true);
            })

            $('#modal-administrator').modal('show');
        });
    }

    const saveAdministrator = () => {
        let id = $('#modal-administrator #id').val() || false;

        let data = {
            id: $('#modal-administrator #id').val(),
            nama: $('#modal-administrator #nama').val(),
            user: $('#modal-administrator #user').val(),
            role: $('#modal-administrator #role').val(),
            access: []
        }

        $('#modal-administrator input[type="checkbox"]').each((i, e) => {
            if ($(e).is(':checked')) {
                data['access'].push($(e).attr('name'));
            }
        });

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menyimpan data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: id ? "PUT" : "POST",
                    url: base_url + 'api/administrator' + (id ? "/" + id : ""),
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res?.messages?.success || ("Berhasil " + (id ? "menyimpan" : "mengedit") + " data!"),
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#modal-administrator').modal('hide');
                        $('#zero-config').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.statusText || 'Kesalahan pada server!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        console.log(err);
                    }
                });
            }
        })
    }

    const deleteAdministrator = (id, nama) => {
        let data = {
            id
        };

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menghapus data " + nama,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: base_url + 'api/administrator/' + id,
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res?.messages?.success || ("Berhasil menghapus data!"),
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#zero-config').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.statusText || 'Kesalahan pada server!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        console.log(err);
                    }
                });
            }
        })
    }

    const editPassAdministrator = (id, nama) => {
        $('#modal-password .modal-title').text('Edit Password Administrator');
        $('#modal-password form').trigger('reset');
        $('#modal-password form #id').val(id);
        $('#modal-password form #nama').val(nama);

        $('#modal-password').modal('show');
    }


    const savePasswordAdministrator = () => {
        let id = $('#modal-password #id').val();

        let data = {
            pass: $('#modal-password #pass').val(),
        }

        if (!id || !data['pass']) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data tidak lengkap',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        if ($('#modal-password #pass').val() !== $('#modal-password #repass').val()) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Konfirmasi password harus sama dengan password!',
                timer: 2000,
                showConfirmButton: false
            });
            $('#modal-password #pass').val('');
            $('#modal-password #repass').val('');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menyimpan data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'api/administrator/pass/' + id,
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res?.messages?.success || ("Berhasil " + (id ? "menyimpan" : "mengedit") + " data!"),
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#modal-password').modal('hide');
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.statusText || 'Kesalahan pada server!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        console.log(err);
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<style>
    .edit {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .pass {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .delete {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }
</style>
<?= $this->endSection(); ?>