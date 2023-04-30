<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcSubscriptionsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('EdcSeasons')->setForeignKey('idseason');
        $this->belongsTo('EdcParticipants');
        $this->belongsTo('EdcMembers')->setForeignKey('idmember');
        $this->belongsTo('EdcClubs')->setForeignKey('clubnumber');
        $this->belongsTo('EdcGrades')->setForeignKey('actualgrade');
        //$this->belongsTo('EdcDegrees');
       /* $this->addBehavior('CounterCache', [
            'EdcSeasons' => ['subscriptions_count']
        ]);*/
    }
}