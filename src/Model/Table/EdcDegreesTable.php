<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcDegreesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('EdcSubscriptions');
        $this->hasMany('EdcParticipants');
    }
}