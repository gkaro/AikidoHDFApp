
<?php 
            echo $this->Html->link("Export XLS", ['action' => 'exportcourses',$season->id],['class'=>'btn btn-primary','style'=>'margin:2%']);   
            debug($season);                  
        ?>
<table class="table highlight responsive-table" id="graytable" style="margin:5% 0">
    <thead class="table-light">
        <tr>
            <th>Stages</th>
            
            <th style="text-align:center">Participants</th>
            <th style="text-align:center">Samedi Matin</th>
            <th style="text-align:center">Samedi Après-Midi</th>
            <th style="text-align:center">Dimanche</th>
            <th style="text-align:center">EdC</th>
            <th style="text-align:center">Non EdC</th>
            <th style="text-align:center">H</th>
            <th style="text-align:center">F</th>
            <th style="text-align:center">Age moyen</th>
            <th style="text-align:center"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $q) : ?>
        <tr>
            <td>
           <strong><?= $q->edc_course_type->name;?></strong></br>
          
           <small> <?= $q->date->format('d-m-Y');?></small></br>
          
           <small><?= $q->place;?></small>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->satam =='oui' || $part->satam == '1'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->satpm =='oui' || $part->satpm == '1'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->sunam =='oui'  || $part->sunam == '1'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->edc =='oui'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->edc =='non'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->edc_subscription->edc_member->gender =='H'){
                    $count = $count + 1;    
                }
            }
            echo $count;
            ?>
            </td>
            <td style="text-align:center"><?php 
            $count = 0;
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id && $part->edc_subscription->edc_member->gender =='F'){
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
            foreach ($q->edc_participants as $part){
                if($part->id_course == $q->id){
                    $count = $count + 1;
                    $age = $part->age;
                    $sum = $sum + $age;
                }
            }
            if($count > 0){
                $average =  round($sum / $count) ;
            }else{
                $average = '0';
            }
            echo  $average;
       ?>
        
        </td>
        <td>
            <a class="waves-effect waves-light btn-floating" href="https://aikido-hdf.fr/edc/edc-courses/listparticipants/<?= $q->id; ?>"><i class="material-icons">people</i></a>
            <a class="waves-effect waves-light btn-floating" href="https://aikido-hdf.fr/edc/edc-courses/stats/<?= $q->id; ?>"><i class="material-icons">insert_chart</i></a>
           
        </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>