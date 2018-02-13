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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = 'prep_page/';
$route['translate_uri_dashes'] = FALSE;


// Restful
// $route['board/(.+)/post/(\d+)']['get'] = 'board/modify/$1/$2';			// 게시글 수정페이지 이동
// $route['board/(.+)/post/(\d+)']['put'] = 'board/modify_board/$1/$2';	// 게시글 수정
// $route['board/(.+)/post/(\d+)']['delete'] = 'board/delete/$1/$2';		// 게시글 삭제
// $route['board/(.+)/post']['get'] = 'board/write/$1';					// 게시글 작성페이지 이동
// $route['board/(.+)/post']['post'] = 'board/write_board/$1/$2';			// 게시글 작성
// $route['board/(.+)/(\d+)']['get'] = 'board/view/$1/$2';					// 게시글 상세
// $route['board/(.+)']['get'] = 'board/lists/$1';

// $route['api/(.+)/(.+)/(.+)']['post'] = '$1/$2/{Function 이름}/$3';
// $route['api/(.+)/(.+)/(.+)']['delete'] = '$1/$2/{Function 이름}/$3';
// $route['api/(.+)/(.+)/(.+)']['put'] = '$1/$2/{Function 이름}/$3';
