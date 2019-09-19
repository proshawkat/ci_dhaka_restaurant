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

$route['default_controller'] = "site_controller/initial_function";
$route['confirmation'] = "parent_controller/show_confirmation";
$route['change_pass'] = 'admin_controller/change_pass';

# page setup
$route['contact'] = "parent_controller/contact";
$route['about'] = "site_controller/about";
$route['menu'] = "site_controller/menu";
$route['reservation'] = "site_controller/reservation";
$route['contact'] = "site_controller/contact";
$route['insert'] = "site_controller/insert";
$route['product'] = "parent_controller/product";
$route['product/:any'] = "parent_controller/product";
$route['category'] = "parent_controller/category";
$route['category/:any'] = "parent_controller/category";

# admin panel setup
$route['admin'] = 'admin_controller';
$route['login'] = 'admin_controller/login';
$route['logout'] = 'admin_controller/logout';
$route['admin_confirmation'] = "admin_controller/show_confirmation";

// category
$route['create_category'] = "admin_controller/create_category";
$route['manage_category'] = "admin_controller/manage_category";
$route['manage_category/:any'] = "admin_controller/manage_category";

// sub category
$route['create_sub_category'] = "admin_controller/create_sub_category";
$route['manage_sub_category'] = "admin_controller/manage_sub_category";
$route['manage_sub_category/:any'] = "admin_controller/manage_sub_category";

$route['create_sub_sub_category'] = "admin_controller/create_sub_sub_category";
$route['manage_sub_sub_category'] = "admin_controller/manage_sub_sub_category";
$route['manage_sub_sub_category/:any'] = "admin_controller/manage_sub_sub_category";

// product
$route['create_product'] = "admin_controller/create_product";
$route['manage_product'] = "admin_controller/manage_product";
$route['manage_product/:any'] = "admin_controller/manage_product";

// slider
$route['create_slider'] = "admin_controller/create_slider";
$route['manage_slider'] = "admin_controller/manage_slider";
$route['manage_slider/:any'] = "admin_controller/manage_slider";

// gallery
$route['add_images'] = "admin_controller/add_images";
$route['manage_gallery'] = "admin_controller/manage_gallery";
$route['manage_gallery/:any'] = "admin_controller/manage_gallery";
$route['gallery/:any'] = "parent_controller/gallery";

// downloads
$route['add_downloads'] = "admin_controller/add_downloads";
$route['manage_downloads'] = "admin_controller/manage_downloads";
$route['manage_downloads/:any'] = "admin_controller/manage_downloads";
$route['downloads/:any'] = "parent_controller/downloads";

// videos
$route['add_videos'] = "admin_controller/add_videos";
$route['manage_videos'] = "admin_controller/manage_videos";
$route['manage_videos/:any'] = "admin_controller/manage_videos";
$route['videos/:any'] = "parent_controller/videos";

// person
$route['add_person'] = "admin_controller/add_person";
$route['manage_person'] = "admin_controller/manage_person";
$route['manage_person/:any'] = "admin_controller/manage_person";
$route['person/:any'] = "parent_controller/person";

// additional data
$route['add_additional_data'] = "admin_controller/add_additional_data";
$route['manage_additional_data'] = "admin_controller/manage_additional_data";
$route['manage_additional_data/:any'] = "admin_controller/manage_additional_data";

// page management
$route['create_page'] = "admin_controller/create_page";
$route['manage_pages'] = "admin_controller/manage_pages";
$route['manage_pages/:any'] = "admin_controller/manage_pages";

# user management
$route['create_user']='master_controller/create_user';
$route['create_student']='master_controller/create_student';
$route['create_teacher_user']='master_controller/create_teacher_user';
$route['create_parents']='master_controller/create_parents';
$route['manage_user']='master_controller/manage_user';
$route['manage_user/:any']='master_controller/manage_user';
$route['create_role']='master_controller/create_role';
$route['manage_role']='master_controller/manage_role';
$route['manage_role/:any']='master_controller/manage_role';
$route['page/:any'] = 'parent_controller/page';
$route['manage_user_data'] = "admin_controller/manage_user_data";
$route['manage_user_data/:any'] = "admin_controller/manage_user_data";
$route['notice'] = "parent_controller/notice";
$route['notice/:any'] = "parent_controller/notice";
$route['events'] = "parent_controller/events";
$route['events/:any'] = "parent_controller/events";
$route['person_msg'] = "parent_controller/person_msg";
$route['person_msg/:any'] = "parent_controller/person_msg";

// dhaka restaurant
$route['create_menu_category'] = "admin_controller/create_menu_category";
$route['manage_menu_category'] = "admin_controller/manage_menu_category";
$route['manage_menu_category/:any'] = "admin_controller/manage_menu_category";
$route['create_menu'] = "admin_controller/create_menu";
$route['manage_menu'] = "admin_controller/manage_menu";
$route['manage_menu/:any'] = "admin_controller/manage_menu";

$route['view_reservation_info'] = "admin_controller/view_reservation_info";
$route['view_reservation_info/:any'] = "admin_controller/view_reservation_info";
$route['view_contact_info'] = "admin_controller/view_contact_info";
$route['view_contact_info/:any'] = "admin_controller/view_contact_info";
