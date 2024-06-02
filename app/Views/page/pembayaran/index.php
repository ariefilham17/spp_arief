<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="text-end">
                    <button onclick="window.location.href = '<?= base_url('pembayaran/bulanan') ?>'" class="btn btn-primary mb-2 ms-auto _effect--ripple waves-effect waves-light w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg><span class="icon-name"></span>
                        <span class="btn-text-inner">Pembayaran Bulanan</span>
                    </button>
                    <button onclick="window.location.href = '<?= base_url('pembayaran/lainnya') ?>'" class="btn btn-primary mb-2 ms-auto _effect--ripple waves-effect waves-light w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg><span class="icon-name"></span>
                        <span class="btn-text-inner">Pembayaran Lainnya</span>
                    </button>
                </div>
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Nominal</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table w-50" id="data">
                        <tbody>
                            <tr>
                                <td width="140">Tanggal</td>
                                <td width="1" class="ps-0 pe-0">:</td>
                                <td class="tanggal"></td>
                            </tr>
                            <tr>
                                <td width="140">Nama</td>
                                <td width="1" class="ps-0 pe-0">:</td>
                                <td class="nama"></td>
                            </tr>
                            <tr>
                                <td width="140">Kelas</td>
                                <td width="1" class="ps-0 pe-0">:</td>
                                <td class="kelas"></td>
                            </tr>
                            <tr>
                                <td width="140">Kategori</td>
                                <td width="1" class="ps-0 pe-0">:</td>
                                <td class="kategori"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table w-100" id="detail">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10">No</th>
                                    <th class="text-center">Pembayaran</th>
                                    <th class="text-center" width="140">Nominal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="/src/plugins/src/tomSelect/tom-select.base.js"></script>

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
                "width": "120",
                "targets": 1
            }, {
                "width": "140",
                "targets": [3, 4]
            }, {
                "orderable": false,
                "width": "10%",
                "targets": 6
            }],
            "pageLength": 10,
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url + 'api/pembayaran',
            },
            createdRow: function(row, data, index) {
                $('td', row).eq(1).addClass('text-center');
                $('td', row).eq(3).addClass('text-center');
                $('td', row).eq(4).addClass('text-end');
            }
        });

        tables.on('draw', function() {
            feather.replace();
        });

        $('#zero-config').on('click', '.edit', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let id = $(this).data('id') || false;
            if (!id) {
                return;
            }

            showDetail(id);
        });

        $('#zero-config').on('click', '.detail', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let id = $(this).data('id') || false;
            if (!id) {
                return;
            }

            window.open(`${base_url}/pembayaran/nota/${id}`);
        });

        $('#zero-config').on('click', '.delete', function() {
            let el = $(this).closest('tr');
            let data = tables?.row(el)?.data();
            let nama = data[2] || false;
            let tanggal = data[1] || false;
            let id = $(this).data('id') || false;

            if (!id || !nama || !tanggal) {
                return;
            }

            deletePembayaran(id, nama, tanggal);
        });
    })

    const showDetail = (id) => {
        $.get(`${base_url}api/pembayaran/detail/${id}`).then((res) => {
            $('#data .tanggal').html(res?.tanggal);
            $('#data .nama').html(res?.nama);
            $('#data .kelas').html(res?.kode_kelas);
            $('#data .kategori').html(res?.kategori);

            let detail = res?.detail?.map((e, i) => {
                return `<tr>
                    <td>${i + 1}</td>
                    <td>${e?.keterangan}</td>
                    <td class="text-end">${e?.nominal}</td>
                </tr>`;
            }).join('');

            $('#detail tbody').html((detail != "" ? detail : `<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>`) + `${res?.keterangan ? `<tr><td colspan="3">Ket : ${res?.keterangan || ''}</td><tr>` : ''}`);
            $('#detail tfoot').html(detail != "" ? `<tr><th colspan="2" class="text-end">Total</th><th class="text-end">${res?.total}</th></tr>` : ``);

            $('#modal-detail').modal('show');
        });
    }

    const deletePembayaran = (id, nama, tanggal) => {
        let data = {
            id
        };

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menghapus pembayaran " + nama + " pada " + tanggal,
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
                    url: base_url + 'api/pembayaran/' + id,
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
    .detail {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
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
</style>
<?= $this->endSection(); ?>