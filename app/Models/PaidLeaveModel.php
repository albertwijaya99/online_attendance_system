<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PaidLeaveModel extends Model
{
    protected $table      = 'paidleave';
    protected $primaryKey = 'leave_id';
    protected $allowedFields = ['leave_type','status','leave_date','requester','requester_note','approver','approver_note'];

    public function getLeaveHistoryPerEmployee($requester){
        $db         =   \Config\Database::connect();
        $builder    =   $db->table('paidleave');
        $query      =   $builder
                        ->where('requester',$requester)
                        ->get()
                        ->getResultArray();
        return $query;
    }
    public function getLeaveHistoryPerNotes($notes,$email){
        $db         =   \Config\Database::connect();
        $builder    =   $db->table('paidleave');
        $query      =   $builder
                        ->where('requester_note',$notes)
                        ->where('requester',$email)
                        ->get()
                        ->getResultArray();
        $leaveDate = "";
        $counter = count($query);
        foreach($query as $leave):
            $temp= Time::parse($leave['leave_date']);
            $leaveDate.= $temp->toLocalizedString('MM/dd/yyyy');
            $counter -= 1;
            if($counter > 0) $leaveDate .= ",";
        endforeach;
        $leaveDateArr = explode(',',$leaveDate);
        return $leaveDateArr;
    }
    public function getLeaveHistoryPerDates($dates){
        $db         =   \Config\Database::connect();
        $query = $db->query('select pl.*,e.employee_name from paidleave as pl, employee as e where e.employee_email = pl.requester and pl.leave_date = ?',$dates);
        return $query->getResultArray();
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
    public function getLeaveRequest($status){
        $db         =   \Config\Database::connect();
        $builder    =   $db->table('paidleave');
        $query      =   $builder
            ->select('requester')
            ->select('requester_note')
            ->where('approver',session()->get('Email'))
            ->groupBy('requester_note')
            ->orderBy('requester','ASC');
        if($status != "all") {$query = $query->where('status',$status);}
        $query = $query
                    ->get()
                    ->getResultArray();
        return $query;
    }
    public function respondLeaveRequest($requesterNotes, $adminResponse, $declineReason ,$requesterEmail){
        $db         =   \Config\Database::connect();
        $EmployeeModel = new EmployeeModel();
        $builder    =   $db->table('paidleave');
        $query      =   $builder
            ->where('requester_note',$requesterNotes)
            ->where('requester',$requesterEmail)
            ->where('status','pending')
            ->get()
            ->getResultArray();
        $leaveID = "";
        $counter = count($query);
        if($adminResponse === "decline") {
            $remainingLeave = $EmployeeModel->getRemainingLeave($requesterEmail);
            $remainingLeave += $counter;
            $data = [
                'remaining_leave' => $remainingLeave,
            ];
            $EmployeeModel->update($requesterEmail,$data);
        }
            //collect id of pending leaves request
            foreach($query as $leave):
                $leaveID.= $leave['leave_id'];
                $counter -= 1;
                if($counter > 0) $leaveID .= ",";
            endforeach;
            $leaveIDArr = explode(',',$leaveID);
            //update leaves request simultaneously
            foreach($query as $index => $leave):
                $data = [
                    'status' => $adminResponse,
                    'approver_note' => $declineReason
                ];
                $this->update($leaveIDArr[$index],$data);
            endforeach;

    }
}
