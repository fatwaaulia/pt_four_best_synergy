<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3 position-relative">
                <?php if ($id_role == 1) : ?>
                <div class="row mb-3">
                    <div class="offset-lg-8 col-lg-4 offset-md-3 col-md-6 d-flex justify-content-end align-items-end">
                        <button href="<?= $base_route . '/new' ?>" class="btn btn-success me-2" onclick="document.getElementById('excel').click()">
                            <i class="fa-solid fa-file-arrow-up fa-sm me-1"></i> Import Excel
                        </button>
                        <form action="<?= $base_route . '/import-excel' ?>" method="post" id="formImportExcel" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="file" class="form-control d-none" id="excel" name="excel" accept=".xlsx, .xls, .csv">
                        </form>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
                        <script>
                        const fileInput = document.getElementById('excel');
                        fileInput.addEventListener('change', () => {
                            if (confirm('Tambahkan?')) {
                                document.getElementById('formImportExcel').submit();
                            } else {
                                location.reload();
                            }
                        });
                        </script>
                    </div>
                </div>
                <?php endif; ?>
                <table class="display nowrap w-100" id="myTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Bukti</th>
                            <th>Tanggal Bukti</th>
                            <th>NPWP Dipotong</th>
                            <th>Nama</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#myTable').DataTable({
        ajax: '<?= $get_data ?>',
        processing: true,
        serverSide: true,
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        'colvis',
        ],
        columns: [
            { data: 'no_urut' },
            { data: 'no_bukti' },
            { data: 'tanggal_bukti' },
            { data: 'npwp_dipotong' },
            { data: 'nama' },
            { data: null, render: data => (<?= $id_role ?> == 1) ? renderOpsi(data) : null },
        ],
    });
});

function renderOpsi(data) {
    let route_hapus_data = `<?= $base_route . '/delete/' ?>${data.id}`;
    return `
    <a href="#" data-bs-toggle="modal" data-bs-target="#hapus_data${data.id}" title="delete">
        <i class="fa-regular fa-trash-can fa-lg text-danger"></i>
    </a>
    <div class="modal fade" id="hapus_data${data.id}" tabindex="-1" aria-labelledby="hapusDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="hapusDataLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this data?</p>
                    <table>
                        <tr>
                            <td>User Id</td>
                            <td>: ${data.no_bukti}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="${route_hapus_data}" method="post">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>`;
}
</script>
