<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcCourseTypesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('EdcCourses',[
            'foreignKey' => 'idtype'
        ]); 
    }
}