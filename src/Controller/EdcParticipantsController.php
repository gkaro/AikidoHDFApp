<?php
namespace App\Controller;

use Cake\ORM\Query;
use Cake\Collection\Collection;
use Cake\Datasource\FactoryLocator;
use Cake\View\JsonView;

class EdcParticipantsController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash'); // Include the FlashComponent

        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $seasons = $seasonTable->find()->select(['id','name'])->all();

        $this->set('seasons', $seasons);
    }
    
    public function index()
    {
        $participantslist = $this->EdcParticipants->find()->contain(['EdcSubscriptions','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])->all();
        $this->viewBuilder()->setOption('serialize', ['participantslist']);
        $this->set(compact('participantslist'));
    }
    
    public function add($id)
    {
        $coursesTable = $this->getTableLocator()->get('EdcCourses');
        $course = $coursesTable
        ->findById($id)
        ->contain(['EdcCourseTypes'])
        ->contain(['EdcCoursePlaces'])
        ->first();
        $idseason = $course->idseason;

        $membersTable = $this->getTableLocator()->get('EdcMembers');
           
        $members = $membersTable
            ->find()
            ->contain('EdcSubscriptions', function (Query $q) use($idseason){
                return $q
                ->where(['EdcSubscriptions.idseason IS' => $idseason]);
            })
            ->order(['name' => 'ASC'])
            ->all()
            ->combine('id', 'name');
       
        $grades = $this->getTableLocator()->get('EdcGrades')->find('all');
        $optionsGrades = $grades->all()->combine('id', 'label');

        $degrees = $this->getTableLocator()->get('EdcDegrees')->find('all');
        $optionsDegrees = $degrees->all()->combine('id', 'label');

        $clubs = $this->getTableLocator()->get('EdcClubs')->find('all')->order(['city'=>'ASC']);
        $optionsClubs = $clubs->all()->combine('id', 'complete_name');

        $this->set('members', $members);
        $this->set('course', $course);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);   
        $this->set('optionsClubs', $optionsClubs); 
    }

    

    public function result()
    {
		$search = $_POST['name'];
        $idseason = $_POST['idseason'];

		if ($this->request->is(['post', 'put'])) {
			$result = $this->getTableLocator()->get('EdcMembers')->find()
            ->where(['name LIKE' => '%'.$search.'%'])
            ->contain('EdcSubscriptions', function (Query $q){
                return $q
                ->where(['EdcSubscriptions.idseason IS' => $_POST['idseason']]);
            })
            ->contain('EdcSubscriptions.EdcClubs')
            ->contain('EdcSubscriptions.EdcGrades')
			->first();
		}  

        $this->set('result', $result);
        $this->viewBuilder()->setOption('serialize', 'result');
	}

    public function addknown()
    {
        $idparticipant = $_POST['idmember'];
        $idsubs = $_POST['idsubs'];
        $idcourse = $_POST['idcourse'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $paid = $_POST['paid'];
		$age = $_POST['age'];
        $samediam = $_POST['samediam'];
        $samedipm = $_POST['samedipm'];
        $dimancheam = $_POST['dimancheam'];
        $edc = $_POST['edc'];
        $rgpd = $_POST['rgpd'];
        $idmember = $_POST['idmember'];
        $clubid = $_POST['clubid'];
        $gradeid = $_POST['gradeid'];
        $degree = $_POST['degree'];
        $idseason = $_POST['idseason'];

        $subscriptionsTable =  $this->getTableLocator()->get('EdcSubscriptions');
        $subscription =  $subscriptionsTable
            ->findById($idsubs)
            ->contain('EdcClubs')
            ->firstOrFail();

        $coursesTable = $this->getTableLocator()->get('EdcCourses');
        $course = $coursesTable
        ->findById($idcourse)
        ->contain(['EdcCoursePlaces'])
        ->first();

        $membersTable = $this->getTableLocator()->get('EdcMembers');
        $member = $membersTable
            ->findById($idmember)
            ->firstOrFail();
       
        $origin = str_replace(' ', '_', $course->edc_course_place->name);
        $destination = str_replace(' ', '_', $subscription->edc_club->map);
        $key = "AIzaSyAxoP4zo_UbIDv1A5R8caiRziCDAXJy5jE";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($origin)."&destinations=" . urlencode( $destination) . "&key=" . $key;
        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        $km = round($jsondata->rows[0]->elements[0]->distance->value/1000);


        $data = [
                'id_subscriptions' => $idsubs,
                'id_course' => $idcourse,
                'satam' => $samediam,
                'satpm' => $samedipm,
                'sunam' => $dimancheam,
                'payment' => $paid,
                'km' => $km,
                'age' => $age,
                'edc'   => $edc,
                'rgpd'  => $rgpd,
                ];
        
        $datamember = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                ];
        
        $datasubscription = [
                'clubnumber' => $clubid,
                'actualgrade' => $gradeid,
                'teacherdegree' => $degree,  
                'idseason' => $idseason, 
                ];         
        
        $participant = $this->EdcParticipants->newEmptyEntity();
        if ($this->request->is('post')) {
            $this->EdcParticipants->patchEntity($participant, $data);
            
            if ($this->EdcParticipants->save($participant)) {
                $this->Flash->success(__('Inscription enregistrée.'));
                //return $this->redirect(['controller'=>'edc-courses','action' => 'view',$idcourse]);
            }
            //$this->Flash->error(__('Impossible d\'ajouter cette inscription.'));
        }

        if ($this->request->is(['post','put'])) {
            $membersTable->patchEntity($member, $datamember);
            if ($membersTable->save($member)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                //return $this->redirect(['controller'=>'EdcMembers','action' => 'view',$id]);
            }
            //$this->Flash->error(__('Mise à jour impossible'));
        }

        if ($this->request->is(['post','put'])) {
            $subscriptionsTable->patchEntity($subscription, $datasubscription);
            if ($subscriptionsTable->save($subscription)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                //return $this->redirect(['controller'=>'EdcMembers','action' => 'view',$id]);
            }
            //$this->Flash->error(__('Mise à jour impossible'));
        }
    }

    public function addrenew()
    {
        $idparticipant = $_POST['idmember'];
        $idcourse = $_POST['idcourse'];
        $name = $_POST['name'];
        $paid = $_POST['paid'];
		$age = $_POST['age'];
        $edc = $_POST['edc'];
        $rgpd = $_POST['rgpd'];
        $idmember = $_POST['idmember'];
        $clubid = $_POST['clubid'];
        $gradeid = $_POST['gradeid'];
        $degree = $_POST['degree'];
        $idseason = $_POST['idseason'];

        $subscriptionsTable =  $this->getTableLocator()->get('EdcSubscriptions');
        
        $coursesTable = $this->getTableLocator()->get('EdcCourses');
        $course = $coursesTable
        ->findById($idcourse)
        ->contain(['EdcCoursePlaces'])
        ->first();

        $membersTable = $this->getTableLocator()->get('EdcMembers');
        
        $datasubscription = [
            'idmember' => $idmember,
            'clubnumber' => $clubid,
            'actualgrade' => $gradeid,
            'teacherdegree' => $degree,  
            'idseason' => $idseason, 
        ];         
        
        $newsub = $subscriptionsTable->newEmptyEntity();
        if ($this->request->is(['post'])) {
            $subscriptionsTable->patchEntity($newsub, $datasubscription);
            if ($subscriptionsTable->save($newsub)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                $member = $membersTable
                ->findById($idmember)
                ->contain('EdcSubscriptions', function (Query $q) use($idseason){
                    return $q
                    ->where(['EdcSubscriptions.idseason IS' => $idseason]);
                })
                ->firstOrFail();
            }
        }
        $this->set('member', $member);
        $this->viewBuilder()->setOption('serialize', 'member');   
    }

    public function edit($id)
    {
        $participant = $this->EdcParticipants
            ->findById($id)
            ->contain('EdcSubscriptions')
            ->contain('EdcSubscriptions.EdcClubs')
            ->contain('EdcSubscriptions.EdcGrades')
            ->contain('EdcSubscriptions.EdcMembers')
            ->contain('EdcCourses')
            ->first();
       
        if ($this->request->is(['post','put'])) {
            $this->EdcParticipants->patchEntity($participant, $this->request->getData(), [
            'associated' => ['EdcSubscriptions']
            ]);
            if ($this->EdcParticipants->save($participant)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                return $this->redirect(['controller'=>'edc-courses','action' => 'view',$participant->id_course]);
            }
            $this->Flash->error(__('Mise à jour impossible'));
            }

        $grades = $this->getTableLocator()->get('EdcGrades')->find('all');
        $optionsGrades = $grades->all()->combine('id', 'label');

        $degrees = $this->getTableLocator()->get('EdcDegrees')->find('all');
        $optionsDegrees = $degrees->all()->combine('id', 'label');

        $clubs = $this->getTableLocator()->get('EdcClubs')->find('all');
        $optionsClubs = $clubs->all()->combine('id', 'name');

        $this->set('participant', $participant);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);   
        $this->set('optionsClubs', $optionsClubs); 
    }

    public function addnewfromcourse($id)
    {
        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');

        $participant = $this->EdcParticipants->newEmptyEntity();
        $participant->id_course = $id;
        if ($this->request->is('post')) {
            $participant = $this->EdcParticipants->patchEntity($participant, $this->request->getData(), 
            ['associated' => ['EdcSubscriptions','EdcSubscriptions.EdcMembers']]);
            if ($this->EdcParticipants->save($participant)) {
                
                $this->Flash->success(__('Inscription enregistrée.'));
                return $this->redirect(['controller'=>'EdcCourses','action' => 'view',$id]);
            }
            $this->Flash->error(__('Impossible d\'ajouter cette inscription.'));
        }

        $coursesTable = $this->getTableLocator()->get('EdcCourses');
        $course = $coursesTable
        ->findById($id)
        ->contain(['EdcCoursePlaces'])
        ->first();

        $seasons = $seasonTable->find()->order(['name'=>'DESC'])->all()->combine('id', 'name');

        $optionsClubs = $this->getTableLocator()->get('EdcClubs')->find()->order(['city'=>'ASC'])->all()->combine('id', 'complete_name');

        $grades = $this->getTableLocator()->get('EdcGrades');
        $optionsGrades = $grades->find()->all()->combine('id', 'label');

        $degrees = $this->getTableLocator()->get('EdcDegrees');
        $optionsDegrees = $degrees->find()->all()->combine('id', 'label');

        $this->set('course', $course);
        $this->set('optionsClubs', $optionsClubs);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);  
        $this->set('seasons', $seasons);
        $this->set('participant', $participant);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $participant = $this->EdcParticipants->findById($id)->firstOrFail();
        if ($this->EdcParticipants->delete($participant)) {
            $this->Flash->success(__('Effacé'));
            return $this->redirect(['controller'=>'edc-courses','action' => 'view',$participant->id_course]);
        }  
    }

    public function syncpart()
    {
        $id = $_POST['idparts'];
        $idcourse = $_POST['idcourse'];
        $idsub = $_POST['idsub'];
        //$km = $_POST['km'];
        $payment = $_POST['payment'];
		$satam = $_POST['satam'];
        $satpm = $_POST['satpm'];
        $sunam = $_POST['sunam'];
        $age = $_POST['age'];
        $edc = $_POST['edc'];

        $subscription =  $this->getTableLocator()->get('EdcSubscriptions')
        ->findById($idsub)
        ->contain('EdcClubs')
        ->firstOrFail();

        $coursesTable = $this->getTableLocator()->get('EdcCourses');
        $course = $coursesTable
        ->findById($idcourse)
        ->first();

        $origin = str_replace(' ', '_', $course->place);
        $destination = str_replace(' ', '_', $subscription->edc_club->city);
        $key = "AIzaSyAxoP4zo_UbIDv1A5R8caiRziCDAXJy5jE";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($origin)."&destinations=" . urlencode( $destination) . "&key=" . $key;
        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        $km = round($jsondata->rows[0]->elements[0]->distance->value/1000);

        $data = [
            'id_subscriptions' => $idsub,
            'id' => $id,
            'id_course' => $idcourse,
            'km' => $km,
            'payment' => $payment,
            'km' => $km,
            'satam' => $satam,
            'satpm' => $satpm,
            'sunam' => $sunam,
            'age' => $age,
            'edc' => $edc,
            'synced' => 'Y'
            ];
        
        $participant = $this->EdcParticipants->newEmptyEntity();
        if ($this->request->is('ajax')) {
           $this->EdcParticipants->patchEntity($participant, $data); 
            if ($this->EdcParticipants->save($participant))
            return $this->redirect($this->here);
              $this->Flash->success(__('OK!'));
        }
        $this->Flash->error(__('Erreur.'));
    }

    public function calckm()
    {
        $clubnumber = $_POST['clubnumber'];

        $clubsTable = $this->getTableLocator()->get('EdcClubs');
        $club = $clubsTable
        ->findById($clubnumber)
        ->first();

        $origin = str_replace(' ', '_', $club->map);
        $destination = str_replace(' ', '_', $_POST['destination']);
        $key = "AIzaSyAxoP4zo_UbIDv1A5R8caiRziCDAXJy5jE";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($origin)."&destinations=" . urlencode( $destination) . "&key=" . $key;
        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        $km = round($jsondata->rows[0]->elements[0]->distance->value/1000);

        $this->set('km', $km);
        $this->viewBuilder()->setOption('serialize', 'km'); 
    }

    public function recalckm($id)
    {
        $id=$_POST['id'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $key = $_POST['key'];
        $url = $_POST['url'];

        $participant =  $this->EdcParticipants
        ->findById($id)
        ->firstOrFail();

        $jsonfile = file_get_contents($url);
        $jsondata = json_decode($jsonfile);
        $km = round($jsondata->rows[0]->elements[0]->distance->value/1000);
        if ($this->request->is('ajax')) {
            $participant->km = $km;
            $this->EdcParticipants ->save($participant);

        }
    }
}