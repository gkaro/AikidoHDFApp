<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcParticipantsTable extends Table
{
    public function initialize(array $config): void
    {     
        $this->belongsTo('EdcCourses',[
            'foreignKey' => 'id_course'
        ]);
        $this->belongsTo('EdcSubscriptions',[
            'foreignKey' => 'id_subscriptions'
        ]);
      /*  $this->addBehavior('CounterCache', [
            'EdcCourses' => ['participants_count']
        ]);*/

        $this->addBehavior('CounterCache', [
            'EdcSubscriptions' => ['nbcourses']
        ]);
    }
}