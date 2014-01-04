<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define("CLIENT_LIST","rvl_client_list");
define("WAREHOUSE_LIST","rvl_warehouse_list");
define("DRIVER_LIST","rvl_driver_list");
define("DELIVERY_RECEIPT","rvl_delivery_receipt");
define("VN_LIST","rvl_vn_list");
define("VEHICLE_COLOR_LIST","rvl_vehicle_color_list");
define("VECHICLE_MODEL_LIST","rvl_vehicle_model_list");
define("TRUCK_LIST","rvl_truck_list");
define('RVL_USER','rvl_user');
define('RVL_EMPLOYEE','rvl_employee');
define('RVL_ADDRESS_LIST','rvl_address_list');
define('RVL_TRIP_RATES','rvl_trip_rates');
define('RVL_SETTINGS_RATE','rvl_settings_rate');

define('RVL_PAYROLL_REGISTER','rvl_payroll_register');
define('RVL_DELIVERY_PLAN_TRACKING','rvl_delivery_plan_tracking');

define('RVL_RATE_HONDA','rvl_rate_honda');

/*
|--------------------------------------------------------------------------
| DATABASE TABLE NAMES
|--------------------------------------------------------------------------
*/

define("YES","Yes");
define("NO","No");
define("ACTIVE","Active");
define("INACTIVE","Inactive");
define("PENDING","Pending");
define("FORAPPROVAL","For Approval");
define("FORPRINTING","For Printing");
define("APPROVED","Approved");
define("REJECTED","Revised");
define("CLEARED","Cleared");
define("PRINTED","Printed");
define("AVAILABLE","Available");
define("NOTAVAILABLE","Not Available");
define("PORTER","Porter");
define("JOCKEY","Jockey");

define("STANDARD","Standard");
define("SPECIAL","Special");

define("INVOICE","Invoice");
define("BILLED","Billed");
define("PAID","Paid");

define("INBOUND","Inbound");
define("OUTBOUND","Outbound");

define("DEFAULT_ERROR","Ooops! Please contact web administrator!");


/* USER ROLES */

define("SUPER_ADMIN","Super Admin");
define("USER_ADMIN","User Admin");
define("SYSTEM_ADMIN","System Admin");
define("COORDINATOR","Coordinator");
define("CENTRAL_DISPATCHER","Central Dispatcher");
define("GUARD","Guard");
define("DRIVER","Driver");
define("TRUCK_MAINTENANCE","Truck Maintenance");
define("PREDEP_INSPECTOR","Pre-Departure Inspector");
define("BILLING","Billing");
define("PAYROLL","Payroll");
define("FUEL_TENDER","Fuel Tender");
define("CLIENT_INTERFACE","Client Interface");
define("PETTY_CASH_CUSTODIAN","Petty Cash Custodian");
define("EXECUTIVE","Executive");
define("CORE_SYSTEM","Core System");



/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */