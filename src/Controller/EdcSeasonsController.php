<?php
namespace App\Controller;
use Cake\Datasource\FactoryLocator;

class EdcSeasonsController extends AppController
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
        $seasons = $this->EdcSeasons->find();
        $seasonlist = $this->EdcSeasons->find()->order(['name'=>'DESC'])->all();
        $this->viewBuilder()->setOption('serialize', ['seasonlist']);
        $this->set(compact('seasons'));
        $this->set(compact('seasonlist'));
    }

    public function view($id)
    {
        $season = $this->EdcSeasons->findById($id)->first();;

        $subsTable = FactoryLocator::get('Table')->get('EdcSubscriptions');
        $subs = $subsTable
        ->find("all")
        ->contain(['EdcMembers','EdcClubs','EdcGrades'])
        ->where(['idseason' => $id])
        ->order(['EdcMembers.name'=>'ASC']);

        $participantsTable = FactoryLocator::get('Table')->get('EdcParticipants');
        $parts = $participantsTable
        ->find("all")
        ->contain(['EdcSubscriptions.EdcMembers','EdcSubscriptions','EdcCourses'])
        ->contain(['EdcCourses.EdcCourseTypes','EdcCourses.EdcCoursePlaces']);

        $this->set(compact('season'));
        $this->set(compact('subs'));
        $this->set(compact('parts'));
    }

    public function viewedc($id)
    {
        $season = $this->EdcSeasons->findById($id)->first();;

        $subsTable = FactoryLocator::get('Table')->get('EdcSubscriptions');
        $subs = $subsTable->find("all")->contain(['EdcMembers','EdcClubs','EdcGrades'])->where(['idseason' => $id])->where(['EdcSubscriptions.edc' => "oui"])->order(['EdcMembers.name'=>'ASC']);

        $participantsTable = FactoryLocator::get('Table')->get('EdcParticipants');
        $parts = $participantsTable->find("all")->contain(['EdcSubscriptions.EdcMembers','EdcSubscriptions','EdcCourses']);

        $this->set(compact('season'));
        $this->set(compact('subs'));
        $this->set(compact('parts'));
    }

    public function add()
    {
        $season = $this->EdcSeasons->newEmptyEntity();
        if ($this->request->is('post')) {
            $season = $this->EdcSeasons->patchEntity($season, $this->request->getData());

            if ($this->EdcSeasons->save($season)) {
                $this->Flash->success(__('Nouvelle saison sportive ajoutée'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'enregistrer.'));
        }
        $this->set('season', $season);
    }

    public function exportsubscriptions($id)
    {
        $season = $this->EdcSeasons->findById($id)->first();

        $subsTable = $this->getTableLocator()->get('EdcSubscriptions');  
        $subs = $subsTable
            ->find("all")
            ->contain(['EdcMembers','EdcClubs','EdcGrades'])
            ->where(['idseason' => $id])
            ->order(['EdcMembers.name'=>'ASC'])
            ->toArray();

        $name = $season->name;
        $datatabl='';
        $datatabl = '<table cellspacing="2" cellpadding="5">';
        $datatabl .= '
        <caption>Inscriptions saison '.$name .'</caption>
        <thead>
			<th>Nom et prenom</th>
            <th>Genre</th>
			<th>Club</th>
            <th>Age</th>
            <th>Grade</th>
            <th>Diplome</th>
            <th>EdC</th>
            <th>Nombre de stages</th>
            <th>CID</th>
            </thead>';
        foreach($subs as $i){
            $name = $i['edc_member']['name'];
            $gender = $i['edc_member']['gender'];
            $club = $i['edc_club']['name'];
            $age = $i['age'];
            $grade = $i['edc_grade']['label'];
            $degree = $i['teacherdegree'];
            $edc = $i['edc'];
            $nbcourses = $i['nbcourses'];
            $cid = $i['edc_club']['CID'];
			$color_border = '#d5d5d5';
			$background_color = '#eeeeee';

            $datatabl .= '<tr>
				<td style="vertical-align:middle;border:1px solid ' . $color_border . '">' . $name . '</td>';
                $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $gender . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $club . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $age . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $grade . '</td>';
			$datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $degree . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $edc . '</td>';
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $nbcourses . '</td>';		
            $datatabl .= '<td style="vertical-align:middle;border:1px solid ' . $color_border . '" >' . $cid . '</td>';		
        }
        $datatabl .= '</table>';
        header('Content-type: application/force-download; charset=UTF-8;');
        header('Content-disposition:attachment; filename= export_participants.xls');
        header('Pragma: ');
        header('cache-control: ');
        echo $datatabl;
        die;
	}

    public function result()
    {
		$search = $_POST['name'];
        $season = $_POST['idseason'];

		if ($this->request->is(['post', 'put'])) {
			$subs = $this->getTableLocator()->get('EdcSubscriptions')->find()
            ->where(['EdcMembers.name LIKE' => '%'.$search.'%'])
            ->where(['idseason' => $season])
            ->contain(['EdcClubs','EdcMembers','EdcGrades'])
            ->order(['EdcMembers.name'=>'ASC'])
			->all();

            $participantsTable = FactoryLocator::get('Table')->get('EdcParticipants');
            $parts = $participantsTable
            ->find()
            ->contain(['EdcSubscriptions.EdcMembers','EdcSubscriptions','EdcCourses'])
            ->contain(['EdcCourses.EdcCourseTypes','EdcCourses.EdcCoursePlaces'])
            ->where(['EdcMembers.name LIKE' => '%'.$search.'%']);
		}  

        $this->set(compact('subs'));
        $this->set(compact('parts'));
        //$this->viewBuilder()->setOption('serialize', 'result');
	}
}