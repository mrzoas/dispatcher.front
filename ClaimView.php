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