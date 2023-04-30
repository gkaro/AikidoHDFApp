<script>
$(document).ready(function(){
  $('.tabs').tabs();
});
</script>
<div id="title">Stats sur les inscriptions école des cadres</div>
<div class="row" style="margin-top:5%" id="stats">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col"><a class="active" href="#globalstats">Statistiques globales</a></li>
        <li class="tab col"><a href="#clubs">Clubs</a></li>
        <li class="tab col"><a href="#gender">Sexes</a></li>
        <li class="tab col"><a href="#age">Age</a></li>
        <li class="tab col"><a href="#degree">Diplômes</a></li>
        <li class="tab col"><a href="#grade">Grades</a></li>
        <li class="tab col"><a href="#subs">Inscrits</a></li>
      </ul>
    </div>
    <div id="globalstats" class="col s12">
        <?php 
            echo $this->Html->link("Export XLS ", ['action' => 'exportglobal'],['class'=>'btn btn-primary','style'=>'margin:2%']);
                              
        ?>
        <table class="table highlight responsive-table" style="margin-top:2%">
            <thead class="table-light">
            <tr>
                <th></th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                <strong>Inscriptions EdC</strong>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($subsEdc as $q){
                        if($q->idseason == $k->id){
                            $count = $count + 1;
                        }               
                    }
                    echo '<strong>'.$count.'</strong>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Picardie</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($subsEdc as $q){
                        if($q->idseason == $k->id && $q->edc_club->CID == 'Picardie'){
                            $count = $count + 1;
                        }               
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>NPDC</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($subsEdc as $q){
                        if($q->idseason == $k->id && $q->edc_club->CID == 'Nord-Pas-de-Calais'){
                            $count = $count + 1;
                        }               
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($subsEdc as $q){
                        if($q->idseason == $k->id && $q->edc_club->CID == 'Hors Ligue'){
                            $count = $count + 1;
                        }               
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <strong>Participations Stages (Total)</strong>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id){
                            $count = $count + 1;
                        }               
                    }
                    echo '<strong>'.$count.'</strong>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Picardie</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc_subscription->edc_club->CID == 'Picardie'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>NPDC</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc_subscription->edc_club->CID == 'Hors Ligue'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <strong>Participations Stages inscrits Edc</strong>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc == "oui"){
                            $count = $count + 1;
                        }               
                    }
                    echo '<strong>'.$count.'</strong>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Picardie</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc == "oui" && $q->edc_subscription->edc_club->CID == 'Picardie'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            
            <tr>
                <td>
                    <span style="margin-left:5%"><i>NPDC</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc == "oui" && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc == "oui" && $q->edc_subscription->edc_club->CID == 'Hors Ligue'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <strong>Participations Stages non inscrits Edc</strong>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc != "oui"){
                            $count = $count + 1;
                        }               
                    }
                    echo '<strong>'.$count.'</strong>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Picardie</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc != "oui" && $q->edc_subscription->edc_club->CID == 'Picardie'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>NPDC</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc != "oui" && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                    <span style="margin-left:5%"><i>Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                
                <?php 
                    $count = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc != "oui" && $q->edc_subscription->edc_club->CID == 'Hors Ligue'){
                                    $count = $count + 1;                   
                        }
                    }
                    echo '<i>'.$count. '</i>';
                ?>
                </td>
                <?php endforeach; ?>
        
            </tr>
            
            </tbody>

        </table>
        <table class="table highlight responsive-table" style="margin-top:2%">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                Nouvelles inscriptions
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->type == '1' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                Renouvellements
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->type == '2' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                Renouvellement après interruption
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->type == '3' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            
        </tbody>
    </table>
    
       
       
    </div>
    <div id="clubs" class="col s12">
    <?php 
            echo $this->Html->link("Export XLS Clubs", ['action' => 'exportclubs'],['class'=>'btn btn-primary','style'=>'margin:2%']);
                              
        ?>
    <table class="table highlight responsive-table" style="margin-top:2%">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clubs as $q) : ?>
            <tr>
                <td>
                <?= $q->name.'</br><small>'.$q->city .'</small>'; ?>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($q->edc_subscriptions as $sub){
                    if($sub->idseason == $k->id){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   
    </div>
    <div id="gender" class="col s12">
    <?php 
        echo $this->Html->link("Export XLS Genres", ['action' => 'exportgenders'],['class'=>'btn btn-primary','style'=>'margin:2%']);                    
    ?>

    <table class="table highlight responsive-table" style="margin-top:2%">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td>
                <strong>Participations Hommes aux stages</strong>
                </td>
                <?php foreach ($seasons as $k) : ?>
                    <?php 
                $total = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id){
                        $total = $total + 1;    
                    }
                } 
                ?>
                <td style="text-align:center;">
                <?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'H'){
                        $count = $count + 1;    
                    }
                }
                echo  '<strong>'.$count. '</strong><small>('.round($count/$total*100);
                echo '%)</small>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Hommes Picardie</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'H' && $p->edc_subscription->edc_club->CID == 'Picardie'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Hommes NPDC</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'H' && $p->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Hommes Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'H' && $p->edc_subscription->edc_club->CID == 'Hors Ligue'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <strong>Participations Femmes aux stages</strong>
                </td>
                <?php foreach ($seasons as $k) : ?>
                    <?php 
                $total = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id){
                        $total = $total + 1;    
                    }
                } 
                
                ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'F'){
                        $count = $count + 1;    
                    }
                }
                echo  '<strong>'.$count. '</strong><small>('.round($count/$total*100);
                echo '%)</small>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Femmes Picardie</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'F' && $p->edc_subscription->edc_club->CID == 'Picardie'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Femmes NPDC</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'F' && $p->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Participations Femmes Hors Ligue</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->edc_member->gender == 'F' && $p->edc_subscription->edc_club->CID == 'Hors Ligue'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <strong>Hommes inscrits EdC</strong>
                </td>
                <?php foreach ($seasons as $k) : ?>
                    <?php 
                $total = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc == 'oui'){
                        $total = $total + 1;    
                    }
                } 
                ?>
                <td style="text-align:center;">
                <?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'H' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo '<strong>'.$count. '</strong><small>('.round($count/$total*100);
                echo '%)</small>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Hommes inscrits EdC Picardie</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'H' && $sub->edc == 'oui' && $sub->edc_club->CID == 'Picardie'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Hommes inscrits EdC NPDC</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'H' && $sub->edc == 'oui' && $sub->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <strong>Femmes inscrites EdC</strong>
                </td>
                <?php foreach ($seasons as $k) : ?>
                    <?php 
                $total = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc == 'oui'){
                        $total = $total + 1;    
                    }
                } 
                
                ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'F' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  '<strong>'.$count. '</strong><small>('.round($count/$total*100);
                echo '%)</small>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Femmes inscrites EdC Picardie</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'F' && $sub->edc == 'oui' && $sub->edc_club->CID == 'Picardie'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Femmes inscrites EdC NPDC</i></span>
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->edc_member->gender == 'F' && $sub->edc == 'oui' && $sub->edc_club->CID == 'Nord-Pas-de-Calais'){
                        $count = $count + 1;    
                    }
                }
                echo '<i>'.$count. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
    </div>
    <div id="age" class="col s12">
    <?php 
        echo $this->Html->link("Export XLS Ages", ['action' => 'exportages'],['class'=>'btn btn-primary','style'=>'margin:2%']);                    
    ?>
    <table class="table highlight responsive-table" style="margin-top:2%">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr><td><strong>Tranches d'âge participants</strong></td></tr>
            <tr>
                <td>
                25 ans ou moins
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->age <= '25' && $p->age != '0'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                plus de 25 ans
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->age >= '25' && $p->age != '0'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr><td><strong>Tranches d'âge inscrits EdC</strong></td></tr>
            <tr>
                <td>
                25 ans ou moins
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->age <= '25' && $sub->age != '0' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                plus de 25 ans
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->age >= '25' && $sub->age != '0' && $sub->edc == 'oui'){
                        $count = $count + 1;    
                    }
                }
                echo  $count;
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                    <strong>Moyenne d'âge des participants aux stages</strong>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id){
                            $count = $count + 1;
                            $age = $q->age;
                            $sum = $sum + $age;
                            
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                 
                    echo  '<strong>'.$average.'</strong>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Moyenne d'âge Picardie</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc_subscription->edc_club->CID == 'Picardie'){
                            $count = $count + 1;
                            $age = $q->age;
                            $sum = $sum + $age;
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                    echo  '<i>'.$average. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Moyenne d'âge NPDC</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $q){
                        if($q->edc_course->idseason == $s->id && $q->edc_subscription->edc_club->CID == 'Nord-Pas-de-Calais'){
                            $count = $count + 1;
                            $age = $q->age;
                            $sum = $sum + $age;
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                    echo  '<i>'.$average. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <strong>Moyenne d'âge des inscrits EdC</strong>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($subsEdc as $sub){
                        if($sub->idseason == $s->id && $sub->edc == 'oui'){
                            $count = $count + 1;
                            $age = $sub->age;
                            $sum = $sum + $age;
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                    echo  '<strong>'.$average.'</strong>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Moyenne d'âge EdC Picardie</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($subsEdc as $sub){
                        if($sub->idseason == $s->id && $sub->edc == 'oui' && $sub->edc_club->CID == 'Picardie'){
                            $count = $count + 1;
                            $age = $sub->age;
                            $sum = $sum + $age;
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                    echo  '<i>'.$average. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
            <tr>
                <td>
                <span style="margin-left:5%"><i>Moyenne d'âge EdC NPDC</i></span>
                </td>
                <?php foreach ($seasons as $s) : ?>
                <td style="text-align:center;">
                <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($subsEdc as $sub){
                        if($sub->idseason == $s->id && $sub->edc == 'oui' && $sub->edc_club->CID == 'Nord-Pas-de-Calais'){
                            $count = $count + 1;
                            $age = $sub->age;
                            $sum = $sum + $age;
                        }
                    }
                    if($count > 0){
                        $average =  round($sum / $count,2) ;
                    }else{
                        $average = '0';
                    }
                    echo  '<i>'.$average. '</i>';
                ?>
                
                </td>
                <?php endforeach; ?>
        
            </tr>
        </tbody>
    </table>
    </div>
    <div id="degree" class="col s12">
    <?php 
        echo $this->Html->link("Export XLS Diplomes", ['action' => 'exportdegrees'],['class'=>'btn btn-primary','style'=>'margin:2%']);                    
    ?>

    <table class="table highlight responsive-table" style="margin-top:2%">
        <thead class="table-light">
            <tr>
                <th>Diplômes</th>
                <?php foreach ($seasons as $s) : ?>
                <th style="text-align:center;"><?= $s->name; ?></br><small>Participants (EdC)</small></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td>
                Aucun diplôme d'enseignant
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'Aucun'){
                        $count = $count + 1;    
                    }
                }
               
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'Aucun' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                BIF
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'BIF'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'BIF' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                BF
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'BF'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'BF' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                BE1
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'BE1'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'BE1' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                BE2
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'BE2'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'BE2' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                CQP
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'CQP'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'CQP' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                DEJEPS
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'DEJEPS'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'DEJEPS' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <td>
                DESJEPS
                </td>
                <?php foreach ($seasons as $k) : ?>
                <td style="text-align:center;"><?php 
                $count = 0;
                foreach ($participants as $p){
                    if($p->edc_course->idseason == $k->id && $p->edc_subscription->teacherdegree == 'DESJEPS'){
                        $count = $count + 1;    
                    }
                }
                
                $countedc = 0;
                foreach ($subsEdc as $sub){
                    if($sub->idseason == $k->id && $sub->teacherdegree == 'DESJEPS' && $sub->edc == 'oui'){
                        $countedc = $countedc + 1;    
                    }
                }
                echo   $count.' ('.$countedc.')';
                ?>
                
                </td>
                <?php endforeach; ?>
            </tr>
        
        </tbody>
    </table>
    </div>
    <div id="grade" class="col s12">
  
    <?php 
        echo $this->Html->link("Export XLS Grades", ['action' => 'exportgrades'],['class'=>'btn btn-primary','style'=>'margin:2%']);                    
    ?>
        <table class="table highlight responsive-table" style="margin-top:2%">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <?php foreach ($seasons as $s) : ?>
                    <th style="text-align:center;"><?= $s->name; ?></br><small>Participants (EdC)</small></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            
                <?php foreach ($grades as $q) : ?>
                <tr>
                    <td>
                    <?= $q->label; ?>
                    </td>
                    <?php foreach ($seasons as $k) : ?>
                    <td style="text-align:center;"><?php 
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $k->id && $p->edc_subscription->actualgrade == $q->id){
                            $count = $count + 1;    
                        }
                    }
                    

                    $countedc = 0;
                    foreach ($q->edc_subscriptions as $sub){
                        if($sub->idseason == $k->id){
                            $countedc = $countedc + 1;    
                        }
                    }
                    echo $count .' ('. $countedc .')';
                    ?>
                    
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="subs" class="col s12">
    <?php 
        echo $this->Html->link("Export XLS Inscrits", ['action' => 'exportsubs'],['class'=>'btn btn-primary','style'=>'margin:2%']);                    
    ?>

        <table class="table highlight responsive-table" style="margin-top:2%">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <?php foreach ($seasons as $s) : ?>
                    <th style="text-align:center;"><?= $s->name; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $m) : ?>
                        <tr>
                            <td>
                              
                             <?= $m->name; ?>
                            </td>
                            <?php foreach ($seasons as $k) : ?>
                            <td style="text-align:center;"><?php 
                            $count = 0;
                            foreach ($m->edc_subscriptions as $sub){
                                if($sub->idseason == $k->id && $sub->edc == 'oui'){
                                    $count = $count + 1;    
                                }
                            }
                            if ($count == 0){echo "non";}
                            else{echo "oui";}
                            
                            foreach ($m->edc_subscriptions as $sub){
                                if($sub->idseason == $k->id){
                                    if ($sub->nbcourses == 0){echo " | aucun stage";}
                                    elseif ($sub->nbcourses == 1){echo " | ".$sub->nbcourses." stage";}
                                    else {echo " | ".$sub->nbcourses." stages";}
                                }
                                
                            }
                           
                            ?>
                             
                            </td>
                            <?php endforeach; ?>

                        </tr>
                   
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
  </div>











