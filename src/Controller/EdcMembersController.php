<?php
namespace App\Controller;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Collection\Collection;
use Cake\Datasource\FactoryLocator;
use Cake\View\JsonView;
use Cake\Http\Middleware\BodyParserMiddleware;

Time::setDefaultLocale('fr_FR'); // For any mutable DateTime
FrozenTime::setDefaultLocale('fr_FR'); // For any immutable DateTime
Date::setDefaultLocale('fr_FR'); // For any mutable Date
FrozenDate::setDefaultLocale('fr_FR'); // For any immutable Date

class EdcMembersController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');   
        $this->loadComponent('RequestHandler');
        
        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $seasons = $seasonTable->find()->select(['id','name'])->all();
        $this->set('seasons', $seasons);
    }

    public function index()
    {

        $members = $this->getTableLocator()->get('EdcSubscriptions')
        ->find('all')
        ->contain(['EdcMembers','EdcClubs'])
        ->contain(['EdcMembers.EdcSubscriptions','EdcMembers.EdcSubscriptions.EdcSeasons','EdcMembers.EdcSubscriptions.EdcClubs'])
        ->order(['EdcMembers.name'=>'ASC'])
        ->distinct(['EdcMembers.name']);
        
        $memberlist = $this->getTableLocator()->get('EdcMembers')->find()->contain(['EdcSubscriptions','EdcSubscriptions.EdcClubs'])->all();
        
        $this->viewBuilder()->setOption('serialize', ['memberlist']);
        
        $this->set(compact('members'));
        $this->set(compact('memberlist'));
        
    }

    public function edc()
    {

        $members = $this->getTableLocator()->get('EdcSubscriptions')
        ->find('all')
        ->contain(['EdcMembers','EdcClubs'])
        ->contain(['EdcMembers.EdcSubscriptions','EdcMembers.EdcSubscriptions.EdcSeasons'])
        ->where(['edc' => 'oui'])
        ->order(['EdcMembers.name'=>'ASC'])
        ->distinct(['EdcMembers.name']);
        
        $memberlist = $this->getTableLocator()->get('EdcMembers')->find()->contain(['EdcSubscriptions','EdcSubscriptions.EdcClubs'])->all();
        
        $this->viewBuilder()->setOption('serialize', ['memberlist']);
        
        $this->set(compact('members'));
        $this->set(compact('memberlist'));
        
    }

    public function view($id)
    {
        $member = $this->EdcMembers->findById($id)
        ->contain(['EdcSubscriptions.EdcSeasons','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])
        ->firstOrFail();

        $this->set(compact('member'));   
    }

    public function add()
    {       
        $grades = $this->getTableLocator()->get('EdcGrades')->find()->all();
        $optionsGrades = $grades->combine('id', 'label');
        $degrees = $this->getTableLocator()->get('EdcDegrees')->find()->all();
        $optionsDegrees = $degrees->combine('id', 'label');
        $clubs = $this->getTableLocator()->get('EdcClubs')->find()->all();
        $optionsClubs = $clubs->combine('id', 'name');

        $member = $this->EdcMembers->newEmptyEntity();
        if ($this->request->is('post')) {
            $member = $this->EdcMembers->patchEntity($member, $this->request->getData(),
            ['associated' => ['EdcSubscriptions','EdcSeasons']]); 
            if ($this->EdcMembers->save($member)) {   
                $this->Flash->success(__('Inscription enregistrée.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter cette inscription.'));
        }

        $seasonsTable = $this->getTableLocator()->get('EdcSeasons');
        $seasonsList = $seasonsTable->find('list')->all();

        $this->set('seasonsList', $seasonsList);
        $this->set('member', $member);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);   
        $this->set('optionsClubs', $optionsClubs); 
    }

    public function edit($id)
    {
        $member = $this->EdcMembers
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $this->EdcMembers->patchEntity($member, $this->request->getData());
            if ($this->EdcMembers->save($member)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                return $this->redirect(['controller'=>'EdcMembers','action' => 'view',$id]);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }

        $this->set('member', $member);
    }

    public function delete($id)
    {
    }

    public function result()
    {
		$search = $_POST['name'];

		if ($this->request->is(['post', 'put'])) {
			$result = $this->getTableLocator()->get('EdcMembers')->find()
            ->where(['name LIKE' => '%'.$search.'%'])
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcSeasons'])
			->all();
		}  

        $this->set('result', $result);
        $this->viewBuilder()->setOption('serialize', 'result');
	}

    public function resultedc()
    {
		$search = $_POST['name'];

		if ($this->request->is(['post', 'put'])) {
			$result = $this->getTableLocator()->get('EdcMembers')->find()
            ->where(['name LIKE' => '%'.$search.'%'])
            ->contain('EdcSubscriptions', function (Query $q){
                return $q
                ->where(['EdcSubscriptions.edc IS' => 'oui']);
            })
            ->contain(['EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcSeasons'])
			->all();
		}  

        $this->set('result', $result);
        $this->viewBuilder()->setOption('serialize', 'result');
	}


    public function offline()
    {/*gestion des inscriptions en stage en mode déconnexion -- voir fichier offline.php */
        $this->viewBuilder()->setLayout('offline');
    }

    public function offline2()
    {/*gestion des nouvelles inscriptions en stage mode déconnexion -- voir fichier offline2.php */
        $this->viewBuilder()->setLayout('offline');
    }

    public function syncmember()
    {
        $id = $_POST['idmember'];
        $name = $_POST['namemember'];
        $phone = $_POST['phonemember'];
        $email = $_POST['ememailmemberail'];
        $dob = $_POST['dobmember'];
		$gender = $_POST['gendermember'];

        $data = [
            'name' => $name,
            'id' => $id,
            'phone' => $phone,
            'email' => $email,
            'dob' => $dob,
            'gender' => $gender,
            'synced' => 'Y'
            ];
        
        $member = $this->EdcMembers->newEmptyEntity();
        if ($this->request->is('ajax')) {
           $this->EdcMembers->patchEntity($member, $data); 
            if ($this->EdcMembers->save($member))
            return $this->redirect($this->here);
            $this->Flash->success(__('OK!'));
        }
        $this->Flash->error(__('Erreur.'));
    }
}