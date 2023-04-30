<?php
namespace App\Controller;

use Cake\ORM\Query;
use Cake\Collection\Collection;
use Cake\Datasource\FactoryLocator;
use Cake\View\JsonView;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\I18n\Date;

Time::setDefaultLocale('fr_FR'); 
FrozenTime::setDefaultLocale('fr_FR'); 
Date::setDefaultLocale('fr_FR'); 
FrozenDate::setDefaultLocale('fr_FR');

class EdcCoursesController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash'); // Include the FlashComponent

        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $seasons = $seasonTable->find()->select(['id','name'])->all();

        $this->set('seasons', $seasons);
    }

    public function index()
    {
        $courses = $this->EdcCourses
        ->find()
        ->order(['date' => 'DESC'])
        ->contain(['EdcCourseTypes'])
        ->contain(['EdcCoursePlaces'])
        ->contain(['EdcCourseTeachers']);
        $this->viewBuilder()->setOption('serialize', ['courses']);
        $this->set(compact('courses'));
    }

    public function add()
    {
        $course = $this->EdcCourses->newEmptyEntity();

        if ($this->request->is('post')) {
            $course = $this->EdcCourses->patchEntity($course, $this->request->getData());
            if ($this->EdcCourses->save($course)) {
                $this->Flash->success(__('Stage ajouté.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter ce stage.'));
        }

        $seasonsTable = $this->getTableLocator()->get('EdcSeasons');
        $seasonslist = $seasonsTable->find('list')->order(['name'=>'DESC'])->all();

        $typesTable = $this->getTableLocator()->get('EdcCourseTypes');
        $types = $typesTable->find()->all()->combine('id', 'name');

        $placesTable = $this->getTableLocator()->get('EdcCoursePlaces');
        $places = $placesTable->find()->order(['name'=>'ASC'])->all()->combine('id', 'name');

        $teachersTable = $this->getTableLocator()->get('EdcCourseTeachers');
        $teachers = $teachersTable->find()->order(['name'=>'ASC'])->all()->combine('id', 'name');

        $this->set('seasonslist', $seasonslist);
        $this->set('teachers', $teachers);
        $this->set('types', $types);
        $this->set('places', $places);
        $this->set('course', $course);
    }

    public function edit($id)
    {
        $course = $this->EdcCourses
            ->findById($id)
            ->contain(['EdcCourseTypes'])
            ->contain(['EdcCoursePlaces'])
            ->contain(['EdcCourseTeachers'])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->EdcCourses->patchEntity($course, $this->request->getData(), [
                'associated' => ['EdcCourseTypes','EdcCoursePlaces','EdcCourseTeachers']
            ]);
            if ($this->EdcCourses->save($course)) {
                $this->Flash->success(__('Stage mis à jour.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }

        $seasonsTable = $this->getTableLocator()->get('EdcSeasons');
        $seasons = $seasonsTable->find('list')->all();

        $typesTable = $this->getTableLocator()->get('EdcCourseTypes');
        $types = $typesTable->find()->all()->combine('id', 'name');

        $placesTable = $this->getTableLocator()->get('EdcCoursePlaces');
        $places = $placesTable->find()->all()->combine('id', 'name');

        $teachersTable = $this->getTableLocator()->get('EdcCourseTeachers');
        $teachers = $teachersTable->find()->order(['name'=>'ASC'])->all()->combine('id', 'name');

        $this->set('seasons', $seasons);
        $this->set('teachers', $teachers);
        $this->set('types', $types); 
        $this->set('places', $places);
        $this->set('course', $course);
    }

    public function view($id)
    {
        $course = $this->EdcCourses
            ->findById($id)
            ->contain(['EdcCourseTypes'])
            ->contain(['EdcCoursePlaces'])
            ->contain(['EdcCourseTeachers'])
            ->firstOrFail();

        $participantsTable = $this->getTableLocator()->get('EdcParticipants');  
        $coursesParticipants = $participantsTable
            ->find()
            ->where(['id_course' => $id])
            ->order(['EdcMembers.name'=>'ASC'])
            ->contain(['EdcSubscriptions'])
            ->contain(['EdcSubscriptions.EdcMembers','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])
            ->all();

        $count = $coursesParticipants->count();
        $sum = (new Collection($coursesParticipants))->sumOf('payment');
        $this->set('course', $course); 
        $this->set('count', $count); 
        $this->set('sum', $sum);
        $this->set('coursesParticipants', $coursesParticipants); 
    }

    public function listparticipants($id)
    {
        $course = $this->EdcCourses->findById($id)->first();

        $participantsTable = $this->getTableLocator()->get('EdcParticipants'); 
        $participants = $participantsTable
        ->find()
        ->contain(['EdcSubscriptions', 'EdcSubscriptions.EdcMembers','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])
        ->where(['id_course'=>$id])
        ->order(['EdcMembers.name'=>'ASC'])
        ->all()
        ;

        $this->set('participants', $participants);
        $this->set('course', $course);
    }

    public function stats($id)
    {
        $course = $this->EdcCourses
            ->findById($id)
            ->contain(['EdcCourseTypes','EdcCoursePlaces'])
            ->first(); /* pour localisation du stage dans googlemap */

        $participantsTable = $this->getTableLocator()->get('EdcParticipants');  
        $participants = $participantsTable
            ->find('all')
            ->contain(['EdcSubscriptions','EdcCourses'])
            ->contain(['EdcSubscriptions.EdcClubs'])
            ->contain(['EdcSubscriptions.EdcMembers'])
            ->where(['id_course'=>$id]);


        $participantsClubs = $participantsTable
            ->find('all')
            ->contain(['EdcSubscriptions','EdcCourses'])
            ->contain(['EdcSubscriptions.EdcClubs'])
            ->where(['id_course'=>$id])
            ->where(['EdcSubscriptions.clubnumber IS NOT'=>'99999999'])
            ->select(['clubname'=>'EdcClubs.name','cid'=>'EdcClubs.CID','ville'=>'EdcClubs.city','map'=>'EdcClubs.map','km']);

        $participantsClubs->select([
            'count' => $participantsClubs->func()->count('EdcClubs.name')])
            ->group('EdcClubs.name');

        $participantsCids = $participantsTable
            ->find('all')
            ->contain(['EdcSubscriptions','EdcCourses'])
            ->contain(['EdcSubscriptions.EdcClubs'])
            ->where(['id_course'=>$id])
            ->select(['cid'=>'EdcClubs.CID']);

        $participantsCids->select([
            'count' => $participantsCids->func()->count('EdcClubs.name')])
            ->group('EdcClubs.CID');

        $participantsGrades = $participantsTable
            ->find('all')
            ->contain(['EdcSubscriptions','EdcCourses'])
            ->contain(['EdcSubscriptions.EdcGrades'])
            ->where(['id_course'=>$id])
            ->select(['grade'=>'EdcGrades.label']);
        $participantsGrades->select([
                'count' => $participantsGrades->func()->count('EdcGrades.label')])
                ->group('EdcGrades.label')
                ->order(['EdcGrades.id' => 'ASC']);

        $participantsDegrees = $participantsTable
            ->find('all')
            ->contain(['EdcSubscriptions','EdcCourses'])
            ->where(['id_course'=>$id])
            ->select(['degree'=>'teacherdegree']);
        $participantsDegrees->select([
                'count' => $participantsDegrees->func()->count('teacherdegree')])
                ->group('teacherdegree');
        
        $participantsAge = $participantsTable
            ->find('all')
            ->where(['id_course'=>$id])
            ->where(['age IS NOT'=> NULL])
            ->select(['age']);
        $participantsAge->select([
                'count' => $participantsAge->func()->count('age')])
                ->group('age');

        $avgAge = $participantsTable
            ->find()
            ->where(['id_course'=>$id])
            ->where(['age IS NOT'=> NULL])
            ->all()
            ->avg('age');

        $avgKm = $participantsTable
            ->find()
            ->contain('EdcSubscriptions')
            ->where(['id_course'=>$id])
            ->where(['EdcSubscriptions.clubnumber IS NOT'=>'99999999'])/*pour ne pas prendre en compte les les participants "hors ligue"*/
            ->all()
            ->avg('km');
        
        
        $this->set('participants', $participants);
        $this->set('participantsClubs', $participantsClubs);
        $this->set('participantsCids', $participantsCids);
        $this->set('participantsAge', $participantsAge);
        $this->set('participantsGrades', $participantsGrades);
        $this->set('participantsDegrees', $participantsDegrees);
        $this->set('avgAge', $avgAge);
        $this->set('avgKm', $avgKm);
        $this->set('course', $course);
    }

	public function exportparticipants($id)
    {
        $course = $this->EdcCourses
        ->findById($id)
        ->firstOrFail();

        $participantsTable = $this->getTableLocator()->get('EdcParticipants');  
        $coursesParticipants = $participantsTable
            ->find()
            ->where(['id_course' => $id])
            ->contain(['EdcSubscriptions'])
            ->contain(['EdcSubscriptions.EdcMembers','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])
            ->all()
            ->toArray();

        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '<thead>
			<th>Nom et prenom</th>
			<th>Club</th>
            <th>Email</th>
            <th>Grade</th>
            <th>Diplome</th>
            <th>Samedi matin</th>
            <th>Samedi apres-midi</th>
            <th>Dimanche</th>
            <th>Paiement</th>
            <th>Km</th>
            <th>EdC</th>
            <th>RGPD</th>
            <th>Commentaires</th>
            </thead>';
        foreach($coursesParticipants as $i){
            $name = $i['edc_subscription']['edc_member']['name'];
            $club = $i['edc_subscription']['edc_club']['name'];
            $email = $i['edc_subscription']['edc_member']['email'];
            $grade = $i['edc_subscription']['edc_grade']['label'];
            $degree = $i['edc_subscription']['teacherdegree'];
            $satam = $i['satam'];
			$satpm = $i['satpm'];
            $sunam = $i['sunam'];
            $payment = $i['payment'];
            $km = $i['km'];
            $rgpd = $i['rgpd'];
            $comments = $i['comments'];
			
            if($i['edc'] == 'oui'){
                $edc = '1';
            }else if($i['edc'] == 'non' | $i['edc'] == null)
            {
                $edc = '0';
            }

			$color_border = '#d5d5d5';
			$background_color = '#eeeeee';

            $datatabl .= '<tr>
				<td style="vertical-align:middle;border:1px solid ' . $color_border . '">' . $name . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $club . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $email . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $grade . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $degree . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $satam . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $satpm . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $sunam . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $payment . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $km . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $edc . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $rgpd . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $comments . '</td>';
		
			
        }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_participants_'. $course->name .'.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function sync()
    {

    }

    
}