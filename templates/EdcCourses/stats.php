<div id="title">Statistiques du stage <?= $course->edc_course_type->name; ?> (<?= $course->date->format("d-m-Y"); ?>)</div>

<?php $referer = $this->request->referer(); ?>
<?= $this->Html->link('Retour', $referer,['class'=>"form-control btn btn-primary","style"=>"margin:20px 0"]);?>

<div class="row" style="margin:2% 0%;min-height:400px">
    <script>
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTable);
        function drawTable() {
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string', 'Clubs');
            data3.addColumn('number', 'Inscrits');
            data3.addRows([
                <?php 
                foreach ($participantsClubs as $key) {  
                    echo'["'.$key->clubname .'",'.($key->count).'],';
                }
                ?>
            ]);
            var table = new google.visualization.Table(document.getElementById('chart_clubs'));
            table.draw(data3, {showRowNumber: true, width: '100%', height: '100%'});
        }
    </script>
    <div id="chart_clubs" class="col s3"></div>
    
    <script>
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTableCid);
        function drawTableCid() {
            var dataCid = new google.visualization.DataTable();
            dataCid.addColumn('string', 'CID');
            dataCid.addColumn('number', 'Inscrits');
            dataCid.addRows([
                <?php 
                foreach ($participantsCids as $key) {  
                    echo'["'.$key->cid .'",'.($key->count).'],';
                }
                ?>
            ]);
            var table = new google.visualization.Table(document.getElementById('CID'));
            table.draw(dataCid, {showRowNumber: false, width: '100%', height: '100%'});
        }
    </script>
    <div id="CID" class="col s2"></div>

    <div id="geoloc" class="col s7 hide-on-small-only">
    
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 7,
                    center: { lat: 50, lng: 3 },
                });
                setMarkers(map);
               
            }

            const clubs = [
                <?php 
                foreach ($participantsClubs as $key) {  
                    echo'["'.$key->clubname .'",'.$key->map.'],';
                }
                
               //echo'["'.$course->edc_course_place->name .'","'.$course->edc_course_place->name.'"],';
                ?>
            ];

            function setMarkers(map) {
                
                for (let i = 0; i < clubs.length; i++) {
                    const club = clubs[i];

                    new google.maps.Marker({
                        position: { lat: club[1], lng: club[2] },
                        map,
                        title: club[0],
                    });
                }
     
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: <?php echo '"'. $course->edc_course_place->name.'"'; ?> }, function(results, status) {
                    if (status === 'OK') {
                        // Create a new marker at the geocoded location
                        var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        icon: {
                            url: 'https://aikido-hdf.fr/edc/img/location-dot-solid.svg',
                            scaledSize: new google.maps.Size(50, 50)
                        },
                        title : "stage",
                        });
                    } else {
                        console.log('Geocode was not successful for the following reason: ' + status);
                    }
                });

               
               
            }

            window.initMap = initMap;

        </script>
        <style>
            #map {
                height: 100%;
                width: 100%;
                min-height:400px;
            } 
        </style>
        <div id="map"></div>
        <script
      src=""
      defer
    ></script>
    </div>
    
</div>

<div class="row" style="margin:2% 0%;min-height:400px">
    <script>
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTableGrade);
        function drawTableGrade() {
            var dataGrade = new google.visualization.DataTable();
            dataGrade.addColumn('string', 'Grades');
            dataGrade.addColumn('number', 'Inscrits');
            dataGrade.addRows([
            <?php 
            foreach ($participantsGrades as $key) {
              echo'["'.$key->grade .'",'.($key->count).'],';
            }
            ?>
          ]);
        var table = new google.visualization.Table(document.getElementById('chart_grades'));
        table.draw(dataGrade, {width: '100%', height: '100%'});
        }
    </script>
    <div id="chart_grades" class="col s2"></div>

    <script>
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTableDegree);
        function drawTableDegree() {
            var dataDegree = new google.visualization.DataTable();
            dataDegree.addColumn('string', 'Diplômes');
            dataDegree.addColumn('number', 'Inscrits');
            dataDegree.addRows([
            <?php 
            foreach ($participantsDegrees as $key) {
              echo'["'.$key->degree .'",'.($key->count).'],';
            }
            ?>
          ]);
        var table = new google.visualization.Table(document.getElementById('chart_degrees'));
        table.draw(dataDegree, {width: '100%', height: '100%'});
        }
    </script>
    <div id="chart_degrees" class="col s2"></div>
    
    <script>
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTableAge);
        function drawTableAge() {
            var dataAge = new google.visualization.DataTable();
            dataAge.addColumn('string', 'Age');
            dataAge.addColumn('number', 'Inscrits');
            dataAge.addRows([
            <?php 
            foreach ($participantsAge as $key) {
              echo'["'.$key->age .'",'.($key->count).'],';
            }
            ?>
          ]);
        var table = new google.visualization.Table(document.getElementById('chart_age'));
        table.draw(dataAge, {width: '100%', height: '100%'});
        }
    </script>
    <div id="chart_age" class="col s2"></div>

    <div class="col s6">
        <div class="row">
            <div class="col s6">
                Moyenne d'âge :
            </div>
            <div class="col s6">
                <?php if($avgAge != null){ echo round($avgAge);} ?>
            </div>
       
        <?php 
            $countunder25 = 0;
            foreach ($participants as $p){
                if($p->age <= '25' && $p->age != '0' && $p->age != NULL){
                    $countunder25 = $countunder25 + 1;    
                }
            }
            echo  '<div class="col s6">-25 ans :</div> <div class="col s6"> '.$countunder25.'</div>';?>
        
        <?php 
            $countover25 = 0;
            foreach ($participants as $p){
                if($p->age > '25' && $p->age != NULL){
                    $countover25 = $countover25 + 1;    
                }
            }
            echo  '<div class="col s6">+25 ans :</div> <div class="col s6"> '.$countover25.'</div>';?>
       
            <div class="col s6">Moyenne km parcourus :</div> <div class="col s6"><?php if($avgKm != null){ echo round($avgKm);} ?></div>
       
       <?php
       $total = 0;
       $male = 0;
        foreach ($participants as $p){
            $total = $total + 1;    
            if($p->edc_subscription->edc_member->gender == 'H'){
                $male = $male + 1;    
            }
        }
        echo  '<div class="col s6">Hommes :</div> <div class="col s6">'.$male; 
        if($total != 0){echo ' <small> ('.round($male/$total*100).'%)</small>';}
        echo '</div>';
            
        $female = 0;
        foreach ($participants as $p){
            if($p->edc_subscription->edc_member->gender == 'F'){
                $female = $female + 1;    
            }
        }
        echo  '<div class="col s6">Femmes :</div> <div class="col s6">'.$female; 
        if($total != 0){echo ' <small> ('.round($female/$total*100).'%)</small>';}
        echo '</div>';

        $edc = 0;
        foreach ($participants as $p){
            if($p->edc == 'oui'){
                $edc = $edc + 1;    
            }
        }
        echo  '<div class="col s6">Inscrits école des cadres :</div> <div class="col s6">'.$edc. '</div>';
        
        $nonedc = 0;
        foreach ($participants as $p){
            if($p->edc != 'oui'){
                $nonedc = $nonedc + 1;    
            }
        }
        echo  '<div class="col s6">Non inscrits école des cadres :</div> <div class="col s6">'.$nonedc. '</div>';?>
       
    </div>
</div>
