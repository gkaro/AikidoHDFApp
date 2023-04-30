<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcMembersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->hasMany('EdcSubscriptions')->setForeignKey('idmember');
    }
}