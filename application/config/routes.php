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

$route['default_controller'] = 'home';
$route['404_override'] = '';


$route['member/(:num)']         = 'member/member/home/$1';  //他/她的个人主页
$route['member/(:num)/albums']  = 'member/member/albums/$1';  //他/她的全部专辑

$route['member/check/(:any)']   = 'member/check/$1';
$route['member/setting/(:any)'] = 'member/setting/$1';  //设置
$route['member/emailcheck/(:any)'] = 'member/index/emailcheck/$1';  //会员邮箱激活地址
$route['member/resetpwd/(:any)'] = 'member/index/resetpwd/$1';  //会员找回密码链接地址
$route['member/(:any)']         = 'member/index/$1';  //会员中心通用

$route['album/(:num)']          = "album/index/$1";  //专辑首页
$route['view/(:num)']           = 'view/index/$1';  //图片页
$route['tag/(:num)']            = 'tag/tag_content/$1';  //标签详情
$route['hot']                   = 'home/hot';  //热门

/* End of file routes.php */
/* Location: ./application/config/routes.php */