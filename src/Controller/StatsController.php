<?php
namespace App\Controller;

use App\Model\Table\EdcSeasonsTable;
use App\Model\Table\EdcMembersTable;
use App\Model\Table\EdcSubscriptionsTable;
use App\Model\Table\EdcParticipantsTable;
use App\Model\Table\EdcClubsTable;
use App\Model\Table\EdcGradesTable;
use App\Model\Table\EdcCoursesTable;
use App\Model\Table\EdcCourseTypesTable;
use App\Model\Table\EdcCourseTeachersTable;
use App\Model\Table\EdcCoursePlacesTable;
use Cake\View\Helper\HtmlHelper;

class StatsController extends AppController{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash'); // Include the FlashComponent

        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->select(['id','name'])->all();

        $this->set('seasons', $seasons);
    }

    public function index()
    {
        $subscriptionsTable = new EdcSubscriptionsTable();
        $subsEdc = $subscriptionsTable
            ->find('all')
            ->where(["edc"=>"oui"])
            ->contain('EdcClubs')
            ->contain('EdcMembers');

        $membersTable = new EdcMembersTable();
        $members = $membersTable
            ->find('all')
            ->contain('EdcSubscriptions')
            ->order(['name' => 'ASC']);

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
            ->find('all')
            ->contain('EdcCourses')
            ->contain('EdcSubscriptions')
            ->contain('EdcSubscriptions.EdcMembers')
            ->contain('EdcSubscriptions.EdcClubs');

        $clubsTable = new EdcClubsTable();
        $clubs = $clubsTable->find();
        $clubs->contain('EdcSubscriptions', function ($q) {
            return $q->where(['EdcSubscriptions.edc' => 'oui']);
        })
        ;

        $gradesTable = new EdcGradesTable();
        $grades = $gradesTable->find();
        $grades->contain('EdcSubscriptions', function ($q) {
            return $q->where(['EdcSubscriptions.edc' => 'oui']);
        })
        ;

        $this->set('clubs', $clubs);
        $this->set('grades', $grades);
        $this->set('subsEdc', $subsEdc);
        $this->set('members', $members);
        $this->set('participants', $participants);
    }

    public function type()
    {
        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCourseTypes','EdcCoursePlaces');

        $courseTypesTable = new EdcCourseTypesTable();
        $types = $courseTypesTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs');

        $this->set('courses', $courses);
        $this->set('types', $types);
        $this->set('participants', $participants);
    }

    public function exporttypes($id)
    {
        $seasonTable = new EdcSeasonsTable();
        $season = $seasonTable->findById($id)->first();

        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCourseTypes','EdcCoursePlaces');

        $courseTypesTable = new EdcCourseTypesTable();
        $types = $courseTypesTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs');

        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par type de stage</caption>
        <thead>
			<th>Types de stages</th>
            <th>Nb de stages</th>
            <th>Participants</th>
            <th>EdC</th>
            <th>Non EdC</th>
            <th>Hommes</th>
            <th>Femmes</th>
            <th>Age moyen</th>
            <th>Km moyen</th>
            <th>Picardie</th>
            <th>NPDC</th>
            <th>Hors Ligue</th>';
        $datatabl .= '</thead>';
        foreach ($types as $t){
            $countCourses = 0;
            foreach ($courses as $c){  
                if($c->idtype == $t->id && $c->idseason == $season->id){
                    $countCourses = $countCourses + 1;    
                }
            }
            if($countCourses > 0){
                $datatabl .= '<tr><td>
                <strong>'.$t->name. '</strong>
                </td><td style="text-align:center"> ';
                $count = 0;
                foreach ($courses as $c){
                    if($c->idtype == $t->id && $c->idseason == $season->id){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc =="oui"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc !="oui"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="H"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="F"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;
                        $age = $p->age;
                        $sum = $sum + $age;    
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';

                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;
                        $km = $p->km;
                        $sum = $sum + $km; 
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Picardie"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Nord-Pas-de-Calais"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idtype == $t->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Hors Ligue"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count.'<td>';
            }
            $datatabl .= '</tr>';
        
            
        }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_types_stages.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
    }

    public function teacher()
    {
        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCourseTeachers');

        $courseTeachersTable = new EdcCourseTeachersTable();
        $teachers = $courseTeachersTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs')
        ->contain('EdcCourses.EdcCourseTeachers');

        $this->set('courses', $courses);
        $this->set('teachers', $teachers);
        $this->set('participants', $participants);

    }

    public function exportteachers($id)
    {
        $seasonTable = new EdcSeasonsTable();
        $season = $seasonTable->findById($id)->first();

        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCourseTeachers');

        $courseTeachersTable = new EdcCourseTeachersTable();
        $teachers = $courseTeachersTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs')
        ->contain('EdcCourses.EdcCourseTeachers');;

        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par type de stage</caption>
        <thead>
			<th>Intervenants</th>
            <th>Nb de stages</th>
            <th>Participants</th>
            <th>EdC</th>
            <th>Non EdC</th>
            <th>Hommes</th>
            <th>Femmes</th>
            <th>Age moyen</th>
            <th>Km moyen</th>
            <th>Picardie</th>
            <th>NPDC</th>
            <th>Hors Ligue</th>';
        $datatabl .= '</thead>';
        foreach ($teachers as $t){
            $countCourses = 0;
            foreach ($courses as $c){ 
                foreach($c->edc_course_teachers as $teacher) {
                    if($teacher->id == $t->id && $c->idseason == $season->id){
                        $countCourses = $countCourses + 1;    
                    }
                } 
            }
            if($countCourses > 0){
                $datatabl .= '<tr><td>
                <strong>'.$t->name. '</strong>
                </td><td style="text-align:center"> ';
                $count = 0;
                foreach ($courses as $c){
                        
                    if($c->idseason == $season->id){
                        foreach($c->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                                $count = $count + 1;    
                            }
                        }
                        
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc =="oui"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc !="oui"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="H"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
               
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="F"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                                $count = $count + 1;
                                $age = $p->age;
                                $sum = $sum + $age;
                            }
                        }
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';

                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                                $count = $count + 1;
                                $km = $p->km;
                                $sum = $sum + $km;
                            }
                        }
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Picardie"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Nord-Pas-de-Calais"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Hors Ligue"){
                        foreach($p->edc_course->edc_course_teachers as $teacher){
                            if($teacher->id == $t->id){
                            $count = $count + 1;  
                            }
                        }
                    }
                }
                $datatabl .= $count.'<td>';
            }
            $datatabl .= '</tr>';
        
            
        }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_teachers_stages.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
    }

    public function place()
    {
        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCoursePlaces');

        $coursePlacesTable = new EdcCoursePlacesTable();
        $places = $coursePlacesTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs')
        ->contain('EdcCourses.EdcCoursePlaces');

        $this->set('courses', $courses);
        $this->set('places', $places);
        $this->set('participants', $participants);

    }

    public function exportplaces($id)
    {
        $seasonTable = new EdcSeasonsTable();
        $season = $seasonTable->findById($id)->first();

        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCoursePlaces');

        $coursePlacesTable = new EdcCoursePlacesTable();
        $places = $coursePlacesTable
        ->find()
        ->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
        ->find('all')
        ->contain('EdcCourses')
        ->contain('EdcSubscriptions')
        ->contain('EdcSubscriptions.EdcMembers')
        ->contain('EdcSubscriptions.EdcClubs')
        ->contain('EdcCourses.EdcCoursePlaces');;

        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par type de stage</caption>
        <thead>
			<th>Lieux de stage</th>
            <th>Nb de stages</th>
            <th>Participants</th>
            <th>EdC</th>
            <th>Non EdC</th>
            <th>Hommes</th>
            <th>Femmes</th>
            <th>Age moyen</th>
            <th>Km moyen</th>
            <th>Picardie</th>
            <th>NPDC</th>
            <th>Hors Ligue</th>';
        $datatabl .= '</thead>';
        foreach ($places as $place){
            $countCourses = 0;
            foreach ($courses as $c){  
                if($c->idplace == $place->id && $c->idseason == $season->id){
                    $countCourses = $countCourses + 1;    
                }
            }
            if($countCourses > 0){
                $datatabl .= '<tr><td>
                <strong>'.$place->name. '</strong>
                </td><td style="text-align:center"> ';
                $count = 0;
                foreach ($courses as $c){
                    if($c->idplace == $place->id && $c->idseason == $season->id){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc =="oui"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc !="oui"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="H"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_member->gender =="F"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;
                        $age = $p->age;
                        $sum = $sum + $age;    
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';

                $count = 0;
                $sum = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id){
                        $count = $count + 1;
                        $km = $p->km;
                        $sum = $sum + $km; 
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count,2) ;
                }else{
                    $average = '0';
                }
                $datatabl .= '<strong>'.$average.'</strong>';
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Picardie"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Nord-Pas-de-Calais"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count;
                $datatabl .= '</td><td style="text-align:center">';
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idplace == $place->id && $p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID =="Hors Ligue"){
                        $count = $count + 1;    
                    }
                }
                $datatabl .= $count.'<td>';
            }
            $datatabl .= '</tr>';
        
            
        }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_places_stages.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
    }

    public function seasoncourses($id)
    {
        $seasonTable = new EdcSeasonsTable();
        $season = $seasonTable->findById($id)->first();
        
        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
            ->find('all')
            ->contain('EdcCourses', function ($q) use($id) {
                return $q->where(['EdcCourses.idseason' => $id]);
            })
            ->contain('EdcSubscriptions.EdcClubs');

            
        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->where(['idseason'=>$id])
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
        ->contain('EdcCourseTypes','EdcCoursePlaces');
        
        $this->set('participants', $participants);
        $this->set('season', $season);
        $this->set('courses', $courses);
    }

    public function exportglobal()
    {
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $subsTable = new EdcSubscriptionsTable();
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
            ->find('all')
            ->contain('EdcCourses')
            ->contain('EdcSubscriptions.EdcClubs');
    
       
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques globales</caption>
        <thead>
			<th></th>';
			
            foreach ($seasons as $season){
                $seasonname = $season['name'];
                $datatabl .= '<th>Inscriptions ' . $seasonname . '</th>';
            }
            $datatabl .= '</thead>';
       
        $datatabl .= '<tr> 
            <td>
            Inscriptions EdC
            </td><td>';
            foreach ($seasons as $season){
                $count = 0;
                foreach ($subs as $q){
                    if($q->idseason == $season->id){
                        $count = $count + 1;
                    }               
                }
                $datatabl .= $count.'<td>';
            }  
            $datatabl .= '</tr>';
       			
        $datatabl .= '<tr>
                <td>
                Picardie
                </td><td>';
            foreach ($seasons as $season){
                $count2 = 0;
                foreach ($subs as $q){
                    if($q->idseason == $season->id && $q->edc_club->CID == 'Picardie'){
                        $count2 = $count2 + 1;
                    }               
                }
                $datatabl .= $count2.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '<tr>
                <td>
                NPDC
                </td><td>';
            foreach ($seasons as $season){
                $count3 = 0;
                foreach ($subs as $q){
                    if($q->idseason == $season->id && $q->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count3 = $count3 + 1;
                    }               
                }
                $datatabl .= $count3.'<td>';
            }  
            $datatabl .= '</tr>';
       
        $datatabl .= '<tr>
                <td>
                Participations Stages
                </td><td>';
            foreach ($seasons as $season){
                $count4 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id){
                        $count4 = $count4 + 1;
                    }               
                }
                $datatabl .= $count4.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '<tr>
                <td>
                Participations Stages Picardie
                </td><td>';
            foreach ($seasons as $season){
                $count5 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc_subscription->edc_club->CID == 'Picardie'){
                        $count5 = $count5 + 1;
                    }               
                }
                $datatabl .= $count5.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '<tr>
                <td>
                Participations Stages NPDC
                </td><td>';

            foreach ($seasons as $season){
                $count6 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count6 = $count6 + 1;
                    }               
                }
                $datatabl .= $count6.'<td>';
            }  
            $datatabl .= '</tr>';
       
        $datatabl .= '<tr>
                <td>
                Participations Stages inscrits Edc
                </td><td>';
            foreach ($seasons as $season){
                $count7 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "oui"){
                        $count7 = $count7 + 1;
                    }               
                }
                $datatabl .= $count7.'<td>';
            }  
            $datatabl .= '</tr>';
        $datatabl .= '<tr>
                <td>
                Participations Stages inscrits Edc Picardie
                </td><td>';
            foreach ($seasons as $season){
                $count8 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "oui" && $q->edc_subscription->edc_club->CID == 'Picardie'){
                        $count8 = $count8 + 1;
                    }               
                }
                $datatabl .= $count8.'<td>';
            }  
            $datatabl .= '</tr>';
       
        $datatabl .= '<tr>
                <td>
                Participations Stages inscrits Edc NPDC
                </td><td>';
            foreach ($seasons as $season){
                $count9 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "oui" && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count9 = $count9 + 1;
                    }               
                }
                $datatabl .= $count9.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '<tr>
                <td>
                Participations Stages non inscrits Edc
                </td><td>';
            foreach ($seasons as $season){
                $count10 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "non"){
                        $count10 = $count10 + 1;
                    }               
                }
                $datatabl .= $count10.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '<tr>
                <td>
                Participations Stages non inscrits Edc Picardie
                </td><td>';
            foreach ($seasons as $season){
                $count11 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "non" && $q->edc_subscription->edc_club->CID == 'Picardie'){
                        $count11 = $count11 + 1;
                    }               
                }
                $datatabl .= $count11.'<td>';
            }  
            $datatabl .= '</tr>';
      
        $datatabl .= '<tr>
                <td>
                Participations Stages non inscrits Edc NPDC
                </td><td>';
            foreach ($seasons as $season){
                $count12 = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id && $q->edc == "non" && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count12 = $count12 + 1;
                    }               
                }
                $datatabl .= $count12.'<td>';
            }  
            $datatabl .= '</tr>';

        $datatabl .= '<tr>
                <td>
                Moyenne d\'age des participants
                </td><td>';
            foreach ($seasons as $season){
                $count = 0;
                $sum = 0;
                foreach ($participants as $q){
                    if($q->edc_course->idseason == $season->id){
                        $count = $count + 1;
                        $age = $q->age;
                        $sum = $sum + $age;
                    }
                }
                if($count > 0){
                    $average =  round($sum / $count) ;
                }else{
                    $average = '0';
                }
                $datatabl .= $average.'<td>';
            }  
            $datatabl .= '</tr>';
        
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_participants.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function exportcourses($id)
    {
        $seasonTable = new EdcSeasonsTable();
        $season = $seasonTable->findById($id)->first();

        $coursesTable = new EdcCoursesTable();
        $courses = $coursesTable
        ->find()
        ->where(['idseason'=>$id])
        ->order(['date'=>'DESC'])
        ->contain('EdcParticipants')
        ->contain('EdcParticipants.EdcSubscriptions.EdcMembers')
            ;

        $name = $season->name;
       
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Participants par stage saison '.$name .'</caption>
        <thead>
			<th>Stage</th>
            <th>Date</th>
            <th>Lieu</th>
			<th>Participants</th>
            <th>Samedi matin</th>
            <th>Samedi apres-midi</th>
            <th>Dimanche</th>
            <th>EdC</th>
            <th>Non EdC</th>
            <th>Hommes</th>
            <th>Femmes</th>
            <th>Moyenne d\'age</th>
           
            </thead>';
            foreach($courses as $q){
                $name = $q['name'];
                $date = $q['date'];
                $place = $q['place'];
                $count1 = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id){
                        $count1 = $count1 + 1;    
                    }
                }
                $count2 = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->satam =='oui'){
                        $count2 = $count2 + 1;    
                    }
                }
                $count3 = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->satpm =='oui'){
                        $count3 = $count3 + 1;    
                    }
                }   
                $count4 = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->sunam =='oui'){
                        $count4 = $count4 + 1;    
                    }
                }
                $countedc = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->edc =='oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                $countnonedc = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->edc =='non'){
                        $countnonedc = $countnonedc + 1;    
                    }
                }
                $countmale = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->edc_subscription->edc_member->gender =='H'){
                        $countmale = $countmale + 1;    
                    }
                }
                $countfemale = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id && $part->edc_subscription->edc_member->gender =='F'){
                        $countfemale = $countfemale + 1;    
                    }
                }
                $countage = 0;
                $sum = 0;
                foreach ($q->edc_participants as $part){
                    if($part->id_course == $q->id){
                        $countage = $countage + 1;
                        $age = $part->age;
                        $sum = $sum + $age;
                    }
                }
                if($countage > 0){
                    $average =  round($sum / $countage) ;
                }else{
                    $average = '0';
                }
               
    
                $datatabl .= '<tr>
                    <td>' . $name . '</td>';
                $datatabl .= '<td>' . $date . '</td>';
                $datatabl .= '<td>' . $place . '</td>';
                $datatabl .= '<td>' . $count1 . '</td>';
                $datatabl .= '<td>' . $count2 . '</td>';
                $datatabl .= '<td>' . $count3 . '</td>';
                $datatabl .= '<td>' . $count4 . '</td>';
                $datatabl .= '<td>' . $countedc . '</td>';		
                $datatabl .= '<td>' . $countnonedc . '</td>';	
                $datatabl .= '<td>' . $countmale . '</td>';	
                $datatabl .= '<td>' . $countfemale . '</td>';		
                $datatabl .= '<td>' . $average . '</td>';	
            }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_participants.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function exportclubs()
    {
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $subsTable = $this->getTableLocator()->get('EdcSubscriptions');  
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();

        $clubsTable = FactoryLocator::get('Table')->get('EdcClubs');
        $clubs = $clubsTable->find();
        $clubs->contain('EdcSubscriptions', function ($q) {
                return $q->where(['EdcSubscriptions.edc' => 'oui']);
        }) ;
    
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques </caption>
        <thead>
			<th>Clubs</th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th>Inscriptions EdC ' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
            
        foreach ($clubs as $q) {
            $name = $q['name'];
           
            $datatabl .= '<tr> 
            <td>' . $name . '</td><td>'; 
             
            foreach ($seasons as $season){
             
                $count = 0;
                foreach ($q->edc_subscriptions as $sub){
                    if($sub->idseason == $season->id) {
                        $count = $count + 1; 
                    }     
                        
                }
                $datatabl .= $count.'</td>';
            }  
             $datatabl .= '</tr>';
        }
        
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_edcparclubs.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function exportgenders()
    {
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
            ->find("all")
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcCourses','EdcSubscriptions.EdcClubs'])
            ->toArray();

        $subsTable = new EdcSubscriptionsTable();  
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();
                
		$background_color = '#eeeeee';
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par genre</caption>
        <thead>
			<th></th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th>Inscriptions EdC ' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Hommes aux stages
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "H") {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Hommes Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "H" && $part->edc_subscription->edc_club->CID == 'Picardie') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Hommes NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "H" && $part->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Hommes Hors Ligue
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "H" && $part->edc_subscription->edc_club->CID == 'Hors Ligue') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Femmes aux stages
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "F") {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';
        
        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Femmes Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "F" && $part->edc_subscription->edc_club->CID == 'Picardie') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Femmes NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "F" && $part->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Participations Femmes Hors Ligue
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->edc_member->gender == "F" && $part->edc_subscription->edc_club->CID == 'Hors Ligue') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Inscriptions Hommes EdC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "H") {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
        Inscriptions Hommes EdC Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "H" && $s->edc_club->CID == 'Picardie') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
        Inscriptions Hommes EdC NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "H" && $s->edc_club->CID == 'Nord-Pas-de-Calais') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
            Inscriptions Femmes EdC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "F") {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
        Inscriptions Femmes EdC Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "F" && $s->edc_club->CID == 'Picardie') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr>';
        $datatabl .= '<td>
        Inscriptions Femmes EdC NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $s){
                if($s->idseason == $season->id && $s->edc_member->gender == "F" && $s->edc_club->CID == 'Nord-Pas-de-Calais') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_edcpargenre.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function exportages()
    {
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $participantsTable = new EdcParticipantsTable();  
        $participants = $participantsTable
            ->find("all")
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcCourses','EdcSubscriptions.EdcClubs'])
            ->toArray();

        $subsTable = new EdcSubscriptionsTable();
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();
                
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par tranche d\'age</caption>
        <thead>
			<th></th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th>' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
       
        $datatabl .= '<tr><td>
        Tranches d\'age participants
            </td><\tr>';

        $datatabl .= '<tr><td>
        25 ans ou moins
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->age <= '25' && $part->age != '0') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        plus de 25 ans
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->age >= '25' && $part->age != '0') {
                    $count = $count + 1; 
                }     
            
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Tranches d\'age inscrits EdC
            </td><\tr>';

        $datatabl .= '<tr><td>
        25 ans ou moins
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->age <= '25' && $sub->age != '0' && $sub->edc == 'oui'){
                    $count = $count + 1;    
                }
            }  
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        plus de 25 ans
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->age >= '25' && $sub->age != '0' && $sub->edc == 'oui'){
                    $count = $count + 1;    
                }
            }
            $datatabl .= '<td>' . $count . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Moyenne d\'age des participants aux stages
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($participants as $p){
                if($p->edc_course->idseason == $season->id){
                    $count = $count + 1; 
                    $age = $p->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';
        
        $datatabl .= '<tr><td>
        Moyenne d\'age Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($participants as $p){
                if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID == 'Picardie'){
                    $count = $count + 1; 
                    $age = $p->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Moyenne d\'age NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($participants as $p){
                if($p->edc_course->idseason == $season->id && $p->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                    $count = $count + 1; 
                    $age = $p->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Moyenne d\'age des inscrits EdC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->edc == 'oui'){
                    $count = $count + 1; 
                    $age = $sub->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Moyenne d\'age des inscrits EdC Picardie
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->edc == 'oui' && $sub->edc_club->CID == 'Picardie'){
                    $count = $count + 1; 
                    $age = $sub->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>
        Moyenne d\'age des inscrits EdC NPDC
            </td>';
        foreach ($seasons as $season){
            
            $count = 0;
            $sum = 0;
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->edc == 'oui' && $sub->edc_club->CID == 'Nord-Pas-de-Calais'){
                    $count = $count + 1; 
                    $age = $sub->age;
                    $sum = $sum + $age;   
                }
            }
            if($count > 0){
                $average =  round($sum / $count,2) ;
            }else{
                $average = '0';
            }
            $datatabl .= '<td>' . $average . '</td>';
               
        }  
        $datatabl .= '</tr>';

        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_age.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function exportdegrees(){
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $participantsTable = new EdcParticipantsTable(); 
        $participants = $participantsTable
            ->find("all")
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcCourses','EdcSubscriptions.EdcClubs'])
            ->toArray();

        $subsTable = new EdcSubscriptionsTable();  
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();

        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par diplome participants stages/inscrits EdC</caption>
        <thead>
            <th>Diplomes</th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th colspan="2">' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
        $datatabl .= '<tr><td>Aucun diplôme</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'Aucun') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'Aucun' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>BIF</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'BIF') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'BIF' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>BF</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'BF') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'BF' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>BE1</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'BE1') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'BE1' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>BE2</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'BE2') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'BE2' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>CQP</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'CQP') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'CQP' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>DEJEPS</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'DEJEPS') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'DEJEPS' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '<tr><td>DESJEPS</td>';
        foreach ($seasons as $season){
            $count = 0; 
            foreach ($participants as $part){
                if($part->edc_course->idseason == $season->id && $part->edc_subscription->teacherdegree == 'DESJEPS') {
                    $count = $count + 1; 
                }     
            }
            $countedc = 0; 
            foreach ($subs as $sub){
                if($sub->idseason == $season->id && $sub->teacherdegree == 'DESJEPS' && $sub->edc == 'oui') {
                    $countedc = $countedc + 1; 
                }     
            }
            $datatabl .= '<td>' . $count . '</td>';
            $datatabl .= '<td>' . $countedc . '</td>';
        }  
        $datatabl .= '</tr>';

        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_diplomes.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
    }

    public function exportgrades(){
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();

        $participantsTable = new EdcParticipantsTable();
        $participants = $participantsTable
            ->find("all")
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcCourses','EdcSubscriptions.EdcClubs'])
            ->toArray();

        $subsTable = new EdcSubscriptionsTable();  
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(["edc"=>"oui"])
            ->toArray();

        $gradesTable = new EdcGradesTable();
        $grades = $gradesTable
            ->find("all")
            ->toArray();
        
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par grade participants stages/inscrits EdC</caption>
        <thead>
            <th>Grades</th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th colspan="2">' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
        foreach ($grades as $grade){
            $gradelabel = $grade['label'];
            $gradeid = $grade['id'];
            $datatabl .= '<tr><td>' . $gradelabel . '</td>';
            foreach ($seasons as $season){
                $count = 0; 
                foreach ($participants as $part){
                    if($part->edc_course->idseason == $season->id && $part->edc_subscription->actualgrade == $gradeid) {
                        $count = $count + 1; 
                    }     
                }
                $countedc = 0; 
                foreach ($subs as $sub){
                    if($sub->idseason == $season->id && $sub->actualgrade == $gradeid && $sub->edc == 'oui') {
                        $countedc = $countedc + 1; 
                    }     
                }
                $datatabl .= '<td>' . $count . '</td>';
                $datatabl .= '<td>' . $countedc . '</td>';
            }  
            $datatabl .= '</tr>';
        }

        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_grades.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
    }

    public function exportsubs(){
        $seasonTable = new EdcSeasonsTable();
        $seasons = $seasonTable->find()->all();
        
        $membersTable = new EdcMembersTable();
        $members = $membersTable
            ->find('all')
            ->contain('EdcSubscriptions')
            ->order(['name' => 'ASC']);
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Statistiques par inscrit</caption>
        <thead>
            <th></th>';
        foreach ($seasons as $season){
            $seasonname = $season['name'];
            $datatabl .= '<th>' . $seasonname . '</th>';
        }
        $datatabl .= '</thead>';
        foreach ($members as $member){
            $membername = $member['name']; 
            $datatabl .= '<tr>
            <td>' . $membername . '</td>'; 
            foreach ($seasons as $season){
                $count = 0;
                foreach ($member->edc_subscriptions as $sub){
                    if($sub->idseason == $season->id && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                if ($count == 0){ $datatabl .= '<td>non'; }
                else{$datatabl .= '<td>oui';}
                foreach ($member->edc_subscriptions as $sub){
                    if($sub->idseason == $season->id){
                        if ($sub->nbcourses == 0){$datatabl .= '| aucun stage</td>';}
                        elseif ($sub->nbcourses == 1){$datatabl .= ' | '.$sub->nbcourses.' stage</td>';}
                        else {$datatabl .=  " | ".$sub->nbcourses." stages</td>";}
                    }
                    
                }
            }
            $datatabl .= '</tr>';
        }
        $datatabl .= '</table>';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="data.xls"');
    header('Cache-Control: max-age=0');
        echo $datatabl;
        die;
    }
}