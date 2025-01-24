<?php
namespace App\Controller;
use Cake\Datasource\FactoryLocator;

class ConfigController extends AppController{

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
       
    }

    public function types()
    {  
        $types = $this->getTableLocator()->get('EdcCourseTypes')
        ->find('all');
        $this->set(compact('types'));   
    }

    public function addtype()
    {  
        $types = $this->getTableLocator()->get('EdcCourseTypes');
          
        $type = $types->newEmptyEntity();
        if ($this->request->is('post')) {
            $type = $types->patchEntity($type, $this->request->getData()); 
            if ($types->save($type)) {   
                $this->Flash->success(__('Type de stage enregistré.'));
                return $this->redirect(['action' => 'types']);
            }
            $this->Flash->error(__('Impossible d\'ajouter ce type de stage.'));
        }

        $this->set(compact('type'));
    }

    public function edittype($id)
    {  
        $types = $this->getTableLocator()->get('EdcCourseTypes');
          
        $type = $types
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $types->patchEntity($type, $this->request->getData());
            if ($types->save($type)) {
                $this->Flash->success(__('Le type a été mise à jour.'));
                return $this->redirect(['controller'=>'Config','action' => 'types']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }
        $this->set(compact('type'));
    }

    public function deletetype($id)
    {  
        $types = $this->getTableLocator()->get('EdcCourseTypes');
          
        $this->request->allowMethod(['post', 'delete']);

        $type = $types->findById($id)->firstOrFail();
        if ($types->delete($type)) {
            $this->Flash->success(__('Effacé'));
            return $this->redirect(['controller'=>'Config','action' => 'types']);
        }
    }

    public function places()
    {
        $places = $this->getTableLocator()->get('EdcCoursePlaces')
        ->find('all');
        $this->set(compact('places'));   
    }

    public function addplace()
    {  
        $places = $this->getTableLocator()->get('EdcCoursePlaces');
          
        $place = $places->newEmptyEntity();
        if ($this->request->is('post')) {
            $place = $places->patchEntity($place, $this->request->getData()); 
            if ($places->save($place)) {   
                $this->Flash->success(__('Lieu de stage enregistré.'));
                return $this->redirect(['action' => 'places']);
            }
            $this->Flash->error(__('Impossible d\'ajouter ce lieu de stage.'));
        }

        $this->set(compact('place'));
    }

    public function editplace($id)
    {  
        $places = $this->getTableLocator()->get('EdcCoursePlaces');
          
        $place = $places
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $places->patchEntity($place, $this->request->getData());
            if ($places->save($place)) {
                $this->Flash->success(__('Le lieu a été mis à jour.'));
                return $this->redirect(['controller'=>'Config','action' => 'places']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }
        $this->set(compact('place'));
    }

    public function deleteplace($id)
    {  
        $places = $this->getTableLocator()->get('EdcCoursePlaces');
          
        $this->request->allowMethod(['post', 'delete']);

        $place = $places->findById($id)->firstOrFail();
        if ($places->delete($place)) {
            $this->Flash->success(__('Effacé'));
            return $this->redirect(['controller'=>'Config','action' => 'places']);
        }
    }

    public function teachers()
    {
        $teachers = $this->getTableLocator()->get('EdcCourseTeachers')
        ->find('all')
        ->order(['name'=>'ASC']);
        $this->set(compact('teachers'));   
    }
    

    public function addteacher()
    {  
        $teachers = $this->getTableLocator()->get('EdcCourseTeachers');
          
        $teacher = $teachers->newEmptyEntity();
        if ($this->request->is('post')) {
            $teacher = $teachers->patchEntity($teacher, $this->request->getData()); 
            if ($teachers->save($teacher)) {   
                $this->Flash->success(__('Intervenant enregistré.'));
                return $this->redirect(['action' => 'teachers']);
            }
            $this->Flash->error(__('Impossible d\'ajouter cet intervenant.'));
        }

        $this->set(compact('teacher'));
    }

    public function editteacher($id)
    {  
        $teachers = $this->getTableLocator()->get('EdcCourseTeachers');
          
        $teacher = $teachers
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $teachers->patchEntity($teacher, $this->request->getData());
            if ($teachers->save($teacher)) {
                $this->Flash->success(__('L\'intervenant a été mis à jour.'));
                return $this->redirect(['controller'=>'Config','action' => 'teachers']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }
        $this->set(compact('teacher'));
    }

    public function deleteteacher($id)
    {  
        $teachers = $this->getTableLocator()->get('EdcCourseTeachers');
          
        $this->request->allowMethod(['post', 'delete']);

        $teacher = $teachers->findById($id)->firstOrFail();
        if ($teachers->delete($teacher)) {
            $this->Flash->success(__('Effacé'));
            return $this->redirect(['controller'=>'Config','action' => 'teachers']);
        }
    }

    public function clubs()
    {  
        $clubs = $this->getTableLocator()->get('EdcClubs')
        ->find('all');
        $this->set(compact('clubs'));   
    }

    public function addclub()
    {  
        $clubs = $this->getTableLocator()->get('EdcClubs');
          
        $club = $clubs->newEmptyEntity();
        if ($this->request->is('post')) {
            $club = $clubs->patchEntity($club, $this->request->getData()); 
            if ($clubs->save($club)) {   
                $this->Flash->success(__('Club enregistré.'));
                return $this->redirect(['action' => 'clubs']);
            }
            $this->Flash->error(__('Impossible d\'ajouter ce club.'));
        }

        $optionsCid = ['Nord-Pas-de-Calais' => 'Nord-Pas-de-Calais','Picardie' => 'Picardie','Hors Ligue' => 'Hors Ligue'];
        $this->set('optionsCid', $optionsCid);
        $this->set(compact('club'));
    }

    public function editclub($id)
    {  
        $clubs = $this->getTableLocator()->get('EdcClubs');
          
        $club = $clubs
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $clubs->patchEntity($club, $this->request->getData());
            if ($clubs->save($club)) {
                $this->Flash->success(__('Le club a été mise à jour.'));
                return $this->redirect(['controller'=>'Config','action' => 'clubs']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }
        $this->set(compact('club'));
    }

    public function deleteclub($id)
    {  
        $clubs = $this->getTableLocator()->get('EdcClubs');
          
        $this->request->allowMethod(['post', 'delete']);

        $club = $clubs->findById($id)->firstOrFail();
        if ($clubs->delete($club)) {
            $this->Flash->success(__('Effacé'));
            return $this->redirect(['controller'=>'Config','action' => 'clubs']);
        }
    }

    public function helloassoconfig()
    {
        $configs = $this->getTableLocator()->get('EdcHelloasso');

        $config = $configs
            ->find()
            ->firstOrFail();

        if ($this->request->is(['post','put'])) {
            $configs->patchEntity($config, $this->request->getData());
            if ($configs->save($config)) {
                $this->Flash->success(__('Configuration mise à jour.'));
                return $this->redirect(['controller'=>'Config','action' => 'helloassoconfig']);
            }
            $this->Flash->error(__('Mise à jour impossible'));
        }
          
        

        $this->set(compact('config'));
    }

}