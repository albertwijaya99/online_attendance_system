<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PointModel extends Model
{
    protected $table      = 'point';
    protected $primaryKey = 'point_id';
    protected $allowedFields = ['email','point','date'];
    public function getAllEmployeePoint(){
        $db         =   \Config\Database::connect();
        $query = $db->query('select p.*,sum(p.point),e.image_url_path from point as p,employee as e where p.email = e.employee_email group by p.email order by p.point desc');
        return $query->getResultArray();
    }

    public function calculateTodayPoint(){
        $currTime = new Time('now');
        $checkTimeModel = new CheckTimeModel();
        $todayTapRecord = $checkTimeModel
            ->like('check_in_time',$currTime->toDateString())
            ->where('employee_email',session()->get('Email'))
            ->first();
        $TapIn = Time::parse($todayTapRecord['check_in_time']);
        $TapOut= Time::parse($todayTapRecord['check_out_time']);
        $diff = $TapIn->difference($TapOut);
        $data = [
            'email' => session()->get('Email'),
            'point' => $diff->getMinutes()/10,
            'date'  => $currTime->toDateString()
        ];
        if($diff->getMinutes()>0) $this->insert($data);
    }
}
