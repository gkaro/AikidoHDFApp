<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class EdcCourseTeachersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsToMany('EdcCourses', [
            'joinTable' => 'edccourseteachers_edccourses',
            'foreignKey' => 'edc_course_teacher_id'
        ]);
    }
}