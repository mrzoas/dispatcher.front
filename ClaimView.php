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

  document.getElementById("sendRequestForClaimStatusBtn").onclick = function () {
    codeOfClaim = document.getElementById("codeOfClaim").value;
    
    reconnectToDB(serverAddress);

    socket.onmessage = function(e) {
      console.log("Ответ сервера: " + e.data); // Получение ответа
    };
    socket.onopen = function() {
      socket.send(codeOfClaim); // Отправка на сервер кода заявления
    };

  };
    
SCRIPT123321;

$titleForThisPage = $stringClaimView;

$bodyForThisPage = <<<EOTLF123321
<div class="container p-3">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pb-3">
      <div class="card bg-light">
        <div class="card-header">Просмотр статуса заявления</div>
        <div class="card-body">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">№</span>
            </div>
            <input type="text" id="codeOfClaim" placeholder="Номер запроса" />
            <button type="button" id="sendRequestForClaimStatusBtn" class="btn btn-primary">Проверить</button>
          </div>
        </div>
      </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    
      <div class="alert alert-warning" role="alert">
        <p>Назначен исполнитель. Штатный сантехник: Самсоненко Николай Александрович.</p>
      </div>

      <div class="alert alert-secondary" role="alert">
        <p>Требуется дополнитльное время на то, чтобы купить кран редкой модели.</p>
      </div>

      <div class="alert alert-secondary" role="alert">
        <p>Согласована встреча 29 сентября 2019 года (воскресенье) в 15:20.</p>
      </div>
    
      <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Запрос выполнен</h4>
        <p>Протекающий кран заменён.</p>
        <hr>
        <p class="mb-0">Отзыв о работе сантехника вы можете оставить по телефону 889-АИ-231.</p>
      </div>
    </div>

  </div>
</div>
EOTLF123321;

include_once("_layer.inc");
?>