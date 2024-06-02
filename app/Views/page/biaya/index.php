<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nominal Biaya</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="form-group col-12 col-md-3" style="min-width: 100px;">
                        <select id="jenis" name="jenis" placeholder="Pilih Jenis" autocomplete="off" required>
                            <option value="">Pilih Jenis</option>
                            <?php foreach ($data['jenis'] as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-3" style="min-width: 100px;">
                        <select id="kategori" name="kategori" placeholder="Pilih Kategori" autocomplete="off" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($data['kategori'] as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-2" style="min-width: 100px;">
                    </div>
                    <div class="col-12 col-md-4 text-end">
                        <button onclick="addBiaya()" class="btn btn-primary mb-2 ms-auto _effect--ripple waves-effect waves-light w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span class="icon-name"></span>
                            <span class="btn-text-inner">Biaya</span>
                        </button>
                    </div>
                </div>
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-biaya" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form onsubmit="saveBiaya(); return false;">
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
                            <label for="select-jenis">Jenis</label>
                            <select id="select-jenis" name="jenis" placeholder="Pilih Jenis" autocomplete="off" required>
                                <option value="">Pilih Jenis</option>
                                <?php foreach ($data['jenis'] as $key => $value) { ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input id="nominal" type="text" name="nominal" id="nominal" placeholder="Masukkan Nominal" class="form-control" required="" onkeyup="formatRupiah(this)">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-dark _effect--ripple waves-effect waves-light" data-bs-dismiss="modal">Discard</button>
                        <button class="btn btn-primary _effect--ripple waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script src="/src/plugins/src/tomSelect/tom-select.base.js"></script>
<script>
    let jenis = new TomSelect("#select-jenis", {
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    let kategori = new TomSelect("#select-kategori", {
        sortField: {
            field: "text",
            direction: "asc"
        },
        searchField: null
    });

    $(document).ready(function() {
        new TomSelect("#jenis", {
            sortField: {
                field: "text",
                direction: "asc"
            },
            onChange: (value) => {
                tables.ajax.url(base_url + `api/biaya?jenis=${$('#jenis').val()}&kategori=${$('#kategori').val()}`).load();
            }
        });

        new TomSelect("#kategori", {
            sortField: {
                field: "text",
                direction: "asc"
            },
            searchField: null,
            onChange: (value) => {
                tables.ajax.url(base_url + `api/biaya?jenis=${$('#jenis').val()}&kategori=${$('#kategori').val()}`).load();
            }
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
                "width": "15%",
                "targets": [2, 3]
            }, {
                "orderable": false,
                "width": "10%",
                "targets": [4]
            }, ],
            "pageLength": 10,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url + `api/biaya?jenis=${$('#jenis').val()}&kategori=${$('#kategori').val()}`,
            },
            createdRow: function(row, data, index) {
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

            editBiaya(id, nama);
        });

        $('#zero-config').on('click', '.delete', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama) {
                return;
            }

            deleteBiaya(id, nama);
        });
    })

    const addBiaya = () => {
        $('#modal-biaya .modal-title').text('Tambah Biaya');
        $('#modal-biaya form').trigger('reset');
        $('#modal-biaya form #id').val('');

        jenis.setValue(null);
        kategori.setValue(null);

        $('#modal-biaya').modal('show');
    }

    const editBiaya = (id, nama) => {
        $.get(`${base_url}api/biaya/${id || ''}`).then((res) => {
            $('#modal-biaya .modal-title').text('Edit Biaya');
            $('#modal-biaya form').trigger('reset');
            $('#modal-biaya form #id').val(id);
            $('#modal-biaya form #nominal').val(res?.nominal || null).trigger('keyup');

            jenis.setValue(res?.jenis || null);
            kategori.setValue(res?.kategori || null);

            $('#modal-biaya').modal('show');
        });
    }

    const saveBiaya = () => {
        let id = $('#modal-biaya #id').val() || false;

        let data = {
            id: $('#modal-biaya #id').val(),
            jenis: $('#modal-biaya #select-jenis').val(),
            nominal: $('#modal-biaya #nominal').val().replaceAll(',', ''),
            kategori: $('#modal-biaya #select-kategori').val(),
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
                    url: base_url + 'api/biaya' + (id ? "/" + id : ""),
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

                        $('#modal-biaya').modal('hide');
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

    const deleteBiaya = (id, nama) => {
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
                    url: base_url + 'api/biaya/' + id,
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
</script>

<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" type="text/css" href="/src/plugins/src/tomSelect/tom-select.default.min.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/light/tomSelect/custom-tomSelect.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/dark/tomSelect/custom-tomSelect.css">

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