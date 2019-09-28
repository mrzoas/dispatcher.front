"use strict"; //All my JavaScript written in Strict Mode http://ecma262-5.com/ELS5_HTML.htm#Annex_C


var socket = null;

function reconnectToDB(serverAddress) {
    socket = new WebSocket(serverAddress);
    socket.onopen = connectionOpen;
    socket.onmessage = messageReceived;
    socket.onerror = errorSocket;
}

function sendMessage(message) {
    if (notnull(socket)) {
        socket.send(message);
        console.log("Серверу отправлено сообдение \"" + message + "\"");
    }
    else console.log("Соединение с ервером ещё не произошло");
};

function connectionOpen() {
    console.log("Подключились к серверу");
    //socket.send("Connection with \""+document.getElementById("sock-addr").value+"\" Подключение установлено обоюдно, отлично!");
 }

function messageReceived(e) {
    console.log("Ответ сервера: " + e.data);
    //document.getElementById("sock-info").innerHTML += (e.data+"<br />");
}

function connectionClose() {
    socket.close();
    console.log("Соединение с сервером закрыто");
}


function errorSocket(error) {
    console.log("Ошибка " + error.message);
};


// (function () {
//     // ======== private vars ========
// 	var socket;

//     ////////////////////////////////////////////////////////////////////////////
//     var init = function () {
		
// 		socket = new WebSocket(document.getElementById("sock-addr").value);

// 		socket.onopen = connectionOpen; 
// 		socket.onmessage = messageReceived; 
// 		//socket.onerror = errorOccurred; 
// 		//socket.onopen = connectionClosed;

//         document.getElementById("sock-send-butt").onclick = function () {
//             socket.send(document.getElementById("sock-msg").value);
//         };


//         document.getElementById("sock-disc-butt").onclick = function () {
//             connectionClose();
//         };

//         document.getElementById("sock-recon-butt").onclick = function () {
//             socket = new WebSocket(document.getElementById("sock-addr").value);
//             socket.onopen = connectionOpen;
//             socket.onmessage = messageReceived;
//         };

//     };


// 	function connectionOpen() {
// 	   socket.send("Connection with \""+document.getElementById("sock-addr").value+"\" Подключение установлено обоюдно, отлично!");
// 	}

// 	function messageReceived(e) {
// 	    console.log("Ответ сервера: " + e.data);
//         document.getElementById("sock-info").innerHTML += (e.data+"<br />");
// 	}

//     function connectionClose() {
//         socket.close();
//         document.getElementById("sock-info").innerHTML += "Соединение закрыто <br />";

//     }


//     return {
//         ////////////////////////////////////////////////////////////////////////////
//         // ---- onload event ----
//         load : function () {
//             window.addEventListener('load', function () {
//                 init();
//             }, false);
//         }
//     }
// })().load();