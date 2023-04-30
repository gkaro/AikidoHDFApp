<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ruda:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/edc/css/materialize.css">
    <link rel="stylesheet" href="/edc/css/custom.css"/>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    
    <script src="/edc/js/materialize.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
    <?php echo $this->Html->meta("csrfToken", $this->request->getAttribute("csrfToken"));?>


    <!--PWA Manifest et Service Worker-->
    <link rel="manifest" href="/edc/manifest.json">
    <script>
        navigator.serviceWorker.register("https://aikido-hdf.fr/pwabuilder-sw.js")
    </script>


    <!--Chargements JSON pour alimenter IndexedDB-->
    <script>

   /*load members*/
    async function loadJSONMembers(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str) 
         var idbMembers = await importIDBMembers("edc-members", "members", data["memberlist"])     
    }
 
    window.onload= loadJSONMembers("https://aikido-hdf.fr/edc/edc-members.json");
     
    function importIDBMembers(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname,3)
            r.onupgradeneeded = function() {
                var idbMembers = r.result
                var store = idbMembers.createObjectStore(sname, {keyPath: "id", autoIncrement: true,unique: true})
                store.createIndex("name", "name", { unique: false });
            }
            r.onsuccess = function() {
                var idbMembers = r.result
                let tactn = idbMembers.transaction(sname, "readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbMembers)     
            }
            r.onerror = function (e) {
                //alert("Enable to access IndexedDB members, " + e.target.errorCode)
            }    
        })
    }

    /*load courses*/
    async function loadJSONCourses(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str)
         var idbCourses = await importIDBCourses("edc-courses", "courses", data["courses"])
    }
 
    window.onload= loadJSONCourses("https://aikido-hdf.fr/edc/edc-courses.json")
     
    function importIDBCourses(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname,3)
            r.onupgradeneeded = function() {
                var idbCourses = r.result
                var store = idbCourses.createObjectStore(sname, {keyPath: "id", autoIncrement: true,unique: true})
                store.createIndex("date", "date", { unique: false });
            }
            r.onsuccess = function() {
                var idbCourses = r.result
                let tactn = idbCourses.transaction(sname,"readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbCourses) 
            }
            r.onerror = function (e) {
                //alert("Enable to access IndexedDB courses, " + e.target.errorCode)
            }    
        })
    }

    /*load participants*/
    async function loadJSONParticipants(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str)
         var idbParts = await importIDBParticipants("edc-participants", "participants", data["participantslist"])  
    }
 
    window.onload= loadJSONParticipants("https://aikido-hdf.fr/edc/edc-participants.json")
     
    function importIDBParticipants(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname)
            r.onupgradeneeded = function() {
                var idbParts = r.result
                var store = idbParts.createObjectStore(sname, {keyPath: "id", autoIncrement: true,unique: true})
            }
            r.onsuccess = function() {
                var idbParts = r.result
                let tactn = idbParts.transaction(sname, "readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbParts)   
            }
            r.onerror = function (e) {
                //alert("Enable to access IndexedDB participants, " + e.target.errorCode)
            }    
        })
    }

     /*load subscriptions*/
     async function loadJSONSubscriptions(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str)
         var idbSubscriptions = await importIDBSubscriptions("edc-subscriptions", "subscriptions", data["subscriptionslist"])
    }
 
    window.onload= loadJSONSubscriptions("https://aikido-hdf.fr/edc/edc-subscriptions.json")
     
    function importIDBSubscriptions(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname)
            r.onupgradeneeded = function() {
                var idbSubscriptions = r.result
                var store = idbSubscriptions.createObjectStore(sname, {keyPath: "id", autoIncrement: true,unique: true})
                store.createIndex("idmember", "idmember", { unique: false });
            }
            r.onsuccess = function() {
                var idbSubscriptions = r.result
                let tactn = idbSubscriptions.transaction(sname,"readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbSubscriptions)
                
            }
            r.onerror = function (e) {
                //alert("Enable to access IndexedDB subscriptions, " + e.target.errorCode)
            }    
        })
    }

    /*load clubs*/
    async function loadJSONClubs(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str) 
         var idbClubs = await importIDBClubs("edc-clubs", "clubs", data["clubs"])    
    }
 
    window.onload= loadJSONClubs("https://aikido-hdf.fr/edc/edc-clubs.json");
     
    function importIDBClubs(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname,2)
            r.onupgradeneeded = function() {
                var idbClubs = r.result
                var store = idbClubs.createObjectStore(sname, {keyPath: "id", unique: true})
            }
            r.onsuccess = function() {
                var idbClubs = r.result
                let tactn = idbClubs.transaction(sname, "readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbClubs)   
            }
            r.onerror = function (e) {
                //alert("Enable to access IndexedDB clubs, " + e.target.errorCode)
            }    
        })
    }


    /*load seasons*/
    async function loadJSONSeasons(fname) {
         var response = await fetch(fname)
         var str = await response.text();
         var data = JSON.parse(str)
         var idbSeasons = await importIDBSeasons("edc-seasons", "seasons", data["seasonlist"])
    }
 
    window.onload= loadJSONSeasons("https://aikido-hdf.fr/edc/edc-seasons.json")
     
    function importIDBSeasons(dname, sname, arr) {
        return new Promise(function(resolve) {
            var r = window.indexedDB.open(dname)
            r.onupgradeneeded = function() {
                var idbSeasons = r.result
                var store = idbSeasons.createObjectStore(sname, {keyPath: "id", unique: true})
                store.createIndex("name", "name", { unique: true });
            }
            r.onsuccess = function() {
                var idbSeasons = r.result
                let tactn = idbSeasons.transaction(sname,"readwrite")
                var store = tactn.objectStore(sname)
                for(var obj of arr) {
                        store.put(obj)
                }
                resolve(idbSeasons) 
            }
            r.onerror = function (e) {
                
            }    
        })
    }
     </script>
</head>
<body>


<!--Menu Principal -->
 

    <nav>
        <div class="nav-wrapper">
            <a href="<?= $this->Url->build('/edc-members/offline') ?>" class="brand-logo left">Stages Ligue HDF</a>
           
            <ul class="right hide-on-med-and-down">
                   <li><a href="<?= $this->Url->build('/') ?>">Mode Connecté</a></li>
            </ul>
        </div>
    </nav>






    
     
    <main class="main">
        <div class="container px-5 mt-5 edc">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer style="min-height:100px;">
   
    </footer>
</body>
</html>

