<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PaidLeaveModel;
use App\Models\PointModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Models\CheckTimeModel;

class AdminController extends Controller
{

    public function index() {}

    public function showLeaveRequest()
    {
        $PaidLeaveModel = new PaidLeaveModel();
        //intialize model and helper
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['title'] = "admin";
        $data['requesterEmailList'] = $PaidLeaveModel->getLeaveRequest('pending');
        return view('pages/admin/leaveRequest',$data);
    }
    public function showLeaveHistory(){
        $PaidLeaveModel = new PaidLeaveModel();
        $EmployeeModel = new EmployeeModel();
        //intialize model and helper
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['title'] = "admin";
        $data['employee'] = $EmployeeModel->getAllEmployeeWithStringDivision();
        return view('pages/admin/leaveHistory',$data);
    }
    public function showAttendanceHistory(){
        $PaidLeaveModel = new PaidLeaveModel();
        $EmployeeModel = new EmployeeModel();
        //intialize model and helper
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['title'] = "admin";
        $data['employee'] = $EmployeeModel->getAllEmployeeWithStringDivision();
        return view('pages/admin/attendanceHistory',$data);
    }
    public function fetchSelectedLeaveRequest(){
        $request = \Config\Services::request();
        $PaidLeaveModel = new PaidLeaveModel();
        $requesterNotes = $request->getGet('notes');
        $requesterEmail = $request->getGet('email');
        $requesterLeaveDate = $PaidLeaveModel->getLeaveHistoryPerNotes($requesterNotes,$requesterEmail);
        echo json_encode($requesterLeaveDate);

    }
    public function fetchLeaveHistoryByEmployee(){
        $request = \Config\Services::request();
        $PaidLeaveModel = new PaidLeaveModel();
        $employeeEmail = $request->getGet('email');
        $employeeLeaveHistory = $PaidLeaveModel->getLeaveHistoryPerEmployee($employeeEmail);
        echo json_encode($employeeLeaveHistory);

    }
    public function fetchLeaveHistoryByDate(){
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
        $PaidLeaveModel = new PaidLeaveModel();
        $date = !empty($request->getGet('date')) ? Time::parse($db->escapeString($request->getGet('date')))->toDateString() : Time::today()->toDateString(); //if theres no selected date, use current date [today] instead
        echo json_encode($PaidLeaveModel->getLeaveHistoryPerDates($date));

    }
    public function respondLeaveRequest(){
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
        $PaidLeaveModel = new PaidLeaveModel();
        $requesterNotes = !empty($request->getPost('requesterNote')) ? $db->escapeString($request->getPost('requesterNote')) : "";
        $adminResponse = !empty($request->getPost('adminResponse')) ? $db->escapeString($request->getPost('adminResponse')) : "";
        $declineReason = !empty($request->getPost('declineReason')) ? $db->escapeString($request->getPost('declineReason')) : "";
        $requesterEmail = !empty($request->getPost('requesterEmail')) ? $db->escapeString($request->getPost('requesterEmail')) : "";
        if($adminResponse === "accept" || $adminResponse === "decline"){
            $PaidLeaveModel->respondLeaveRequest($requesterNotes, $adminResponse, $declineReason ,$requesterEmail);
        }
        return redirect()->to(base_url('/admin/showLeaveRequest'));
    }
    public function fetchAttendanceHistoryByEmployee(){
        $request = \Config\Services::request();
        $CheckTimeModel = new CheckTimeModel;
        $email = $request->getGet('email');
        $attendanceHistory = $CheckTimeModel->geAttendanceHistoryPerEmployee($email);
        echo json_encode($attendanceHistory);

    }
    public function fetchAttendanceHistoryByDate(){
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
        $CheckTimeModel = new CheckTimeModel;
        $date = !empty($request->getGet('date')) ? Time::parse($db->escapeString($request->getGet('date')))->toDateString() : Time::today()->toDateString(); //if theres no selected date, use current date [today] instead
        $attendanceHistory = $CheckTimeModel->geAttendanceHistoryPerDate($date);
        echo json_encode($attendanceHistory);

    }
}
