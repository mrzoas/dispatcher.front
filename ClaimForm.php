<?php

include_once("settings.php");


$scriptForThisPage = <<<SCRIPT123321


const connection = new signalR.HubConnectionBuilder()
    .withUrl(serverAddressForAnswerAfterSendClaim)
    .configureLogging(signalR.LogLevel.Information)    
    .build();
connection.on("TaskCreate", (info) => {
    //const gameGuid = info["gameGuid"];
    //const sessionGuid = info["sessionGuid"];
    console.log(info);
});

async function start() {
  try {
      await connection.start();
      console.log("connected");
  } catch (err) {
      console.log(err);
      setTimeout(() => start(), 5000);
  }
};
start();
connection.onclose(async () => {
  await start();
});



var sendBtn = document.getElementById("sendClaimToServer");
sendBtn.addEventListener("click", function(){
  var textT = document.getElementById("claimTextarea").value;  
  
  var dataForSanding = {
    nameClient: 'UK void*',
    text: textT
  };

  var request = new XMLHttpRequest();
  
  request.open('POST',serverAddressForSendClaim,true);
    
  request.setRequestHeader('Accept', 'application/json');
  request.setRequestHeader('Content-Type', 'application/json');
  
  request.addEventListener('readystatechange', function() {
    if ((request.readyState==4) && (request.status==200)) {
      var answerFromServer = request.responseText;
      sendBtn.classList.add('disabled');
      document.getElementById("alertForSuccessSending").classList.remove("d-none");
      
      var claimId = JSON.parse(answerFromServer);
      
      document.getElementById("alertForSuccessSending").innerHTML +=
        "Заявление успешно зарегистрированно. Отслеживать статус обращения можно по присвоенному ему коду: <strong>" +
        claimId.data.id +"</strong>.<br />Воспользуйтесь для этого <a href='ClaimView.php'>специальной страницей</a>.";
    }
  });

  request.send(JSON.stringify(dataForSanding));

  // reconnectToDB(serverAddress);
  // // Теперь ждем от сервера сообщеиния обработке задания
  // socket.onmessage = function(e) {
  //   console.log("Ответ сервера: " + e.data);
  // };

  
});
SCRIPT123321;

$titleForThisPage = $stringClaimForm;

$bodyForThisPage = <<<EOTLF123321
<header class="navbar bg-light navbar-expand flex-column flex-md-row bd-navbar m-0 p-0">
    <div class="container">
      <span class="col-7 col-sm-8 header-container m-0">
        <a href="lochalhost/#/" class="navbar-brand float-left m-0 p-0" data-test-id="header-home">
        <label class="row logo-dsgn m-0 p-0">
        	САД
        	<div class="m-0 p-0">
        <label class="post-logo-dsgn p-1" >
        	жкх
        </label>
    </div>
        </label>
        </a>
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
      <input
    </div>
    <button type="button" class="btn btn-primary" id="sendClaimToServer">Отправить</button>
    <div class="alert alert-info mt-2 d-none" id="alertForSuccessSending" role="alert">
    </div>
  </form>
</div>
</div>



<!-- FOOTER.begin -->

  <footer class="bd-footer footer-dsgn text-muted bg-light my-100">
    <div class="bg-light container-fluid p-3 p-md-3">
      <p>Разработано в рамках проведених хакатона "Цифровой прорыв" командой <strong>void*</strong>
      <p>Казань, 27-29 сентября 2019 года</p>
    </div>
  </footer>
  <!-- FOOTER.end -->
EOTLF123321;

include_once("_layer.inc");
?>