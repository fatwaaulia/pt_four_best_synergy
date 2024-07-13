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
                <div class="row mb-3">
                    <div class="col-lg-6 offset-lg-6 col-md-6 d-flex justify-content-end align-items-end">
                        <a href="<?= $base_route . '/new' ?>" class="btn btn-primary">
                            <i class="fa-solid fa-plus fa-sm"></i> New
                        </a>
                    </div>
                </div>
                <table class="display nowrap w-100" id="myTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Role</th>
                            <th>ID User</th>
                            <th>Created At</th>
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
        dom: 'Bfrtip',
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
            { data: 'nama_role' },
            { data: 'id_decode' },
            { data: 'created_at' },
            { data: null, render: renderOpsi },
        ],
    });
});

function renderOpsi(data) {
    if (data.id_role == 1) return null;
    let route_edit_data = `<?= $base_route . '/edit/' ?>${data.id}`;
    let route_hapus_data = `<?= $base_route . '/delete/' ?>${data.id}`;
    return `
    <a href="${route_edit_data}" class="me-2" title="edit">
        <i class="fa-regular fa-pen-to-square fa-lg"></i>
    </a>
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
                            <td>: ${data.id_decode}</td>
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
