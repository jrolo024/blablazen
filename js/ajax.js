//implémentation de la fonction permettant les requêtes ajax
function ajaxRequest(type, url, callback, data= null){
    let xhr;
    xhr = new XMLHttpRequest();
    console.log(data);
    if (type == 'GET' && data != null)
      url += '?' + data;
    console.log(url);
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = () =>{
      switch (xhr.status){
        case 200:
        case 201:
          callback(JSON.parse(xhr.responseText));
          break;
        default:
          httpErrors(xhr.status);
      }
    };
    xhr.send(data);
  }
  
  //implémentation de la fonction permettant d'afficher les différentes erreurs liées aux requêtes ajax
  function httpErrors(errorCode){
    let messages = {
      400: 'Requête incorrecte',
      401: 'Authentifiez vous',
      403: 'Accès refusé',
      404: 'Page non trouvée',
      500: 'Erreur interne du serveur',
      503: 'Service indisponible'
    };

    if (errorCode in messages){
      $('#errors').html('<strong>' + messages[errorCode] + '</strong>');
      $('#errors').show();
      setTimeout(() =>
      {
        $('#errors').hide();
      }, 5000);
    }
  }
  
