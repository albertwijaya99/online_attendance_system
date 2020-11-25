<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;

class DivisionModel extends Model
{
    protected $table      = 'division';
    protected $primaryKey = 'division_id';
    protected $allowedFields = ['division_name','admin_email'];

    public function getSelectedDivisionName($selectedDivisionID){
        return $this->find($selectedDivisionID);
    }
    public function getEmployeeDivisionHeadEmail(){
        $EmployeeModel = new EmployeeModel();
        $employeeInfo = $EmployeeModel->find(session()->get('Email'));

        $divisionInfo = $this->getSelectedDivisionName($employeeInfo['division_id']);
        return $divisionInfo['admin_email'];
    }
}
