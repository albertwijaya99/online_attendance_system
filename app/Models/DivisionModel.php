<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;

class DivisionModel extends Model
{
    protected $table      = 'division';
    protected $primaryKey = 'division_id';
    protected $allowedFields = ['division_name','email'];

    public function getSelectedDivisionName($selectedDivisionID){
        return $this->find($selectedDivisionID);
    }
}
