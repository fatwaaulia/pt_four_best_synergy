<?php
$user_session = model('Users')->where('id', session()->get('id_user'))->first();
$user_role = model('Role')->where('id', $user_session['id_role'])->first()['slug'];

$app_settings = model('AppSettings')->find(1);
$logo = base_url('assets/uploads/app_settings/') . $app_settings['logo'];
?>

<header id="header" class="header fixed-top d-flex align-items-center">
	<div class="d-flex align-items-center justify-content-between">
		<a href="<?= base_url($user_role) . '/dashboard' ?>" class="logo d-flex align-items-center">
			<img src="<?= $logo ?>">
		</a>
		<i class="fa-solid fa-bars toggle-sidebar-btn" id="toggleSidebarBtn"></i>
	</div>
	<nav class="header-nav ms-auto">
		<ul class="d-flex align-items-center">
			<label for="darkMode" class="me-2">
				<i class="fa-solid fa-circle-half-stroke"></i>
			</label>
			<div class="form-check form-switch me-3">
				<input class="form-check-input" type="checkbox" role="switch" id="darkMode">
			</div>
			<script>
			const darkmode_checkbox = document.getElementById('darkMode');
			const html = document.getElementById('html');

			if (localStorage.getItem('isDarkMode') === 'true') {
				html.setAttribute('data-bs-theme', 'dark');
				html.style.backgroundColor = '#1b1f22';
				darkmode_checkbox.checked = true;
			} else {
				html.setAttribute('data-bs-theme', 'light');
				html.removeAttribute('style');
				darkmode_checkbox.checked = false;
			}

			darkmode_checkbox.onclick = function() {
				if (darkmode_checkbox.checked) {
					localStorage.setItem('isDarkMode', true);
					html.setAttribute('data-bs-theme', 'dark');
					html.style.backgroundColor = '#1b1f22';
					darkmode_checkbox.checked = true;
				} else {
					localStorage.removeItem('isDarkMode');
					html.setAttribute('data-bs-theme', 'light');
					html.removeAttribute('style');
					darkmode_checkbox.checked = false;
				}
			}
			</script>
			<li class="nav-item dropdown pe-3">
				<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
					<img src="<?= base_url('assets/uploads/user-default.png'); ?>" alt="Profile" class="rounded-circle img-style" style="width:36px;height:36px">
					<span class="d-none d-md-block dropdown-toggle ps-2" style="color:var(--dark-color)"><?= $user_session['id']; ?></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
					<li>
						<hr class="dropdown-divider">
					</li>
					<li>
						<a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?>">
							<i class="fa-solid fa-arrow-right-from-bracket" style="font-size:16px"></i>
							<span>Keluar</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</nav>
</header>

<aside id="sidebar" class="sidebar">
	<?php
	$sidebar = [
		[
			'title'		=> 'Dashboard',
			'icon'		=> 'fa-solid fa-chart-line',
			'url'		=> base_url($user_role) . '/dashboard',
			'role'		=> [1, 2],
			'type'	    => 'no-collapse',
		],
		[
			'title'		=> 'Berkas',
			'icon'		=> 'fa-solid fa-file',
			'url'		=> base_url($user_role) . '/berkas',
			'role'		=> [1, 2],
			'type'	    => 'no-collapse',
		],
		[
			'title'		=> 'User Management',
			'icon'		=> 'fa-solid fa-user-group',
			'url'		=> base_url($user_role) . '/users',
			'role'		=> [1],
			'type'	    => 'no-collapse',
		],
		[
			'title'		=> 'Keluar',
			'icon'		=> 'fa-solid fa-arrow-right-from-bracket',
			'url'		=> base_url('logout'),
			'role'		=> [1, 2],
			'type'	    => 'no-collapse',
		],
	];
	?>
	<ul class="sidebar-nav" id="sidebar-nav">
		<?php
		$uri = service('uri');
		$uri->setSilent(true);
		$base_route = base_url($uri->getSegment(1) . '/' . $uri->getSegment(2));

		foreach ($sidebar as $v) :
			if (in_array($user_session['id_role'], $v['role'])) :
			if ($v['type'] == 'no-collapse') {
				($base_route == $v['url']) ? $collapsed = '' : $collapsed = 'collapsed';
		?>
		<li class="nav-item">
			<a class="nav-link <?= $collapsed ?>" href="<?= $v['url'] ?>">
				<i class="<?= $v['icon'] ?>"></i>
				<span><?= $v['title'] ?></span>
			</a>
		</li>
		<?php
			} elseif ($v['type'] == 'collapse') {
				if (in_array($base_route, array_column($v['collapse'], 'url'))) {
					$collapsed = '';
					$collapse_show = 'show';
				} else {
					$collapsed = 'collapsed';
					$collapse_show = '';
				}
		?>
		<li class="nav-item">
			<a class="nav-link <?= $collapsed ?>" data-bs-target="#<?= url_title($v['title'], '-', true) ?>" data-bs-toggle="collapse" href="#">
				<i class="<?= $v['icon'] ?>"></i>
				<span><?= $v['title'] ?></span>
				<i class="fa-solid fa-angle-down ms-auto"></i>
			</a>
			<ul id="<?= url_title($v['title'], '-', true) ?>" class="nav-content collapse <?= $collapse_show ?>" data-bs-parent="#sidebar-nav">
				<?php foreach ($v['collapse'] as $collapse) : ?>
				<li>
					<a href="<?= $collapse['url'] ?>" class="<?= $collapse['url'] == $base_route ? 'active' : '' ?>">
						<i class="fa-solid fa-circle"></i>
						<span><?= $collapse['title'] ?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
      	</li>
		<?php 
			} elseif (($v['type'] == 'heading')) {
		?>
		<li class="nav-heading my-3">
			<i class="fa-solid fa-minus"></i>
			<?= $v['title'] ?>
		</li>
		<?php
			}
			endif;
		endforeach;
		?>
	</ul>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let sidebar = document.getElementById('sidebar');
    if (sessionStorage.getItem('sidebarScrollPosition')) {
        sidebar.scrollTop = sessionStorage.getItem('sidebarScrollPosition');
    }
    sidebar.addEventListener('scroll', () => {
        sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop);
    });
});

let toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
toggleSidebarBtn.onclick = () => {
	if (window.innerWidth < 1200) return;

	let scrollHeadInner = document.querySelector('.dataTables_scrollHeadInner');
	if (!scrollHeadInner) return;

	if (document.body.classList.contains('toggle-sidebar')) {
		let scrollHeadInner_table = document.querySelector('.dataTables_scrollHeadInner table');
		scrollHeadInner.style.transition = 'width 0.3s ease';
		scrollHeadInner.style.width = scrollHeadInner_table.style.width;
	} else {
		scrollHeadInner.style.transition = 'width 0.3s ease';
		scrollHeadInner.style.width = '100%';
	}
};
</script>