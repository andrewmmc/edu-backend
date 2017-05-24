<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*** Restful API Start ***/

// Courses
$route['api/courses/(:num)'] = 'api/courses/index/courses_id/$1';
$route['api/courses/providers/(:num)'] = 'api/courses/providers/providers_id/$1';
$route['api/courses/lessons/(:num)'] = 'api/courses/lessons/courses_id/$1';
$route['api/courses/photos/(:num)'] = 'api/courses/photos/courses_id/$1';

// Members
$route['api/members/profile/(:num)'] = 'api/members/profile/members_id/$1';
$route['api/members/password/(:num)'] = 'api/members/password/members_id/$1';
$route['api/members/courses/(:num)'] = 'api/members/courses/members_id/$1';
$route['api/members/transaction/(:num)'] = 'api/members/transaction/members_id/$1';

// Providers
$route['api/providers/profile/(:num)'] = 'api/providers/profile/providers_id/$1';
$route['api/providers/courses/(:num)'] = 'api/providers/courses/providers_id/$1';
$route['api/providers/attendance/(:num)'] = 'api/providers/attendance/courses_id/$1';
$route['api/providers/transaction/(:num)'] = 'api/providers/transaction/providers_id/$1';

// Search
$route['api/search/(:num)'] = 'api/search/index/category_id/$1';

/*** Restful API End ***/

/*** Paypal ***/
$route['paypal/Payments/pay_return/(:num)'] = 'paypal/Payments/pay_return/$1';

/*** Examples ***/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
?>