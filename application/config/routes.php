<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

# LOGIN ROUTES
$route['register']['GET'] = 'Login/index_register';
$route['user/register']['POST'] = 'Login/register';
$route['user/login']['POST'] = 'Login/login';
$route['user/logout']['GET'] = 'Login/logout';



# PATIENT ROUTES
$route['patient']['GET'] = 'Patient/index';
$route['patient/add']['POST'] = 'Patient/add'; 
$route['patient/editpatient/(:any)']['GET'] = 'Patient/edit_ajax/$1'; 
$route['patient/edit']['POST'] = 'Patient/update'; 
$route['patient/delete/(:any)']['GET'] = 'Patient/delete/$1'; 

$route['migrate/(:any)']['GET'] = 'Patient/migrate/$1'; 


# API ROUTES
$route['api/v1/patients']['GET'] = 'api/v1/Patient/all';
$route['api/v1/patient']['POST'] = 'api/v1/Patient/create';
$route['api/v1/patient/(:any)']['GET'] = 'api/v1/Patient/read/$1';
$route['api/v1/patient/update(:any)']['GET'] = 'api/v1/Patient/update/$1';
$route['api/v1/patient/delete(:any)']['GET'] = 'api/v1/Patient/delete/$1';



