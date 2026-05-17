<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['do_login'] = 'auth/do_login';

// Setup (jalankan sekali)
$route['setup'] = 'setup/index';

// Admin routes
$route['admin'] = 'admin/dashboard/index';
$route['admin/(:any)'] = 'admin/$1';
