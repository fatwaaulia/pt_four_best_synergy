<?php
$user_session = model('Users')->where('id', session()->get('id_user'))->first();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4" style="background: linear-gradient(60deg, rgb(57 32 150) 0%, #2196F3 100%);">
                <div class="card-body text-white">
                    <h3 class="fw-600">Selamat datang <?= $user_session['id']; ?>!</h3>
                    <p>Akses cepat dan pengelolaan informasi secara efisien.</p>
                </div>
                <div>
                    <svg class="waves mb-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(255,255,255,0.7)" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6">
            <div class="card mb-3">
                <div class="card-body text-center" style="border-bottom:4px solid var(--bs-primary); border-radius:var(--border-radius)">
                    <p class="fw-500 d-block mb-2">
                        <i class="fa-solid fa-user-group me-1"></i>
                        Total Pengguna
                    </p>
                    <?php $users = model('Users')->findAll() ?>
                    <h3 class="mb-0"><?= count($users) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
