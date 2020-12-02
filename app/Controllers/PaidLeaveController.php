<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PaidLeaveModel;
use CodeIgniter\Controller;

class PaidLeaveController extends Controller
{

    public function index()
    {
        //intialize model and helper
        $EmployeeModel = new EmployeeModel();
        $PaidLeaveModel = new PaidLeaveModel();
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['remaining_leaves'] = $EmployeeModel->getRemainingLeave(session()->get('Email'));
        $data['history_leaves'] = $PaidLeaveModel->getLeaveHistoryPerEmployee(session()->get('Email'));
        $data['title'] = "paidleave";
        return view('pages/PaidLeave',$data);
    }

    public function requestLeave(){
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        //intialize model, helper and variable from view
        $EmployeeModel = new EmployeeModel();
        $PaidLeaveModel = new PaidLeaveModel();
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
        $leaveDateRangeArr = explode(', ',$db->escapeString($request->getPost('leave_date_range')));
        $leaveReason = !empty($request->getPost('leave_reason')) ? $db->escapeString($request->getPost('leave_reason')) : "";
        $leaveType = !empty($request->getPost('leave_type')) ? $db->escapeString($request->getPost('leave_type')) : "";
        $leaveReason = trim(preg_replace('/\s\s+/', ' ', $leaveReason));
        $PaidLeaveModel->requestLeave($leaveDateRangeArr,$leaveReason,$leaveType);
        if($leaveType!= 'unpaid') $EmployeeModel->cutRemainingLeave(count($leaveDateRangeArr));
        return redirect()->to(base_url('paidLeave'));
    }
}
