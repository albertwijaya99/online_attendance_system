<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CheckTimeModel extends Model
{
    protected $table      = 'check_time';
    protected $primaryKey = 'check_time_id';
    protected $allowedFields = ['id_check_valid','check_in_time','check_out_time','employee_email','date'];
    public function tapIn($email){
        $pointModel = new PointModel;
        $currTime = new Time('now');
        $todayTapRecord = $this
                                ->like('check_in_time',$currTime->toDateString())
                                ->where('employee_email',$email)
                                ->first();
        if(strtotime($currTime) < strtotime('07:30:00')) return "not yet dude";
        if(empty($todayTapRecord)){
            //for tapping in
            $data = [
                'employee_email' => $email,
                'date' => $currTime->toDateString(),
                'check_in_time' => $currTime->toDateTimeString(),
            ];
            $this->insert($data);
            return "Have a nice day at work today";
        }
        else{
            if(empty($todayTapRecord['check_out_time'])){
                //for normal tapping out
                $data = [
                    'check_out_time' => $currTime->toDateTimeString(),
                ];
                $this->update($todayTapRecord['check_time_id'],$data);
                $pointModel->calculateTodayPoint();
                return "Thank you for your hard work today";
            }
            else{
                //if already tap out today, do nothing
                return "You Already Checking Out Today";
            }
        }
        return redirect()->to(base_url());
    }
    public function isAlreadyTappingIn($email){
        $currTime = new Time('now');
        $todayTapRecord = $this
                            ->like('check_in_time',$currTime->toDateString())
                            ->where('employee_email',$email)
                            ->first();
        if(!empty($todayTapRecord)) return true;
        else return false;
    }
    public function isAlreadyTappingOut($email){
        $currTime = new Time('now');
        $todayTapRecord = $this
            ->like('check_out_time',$currTime->toDateString())
            ->where('employee_email',$email)
            ->first();
        if(!empty($todayTapRecord)) return true;
        else return false;
    }
    public function geAttendanceHistoryPerEmployee($email){
        $db         =   \Config\Database::connect();
        $builder    =   $db->table('check_time');
        $query      =   $builder
            ->where('employee_email',$email)
            ->get()
            ->getResultArray();
        return $query;
    }
    public function geAttendanceHistoryPerDate($date){
        $db         =   \Config\Database::connect();
        $query = $db->query('select ct.*,e.employee_name from check_time as ct, employee as e where e.employee_email = ct.employee_email AND ct.date = ?',$date);
        return $query->getResultArray();
    }
}
