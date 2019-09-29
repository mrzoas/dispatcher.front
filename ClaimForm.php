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
  var textA = document.getElementById("inputAddress").value;  
  var textP = document.getElementById("inputPhone").value;  
  var textE = document.getElementById("inputEmail").value;  
  
  var dataForSanding = {
    nameClient: 'UK void*',
    text: textT,
    address: textA,
    phone: textP,
    email: textE
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

<div class="container p-3">
<div class="row">
  <form class=" container-fluid">
    <div class="form-group">
      <label>Форма для оращения в управляющую компанию</label>
      <textarea class="form-control" id="claimTextarea" placeholder="Текст обращения" rows="10" required></textarea>
      
      <div class="form-group row m-1">
        <label for="inputAddress" class="col-sm-2 col-form-label">Адрес</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="inputAddress" placeholder="Улица 12, 34">
        </div>
      </div>
      
      <div class="form-group row m-1">
        <label for="inputPhone" class="col-sm-2 col-form-label">Номер телефон</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="inputPhone" placeholder="8(912)345-67-78">
        </div>
      </div>

      <div class="form-group row m-1">
        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-6">
        <input type="email" class="form-control" id="inputEmail" placeholder="name@example.ru">
        </div>
      </div>
    </div>
    <button type="button" class="btn btn-primary" id="sendClaimToServer">Отправить</button>
    <div class="alert alert-info mt-2 d-none" id="alertForSuccessSending" role="alert">
    </div>
  </form>
</div>
</div>

EOTLF123321;

include_once("_layer.inc");
?>