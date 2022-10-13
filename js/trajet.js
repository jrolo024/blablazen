let path = window.location.pathname //récupération du lien de la page actuelle

//partie recherche trajet
if(path == "/searchtravel.php"){
  const urlParams = new URLSearchParams(window.location.search); //récupération des données de l'url
  if(urlParams.get("depart1") != undefined){ //gestion de quel formulaire entre les 2 présents sur la page index.php
    ajaxRequest('GET','php/request.php/trajet/',displaySearch,'depart=' +urlParams.get("depart1") +'&dest=' + urlParams.get("isen") +'&date='+ urlParams.get("date") ); //requête de recherche
    
  }else if (urlParams.get("destination") != undefined){
    ajaxRequest('GET','php/request.php/trajet/',displaySearch,'depart=' +urlParams.get("isen") +'&dest=' + urlParams.get("destination") +'&date='+ urlParams.get("date") );   //requête de recherche
  }
  
}

//partie mon compte
if(path == "/myaccount.php"){
  const urlParams = new URLSearchParams(window.location.search);
  ajaxRequest('GET', 'php/request.php/trajet/?infosCompte',displayAccount); //requête ajax pour les infos sur l'utilisateur
  if(urlParams.get("id")!=undefined){
  ajaxRequest('DELETE', 'php/request.php/trajet/',function(reponse){ //requête ajax pour supprimer une réservation
    window.location = "/myaccount.php";
  },'idtrajetdelete=' +urlParams.get("id"));}

  //modification de pseudonyme
  $('#edit').on('click', () =>{ 
    let text;
    let person = prompt("Please enter your new login:", ""); //création d'un popup avec un prompt
    if (person == null || person == "") {
      text = "User cancelled the prompt.";
    } else {
      console.log(person);
      ajaxRequest('PUT', 'php/request.php/trajet/',function(reponse){
      window.location = "/myaccount.php";
      },'newlogin=' +person); //requête de modification
    }
    document.getElementById("edit").innerHTML = text;
  });
}

//partie confirmation de réservation
if(path =="/confirmtravel.php"){
  const urlParams = new URLSearchParams(window.location.search); 
  let varid=urlParams.get("id");
  console.log(varid);
  let varlog=urlParams.get("login");
  ajaxRequest('GET', 'php/request.php/trajet/',displayConfirm,'idtrajet=' +varid+'&log=' +varlog); //requête de reservation

  //confirmation après avoir choisi le trajet, en appuyant sur le bouton "confirmer le trajet"
  $('#confirm').on('click', () =>{
  ajaxRequest('GET','php/request.php/trajet/',function(reponse){   
    if(reponse){//gestion des erreurs
      window.location = "/myaccount.php";
    }else{
      window.location = "?error";
    }
  },'idtrajett=' +varid+'&logi=' +varlog+'&value='+0 );
});

  //impression des informations
  $('#impression').on('click', () =>{
    window.print();
  });
}

//partie authentification
$('#connect').on('click', () =>{
  const urlParams = new URLSearchParams(window.location.search);
  ajaxRequest('GET','php/request.php/trajet/',function(reponse){
    if(reponse.status == 0){//gestion des erreurs
      window.location = "/myaccount.php";
    }else if(reponse.status == 1){
      window.location = "/login.php?error";
    }else{
      window.location = "/login.php?error2";
    }
  },'login=' +$("#login1").val() +'&password=' +$("#pwd1").val() );//requête de login
});

//partie ajout d'un trajet
$('#add').on('click', () =>{
  const urlParams = new URLSearchParams(window.location.search);
  ajaxRequest('POST','php/request.php/trajet/',function(reponse){
    if(reponse.status == 0){//gestion des erreurs
      window.location = "/myaccount.php";
    }else{
      window.location = "/addtravel.php?error"+reponse.status;
    }
  },'vd=' +$("#vd").val() +'&va=' + $("#va").val()+'&hd=' + $("#hd").val()+'&ha=' + $("#ha").val()+'&cpd=' + $("#cpd").val()+'&cpa=' + $("#cpa").val()+'&place=' + $("#place").val()+'&prix=' + $("#prix").val() );//requête d'ajout
});

//partie ajout d'un utilisateur
$('#sign').on('click', () =>{
  const urlParams = new URLSearchParams(window.location.search);
  ajaxRequest('POST','php/request.php/trajet/',function(reponse){
    if(reponse.status == 0){//gestion des erreurs
      window.location = "/login.php";
    }else{
      window.location = "/signin.php?error"+reponse.status;
    }
  },'user=' +$("#user").val() +'&pwd=' + $("#password").val()+'&conf=' + $("#confpwd").val()+'&num=' + $("#numtel").val()+'&nom=' + $("#nom").val());//requête d'ajout
});

//fonction permettant d'afficher les résultats de recherche de trajet et l'heure choisie initialement + nbr résultat
function displaySearch(search){
  if(search.status == undefined){
    let count =0;
    const urlParams = new URLSearchParams(window.location.search);
    for (let i = 0; i < search.length; i++){
      if(i<10){
        count+=i;
        let testD=search[i].date_depart;
        let date1 = testD.substring( 0, 10); 
        let time = testD.substring(11);
        let testD2=search[i].date_arrivee;
        let date2 = testD2.substring( 0, 10); 
        let time2 = testD2.substring( 11);
        console.log(search);
        //insertion des valeurs trouvées lors de la recherche et possibilité de choisir un trajet via un bouton
        $('#ajout').append('<div class="container">'+
            '<div class="row">'+
            '<div class="offset-md-2"></div>'+
            '<div class="card text-white" style="background-color: #B09696;">'+
              '<div class="card-body">'+
                '<div class="row mb-3" style="max-height: 10px;">'+
                  '<div class="col-auto">'+
                      '<p>'+date1+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+date2+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+time+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+time2+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+search[i].pseudo+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+search[i].addresse_depart+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+search[i].addresse_arrivee +'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p>'+search[i].prix+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                    '<button type="button" id="choixdetraj'+i+'" idtraj='+search[i].id_trajet+' login='+search[i].pseudo+'  class="btn btn-secondary">Choisir</button>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'+
            '</div>'+'</br>');     
        }
      }
    if (search[0]!=undefined){count++;}
    $('#nbresult').append(count); //ajout des données en haut de la page dans des champs prédéfinis
    $('#heureD').append(urlParams.get("date").substring(11));
    $('#dateD').append(urlParams.get("date").substring(0,10));

    //partie choix d'un trajet par rapport à l'id du bouton qui modifie l'url suivant les infos dans le bouton
    for (let i=0;i<=10;i++){
      $('#choixdetraj'+i+'').on('click', () =>{
        let idtrajet=$('#choixdetraj'+i+'').attr("idtraj");
        let login1=$('#choixdetraj'+i+'').attr("login");
        url="/confirmtravel.php";
        data='id='+idtrajet+'&login='+login1;
        url += '?' + data;
        window.location = url; 
      });  
    }
  }else{
    window.location = "index.php?error="+search.status;//gestion d'erreurs
  }
}

//fonction d'affichage des informations d'un trajet pour la confirmation
function displayConfirm(search){
   $('#addvid').append(search.addresse_depart);
   $('#addvia').append(search.addresse_arrivee);
   $('#addhid').append(search.date_depart);
   $('#addnb').append(search.nb_places);
   $('#addtel').append(search.telephone);
   $('#addname').append(search.nom);
}

//fonction d'affichage des informations de l'utilisateur et de ses trajets
function displayAccount(account){
  //partie ajout des informations sur l'utilisateur
   $('#username').append(account.pseudo);
   $('#name').append(account.nom);
   $('#telephone').append(account.telephone);

  //partie mes trajets en temps que conducteur
  //ajout des données récupérées par la requête dans les différents champs correspondants
   ajaxRequest('GET','php/request.php/trajet/',function(search){ for (let i = 0; i < search.length; i++){
    let testD=search[i].date_depart;
    let date1 = testD.substring( 0, 10); 
    let time = testD.substring(11);
    let testD2=search[i].date_arrivee;
    let date2 = testD2.substring( 0, 10); 
    let time2 = testD2.substring( 11);
    $('#addmy').append('<div class="container">'+
        '<div class="row">'+
        '<div class="offset-md-2"></div>'+
        '<div class="card bg-dark" >'+
          '<div class="card-body">'+
            '<div class="row mb-3" style="max-height: 10px;">'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+date1+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+date2+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+time+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+time2+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+search[i].nb_places+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+search[i].addresse_depart+'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+search[i].addresse_arrivee +'</p>'+
              '</div>'+
              '<div class="col-auto">'+
                  '<p class="p-1 mb-2 bg-dark text-white">'+search[i].prix+'</p>'+
              '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
        '</div>'+'</br>');
   }},'log='+account.pseudo );

    //partie mes réservations
    //ajout des données récupérées par la requête dans les différents champs correspondants
   ajaxRequest('GET','php/request.php/trajet/',function(search){
     console.log(search);
      for (let i = 0; i < search.length; i++){
        let testD=search[i].date_depart;
        let date1 = testD.substring( 0, 10); 
        let time = testD.substring(11);
        let testD2=search[i].date_arrivee;
        let date2 = testD2.substring( 0, 10); 
        let time2 = testD2.substring( 11);
        $('#addnotmy').append('<div class="container">'+
            '<div class="row">'+
            '<div class="offset-md-2"></div>'+
            '<div class="card bg-dark text-white" >'+
              '<div class="card-body">'+
                '<div class="row mb-3" style="max-height: 10px;">'+
                  '<div class="col-auto">'+
                      '<p >'+date1+'</p>'+ //date depart
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+date2+'</p>'+ //date arrivée
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+time+'</p>'+//heure départ
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+time2+'</p>'+//heure arrivée
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+search[i].pseudoc+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+search[i].addresse_depart+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+search[i].addresse_arrivee +'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<p >'+search[i].prix+'</p>'+
                  '</div>'+
                  '<div class="col-auto">'+
                      '<button type="button" id="delete'+i+'" idtraj='+search[i].id_trajet+' login='+search[i].pseudo+'  class="btn btn-secondary">Delete</button>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'+
            '</div>'+'</br>');

  //boucle pour récupérer suivant l'id du bouton (si delete0 ou delete1) et envoyer les données du bouton dans l'url
  for (let i=0;i<=10;i++){
    $('#delete'+i+'').on('click', () =>{
      let idtrajet=$('#delete'+i+'').attr("idtraj");
      let login1=$('#delete'+i+'').attr("login");
      url="/myaccount.php";
      data='id='+idtrajet+'&login='+login1;
      url += '?' + data;
      window.location = url;
    });  
  }
  }},'loginadd='+account.pseudo+'&value2='+1 );
}
