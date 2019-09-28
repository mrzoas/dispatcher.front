<?php

include_once("settings.php");


$scriptForThisPage = <<<SCRIPT123321
var sendBtn = document.getElementById("sendClaimToServer");
sendBtn.addEventListener("click", function(){
  var textT = document.getElementById("claimTextarea").value;  
  
  var dataForSanding = {
    nameClient: 'UK void*',
    text: textT
  };

  var request = new XMLHttpRequest();
  
  request.open('POST',serverAddresForSendClaim,true);
    
  request.setRequestHeader('Accept', 'application/json');
  request.setRequestHeader('Content-Type', 'application/json');
  
  request.addEventListener('readystatechange', function() {
    if ((request.readyState==4) && (request.status==200)) {
      var answerFromServer = request.responseText;
      sendBtn.classList.add('disabled');
      document.getElementById("alertForSuccessSending").classList.remove("d-none");
      let claimId = JSON.parse(answerFromServer).data.id;
      alert(JSON.parse(answerFromServer).data);
      document.getElementById("alertForSuccessSending").value += answerFromServer;
    }
  });

  request.send(JSON.stringify(dataForSanding));

  reconnectToDB(serverAddress);
  // Теперь ждем от сервера сообщеиния обработке задания
  socket.onmessage = function(e) {
    console.log("Ответ сервера: " + e.data);
  };
});
SCRIPT123321;

$titleForThisPage = $stringClaimForm;

$bodyForThisPage = <<<EOTLF123321
<header class="navbar bg-light navbar-expand flex-column flex-md-row bd-navbar">
<div class="container">
  <span class="col-7 col-sm-8 header-container">
    <a href="lochalhost/#/" class="navbar-brand float-left" data-test-id="header-home"><span>УК void*</span></a>
  </span>
  <ul class="navbar-nav nav-flex-icons ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Действия
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
      </div>
    </li>

    <li class="nav-item"><a href="lochalhost/#/" class="nav-link">Вход</a></li>
  </ul>
</div>
</nav>
</header>




<div class="container p-3">
<div class="row">
  <form class=" container-fluid">
    <div class="form-group">
      <label>Форма для оращения в управляющую компанию</label>
      <textarea class="form-control" id="claimTextarea" placeholder="Текст обращения" rows="10" required></textarea>
    </div>
    <button type="button" class="btn btn-primary" id="sendClaimToServer">Отправить</button>
    <div class="alert alert-info mt-2 d-none" id="alertForSuccessSending" role="alert">
      Заявление успешно зарегистрированно. Отслеживать статус обращения можно по присвоенному ему коду: 
    </div>
  </form>
</div>
</div>



<!-- FOOTER.begin -->

<footer class="bd-footer footer text-muted bg-light my-100">
  <div class="bg-light container-fluid p-3 p-md-3">
        <noindex><a rel="nofollow noopener" target="_blank"
            href="https://github.com/mrzoas/dispatcher.front"><img src="img/github.svg" height="28pt"></img>GitHub</a></noindex>
      
    <p>Разработано в рамках проведених хакатона "Цифровой прорыв" командой <strong>void*</strong>
      <p>Казань, 27-29 сентября 2019 года</p>
  </div>
</footer>
<!-- FOOTER.end -->
EOTLF123321;

include_once("_layer.inc");
?>