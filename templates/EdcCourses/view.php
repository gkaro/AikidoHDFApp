
<div id="title"><?php echo $course->edc_course_type->name; ?> <span><a class="" href="https://aikido-hdf.fr/edc/edc-courses/edit/<?= $course->id; ?>"><i class="material-icons">edit</i></a></span></div>

<div class="row" >
    <div class="col s4" style="border-right: 1px solid lightgray;">
        <div class="row" >
            <div class="col s6"><span class="details_course">Lieu</span></div><div class="col s6"> <?php if($course->idplace == null){echo "---";}else{echo $course->edc_course_place->name;} ?></div>
            <div class="col s6"><span class="details_course">Date</span> </div><div class="col s6"><?php if($course->date->format('d-M-Y') == null){echo "---";}else{echo $course->date->format('d-M-Y');} ?></div>
            <div class="col s6"><span class="details_course">Intervenant(s)</span> </div><div class="col s6"> 
                <?php if($course->edc_course_teachers == null){echo "---";}else{foreach ($course->edc_course_teachers as $t){echo $t->name." <br> ";} } ?>
            </div>
            <div class="col s6"><span class="details_course">Tarifs</span> </div><div class="col s6"><?php if($course->price == null){echo "---";}else{echo $course->price;} ?></div>
        </div>
    </div>
    <div class="col s4" style="border-right: 1px solid lightgray;">
        <div class="row" >
            <div class="col s8"><span class="details_course">Inscrits</span></div><div class="col s4"><?php echo $count; ?></div>

            <?php 
                $countedc = 0;
                foreach ($coursesParticipants as $part){
                    if($part->edc =='oui'){
                        $countedc = $countedc + 1;    
                    }
                }         
            ?>
            <div class="col s8"><span class="details_course">dont école des cadres</span></div><div class="col s4"><?php echo $countedc?> </div>

            <?php 
                $male = 0;
                foreach ($coursesParticipants as $part){
                    if($part->edc_subscription->edc_member->gender =='H'){
                        $male = $male + 1;    
                    }
                }         
            ?>
            <div class="col s8"><span class="details_course">Hommes </span></div><div class="col s4"><?php echo $male?> </div>

            <?php 
                $female = 0;
                foreach ($coursesParticipants as $part){
                    if($part->edc_subscription->edc_member->gender =='F'){
                        $female = $female + 1;    
                    }
                }         
            ?>
            <div class="col s8"><span class="details_course">Femmes </span></div><div class="col s4"><?php echo $female?> </div>
        </div>
    </div>
    <div class="col s4" style="border-right: 1px solid lightgray;">
        <div class="row" >
        <?php 
            $npdc = 0;
            foreach ($coursesParticipants as $part){
                if($part->edc_subscription->edc_club->CID =='Nord-Pas-de-Calais'){
                    $npdc = $npdc + 1;    
                }
            }         
        ?>
            <div class="col s6"><span class="details_course">CID NPDC </span></div><div class="col s6"><?php echo $npdc?></div>

        <?php 
            $pic = 0;
            foreach ($coursesParticipants as $part){
                if($part->edc_subscription->edc_club->CID =='Picardie'){
                    $pic = $pic + 1;    
                }
            }         
        ?>
            <div class="col s6"><span class="details_course">CID Picardie </span></div><div class="col s6"><?php echo $pic?></div>
            <div class="col s6"><span class="details_course">Total des paiements</span></div><div class="col s6"><?php echo $sum; ?>€</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col hide-on-small-only">
        <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-participants/add/<?= $course->id; ?>"><i class="material-icons left">add</i>ajouter une inscription</a>
    </div>
    <div class="col show-on-small-only hide-on-med-and-up">
        <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-participants/add/<?= $course->id; ?>"><i class="material-icons">add</i></a>
    </div>
    <div class="col">
        <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/stats/<?= $course->id; ?>"><i class="material-icons">insert_chart</i></a>
    </div>
    <div class="col hide-on-small-only">
        <?= $this->Html->link("Liste des participants XLS", ['action' => 'exportparticipants', $course->id],['class'=>'btn btn-primary']) ?>
    </div>
    <div class="col show-on-small-only hide-on-med-and-up">
        <?= $this->Html->link("XLS", ['action' => 'exportparticipants', $course->id],['class'=>'btn btn-primary']) ?>
    </div>
</div>

<table class="table table-hover responsive-table">
    <thead class="table-light">
        <tr>
            <th>Nom</th>
            <th>Club</th>
            <th>Grade</th>
            <th>Diplôme</th>
            <th>Paiement</th>
            <th>Km</th>
            <th>Edc</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($coursesParticipants as $c): ?>
        <tr>
            <td>
                <?= $c->edc_subscription ->edc_member->name; ?>
            </td>
            <td>
                <?= $c->edc_subscription->edc_club->name; ?>
            </td>
            <td>
                <?= $c->edc_subscription ->edc_grade->label; ?>
            </td>
            <td>
                <?= $c->edc_subscription ->teacherdegree; ?>
            </td>
            <td>
                <?= $c->payment; ?>
            </td>
            <td>
                <?= $c->km; ?>
            </td>
            <td>
                <?= $c->edc; ?>
            </td>
            <td>
                <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-participants/edit/<?= $c->id; ?>"><i class="material-icons">edit</i></a>
            </td>
            <td>
                <?= $this->Form->postLink(
                'Supprimer',
                ['controller'=>'edc-participants','action' => 'delete', $c->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer?', "class"=>"waves-effect waves-light btn red"])
            ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>