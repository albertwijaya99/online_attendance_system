<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PaidLeaveModel;
use App\Models\PointModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{

    public function index() {}

    public function showLeaveRequest()
    {
        $PaidLeaveModel = new PaidLeaveModel();
        //intialize model and helper
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['title'] = "admin";
        $data['requesterEmailList'] = $PaidLeaveModel->getPendingLeaveRequest();
        return view('pages/admin/leaveRequest',$data);
    }
    public function fetchSelectedLeaveRequest(){
        $request = \Config\Services::request();
        $PaidLeaveModel = new PaidLeaveModel();
        $requesterNotes = $request->getGet('notes');
        $requesterEmail = $request->getGet('email');
        $requesterLeaveDate = $PaidLeaveModel->getLeaveHistoryPerNotes($requesterNotes,$requesterEmail);
        echo json_encode($requesterLeaveDate);

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
}
