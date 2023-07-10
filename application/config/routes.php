<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = 'DashboardController/error';
$route['translate_uri_dashes'] = FALSE;



//AuthController routes
$route['default_controller'] = 'AuthController';

$route['welcome'] = 'AuthController';

$route['authenticateUser'] = 'AuthController/authenticate_user';

$route['forgotpassword'] = 'AuthController/forgotpassword';

$route['signout'] = 'AuthController/signout';

$route['resetPassword'] = 'AuthController/resetPassword';


//dashboardcontroller routes
$route['home'] = 'DashboardController/index';

$route['dashboard'] = 'DashboardController/index';

$route['getmastdevicescount'] = 'DashboardController/getmastdevicescount';

$route['getallstations'] = 'DashboardController/getallstations';

$route['getallAPs'] = 'DashboardController/getallAPs';

$route['getalldevices'] = 'DashboardController/getalldevices';

$route['get_recent_disconnections'] = 'DashboardController/get_recent_disconnections';

$route['get_connections_per_ap'] = 'DashboardController/get_connections_per_ap';

$route['get_recent_activity_items'] = 'DashboardController/get_recent_activity_items';

$route['get_connection_status_history'] = 'DashboardController/get_connection_status_history';


//devicescontroller routes
$route['masts'] = 'devicescontroller/masts';

$route['devices'] = 'devicescontroller/devices';

$route['mastdevices'] = 'devicescontroller/mastdevices';

$route['getMastId'] = 'devicescontroller/getmastid';

$route['getAllMasts'] = 'devicescontroller/getAllMasts';

$route['insertMastData'] = 'devicescontroller/insertMastData';

$route['editDeviceData'] = 'devicescontroller/editDeviceData';

$route['getAllDevices'] = 'devicescontroller/getAllDevices';

$route['deleteDevice'] = 'devicescontroller/deleteDevice';

$route['insertDeviceData'] = 'devicescontroller/insertDeviceData';

$route['getConnectedFrom'] = 'devicescontroller/getConnectedFrom';

$route['update_radiomode_connectedfrom'] = 'devicescontroller/update_radiomode_connectedfrom';

$route['deleteMast'] = 'devicescontroller/deleteMast';



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

$route['getdiscoverydata'] = 'discoverycontroller/getdiscoverydata';

$route['updatediscoverydata'] = 'discoverycontroller/updatediscoverydata';

$route['cleardiscoverydata'] = 'discoverycontroller/cleardiscoverydata';

$route['addDiscoveryDevices'] = 'discoverycontroller/addDiscoveryDevices';

$route['addinterface'] = 'discoverycontroller/addinterface';


//notificationscontroller routes
$route['notifications'] = 'notificationscontroller/index';

$route['get_all_client_notifications'] = 'notificationscontroller/get_all_client_notifications';

$route['get_all_nonclient_notifications'] = 'notificationscontroller/get_all_nonclient_notifications';

$route['getNotificationList'] = 'notificationscontroller/getNotificationList';

$route['update_seen'] = 'notificationscontroller/update_seen';


//notifications_storage_controller routes
$route['storenotification/(:any)/(:any)']= 'notificationsstoragecontroller/storenotification/$1/$2';


//SidebarController routes
$route['start-ping'] = 'SidebarController/monitor_on';

$route['stop-ping'] = 'SidebarController/monitor_off';

$route['monitor-status'] = 'SidebarController/monitor_status';


//singledevicecontroller routes
$route['devices/device/(:any)'] = 'SingleDeviceController/index/$1';

$route['getconnectionstatus/(:any)'] = 'SingleDeviceController/getconnectionstatus/$1';

$route['snmpgetruntimedevicedata/(:any)'] = 'SingleDeviceController/snmpgetruntimedevicedata/$1';

$route['snmpgetrecurringdevicedata/(:any)'] = 'SingleDeviceController/snmpgetrecurringdevicedata/$1';












