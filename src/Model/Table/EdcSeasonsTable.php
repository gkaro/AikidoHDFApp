<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcSeasonsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('EdcSubscriptions');
        $this->hasMany('EdcCourses');
    }
}