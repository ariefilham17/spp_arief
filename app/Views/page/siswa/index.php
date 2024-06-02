<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Siswa</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="text-end">
                    <button onclick="addSiswa()" class="btn btn-primary mb-2 ms-auto _effect--ripple waves-effect waves-light w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg><span class="icon-name"></span>
                        <span class="btn-text-inner">Siswa</span>
                    </button>
                </div>
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">NISN</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-siswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form onsubmit="saveSiswa(); return false;">
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
                                <input id="nama" type="text" name="nama" placeholder="Masukkan Nama" class="form-control" required="">
                            </div>
                            <div class="mb-2">
                                <label for="nisn">NISN</label>
                                <input id="nisn" type="text" name="nama" placeholder="Masukkan NISN" class="form-control" required="" onkeyup="formatNumber(this)">
                            </div>
                            <div class="mb-2">
                                <label for="nisn">Jenis Kelamin</label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio custom-control-inline me-2">
                                        <input type="radio" id="customRadioInline1" name="jk" class="custom-control-input" value="L">
                                        <label class="custom-control-label" for="customRadioInline1">Laki-Laki</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="jk" class="custom-control-input" value="P">
                                        <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="date">Tanggal Lahir</label>
                                <input type="text" class="form-control w-100" id="date" placeholder="Add date picker">
                            </div>
                            <div class="form-group">
                                <label for="select-tempat-lahir">Tempat Lahir</label>
                                <select id="select-tempat-lahir" name="tempat_lahir" placeholder="Pilih Tempat Lahir" autocomplete="off" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-kelas">Kelas</label>
                                <select id="select-kelas" name="kelas" placeholder="Pilih Kelas" autocomplete="off" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php foreach ($data['kelas'] as $key => $value) { ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-kategori">Kategori</label>
                                <select id="select-kategori" name="kategori" placeholder="Pilih Kategori" autocomplete="off" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($data['kategori'] as $key => $value) { ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                    <?php } ?>
                                </select>
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


    <div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2"><b>Profil Siswa</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Nama
                                </td>
                                <td class="nama">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    NISN
                                </td>
                                <td class="nisn">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Kelas
                                </td>
                                <td class="kelas">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jenis Kelamin
                                </td>
                                <td class="jk">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    TTL
                                </td>
                                <td class="ttl">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Kategori
                                </td>
                                <td class="kategori">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="max-height: 40vh; overflow: scroll;">
                        <table class="table w-100" id="table_pembayaran">
                            <thead style="position: sticky; top: 0;">
                                <tr>
                                    <th scope="col" colspan="4"><b>Riwayat Pembayaran</b></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="/src/plugins/src/tomSelect/tom-select.base.js"></script>

<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script>
    let kelas = new TomSelect("#select-kelas", {
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    let tempat_lahir = new TomSelect("#select-tempat-lahir", {
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    let kategori = new TomSelect("#select-kategori", {
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    let date = $('#date').flatpickr({
        static: true,
        // dateFormat: "d-m-Y",

        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d',

    });

    $(document).ready(function() {
        $.get(`${base_url}api/master/provinsi`).then((res) => {
            let option = JSON.parse(res)?.map((e) => {
                tempat_lahir.addOption({
                    value: e?.name,
                    text: e?.name
                });
            });
        });

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
                "targets": 5
            }, {
                "width": "15%",
                "targets": [2, 3, 4]
            }],
            "pageLength": 10,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url + `api/siswa`,
            },
            createdRow: function(row, data, index) {
                $('td', row).eq(0).addClass('text-center');
                $('td', row).eq(2).addClass('text-center');
                $('td', row).eq(3).addClass('text-center');
                $('td', row).eq(4).addClass('text-center');
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

            editSiswa(id, nama);
        });

        $('#zero-config').on('click', '.delete', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama) {
                return;
            }

            deleteSiswa(id, nama);
        });

        $('#zero-config').on('click', '.detail', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama) {
                return;
            }

            profilSiswa(id);
        });
    })

    const addSiswa = () => {
        $('#modal-siswa .modal-title').text('Tambah Siswa');
        $('#modal-siswa form').trigger('reset');
        $('#modal-siswa form #id').val('');

        tempat_lahir.setValue(null);
        kelas.setValue(null);
        kategori.setValue(null);

        date.setDate(new Date(), true, 'd-m-Y');


        $('#modal-siswa').modal('show');
    }

    const editSiswa = (id) => {
        $.get(`${base_url}api/siswa/detail/${id}`).then((res) => {
            $('#modal-siswa .modal-title').text('Edit Siswa');
            $('#modal-siswa form').trigger('reset');
            $('#modal-siswa form #id').val(res?.id);
            $('#modal-siswa form #nama').val(res?.nama);
            $('#modal-siswa form #nisn').val(res?.nisn);
            $('#modal-siswa form input[name="jk"][value="' + (res?.jk).toUpperCase() + '"]').prop('checked', 'checked');

            tempat_lahir.setValue(res?.tempat_lahir);
            kelas.setValue(res?.kelas);
            kategori.setValue(res?.kategori);

            $('#modal-siswa').modal({
                backdrop: 'static',
                keyboard: false
            });

            date.setDate(res?.tanggal_lahir, true, 'Y-m-d');

            $('#modal-siswa').modal('show');
        })

    }

    const saveSiswa = () => {
        let id = $('#modal-siswa #id').val() || false;

        let data = {
            id: $('#modal-siswa #id').val(),
            nama: $('#modal-siswa #nama').val(),
            nisn: $('#modal-siswa #nisn').val(),
            kelas: $('#modal-siswa #select-kelas').val(),
            jk: $('input[name="jk"]:checked').val(),
            tempat_lahir: $('#modal-siswa #select-tempat-lahir').val(),
            tanggal_lahir: $('#modal-siswa #date').val(),
            kategori: $('#modal-siswa #select-kategori').val(),
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
                    type: id ? "PUT" : "POST",
                    url: base_url + 'api/siswa' + (id ? "/" + id : ""),
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

                        $('#modal-siswa').modal('hide');
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

    const profilSiswa = (id) => {
        $.get(`${base_url}api/siswa/profil/${id}`).then((res) => {
            console.log(res);

            $('.nama').html(res?.nama);
            $('.nisn').html(res?.nisn);
            $('.kelas').html(res?.kelas);
            $('.jk').html(res?.jk == 'l' ? 'Laki laki' : 'Perempuan');
            $('.ttl').html(res?.tempat_lahir + ', ' + res?.tanggal_lahir);
            $('.kategori').html(res?.kategori);

            const html = res?.pembayaran?.map((e, i) => {
                return `<tr>
                    <td>${i + 1}.</td>
                    <td>${e?.tanggal}</td>
                    <td>${e?.title}</td>
                    <td>${e?.nominal}</td>
                </tr>`
            }).join('');

            $('#table_pembayaran tbody').html(html);
            $('#modal-detail').modal('show');
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" type="text/css" href="/src/plugins/src/tomSelect/tom-select.default.min.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/light/tomSelect/custom-tomSelect.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/dark/tomSelect/custom-tomSelect.css">

<link href="/src/plugins/src/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="/src/plugins/src/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css">

<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/light/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">

<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">


<style>
    .form-control:disabled:not(.flatpickr-input),
    .form-control[readonly]:not(.flatpickr-input) {
        background-color: #fff;
        color: #3b3f5c;
    }

    .edit {
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

    .detail {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .flatpickr-wrapper {
        display: block;
    }
</style>
<?= $this->endSection(); ?>