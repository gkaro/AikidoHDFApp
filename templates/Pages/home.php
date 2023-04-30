<div class="row">
    <div class="col s6 m4 l4"> <!--première colonne : affiche les donées du précédent stage -->
        <div style="margin: 5% 0;font-weight:bold;text-align: center;">Dernier stage</div>
        <div style="margin: 5% 0;padding: 2%;background: cadetblue;color: white;border-radius: 4px;">
            <div style="margin: 2% 0;text-align: center;"> <?= $prevcourse->date->format('d-m-Y'); ?></div><!-- date du stage -->
            <div style="margin: 2% 0;text-align: center;"><a style="color:lightgray;" href="https://aikido-hdf.fr/edc/edc-courses/<?= $prevcourse->id; ?>"><?= $prevcourse->edc_course_type->name; ?></a></div><!-- nom du stage -->
            <div style="margin: 2% 0;text-align: center;"><?= $prevcourse->edc_course_place->name; ?></div><!-- lieu du stage -->
        </div>
        <div style="margin: 5% 0;padding: 2%;background: darkslategrey;color: white;border-radius: 4px;">
            <div class="row"><!-- stats -->
            <!-- nombre de participants -->
                <?php 
                    $count = 0;
                    foreach ($prevcourse->edc_participants as $part){
                            $count = $count + 1;   
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Participants</small></div>';
                    ?>
            <!-- nombre de participants inscrits à l'école des cadres -->
                <?php $count = 0;
                    foreach ($prevcourse->edc_participants as $part){
                        if($part->edc =='oui'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>dont inscrits EdC</small></div>'; 
                    ?>
            </div>
            <div class="row">
                <!-- nombre de participants hommes -->
                <?php $count = 0;
                    foreach ($prevcourse->edc_participants as $part){
                        if($part->edc_subscription->edc_member->gender =='H'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Hommes</small></div>'; 
                    ?>
            <!-- nombre de participants femmes -->
                <?php $count = 0;
                    foreach ($prevcourse->edc_participants as $part){
                        if($part->edc_subscription->edc_member->gender =='F'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Femmes</small></div>'; 
                    ?>
            </div>
            <div class="row">
                <!-- trajet moyen -->
                <div class="col s6" style="text-align: center;"><span style="font-size:2em;"><?= round($avgKm)?></span><br><small>Moy. Km</small></div>
                <!-- âge moyen -->
                <div class="col s6" style="text-align: center;"><span style="font-size:2em;"><?= round($avgAge)?></span><br><small>Moy. Age</small></div>
            </div>
        </div>
        <div>
            <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/stats/<?= $prevcourse->id; ?>"><i class="material-icons">insert_chart</i></a><!-- lien vers page de stats -->

            <!-- uniquement sur desktop et tablette -->
            <?= $this->Html->link("Liste des participants XLS", ['action' => 'exportparticipants', $prevcourse->id],['class'=>'btn btn-primary hide-on-small-only']) ?> <!-- export excel -->


            <!-- uniquement sur mobile -->
            <?= $this->Html->link("XLS", ['action' => 'exportparticipants', $prevcourse->id],['class'=>'btn btn-primary show-on-small-only hide-on-med-and-up']) ?><!-- export excel -->
        </div>
         <!-- uniquement sur desktop et tablette -->
        <div class="hide-on-small-only">
            <div style="margin-top:3%"><a onclick="toggleTable();" href="#"><!-- voir fonction JQuery ci-après -->
            <i class="material-icons left">remove</i> show/hide list</a> </div>
            <table id="viewlist" style="border:1px solid gainsboro;border-radius: 3px;border-collapse: separate;display:none;">
           <!-- liste des participants (nom + club) -->
            <?php foreach ($prevparticipants as $t){
                echo '<tr><td><a href="https://aikido-hdf.fr/edc/edc-participants/edit/'.$t->id.'">'.$t->edc_subscription->edc_member->name.'</a></td><td>| <small>'.$t->edc_subscription->edc_club->name.'</small></td></tr>';
            }
            ; ?>
            </table>
        </div>
        <script>/* fonction JQuery pour montrer ou cacher la liste*/
            function toggleTable() {
                var lTable = document.getElementById("viewlist");
                lTable.style.display = (lTable.style.display == "table") ? "none" : "table";
            }
        </script>
        
    </div>

    <?php 
        if($nextcourse != null):?><!-- si le prochain stage est défini on fait ce qui suit sinon voir class nonextcourse -->
    <div class="col s6 m4 l4 nextcourse">
        <!-- si la date du prochain stage est demain on affiche 'prochain stage' si c'est aujourd'hui on affiche 'stage du jour' -->
        <?php 
            if($nextcourse->date->format('d-m-Y') > $tomorrow){
                echo'<div style="margin: 5% 0;font-weight:bold;text-align: center;">Prochain stage</div>';
            }else{
                echo'<div style="margin: 5% 0;font-weight:bold;text-align: center;">Stage du jour</div>';
            }
        
        
        ?>
        <div style="margin: 5% 0;padding: 2%;background: cadetblue;color: white;border-radius: 4px;">
            <div style="margin: 2% 0;text-align: center;">
                <?php echo $nextcourse->date->format('d-m-Y');?><!-- date du stage -->
            </div>
            <div style="margin: 2% 0;text-align: center;"><a style="color:lightgray;" href="https://aikido-hdf.fr/edc/edc-courses/<?= $nextcourse->id; ?>"><?= $nextcourse->edc_course_type->name; ?></a></div><!-- nom du stage -->
            <div style="margin: 2% 0;text-align: center;"><?= $nextcourse->edc_course_place->name; ?></div><!-- lieu du stage -->
        </div>
        <div style="margin: 5% 0;padding: 2%;background: darkslategrey;color: white;border-radius: 4px;" >
            <div class="row"><!-- stats -->
            <!-- nombre de participants -->
                <?php 
                    $count = 0;
                    foreach ($nextcourse->edc_participants as $part){
                            $count = $count + 1;   
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Participants</small></div>';
                    ?>
             <!-- nombre de participants inscrits à l'école des cadres -->
                <?php $count = 0;
                    foreach ($nextcourse->edc_participants as $part){
                        if($part->edc =='oui'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>dont inscrits EdC</small></div>'; 
                    ?>
            </div>
            <div class="row">
                <!-- nombre de participants hommes -->
                <?php $count = 0;
                    foreach ($nextcourse->edc_participants as $part){
                        if($part->edc_subscription->edc_member->gender =='H'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Hommes</small></div>'; 
                    ?>
                <!-- nombre de participants femmes -->
                <?php $count = 0;
                    foreach ($nextcourse->edc_participants as $part){
                        if($part->edc_subscription->edc_member->gender =='F'){
                            $count = $count + 1;    
                        }
                    }
                    echo '<div class="col s6" style="text-align: center;"><span style="font-size:2em;">'.$count.'</span><br><small>Femmes</small></div>'; 
                    ?>
            </div>
            <div class="row">
                <!-- trajet moyen et âge moyen : on fait la moyenne ici et non dans le controller sinon erreur car id_course = null-->
                <?php 
                $sum_km = 0;
                $i = 0;
                foreach($avgKmNext as $q){
                    if($q->id_course == $nextcourse->id){
                       
                        $i++;
                        $sum_km+=$q->km;
                    }
                    if($i > 0){ $avgKmCalc = $sum_km/$i;}
                   else { $avgKmCalc = 0;}
                }

                $sum_age = 0;
                $i = 0;
                foreach($avgAgeNext as $q){
                    if($q->id_course == $nextcourse->id){
                        $i++;
                        $sum_age+=$q->age;
                    }
                    if($i > 0){ $avgAgeCalc = $sum_age/$i;}
                   else { $avgAgeCalc = 0;}
                }?>
                <div class="col s6" style="text-align: center;"><span style="font-size:2em;"><?= round($avgKmCalc)?></span><br><small>Moy. Km</small></div>
                <div class="col s6" style="text-align: center;"><span style="font-size:2em;"><?= round($avgAgeCalc)?></span><br><small>Moy. Age</small></div>
            </div>
        </div>
        <div>
            <a class="waves-effect waves-light btn" href="https://aikido-hdf.fr/edc/edc-courses/stats/<?= $nextcourse->id; ?>"><i class="material-icons">insert_chart</i></a><!-- lien vers page de stats -->

            <!-- uniquement sur desktop et tablette -->
            <a class="waves-effect waves-light btn hide-on-small-only" href="https://aikido-hdf.fr/edc/edc-participants/add/<?= $nextcourse->id; ?>"><i class="material-icons left">add</i>ajouter une inscription</a><!-- lien vers formulaire ajout participant -->

            <!-- uniquement sur mobile -->
            <a class="waves-effect waves-light btn show-on-small-only hide-on-med-and-up" href="https://aikido-hdf.fr/edc/edc-participants/add/<?= $nextcourse->id; ?>"><i class="material-icons">add</i></a><!-- lien vers formulaire ajout participant -->
        </div>
        
        <!-- uniquement sur desktop et tablette -->
        <div class="hide-on-small-only">
            <div style="margin-top:3%">
                <a onclick="toggleTable2();" href="#"><i class="material-icons left">remove</i> show/hide list</a> <!-- voir fonction JQuery ci-après -->
            </div>
                <table id="viewlist2" style="border:1px solid gainsboro;border-radius: 3px;border-collapse: separate;display:none;">
                <!-- liste des participants (nom + club) -->
                <?php
                 foreach ($todayparticipants as $t){
                    if($t != null){
                    
                    echo '<tr><td><a href="https://aikido-hdf.fr/edc/edc-participants/edit/'.$t->id.'">'.$t->edc_subscription->edc_member->name.'</a></td><td>| <small>'.$t->edc_subscription->edc_club->name.'</small></td></tr>';
                    }else{ echo 'vide';}
                }
                ; ?>
                </table>
            
            <script>/* fonction JQuery pour montrer ou cacher la liste*/
                function toggleTable2() {
                    var lTable = document.getElementById("viewlist2");
                    lTable.style.display = (lTable.style.display == "table") ? "none" : "table";
                }
            </script>
        </div>
           
    </div>
   <? else: ?>
    <div class="col s6 m4 l4 nonextcourse">
        <div style="margin: 5% 0;font-weight:bold;text-align: center;">Pas d'autres stages prévus</div>
    </div>
    <?php endif; ?>  
    <!-- uniquement sur desktop et tablette -->
    <div class="col s6 m4 l4 hide-on-small-only">
        <script>
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.arrayToDataTable([

                    ["stages", "participants", { role: "style" } ],
                    <?php 
                    foreach ($allparticipants as $key) {  
                        echo'["'.$key->date->format('d-m-Y') .'",'.($key->count).',"coral"],';

                    }
                    ?>
                ]);
                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                        { calc: "stringify",
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation" },
                        2]);
                var options = {
                    title: "",
                    width: 600,
                    height: 400,
                    bar: {groupWidth: "75%"},
                    legend: { position: "none" },
                    
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }
            
        </script>
        <div style="margin: 5% 0;font-weight:bold;text-align: center;">Participations aux stages</div>
        
        <div id="columnchart_values"></div>
       
    </div>
</div>
