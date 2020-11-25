<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PaidLeaveModel extends Model
{
    protected $table      = 'leave';
    protected $primaryKey = 'leave_id';
    protected $allowedFields = ['leave_type','status','leave_date','requester','requester_note','approver','approver_note'];

    public function getLeaveHistoryPerEmployee($requester){
        $db         =   \Config\Database::connect();
        $builder    =   $db->table('leave');
        $query      =   $builder
                        ->where('requester',$requester)
                        ->get()
                        ->getResultArray();
        return $query;
    }
    public function requestLeave($leaveDateRangeArr,$leaveReason,$leaveType){
        $DivisionModel = new DivisionModel();
        $divisionHeadEmail = $DivisionModel->getEmployeeDivisionHeadEmail();
        foreach ($leaveDateRangeArr as $leaveDate) :
            $time = Time::parse($leaveDate);
            $data = [
                'leave_type' => $leaveType,
                'status' => 'pending',
                'leave_date' => $time->toDateString(),
                'requester' => session()->get('Email'),
                'requester_note' => $leaveReason,
                'approver' => $divisionHeadEmail
            ];
            $this->insert($data);
        endforeach;
    }
}
