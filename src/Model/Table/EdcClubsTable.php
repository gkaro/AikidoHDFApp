<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcClubsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('EdcSubscriptions')->setForeignKey('clubnumber');;
    }
}

