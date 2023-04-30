<div id="note1" style="margin-top: 2%;">
    <form action="" method="get">
    <div>
       
        <label for="course">Stage :</label>
        <select class="browser-default" onchange="valCourse()" list="courses" name="course" id="courses">
        <option value="" disabled selected>Sélectionner un stage</option>
        </select>
        <div id="selectedcourse" idcourse="" idseason="" style="color:white;">

        </div>
        <label for="participant">Participant :</label>
        <select class="browser-default" onchange="valParticipant()" list="participants" name="participant" id="participant">
            <option value="" disabled selected>Sélectionner un pratiquant</option>    
        </select>
        <div><a class='btn btn-primary' href="offline2" style="margin-top:2%">Nouvelle inscription</a></div>
    </div>
    <div style="margin-top:5%">  
        <div class="row"> 
            <div class="col s6">
                <label for="selectedparticipant">Nom</label>
                <input type="text" name="selectedparticipant" id="selectedparticipant" idsubs="">
            </div>
        </div>
     
        <div class="row"> 
            <div class="col s4">
                <label for="dob">Date de naissance</label>
                <input type="date" name="dob" id="dob">
            </div>
            <div class="col s4">
                <label for="gender">Genre</label>
               
                <select class="browser-default" list="gender" name="gender" id="gender">
                <option value="H">H</option>
                <option value="F">F</option>
                <option value="Autre">Autre</option>
                </select>

            </div>
            <div class="col s4">
                <label for="age">Age</label>
                <input type="text" name="age" id="age">
            </div>
        </div>
        <div id="renew" class="row" style="display:none">
            <div class="card  red darken-4">
                <div class="card-content white-text">
                Stop ! Avant de continuer, indiquez le club, le grade et le diplôme de l'année en cours.
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col s3">
                <label for="club">Club</label>
                <select class="browser-default" list="clubs" name="club" id="club">
                </select>
            </div>
            <div class="col s3">
            <label for="grade">Grade</label>
            <select class="browser-default" list="grades" name="grade" id="grade">
                <option value="1">Mukyu</option>
                <option value="2">6e kyu</option>
                <option value="3">5e kyu</option>
                <option value="4">4e kyu</option>
                <option value="5">3e kyu</option>
                <option value="6">2e kyu</option>
                <option value="7">1er kyu</option>
                <option value="8">1er dan</option>
                <option value="9">2e dan</option>
                <option value="10">3e dan</option>
                <option value="11">4e dan</option>
                <option value="12">5e dan</option>
                <option value="13">6e dan</option>
                <option value="14">7e dan</option>
                <option value="99">non renseigné</option>
            </select>
            </div>
            <div class="col s3">
                <label for="degree">Diplôme</label>
                <select class="browser-default" name="degree" id="degree">
                    <option value="Aucun">Aucun</option>
                    <option value="BE1">BE1</option>
                    <option value="BE2">BE2</option>
                    <option value="BIF">BIF</option>
                    <option value="BF">BF</option>
                    <option value="CQP">CQP</option>
                    <option value="DEJEPS">DEJEPS</option>
                    <option value="DESJEPS">DESJEPS</option>
                </select>
            </div>
            <div class="col s3">
                <label for="edc">EdC</label>
                <select class="browser-default" name="edc" id="edc">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
            </div>
        </div>
        <div class="row" >
            <div class="col">
                <div id="buttonrenew" idmember="0" idsubscriptions="0" style="display:none; margin:20px 0px" class="form-control btn red darken-4">Renouveler</div>
                <div id="validrenew" style="display:none"> 
                    <div class="card  green darken-4">
                        <div class="card-content white-text">
                            Adhérent renouvelé, vous pouvez continuer l'inscription au stage...
                        </div>   
                    </div>   
                    <div id="validsub" class="form-control btn green darken-4">Continuer</div>
                </div>   
            </div>
        </div>
        <div id="coursedetails" class="row" style="display:none;" >
            <div class="col s4">
                <label for="satam">Samedi matin</label>
                <input type="text" name="satam" id="satam">
            </div>
            <div class="col s4">
                <label for="satpm">Samedi après-midi</label>
                <input type="text" name="satpm" id="satpm">
            </div>
            <div class="col s4">
                <label for="sunam">Dimanche matin</label>
                <input type="text" name="sunam" id="sunam">
            </div>
        </div>
        <div class="row">
            <div class="col s4">
               <label for="pay">Paiement</label>
                <input type="text" name="pay" id="pay">
            </div>
        </div>    
        <button type="submit" class="full btn green darken-4" id="submit" idmember="0" idsubscriptions="0">Enregistrer</button>
    </div>
    </form>
</div>

<div >
    <table class="table table-hover responsive-table">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Club</th>
                <th>Grade</th>
                <th>Payé</th>
                <th>Samedi Matin</th>
                <th>Samedi Après midi</th>
                <th>Dimanche</th>
                <th>Synchro</th>
            </tr>
        </thead>
        <tbody id="list">
        </tbody>
    </table>
</div>


<script>
    /*récupère la liste de la table edc-members*/
    const DBOpenRequest = window.indexedDB.open("edc-members");
    DBOpenRequest.onsuccess = (event) => {
        db = DBOpenRequest.result;
        getMembers();
    }

    function getMembers() {
        const transaction = db.transaction("members", "readwrite");
        var objectStore = transaction.objectStore("members");
        
        var cursorRequest = objectStore.index('name').openCursor(null, 'next')
        cursorRequest.onsuccess = function(e){
            var cursor = e.target.result;
            const participants = document.getElementById("participant");
            if (cursor){
                participants.innerHTML += '<option value="'+cursor.value.id+'">'+cursor.value.name+'</option>'; 
                cursor.continue();
            }
        }
    }
    
    /*récupère la liste de la table edc-courses*/
    const DBOpenRequestCourses = window.indexedDB.open("edc-courses");
    DBOpenRequestCourses.onsuccess = (event) => {
        dbCourses = DBOpenRequestCourses.result;
        getCourses();
    }

    function getCourses() {
        const transaction = dbCourses.transaction("courses", "readwrite");
        var objectStore = transaction.objectStore("courses");
  
        var cursorRequest = objectStore.index('date').openCursor(null, 'next')
        cursorRequest.onsuccess = function(e){
            var cursor = e.target.result;
            const courses = document.getElementById("courses");
            if (cursor){
                courses.innerHTML += '<option value="'+cursor.value.id+'">'+cursor.value.fullname+'</option>'; 
                cursor.continue();
            }
        }
    }
   
    /*sélection du stage - on récupère l'id du stage et de la saison*/
    function valCourse() {
        const id = +document.getElementById("courses").value;
        const transaction = dbCourses.transaction("courses", "readwrite");
       
        var objectStore = transaction.objectStore("courses");
        const objectStoreRequest = objectStore.get(id);
       
        objectStoreRequest.onsuccess = (event) => {
            const myCourse = objectStoreRequest.result;
            const selectedcourse = document.getElementById("selectedcourse");
            selectedcourse.setAttribute("idcourse",myCourse.id);
            selectedcourse.setAttribute("idseason",myCourse.idseason);
            
            const DBOpenRequestParticipants = window.indexedDB.open("edc-participants");
            DBOpenRequestParticipants.onsuccess = (event) => {
                dbParticipants = DBOpenRequestParticipants.result;
                const transaction2 = dbParticipants.transaction("participants", "readwrite");
                var objectStore2 = transaction2.objectStore("participants");
                
                
                var cursorRequest = objectStore2.openCursor()
                cursorRequest.onsuccess = function(e){
                   
                    var cursor = e.target.result;
                    const selectedcourse = document.getElementById("selectedcourse");
                    const idcourse = selectedcourse.getAttribute("idcourse");
                    const list = document.getElementById("list");
                    if (cursor){
                            cursor.continue();
                            if (cursor.value.id_course == idcourse){
                                console.log('ok')
                                
                                const idmember = cursor.value.edc_subscription.idmember
                                //const DBOpenRequestMembers = window.indexedDB.open("edc-members");

                                list.innerHTML += '<tr><td>'+idmember+'</td><td>'+cursor.value.edc_subscription.edc_club.name+'</td><td>'+cursor.value.edc_subscription.edc_grade.label+'</td><td>'+cursor.value.payment+'</td><td>'+cursor.value.satam+' </td><td>'+cursor.value.satpm+' </td><td>'+cursor.value.sunam+' </td><td>'+cursor.value.synced+'</td></tr>'; 
                                
                            }
                        
                        
                    }
                }
            }
        };

        

    }

    /*sélection du participant - on récupère le nom, la date de naissance et le genre*/
    function valParticipant() {
        const id = +document.getElementById("participant").value;
        const transaction = db.transaction("members", "readwrite");
        var objectStore = transaction.objectStore("members");
        const objectStoreRequest = objectStore.get(id);
       
        objectStoreRequest.onsuccess = (event) => {
            const participant = objectStoreRequest.result;
           
            const selectedparticipant = document.getElementById("selectedparticipant");
            const dob = document.getElementById("dob");
            const gender = document.getElementById("gender");
            const club = document.getElementById("club");
            const idmember = participant.id;
            const selectedcourse = document.getElementById("selectedcourse");
            const idseason = selectedcourse.getAttribute("idseason");
            selectedparticipant.value = participant.name;
            dob.value = participant.dob;
            gender.value = participant.gender;
            
            /*on vérifie les infos du participants sur la saison correspondant au stage sélectionné */
            const DBOpenRequestSubs = window.indexedDB.open("edc-subscriptions");
            DBOpenRequestSubs.onsuccess = (event) => {
                dbSubs = DBOpenRequestSubs.result;
                const transactionSubs = dbSubs.transaction("subscriptions", "readwrite");
                const objectStoreSubs = transactionSubs.objectStore("subscriptions");
                
                const cursorRequest = objectStoreSubs.openCursor();
                cursorRequest.onsuccess = e => {
                    const cursor = e.target.result;
                
                    if (cursor) {
                        if (cursor.value.idmember == idmember){
                            if(cursor.value.idseason == idseason) {
                                const idsubs = cursor.key;
                                /**on affiche les champs pour l'inscription au stage */
                                
                                $('#coursedetails').show();
                            /*on récupère son diplôme, son grade, son club, son âge*/
                                $("#submit").attr("idsubscriptions",cursor.value.id);
                                const edc = document.getElementById("edc");
                                edc.value = cursor.value.edc;
                                const degree = document.getElementById("degree");
                                degree.value = cursor.value.teacherdegree;
                                const age = document.getElementById("age");
                                age.value = cursor.value.age;
                            
                                const selectedparticipant = document.getElementById("selectedparticipant");
                                selectedparticipant.setAttribute("idsubs",idsubs);
                                if (cursor.value.edc_club.name =! null){
                                    const club = document.getElementById("club");
                                    club.value = cursor.value.edc_club.id;
                                }
                                if (cursor.value.edc_grade.label =! null){
                                    const grade = document.getElementById("grade");
                                    grade.value = cursor.value.actualgrade;
                                }
                            }
                        else {
                                 /*sinon il faut renouveler son inscription - voir bouton 'renouveler'*/
                                $("#submit").attr("idsubscriptions","");
                                var dob = new Date($("#dob").val());   
                                var today = new Date();
                                const age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                                $("#age").val(age);
                                const edc = document.getElementById("edc");
                                edc.value = "";
                                $('#renew').show();
                                $('#buttonrenew').show();
                                
                            }
                        }
                      
                        cursor.continue();
                    }
                };
            }
        };    
    };

    /*récupère la liste de la table edc-clubs*/
    const DBOpenRequestClubs = window.indexedDB.open("edc-clubs");
    DBOpenRequestClubs.onsuccess = (event) => {
        dbClubs = DBOpenRequestClubs.result;
        getClubs();
    }

    function getClubs() {
        const transaction = dbClubs.transaction("clubs", "readwrite");
        var objectStore = transaction.objectStore("clubs");
        const objectStoreRequest = objectStore.getAll();
        objectStoreRequest.onsuccess = (event) => {
            const myClubs = objectStoreRequest.result;
            const clubList = document.getElementById("club");
            
            for (club of myClubs) {
                clubList.innerHTML += '<option value="'+club.id+'">'+club.name+'</option>'; 
            }
        };
    }

    /*bouton 'enregistrer'*/
    const btn = document.querySelector('#submit');
    btn.addEventListener('click', (e) => {
        // prevent the form from submitting
        e.preventDefault();

        // get values
        const name = document.getElementById("participant").value;
        const selectedcourse = document.getElementById("selectedcourse");
        const idcourse = selectedcourse.getAttribute("idcourse");
        const idsubs =  $("#submit").attr("idsubscriptions");
        const age = document.getElementById("age").value;
        const edc = document.getElementById("edc").value;
        const satam = document.getElementById("satam").value;
        const satpm = document.getElementById("satpm").value;
        const sunam = document.getElementById("sunam").value;
        const pay = document.getElementById("pay").value;
    
        const DBOpenRequest = window.indexedDB.open("edc-participants");
        DBOpenRequest.onsuccess = (event) => {
            db = DBOpenRequest.result;
            addData();
        }
        /*add Data in local database*/
        function addData() {
            const newItem = [
                {
                id_course: parseInt(idcourse),
                id_subscriptions: parseInt(idsubs),
                age: parseInt(age),
                edc: edc,
                payment: parseInt(pay),
                satam: satam,
                satpm: satpm,
                sunam: sunam,
                synced: "N"
                },
            ];
            const transaction = db.transaction(["participants"], "readwrite");
            const objectStore = transaction.objectStore("participants");
            const objectStoreRequest = objectStore.add(newItem[0]);
        }
        location. reload()
    });

    /*bouton 'renouveler'*/
    const btnsub = document.querySelector('#buttonrenew');
    btnsub.addEventListener('click', (e) => {
        // prevent the form from submitting
        e.preventDefault();

        const idmember = +document.getElementById("participant").value;
        const season = selectedcourse.getAttribute("idseason");
        const edc = document.getElementById("edc").value;
        const club = document.getElementById("club").value;
        const grade = document.getElementById("grade").value;
        const degree = document.getElementById("degree").value;
        const age = document.getElementById("age").value;

        const DBOpenRequest = window.indexedDB.open("edc-subscriptions");
        DBOpenRequest.onsuccess = (event) => {
            db = DBOpenRequest.result;
            addDataSub();
        }
        /*add Data in local database*/
        function addDataSub() {
            const newItem = [
                {
                    idmember : idmember,
                    idseason : season,
                    clubnumber : club,
                    actualgrade : grade,
                    teacherdegree : degree,
                    edc : edc,
                    age : age,
                    nbcourses : 1,
                    synced: "N"
                },
            ];
         
            const transaction = db.transaction(["subscriptions"], "readwrite");
            const objectStore = transaction.objectStore("subscriptions");
            const objectStoreRequest = objectStore.add(newItem[0]);
            $('#buttonrenew').hide();
            $('#renew').hide();
            $('#validrenew').show();
        }
    });   

    /*bouton 'valider' - affiché après action sur 'renouveler'*/
    const validsub = document.querySelector('#validsub');
    validsub.addEventListener('click', (e) =>  {  
        $('#coursedetails').show();
        const DBOpenRequestSubs = window.indexedDB.open("edc-subscriptions");
        DBOpenRequestSubs.onsuccess = (event) => {
            db = DBOpenRequestSubs.result;
            const transaction2 = db.transaction(["subscriptions"], "readwrite");
            const objectStore2 = transaction2.objectStore("subscriptions");
            
            const idseason = selectedcourse.getAttribute("idseason");
            
            var cursorRequest = objectStore2.index('idmember').openCursor(null, 'next')
            
            cursorRequest.onsuccess = function(e){
                const cursor = e.target.result;
                const idmember = +document.getElementById("participant").value;
                if (cursor){
                    if(cursor.value.idmember == idmember && cursor.value.idseason== idseason){
                        console.log('test2 ' +cursor.value.id);
                        $("#submit").attr("idmember",idmember);
                        $("#submit").attr("idsubscriptions",cursor.value.id);
                    }
                 cursor.continue();
                }                                            
            }  
        } 
    });    

</script>

