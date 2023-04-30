<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcCoursePlacesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('EdcCourses',[
            'foreignKey' => 'idplace'
        ]);
    }
}