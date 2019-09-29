<?php

include_once("settings.php");


$scriptForThisPage = <<<SCRIPT123321


    function uploadFile() {        
        // var xhr = new XMLHttpRequest();                 
        var file = document.getElementById('myfile').files[0];
        // xhr.open("POST", "http://194.1.239.144:9009/api/task/FileUpload");
        // xhr.setRequestHeader("filename", file.name);
        // xhr.send(file);

        console.log(file);

        rawUpload("http://194.1.239.144:9009/api/task/FileUpload", file, file.name);
        
    }

    function rawUpload(url, file, fileName) {
      var reader = new FileReader();
      reader.onload = function(e) {
        fileUpload(url, e.target.result, fileName)
      };
      reader.readAsBinaryString(file);
    }


    function fileUpload(url, fileData, fileName) {
      var fileSize = fileData.length,
        boundary = "xxxxxxxxx",
        uri = url,
        xhr = new XMLHttpRequest();
      
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "multipart/form-data, boundary="+boundary); // simulate a file MIME POST request.
      xhr.setRequestHeader("Content-Length", fileSize);
      xhr.withCredentials = "true";
   
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if ((xhr.status >= 200 && xhr.status <= 200) || xhr.status == 304) {
            
            if (xhr.responseText != "") {
              alert(JSON.parse(xhr.responseText).msg); // display response.
            }
          } else if (xhr.status == 0) {
            alert("Could not parse response because of SOP, but the file was uploaded if you were logged in.");
          }
        }
      }
      
      var body = "--" + boundary + "\\r\\n";
      body += "Content-Disposition: form-data; name=\"contents\"; filename=\"" + fileName + "\"\\r\\n";
      body += "Content-Type: application/octet-stream\\r\\n\\r\\n";
      body += "hgfghfghfghfhghfghfghfgfileData" + "\\r\\n";
      body += "--" + boundary + "--";
      
      xhr.send(body);
      return true;
  }







function uploadFiles(inputId) {
  console.log("File go to server");
  
  var input = document.getElementById(inputId);
  var files = input.files;
  var formData = new FormData();

  for (var i = 0; i != files.length; i++) {
    formData.append("files", files[i]);
  }


  var request = new XMLHttpRequest();
  
  request.open('POST',"http://194.1.239.144:9009/api/task/FileUpload",true);
    
  //request.setRequestHeader('Accept', 'multipart/form-data');
  request.setRequestHeader('Content-Type', 'multipart/form-data');
  //request.setRequestHeader('Content-Length', '20000000');
  
  request.addEventListener('readystatechange', function() {
    if ((request.readyState==4) && (request.status==200)) {
      var answerFromServer = request.responseText;
      sendBtn.classList.add('disabled');
      document.getElementById("alertForSuccessSending").classList.remove("d-none");
      
      var answerParse = JSON.parse(answerFromServer);
      console.log(answerParse); // Ответ на отправленный AJAX

      document.getElementById("alertForSuccessSending").innerHTML +=
        "Заявление успешно зарегистрированно. Отслеживать статус обращения можно по присвоенному ему коду: <strong>" +
        answerParse.data +"</strong>.<br />Воспользуйтесь для этого <a href='ClaimView.php'>специальной страницей</a>.";
    }
  });

  request.send(formData);

  // $.ajax(
  //   {
  //     url: "http://194.1.239.144:9009/api/task/FileUploader",
  //     data: formData,
  //     processData: false,
  //     contentType: false,
  //     type: "POST",
  //     success: function (data) {
  //       alert("Files Uploaded!");
  //       console.log(data);
  //     }
  //   }
  // );
}


const connection = new signalR.HubConnectionBuilder()
    .withUrl(serverAddressForAnswerAfterSendClaim)
    .configureLogging(signalR.LogLevel.Information)    
    .build();
connection.on("TaskCreate", (info) => {
    //const gameGuid = info["gameGuid"];
    //const sessionGuid = info["sessionGuid"];
    console.log(info); // Сообщение из веб сокета
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
      
      var answerParse = JSON.parse(answerFromServer);
      console.log(answerParse); // Ответ на отправленный AJAX

      document.getElementById("alertForSuccessSending").innerHTML +=
        "Заявление успешно зарегистрированно. Отслеживать статус обращения можно по присвоенному ему коду: <strong>" +
        answerParse.data +"</strong>.<br />Воспользуйтесь для этого <a href='ClaimView.php'>специальной страницей</a>.";
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


  <form id="form" name="form" action="http://194.1.239.144:9009/api/task/FileUpload" enctype="multipart/form-data" method="post">
  <div class="buttons">
    <div class="upload-button">
      <div class="label">Click me!</div>
      <input id="files" name="files" type="file" size="1" onchange="uploadFiles('files');" />
    </div>
  </div>
</form>

<form>
    <input type="file" id="myfile"/>  
    <input type="button" onclick="uploadFile();" value="Upload" />
</form>

</div>
</div>

EOTLF123321;
// onchange="uploadFiles('files');
include_once("_layer.inc");
?>