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

class EdcClubsController extends AppController
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
    }

    public function index()
    {
        $clubs = $this->EdcClubs
        ->find('all');
        
        $this->viewBuilder()->setOption('serialize', ['clubs']);
        $this->set(compact('clubs'));
    }
}
    

   
  
   