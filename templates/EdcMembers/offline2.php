
<div id="new_step1">
   <h4>Nouveau pratiquant</h4>
    <form action="" method="get">
    
        <a href="offline">Retour</a>
    
        <div style="margin-top:5%">   
            <div class="row"> 
                <div class="col s6">
                    <label for="participant">Nom</label>
                    <input type="text" name="participant" id="participant">
                </div>
                <div class="col s3">
                    <label for="dob">Date de naissance</label>
                    <input type="date" name="dob" id="dob">
                </div>
                <div class="col s3">
                    <label for="gender">Genre</label>
                    <select class="browser-default" list="gender" name="gender" id="gender">
                        <option value="H">H</option>
                        <option value="F">F</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
            <div class="row"> 
                <div class="col s6">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="col s6">
                    <label for="phone">Téléphone</label>
                    <input type="text" name="phone" id="phone">
                </div>
            </div>
            <button type="submitmember" class="full btn green darken-4" id="submitmember">Continuer</button>
        </div>
    </form>
</div>


<div id="new_step2" style="display:none;">
    <form action="" method="get">
        <!--<h4>Inscription pour la saison</h4>
        <label for="member">Participant :</label>
        <select class="browser-default" onchange="valParticipant()" list="members" name="member" id="member">
            <option value="" disabled selected>Sélectionner un pratiquant</option> 
        </select>-->
   
        <div style="margin-top:5%">
            <div class="row"> 
                <div class="col s6">
                    <label for="selectedmember">Nom</label>
                    <input type="text" name="selectedmember" id="selectedmember" idmember="">
                </div>
                <div class="col s3">
                    <label for="season">Saison</label>
                    <select class="browser-default" list="seasons" name="season" id="season">
                    </select>
                </div>
                <div class="col s3">
                    <label for="age">Age</label>
                    <input type="text" name="age" id="age">
                </div>
            </div>
            <div class="row"> 
                <div class="col s4">
                    <label for="club">Club</label>
                    <select class="browser-default" list="clubs" name="club" id="club">
                    </select>
                </div>
                <div class="col s4">
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
                <div class="col s4">
                    <label for="degree">Diplôme </label>
                    <select class="browser-default" list="grades" name="degree" id="degree">
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
            </div>
            <div class="row">
                <div class="col s4">
                    <label for="edc">EdC</label>
                    <select class="browser-default" name="edc" id="edc">
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select>
                </div>
                <div class="col s4">
                    <label for="type">Type</label>
                    <select class="browser-default" list="types" name="type" id="type">
                        <option value="0"></option>
                        <option value="1">nouvelle inscription</option>
                        <option value="2">renouvellement</option>
                        <option value="3">renouvellement après interruption</option>
                    </select>
                </div>
            </div>  
            <button type="submitsub" class="full btn green darken-4" id="submitsub">Continuer</button>
        </div> 
    </form>
</div>

<div id="new_step3" style="display:none;">
    <form action="" method="get">
    <div>
        <label for="course">Stage :</label>
        <select class="browser-default" onchange="valCourse()" list="courses" name="course" id="courses">
            <option value="" disabled selected>Sélectionner un stage</option>
        </select>
        <div id="selectedcourse" idcourse="" idseason="" style="color:white;">
        </div>
   </div>
    <div class="row" style="margin-top:5%">
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
        <button type="submitpart" class="full btn green darken-4" id="submitpart" idmember="0" idsubscriptions="0">Enregistrer</button>
    </div>
    </form>
</div>


<script>
     /*récupère la liste de la table edc-members*/
    /*const DBOpenRequest = window.indexedDB.open("edc-members");// open database edc-members.
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
            const members = document.getElementById("member");
            if (cursor){
                members.innerHTML += '<option value="'+cursor.value.id+'">'+cursor.value.name+'</option>'; 
                cursor.continue();
            }
        }  
    }
    */

    /*function valParticipant() {
        const id = +document.getElementById("member").value;
        const transaction = db.transaction("members", "readwrite");
        var objectStore = transaction.objectStore("members");
        const objectStoreRequest = objectStore.get(id);
       
        objectStoreRequest.onsuccess = (event) => {
            const participant = objectStoreRequest.result;
            const selectedparticipant = document.getElementById("selectedmember");
            const gender = document.getElementById("gender");
            const club = document.getElementById("club");
            const idmember = participant.id;
            const selectedcourse = document.getElementById("selectedcourse");
            selectedparticipant.value = participant.name;

            const DBOpenRequestSubs = window.indexedDB.open("edc-subscriptions");
            DBOpenRequestSubs.onsuccess = (event) => {
                dbSubs = DBOpenRequestSubs.result;
                const transactionSubs = dbSubs.transaction("subscriptions", "readwrite");
                const objectStoreSubs = transactionSubs.objectStore("subscriptions");
                const cursorRequest = objectStoreSubs.openCursor();
                cursorRequest.onsuccess = e => {
                    const cursor = e.target.result;
                
                    if (cursor) {
                        if (cursor.value.idmember == idmember) {
                            const idsubs = cursor.value.id;
                            const edc = document.getElementById("edc");
                            edc.value = cursor.value.edc;
                            const club = document.getElementById("club");
                            club.value = cursor.value.edc_club.name;
                            const grade = document.getElementById("grade");
                            grade.value = cursor.value.edc_grade.label;
                            const degree = document.getElementById("degree");
                            degree.value = cursor.value.teacherdegree;
                            const age = document.getElementById("age");
                            age.value = cursor.value.age;
                            const selectedparticipant = document.getElementById("selectedparticipant");
                            selectedparticipant.setAttribute("idsubs",idsubs);
                        }
                        cursor.continue();
                    }
                };
            }
        };    
    };*/

    /*récupérer la liste des clubs*/
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

    /*récupérer la liste des saisons*/
    const DBOpenRequestSeasons = window.indexedDB.open("edc-seasons");
    DBOpenRequestSeasons.onsuccess = (event) => {
        dbSeasons = DBOpenRequestSeasons.result;
        getSeasons();
    }

    function getSeasons() {
        const transaction = dbSeasons.transaction("seasons", "readwrite");
        var objectStore = transaction.objectStore("seasons");
        const objectStoreRequest = objectStore.getAll();
        objectStoreRequest.onsuccess = (event) => {
            const mySeasons = objectStoreRequest.result;
            const seasonList = document.getElementById("season");
            
            for (season of mySeasons) {
                seasonList.innerHTML += '<option value="'+season.id+'">'+season.name+'</option>'; 
            }
        };
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
            selectedcourse.innerHTML += myCourse.name+' - '+myCourse.id;
            selectedcourse.setAttribute("idcourse",myCourse.id);
            selectedcourse.setAttribute("idseason",myCourse.idseason);
        };
    }

    /*on enregistre le nouveau membre*/
    const btnmember = document.querySelector('#submitmember');
    btnmember.addEventListener('click', (e) => {
        // prevent the form from submitting
        e.preventDefault();

        $('#new_step2').show();
        // get values
        const name = document.getElementById("participant").value;
        const dob = document.getElementById("dob").value;
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;
        const gender = document.getElementById("gender").value;

        const DBOpenRequest = window.indexedDB.open("edc-members");
        DBOpenRequest.onsuccess = (event) => {
            db = DBOpenRequest.result;
            addData();
        }
        /*add Data in local database*/
        function addData() {
            const newItem = [
                {
                name : name,
                dob : dob,
                gender :  gender,
                email : email,
                phone : phone,
                synced: "N"
                },
            ];
            const transaction = db.transaction(["members"], "readwrite");
            const objectStore = transaction.objectStore("members");
            const objectStoreRequest = objectStore.add(newItem[0]);
        }
        //location. reload()
        const DBOpenRequestSubs = window.indexedDB.open("edc-members");
        DBOpenRequestSubs.onsuccess = (event) => {
            db = DBOpenRequestSubs.result;
            const transaction2 = db.transaction(["members"], "readwrite");
            const objectStore2 = transaction2.objectStore("members");
            const namemember = $("#participant").val();
            var cursorRequest = objectStore2.index('name').openCursor(null, 'next')
            
            cursorRequest.onsuccess = function(e){
                const cursor = e.target.result;
                
                if (cursor){
                    if(cursor.value.name == namemember){
                        
                        $("#selectedmember").val(namemember);
                        $("#selectedmember").attr("idmember",cursor.value.id);
                        $("#submitpart").attr("idmember",cursor.value.id);
                        var dob = new Date($("#dob").val());   
                        var today = new Date();
                        const age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                        $("#age").val(age);
                    }
                    
                 cursor.continue();
                }
            }  
        } 
    });

    const btnsub = document.querySelector('#submitsub');
    btnsub.addEventListener('click', (e) => {
        // prevent the form from submitting
        e.preventDefault();

        $('#new_step3').show();
        // show the form values
        const idmember = +document.getElementById("selectedmember").getAttribute("idmember");
        const season = +document.getElementById("season").value;
        const edc = document.getElementById("edc").value;
        const type = document.getElementById("type").value;
        const club = document.getElementById("club").value;
        const grade = document.getElementById("grade").value;
        const degree = document.getElementById("degree").value;
        const age = document.getElementById("age").value;


        const DBOpenRequest = window.indexedDB.open("edc-subscriptions");
        DBOpenRequest.onsuccess = (event) => {
            db = DBOpenRequest.result;
            addDataSub();
        }
        function addDataSub() {
            const newItem = [
                {
                    idmember : idmember,
                    idseason : season,
                    clubnumber : club,
                    actualgrade : grade,
                    teacherdegree : degree,
                    edc : edc,
                    type : type,
                    age : age,
                    nbcourses : 1,
                    synced: "N"
                },
            ];
            const transaction = db.transaction(["subscriptions"], "readwrite");
            const objectStore = transaction.objectStore("subscriptions");
            const objectStoreRequest = objectStore.add(newItem[0]);
        }
        //window.location.href = "https://aikido-hdf.fr/edc/edc-members/offline";
        const DBOpenRequestSubs = window.indexedDB.open("edc-subscriptions");
        DBOpenRequestSubs.onsuccess = (event) => {
            db = DBOpenRequestSubs.result;
            const transaction2 = db.transaction(["subscriptions"], "readwrite");
            const objectStore2 = transaction2.objectStore("subscriptions");
            const season = +document.getElementById("season").value;

            var cursorRequest = objectStore2.index('idmember').openCursor(null, 'next')
            
            cursorRequest.onsuccess = function(e){
                const cursor = e.target.result;
                const idmember = $("#selectedmember").attr("idmember");
                console.log('test1 ' +idmember+season);
                if (cursor){
                    if(cursor.value.idmember == idmember && cursor.value.idseason== season){
                        console.log('test2 ' +cursor.value.id);
                        $("#submitpart").attr("idmember",idmember);
                        $("#submitpart").attr("idsubscriptions",cursor.value.id);
                    }
                 cursor.continue();
                }                                            
            }  
        } 
    });

    const btn = document.querySelector('#submitpart');
    btn.addEventListener('click', (e) => {
        // prevent the form from submitting
        e.preventDefault();

        
        // get values
        const selectedcourse = document.getElementById("selectedcourse");
        const idcourse = selectedcourse.getAttribute("idcourse");
        const idsubs =  $("#submitpart").attr("idsubscriptions");
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
 
</script>