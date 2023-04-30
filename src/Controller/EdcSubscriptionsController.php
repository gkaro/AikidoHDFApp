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

Time::setDefaultLocale('fr_FR'); // For any mutable DateTime
FrozenTime::setDefaultLocale('fr_FR'); // For any immutable DateTime
Date::setDefaultLocale('fr_FR'); // For any mutable Date
FrozenDate::setDefaultLocale('fr_FR'); // For any immutable Date

class EdcsubscriptionsController extends AppController
{
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
        $subs = $this->EdcSubscriptions->find()
        ->contain(['EdcMembers'])
        ->contain(['EdcSeasons'])
        ->contain(['EdcMembers.EdcSeasons']);
        
        $subscriptionslist = $this->EdcSubscriptions->find()->contain(['EdcClubs'])->contain(['EdcGrades'])->all();
        $this->viewBuilder()->setOption('serialize', ['subscriptionslist']);
        $this->set(compact('subs'));
        $this->set(compact('subscriptionslist'));
    }

    public function view($id)
    {
        $sub = $this->EdcSubscriptions->findById($id)->contain(['EdcSeasons','EdcMembers','EdcClubs'])->firstOrFail();
        $this->set(compact('sub'));
    }

    public function add()
    {
        $seasonTable = $this->getTableLocator()->get('EdcSeasons');

        $sub = $this->EdcSubscriptions->newEmptyEntity();

        if ($this->request->is('post')) {
            $sub = $this->EdcSubscriptions->patchEntity($sub, $this->request->getData(), 
            ['associated' => ['EdcMembers']]);
            if ($this->EdcSubscriptions->save($sub)) {
                $this->Flash->success(__('Inscription enregistrée.'));
                return $this->redirect(['controller'=>'EdcMembers','action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter cette inscription.'));
        }

        $seasons = $seasonTable->find()->order(['name'=>'DESC'])->all()->combine('id', 'name');

        $optionsClubs = $this->getTableLocator()->get('EdcClubs')->find()->order(['city'=>'ASC'])->all()->combine('id', 'complete_name');

        $grades = $this->getTableLocator()->get('EdcGrades');
        $optionsGrades = $grades->find()->all()->combine('id', 'label');

        $degrees = $this->getTableLocator()->get('EdcDegrees');
        $optionsDegrees = $degrees->find()->all()->combine('id', 'label');

        $this->set('optionsClubs', $optionsClubs);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);  
        $this->set('seasons', $seasons);
        $this->set('sub', $sub);
    }

    public function edit($id)
    {
        $seasonTable = $this->getTableLocator()->get('EdcSeasons');

        $sub = $this->EdcSubscriptions
            ->findById($id)
            ->contain('EdcSeasons')
            ->contain('EdcMembers')
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $this->EdcSubscriptions->patchEntity($sub, $this->request->getData(), [
                'associated' => ['EdcMembers','EdcSeasons']
            ]);
            if ($this->EdcSubscriptions->save($sub)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                return $this->redirect(['controller'=>'EdcMembers','action' => 'view',$sub->idmember]);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }

        $grades = $this->getTableLocator()->get('EdcGrades')->find('all');
        $optionsGrades = $grades->all()->combine('id', 'label');

        $optionsClubs = $this->getTableLocator()->get('EdcClubs')->find()->order(['city'=>'ASC'])->all()->combine('id', 'complete_name');

        $degrees = $this->getTableLocator()->get('EdcDegrees')->find('all');
        $optionsDegrees = $degrees->all()->combine('id', 'label');

        $seasons = $seasonTable->find('list')->all();

        $this->set('seasons', $seasons);
        $this->set('sub', $sub);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsDegrees', $optionsDegrees);
        $this->set('optionsClubs', $optionsClubs);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $sub = $this->EdcSubscriptions->findById($id)->firstOrFail();
        if ($this->EdcSubscriptions->delete($sub)) {
            $this->Flash->success(__('Inscription supprimée.'));
            //return $this->redirect(['controller'=>'edc-members','action' => 'index']);
        }
    }


    public function editmember($id)
    {
        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $membersTable = $this->getTableLocator()->get('EdcMembers');

        $member = $membersTable
            ->findById($id)
            ->contain('EdcSubscriptions')
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $membersTable->patchEntity($member, $this->request->getData(), [
                'associated' => ['EdcSubscriptions']
            ]);
            if ($membersTable->save($member)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }

        $seasons = $seasonTable->find('list')->all();
        $this->set('seasons', $seasons);
        $this->set('member', $member);
    }

    public function renew($id)
    {
        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $membersTable = $this->getTableLocator()->get('EdcMembers');

        $member = $membersTable
            ->findById($id)
            ->contain('EdcSubscriptions', function (Query $q){
                return $q->order(['idseason'=>'DESC']);
            })
            ->contain(['EdcSubscriptions.EdcSeasons','EdcSubscriptions.EdcClubs','EdcSubscriptions.EdcGrades'])
            ->firstOrFail();

        $newsub = $this->EdcSubscriptions->newEmptyEntity();

        if ($this->request->is(['post'])) {
            $this->EdcSubscriptions->patchEntity($newsub, $this->request->getData(), [
                'associated' => ['EdcMembers','EdcSeasons','EdcGrades','EdcClubs']
            ]);
            if ($this->EdcSubscriptions->save($newsub)) {
                $this->Flash->success(__('L\'inscription a été mise à jour.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }

        $grades = $this->getTableLocator()->get('EdcGrades')->find('all');
        $optionsGrades = $grades->all()->combine('id', 'label');

        $degrees = $this->getTableLocator()->get('EdcDegrees')->find('all');
        $optionsDegrees = $degrees->all()->combine('id', 'label');

        $optionsClubs = $this->getTableLocator()->get('EdcClubs')->find()->order(['city'=>'ASC'])->all()->combine('id', 'complete_name');

        $seasons = $seasonTable->find()->order(['name'=>'DESC'])->all()->combine('id', 'name');

        $this->set('seasons', $seasons);
        $this->set('member', $member);
        $this->set('newsub', $newsub);
        $this->set('optionsGrades', $optionsGrades);
        $this->set('optionsClubs', $optionsClubs);
        $this->set('optionsDegrees', $optionsDegrees);
    }
    
    public function renewal()
    {
        $seasons = $seasonTable->find()->all();
        $this->set('seasons', $seasons);
    }

    public function syncsub()
    {
        $id = $_POST['idsubs'];
        $idmember = $_POST['idmember'];
        $clubnumber = $_POST['clubnumber'];
        $actualgrade = $_POST['actualgrade'];
        $teacherdegree = $_POST['teacherdegree'];
		$idseason = $_POST['idseason'];
        $age = $_POST['age'];
        $edc = $_POST['edc'];

        $data = [
            'idmember' => $idmember,
            'id' => $id,
            'clubnumber' => $clubnumber,
            'actualgrade' => $actualgrade,
            'teacherdegree' => $teacherdegree,
            'idseason' => $idseason,
            'age' => $age,
            'edc' => $edc,
            'synced' => 'Y'
            ];
        
        $sub = $this->EdcSubscriptions->newEmptyEntity();
        if ($this->request->is('ajax')) {
           $this->EdcSubscriptions->patchEntity($sub, $data); 
            if ($this->EdcSubscriptions->save($sub))
            return $this->redirect($this->here);
             
        }
        $this->Flash->error(__('Erreur.'));
    }

    
}