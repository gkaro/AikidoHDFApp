<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\FactoryLocator;

class PagesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');   
        $this->loadComponent('RequestHandler');
        
        $seasonTable = FactoryLocator::get('Table')->get('EdcSeasons');
        $seasons = $seasonTable->find()->select(['id','name'])->all();
        $this->set('seasons', $seasons);
    }
    
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;
        $today = date("Y-m-d");
        $yesterday = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
        $tomorrow = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
        if (!empty($path[0])) {
            $page = $path[0];
            $prevcourse = $this->getTableLocator()->get('EdcCourses')
            ->find()
            ->contain(['EdcParticipants.EdcSubscriptions', 'EdcParticipants','EdcParticipants.EdcSubscriptions.EdcMembers','EdcCourseTypes','EdcCoursePlaces'])
            ->order(['date'=>'DESC'])
            ->where(['date <'=> $yesterday])
            ->all()
            ->first();

            $avgAge = $this->getTableLocator()->get('EdcParticipants')
            ->find()
            ->where(['id_course'=>$prevcourse->id])
            ->where(['age IS NOT'=> NULL])
            ->all()
            ->avg('age');

            $avgKm = $this->getTableLocator()->get('EdcParticipants')
            ->find()
            ->contain('EdcSubscriptions')
            ->where(['id_course'=>$prevcourse->id])
            ->where(['EdcSubscriptions.clubnumber IS NOT'=>'99999999'])/*pour ne pas prendre en compte les participants "hors ligue"*/
            ->all()
            ->avg('km');

           
            $nextcourse = $this->getTableLocator()->get('EdcCourses')
            ->find()
            ->contain(['EdcParticipants.EdcSubscriptions', 'EdcParticipants','EdcParticipants.EdcSubscriptions.EdcMembers','EdcCourseTypes','EdcCoursePlaces'])
            ->where(['date >='=> $yesterday])
            ->all()
            ->first();


            $avgAgeNext = $this->getTableLocator()->get('EdcParticipants')
            ->find()
            ->contain(['EdcSubscriptions', 'EdcCourses'])
            //->where(['id_course'=>$nextcourse->id])
            ->all();
            //->avg('age');
            

            $avgKmNext = $this->getTableLocator()->get('EdcParticipants')
            ->find()
            ->contain('EdcSubscriptions')
            //->where(['id_course'=>$nextcourse->id])
            ->where(['EdcSubscriptions.clubnumber IS NOT'=>'99999999'])/*pour ne pas prendre en compte les participants "hors ligue"*/
            ->all();
            //->avg('km');
        

            $allparticipants = $this->getTableLocator()->get('EdcParticipants')
            ->find('all')
            ->order(['date'=>'DESC'])
            ->limit('10')
            ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcCourses'])
            ->select(['course'=>'EdcCourses.name','place'=>'EdcCourses.place','date'=>'EdcCourses.date']);
            $allparticipants->select([
                'count' => $allparticipants->func()->count('id_subscriptions')])
                ->group('id_course');

            
            $prevparticipants = $this->getTableLocator()->get('EdcParticipants')
                ->find('all')
                ->where(['id_course' => $prevcourse->id])
                ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcSubscriptions.EdcClubs']);

            if( $nextcourse != null){
                $todayparticipants = $this->getTableLocator()->get('EdcParticipants')
                ->find('all')
                ->where(['id_course' => $nextcourse->id])
                ->contain(['EdcSubscriptions','EdcSubscriptions.EdcMembers','EdcSubscriptions.EdcClubs']);
            }else{
                $todayparticipants = ["null"];
            }
                
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage','prevcourse','nextcourse','allparticipants','todayparticipants','tomorrow','avgAge','avgKm','avgAgeNext','avgKmNext','prevparticipants'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }

       
    }
}
