<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['coming_soon'] = "home/coming_soon";
$route['404_override'] = '';

$route['user_gateway'] 	= "login/module_gateway";
$route['login'] 		= "login/user";
$route['login/user/(:any)'] = "login/user/$1";
$route['logout'] 		= "login/user_logout";
$route['my_profile'] 	= "settings/profile";

$route['generate_invoice_receipt'] 	= "billing_management/generate_invoice_receipt";
$route['view_client_dr'] 			= "billing_management/view_client_dr";




$route['validate_duplicate_email'] 		= "global_tool/validate_duplicate_email";
$route['validate_duplicate_username'] 	= "global_tool/validate_duplicate_username";


/* End of file routes.php */
/* Location: ./application/config/routes.php */