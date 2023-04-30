<script>
$(document).ready(function(){
  $('.tabs').tabs();
});
</script>

<div id="title">Stats par lieu de stages</div>


<div class="row" style="margin-top:5%" id="stats">
    <div class="col s12">
        <ul class="tabs">
        <?php foreach ($seasons as $s): ?>
            <li class="tab col"><a class="active" href="#<?= $s->id; ?>"><?= $s->name; ?></a></li>
       
        <?php endforeach; ?>
            
        </ul>
    </div>
    <?php foreach ($seasons as $s): ?>
    <div id="<?= $s->id; ?>" class="col s12">
    <?php 
            echo $this->Html->link("Export XLS", ['action' => 'exportplaces',$s->id],['class'=>'btn btn-primary','style'=>'margin:2%']);                     
        ?>
        <table class="table highlight responsive-table" id="graytable" style="margin:5% 0">
            <thead class="table-light">
                <tr>
                    <th>Lieux de Stages</th>   
                    <th style="text-align:center">#</th>
                    <th style="text-align:center">Participants</th>
                    <th style="text-align:center">EdC</th>
                    <th style="text-align:center">Non EdC</th>
                    <th style="text-align:center">H</th>
                    <th style="text-align:center">F</th>
                    <th style="text-align:center">Age moyen</th>
                    <th style="text-align:center">Km moyen</th>
                    <th style="text-align:center">Picardie</th>
                    <th style="text-align:center">NPDC</th>
                    <th style="text-align:center">Hors Ligue</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($places as $p) : ?>
                <?php /**on vérifie le nombre de stages pour afficher uniquement les types actifs sur la période */
                    $countCourses = 0;
                    foreach ($courses as $c){
                        
                        if($c->idplace == $p->id && $c->idseason == $s->id){
                            
                                $countCourses = $countCourses + 1;    
                            
                            
                        }
                    }
                    if($countCourses > 0):
                    ?>
                <tr>
                    <td>
                    <strong><?= $p->name;?></strong>
                    </td>
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($courses as $c){
                        if($c->idplace == $p->id && $c->idseason == $s->id){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>

                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc =="oui"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc !="oui"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc_subscription->edc_member->gender =="H"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc_subscription->edc_member->gender =="F"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center">
                    <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id){
                            $count = $count + 1;
                            $age = $part->age;
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
                
                    <td style="text-align:center">
                    <?php 
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id){
                            $count = $count + 1;
                            $km = $part->km;
                            $sum = $sum + $km;
                            
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
               
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc_subscription->edc_club->CID =="Picardie"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc_subscription->edc_club->CID =="Nord-Pas-de-Calais"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php 
                    $count = 0;
                    foreach ($participants as $part){
                        if($part->edc_course->idplace == $p->id && $part->edc_course->idseason == $s->id && $part->edc_subscription->edc_club->CID =="Hors Ligue"){
                            $count = $count + 1;    
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>
