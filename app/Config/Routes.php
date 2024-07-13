<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->set404Override(
    function() {
        $data['title'] = '404';
        $data['content'] = view('errors/page_404');

        $uri_1 = service('uri')->getSegment(1);
        $role = model('Role')->findColumn('slug');
        if (session()->isLogin === true && in_array($uri_1, $role)) {
            $data['sidebar'] = view('dashboard/sidebar');
            return view('dashboard/header', $data);
        } else {
            $data['navbar'] = view('landingpage/navbar');
            $data['footer'] = view('landingpage/footer');
            return view('landingpage/header', $data);
        }
    }
);

/*--------------------------------------------------------------
  # Autentikasi
--------------------------------------------------------------*/
// login
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login-process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');

/*--------------------------------------------------------------
  # Dashboard
--------------------------------------------------------------*/
$user_session = model('Users')->where('id', session()->get('id_user'))->first();
if ($user_session) {
    $user_role = model('Role')->where('id', $user_session['id_role'])->first()['slug'];
    $routes->get($user_role . '/dashboard', 'Dashboard::dashboard', ['filter' => 'Auth']);
}

/*--------------------------------------------------------------
  # Admin
--------------------------------------------------------------*/
$routes->group('admin/app-settings', ['filter' => 'Admin'], static function ($routes) {
    $routes->get('/', 'AppSettings::index');
    $routes->post('update/(:segment)', 'AppSettings::update/$1');
});
$routes->group('admin/users', ['filter' => 'Admin'], static function ($routes) {
    $routes->get('get-data', 'Users::getData');
    $routes->get('/', 'Users::index');
    $routes->get('new', 'Users::new');
    $routes->post('create', 'Users::create');
    $routes->get('edit/(:segment)', 'Users::edit/$1');
    $routes->post('update/(:segment)', 'Users::update/$1');
    $routes->post('delete/(:segment)', 'Users::delete/$1');
    $routes->post('delete/image/(:segment)', 'Users::deleteImg/$1');
});
$routes->group('admin/berkas', ['filter' => 'Admin'], static function ($routes) {
    $routes->get('get-data', 'Berkas::getData');
    $routes->get('/', 'Berkas::index');
    $routes->post('delete/(:segment)', 'Berkas::delete/$1');
    $routes->post('import-excel', 'Berkas::importExcel');
});

/*--------------------------------------------------------------
  # User
--------------------------------------------------------------*/
$routes->group('user/berkas', ['filter' => 'User'], static function ($routes) {
    $routes->get('get-data', 'Berkas::getData');
    $routes->get('/', 'Berkas::index');
});