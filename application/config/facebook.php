<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook App details
| -------------------------------------------------------------------
|
| To get an facebook app details you have to be a registered developer
| at http://developer.facebook.com and create an app for your project.
|
|  facebook_app_id               string  Your facebook app ID.
|  facebook_app_secret           string  Your facebook app secret.
|  facebook_login_type           string  Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string  URL tor redirect back to after login. Do not include domain.
|  facebook_logout_redirect_url  string  URL tor redirect back to after login. Do not include domain.
|  facebook_permissions          array   The permissions you need.
|  facebook_graph_version        string  Set Facebook Graph version to be used.
*/

$config['facebook_app_id']              = '1500041580323632';
$config['facebook_app_secret']          = '4cc12b91299d54854f91972da6b422c5';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'index.php/home/login';
$config['facebook_logout_redirect_url'] = 'index.php';
$config['facebook_permissions']         = array('public_profile', 'publish_actions');
$config['facebook_graph_version']       = 'v2.4';
