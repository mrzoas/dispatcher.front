<?php

include_once("settings.php");


$scriptForThisPage = <<<SCRIPT123321

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
    <form class="container-fluid">
      <div class="form-group">
        <label>Страница просмотра статуса заявления</label>
        <label for="validationServerUsername">Код заявления</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">№</span>
          </div>
          <input type="text" id="codeOfClaim" placeholder="Номер запроса" />
          <div class="invalid-feedback">
          </div>
          <button type="button" id="sendRequestForClaimStatusBtn" class="btn btn-primary">Проверить</button>
        </div>
      </form>
    </div>
  </div>



<!-- FOOTER.begin -->

<footer class="bd-footer text-muted bg-light">
<div class="container-fluid p-3 p-md-3">

  <noindex><a rel="nofollow noopener" target="_blank" href="https://github.com/mrzoas/dispatcher.front"><img
        src="img/github.svg" height="28pt"></img>GitHub</a></noindex>

  <p>Разработано в рамках проведених хакатона "Цифровой прорыв" командой <strong>void*</strong>
    <p>Казань, 27-29 сентября 2019 года</p>
</div>
</footer>
EOTLF123321;

include_once("_layer.inc");
?>