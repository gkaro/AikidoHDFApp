<script>
    $(document).ready(function(){
    $('.collapsible').collapsible();
  });
</script>
<h3>Liste des inscriptions EdC - saison <?= $season->name; ?> </h3>

<ul class="collapsible">
<?php foreach ($subs as $s): ?>

    <li>
        <div class="collapsible-header">
            <div class="container" style="width:100%"> 
                <div class="row"> 
                    <div class="col s3">
                        <strong><?= $s->edc_member->name ?></strong> 
                        <a class="waves-effect waves-light" href="https://aikido-hdf.fr/edc/edc-members/edit/<?= $s->edc_member->id; ?>"><i class="material-icons tiny">edit</i></a>
                        <br>
                        <small><?= $s->edc_club->name ?></small>
                    </div>
                    
                    <div class="col s2">
                        <?= $s->edc_grade->label ?>
                    </div>
                    <div class="col s1">
                        <?= $s->teacherdegree ?>
                    </div>
                    <div class="col s2">
                        <?php if ($s->type == '1') {
                            echo "nouvelle inscription";
                        }
                        elseif ($s->type == '2') {
                            echo "renouvellement";
                        }
                        elseif ($s->type == '3') {
                            echo "renouvellement après interruption"; 
                        }
                        ?>
                    </div>
                    <div class="col s2">
                    <?php if ($s->nbcourses == null){
                        echo "pas de stages";
                    }
                    elseif ($s->nbcourses == '1'){
                        echo $s->nbcourses." stage";
                    }
                    elseif ($s->nbcourses > '1')
                        echo $s->nbcourses." stages" ;?>
                    </div>
                    <div class="col s2">
                        <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-subscriptions/edit/<?= $s->id; ?>"><i class="material-icons">edit</i></a>
        
                    </div>
                </div>
            </div>
        </div>
        <div class="collapsible-body">
        <?php foreach ($parts as $p): ?>
           
            <?php if ($p->id_subscriptions == $s->id) {
                //debug($p);
                          echo $p->edc_course->name." le ".$p->edc_course->date->format('d-m-Y')." à ".$p->edc_course->place."</br>";
                        }?>
           
        <?php endforeach; ?>
        </div>
    </li>
   
<?php endforeach; ?>  
  </ul>