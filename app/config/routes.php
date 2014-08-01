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

// ACCESS
$route['login'] = 'login';
$route['login/(:any)'] = 'login/$1';
$route['logout'] = 'login/logout_user';
$route['register'] = 'login/register_user';

// DOCS
$route['guide'] = 'docs/view/index';
$route['guide/create'] = 'docs/createdoc';
$route['guide/createdoc'] = 'docs/createdoc';
$route['guide/editdoc'] = 'docs/editdoc';
$route['guide/edit/(:any)'] = 'docs/editdoc/$1';
$route['guide/delete/(:any)'] = 'docs/deletedoc/$1';
$route['guide/deletedoc_yes/(:any)'] = 'docs/deletedoc_yes/$1';
$route['guide/general'] = 'docs/view/index';
$route['guide/tech'] = 'docs/view/index';
$route['guide/(:any)/(:any)'] = 'docs/view/$2/$1';
$route['guide/(:any)'] = 'docs/view/$1';

// pattern
$route['pattern'] = 'patterns/view/allpatterns';
$route['pattern/create'] = 'patterns/createpat';
$route['pattern/createpat'] = 'patterns/createpat';
$route['pattern/editpat'] = 'patterns/editpat';
$route['pattern/edit/(:any)'] = 'patterns/editpat/$1';
$route['pattern/delete/(:any)'] = 'patterns/deletepat/$1';
$route['pattern/deletepat_yes/(:any)'] = 'patterns/deletepat_yes/$1';
$route['pattern/general'] = 'patterns/view/index';
$route['pattern/tech'] = 'patterns/view/index';
$route['pattern/(:any)/(:any)'] = 'patterns/view/$2/$1';
$route['pattern/(:any)'] = 'patterns/view/$1';


// TODO - Make generic
//$route['(:any)'] = 'patterns/view/$1';
$route['default_controller'] = "patterns/view";
//$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
