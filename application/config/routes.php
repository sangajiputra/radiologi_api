<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//===== ROUTE API =====//
//===== ROUTE USER =====//
$route['api/users']['GET']              = 'UserController/get_all';
$route['api/user/(:num)']['GET']        = 'UserController/get/$1';
$route['api/register']['POST']          = 'UserController/register';
$route['api/user_update/(:num)']['POST'] = 'UserController/update/$1';
$route['api/user/(:num)']['DELETE']     = 'UserController/delete/$1';
$route['api/login']                     = 'UserController/login';
$route['api/cek_token']['GET']          = 'UserController/cek_token';

//===== ROUTE RADIOLOGI JOBS =====//
$route['api/radiologijobs']['GET']                  = 'RadiologijobsController/get_all';
$route['api/radiologijobs/(:num)']['GET']           = 'RadiologijobsController/get/$1';
$route['api/radiologijobs_update/(:num)']['POST']   = 'RadiologijobsController/update/$1';
$route['api/radiologijobs/(:num)']['DELETE']        = 'RadiologijobsController/delete/$1';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
