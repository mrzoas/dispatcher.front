<?php

include_once("settings.php");


// Получение начальных данных для таблицы
$xml = file_get_contents($serverAddressForGetTableWithClaims);

$scriptForThisPage = <<<SCRIPT123321

var json_obj = $xml; // Актуальные данные по заявкам  

const connection = new signalR.HubConnectionBuilder()
    .withUrl(serverAddressForAnswerAfterSendClaim)
    .configureLogging(signalR.LogLevel.Information)    
    .build();
connection.on("TaskCreate", (info) => {
    //const gameGuid = info["gameGuid"];
    //const sessionGuid = info["sessionGuid"];
    console.log(info); // Сообщение из веб сокета
    var obj = new Object();
    obj["tableData"] = [];
    obj["tableData"][0] = info;
    addRowsToTable(obj);
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



SCRIPT123321;

$titleForThisPage = $stringClaimTable;

$bodyForThisPage = <<<EOTLF123321

<!-- Editable table -->
<div class="contaier pb-3">
  <div class="card p-2 table_background">
    <h3 class="card-header text-left font-weight-bold py-4">Заявки</h3>
    <div class="card-body">
      <div id="table" class="table-editable">
        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success">
          <i class="btn" aria-hidden="true">Добавить</i>
        </a></span>
        <table class="table table-bordered table-responsive-md table-striped text-center">
          <thead>
            <tr>
              <th class="text-center">№</th>
              <th class="text-center">Тип</th>
              <th class="text-center">Адрес</th>
              <th class="text-center">Квартира</th>
              <th class="text-center">Создано</th>
              <th class="text-center">Выполнить до</th>
              <th class="text-center">Статус</th>
              <th class="text-center">Управление</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Editable table -->

EOTLF123321;

include_once("_layerForAuth.inc");
?>