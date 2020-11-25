<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');

//login routes
$routes->get('/login', 'LoginController::index');
$routes->post('/checkLogin','LoginController::checkLoginData');
$routes->get('/logout','LoginController::logout');

//profile routes
$routes->get('/profile','ProfileController::index');
$routes->post('changeProfilePicture','ProfileController::changeProfilePicture');

//Home Routes
$routes->post('/CheckTappedIn','HomeController::CheckTappedIn');

//LeaderBoard Routes
$routes->get('/leaderboard','LeaderBoardController::index');

//PaidLeave Routes
$routes->get('/paidLeave','PaidLeaveController::index');
$routes->post('/RequestLeave','PaidLeaveController::requestLeave');

//Admin Routes
$routes->get('/admin/showLeaveRequest','AdminController::showLeaveRequest');
$routes->get('/admin/fetchSelectedLeaveRequest','AdminController::fetchSelectedLeaveRequest');
$routes->post('/admin/respondLeaveRequest','AdminController::respondLeaveRequest');

$routes->get('/admin/leaveHistory','AdminController::showLeaveHistory');
$routes->get('/admin/fetchEmployeeLeaveHistory','AdminController::fetchLeaveHistoryByEmployee');
$routes->get('/admin/fetchLeaveHistoryByDate','AdminController::fetchLeaveHistoryByDate');

$routes->get('/admin/attendanceHistory','AdminController::showAttendanceHistory');
$routes->get('/admin/fetchAttendanceHistoryByEmployee','AdminController::fetchAttendanceHistoryByEmployee');
$routes->get('/admin/fetchAttendanceHistoryByDate','AdminController::fetchAttendanceHistoryByDate');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
