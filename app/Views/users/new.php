<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/create' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="id_user" class="form-label">User Id</label>
                                    <input type="number" class="form-control <?= validation_show_error('id_user') ? 'is-invalid' : '' ?>" id="id_user" name="id_user" value="<?= old('id_user') ?>" placeholder="Masukkan user id">
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('id_user') ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="mb-2 position-relative">
                                        <input type="password" class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" value="<?= old('password') ?>" placeholder="Password">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('password') ?>
                                        </div>
								        <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_password">
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control <?= validation_show_error('passconf') ? 'is-invalid' : '' ?>" id="passconf" name="passconf" value="<?= old('passconf') ?>" placeholder="Confirm password">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('passconf') ?>
                                        </div>
								        <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_passconf">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 float-end">Tambahkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>
function toggleVisibility(inputElement, eyeElement) {
    const showIcon = "<?= base_url('assets/icon/show.png') ?>";
    const hideIcon = "<?= base_url('assets/icon/hide.png') ?>";
    inputElement.type = inputElement.type === 'password' ? 'text' : 'password';
    eyeElement.src = inputElement.type === 'password' ? showIcon : hideIcon;
}

const eyePassword = document.getElementById('eye_password');
const password = document.getElementById('password');
eyePassword.addEventListener('click', () => {
    toggleVisibility(password, eyePassword);
});

const eyePassconf = document.getElementById('eye_passconf');
const passconf = document.getElementById('passconf');
eyePassconf.addEventListener('click', () => {
    toggleVisibility(passconf, eyePassconf);
});
</script>