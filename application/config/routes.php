<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



//AuthController routes

$route['default_controller'] = 'AuthController';

$route['authenticateUser'] = 'AuthController/authenticate_user';

$route['forgotpassword'] = 'AuthController/forgotpassword';

$route['signout'] = 'AuthController/signout';

$route['resetPassword'] = 'AuthController/resetPassword';


//devicescontroller routes

$route['home'] = 'devicescontroller/mastdevices';

$route['masts'] = 'devicescontroller/masts';

$route['devices'] = 'devicescontroller/devices';

$route['mastdevices'] = 'devicescontroller/mastdevices';

$route['getMastId'] = 'devicescontroller/getmastid';

$route['getAllMasts'] = 'devicescontroller/getAllMasts';

$route['insertMastData'] = 'devicescontroller/insertMastData';

$route['getAllDevices'] = 'devicescontroller/getAllDevices';

$route['deleteDevice'] = 'devicescontroller/deleteDevice';

$route['insertDeviceData'] = 'devicescontroller/insertDeviceData';

$route['getConnectedFrom'] = 'devicescontroller/getConnectedFrom';



$route['deleteMast'] = 'devicescontroller/deleteMast';

$route['sendPushNotification'] = 'devicescontroller/send_notification';




//topologycontroller routes

$route['topology'] = 'topologycontroller/index';

$route['getTopology'] = 'topologycontroller/getTopology';

//userscontroller routes

$route['users'] = 'userscontroller/index';

$route['getAllUsers'] = 'userscontroller/getAllUsers';

$route['insertUserData'] = 'userscontroller/insertUserData';

$route['deleteUser'] = 'userscontroller/deleteUser';

$route['changePassword'] = 'userscontroller/changePassword';

$route['account'] = 'userscontroller/account';

$route['editProfile'] = 'userscontroller/editProfile';

//discoverycontroller routes
$route['discovery'] = 'discoverycontroller/index';

//snmpservice routes
$route['scan'] = 'discoverycontroller/index';
$route['addinterface'] = 'discoverycontroller/addinterface';

//pingservice routes
$route['start-ping'] = 'SidebarController/monitor_on';
$route['stop-ping'] = 'SidebarController/monitor_off';

$route['monitor-status'] = 'SidebarController/monitor_status';









