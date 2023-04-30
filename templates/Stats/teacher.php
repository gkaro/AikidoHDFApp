<script>
$(document).ready(function(){
  $('.tabs').tabs();
});
</script>

<div id="title">Stats par intervenant</div>


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
            echo $this->Html->link("Export XLS", ['action' => 'exportteachers',$s->id],['class'=>'btn btn-primary','style'=>'margin:2%']);                     
        ?>
        <table class="table highlight responsive-table" id="graytable" style="margin:5% 0">
            <thead class="table-light">
                <tr>
                    <th>Intervenants</th>   
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
            <?php foreach ($teachers as $t) : ?>
                <?php /**on vérifie le nombre de stages pour afficher uniquement les données des intervenants actifs sur la période */
                    $countCourses = 0;
                    foreach ($courses as $c){
                        
                        if($c->idseason == $s->id){
                            foreach($c->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                    $countCourses = $countCourses + 1;   
                                    
                                }
                            }
                            
                        }
                    }
                    if($countCourses > 0):
                    ?>
                <tr>
                    <td>
                    <strong><?= $t->name;?></strong>
                    </td>
                    <td style="text-align:center"><?php /**nombre de stages */
                    $count = 0;
                    foreach ($courses as $c){
                        
                        if($c->idseason == $s->id){
                            foreach($c->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                    $count = $count + 1;    
                                }
                            }
                            
                        }
                    }
                    echo $count;
                    ?>
                    </td>

                    <td style="text-align:center"><?php /**nombre de participants */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php /**nombre de participants EdC */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc =="oui"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php /**nombre de participants non EdC */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc !="oui"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php /**nombre de participants hommes */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc_subscription->edc_member->gender =="H"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                   
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php /**nombre de participants femmes */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc_subscription->edc_member->gender =="F"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                   
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php /**age moyen */
                    $count = 0;
                    $sum = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                    $count = $count + 1;
                                    $age = $p->age;
                                    $sum = $sum + $age;
                                }
                            }
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
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                    $count = $count + 1;
                                    $km = $p->km;
                                    $sum = $sum + $km;
                                }
                            }
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
               
                    <td style="text-align:center"><?php /**nombre de participants Picardie */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc_subscription->edc_club->CID =="Picardie"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                   
                    echo $count;
                    ?>
                    </td>
                
                    <td style="text-align:center"><?php /**nombre de participants Nord-Pas-de-Calais */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc_subscription->edc_club->CID =="Nord-Pas-de-Calais"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
                        }
                    }
                   
                    echo $count;
                    ?>
                    </td>
               
                    <td style="text-align:center"><?php /**nombre de participants Hors Ligue */
                    $count = 0;
                    foreach ($participants as $p){
                        if($p->edc_course->idseason == $s->id && $p->edc_subscription->edc_club->CID =="Hors Ligue"){
                            foreach($p->edc_course->edc_course_teachers as $teacher){
                                if($teacher->id == $t->id){
                                $count = $count + 1;  
                                }
                            }
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
