<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcCoursesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasOne('EdcSeasons');
        $this->belongsTo('EdcCourseTypes',[
            'foreignKey' => 'idtype'
        ]);
        $this->belongsTo('EdcCoursePlaces',[
            'foreignKey' => 'idplace'
        ]); 
        $this->belongsToMany('EdcCourseTeachers', [
            'joinTable' => 'edccourseteachers_edccourses',
            'foreignKey' => 'edc_course_id'
        ]);
        $this->hasMany('EdcParticipants',[
            'foreignKey' => 'id_course'
        ]);
    }
}