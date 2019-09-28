const connection = new signalR.HubConnectionBuilder()
    .withUrl("http://localhost:5000/hub")
    .configureLogging(signalR.LogLevel.Information)    
    .build();
connection.on("SetValue", (info) => {
    const gameGuid = info["gameGuid"];
    const sessionGuid = info["sessionGuid"];
    const currentSession = document.getElementById("sessionGuid").value;
    const currentGame = document.getElementById("gameGuid").value;
    //проверка принадлежности события нам происходит на клиенте, это плохо, 
    //так как все ловят события всех и узнают лишние токены сессий и прочее
    //надо переносить на сервер
    if (gameGuid === currentGame && currentSession !== sessionGuid) {
        const ri = info["row"];
        const ci = info["column"];
        const value = info["value"];
        var cellIndex = ri * 9 + ci + 1;
        const cellId = "cell" + cellIndex;
        console.log(ri);
        console.log(ci);
        console.log(cellId);
        const cellElement = document.getElementById(cellId);
        cellElement.value = value;
        cellElement.disabled = true;
        cell.style.color = "green";
    }
});
document.getElementById("createButton").addEventListener("click", event => {
    createGame();
    event.preventDefault();
});
document.getElementById("joinButton").addEventListener("click", event => {
    listGame();
    event.preventDefault();
});
document.getElementById("addResButton").addEventListener("click", event => {
    addResult();
    event.preventDefault();
});
document.getElementById("topButton").addEventListener("click", event => {
    openInNewTab("/top");
    event.preventDefault();
});
for (var i = 0; i < 9; i++) {
    for (var j = 0; j < 9; j++) {
        var cellIndex = i * 9 + j + 1;
        document.getElementById("cell" + cellIndex).addEventListener("change", event => {
            var cell = getTarget(event);
            console.info(cell.id);
            console.info("cell value changed");
            var ri = cell.getAttribute("ri");
            var ci = cell.getAttribute("ci");
            var value = cell.value;
            cell.disabled = true;
            cell.style.color = "red";
            setValue(ri, ci, value);
            event.preventDefault();
        });
    }
}
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

function setValue(ri, ci, value) {
    const user = document.getElementById("userInput").value;
    //const gameGuid = trim(document.getElementById("gameGuid").value, '"');
    //const sessionGuid = trim(document.getElementById("sessionGuid").value, '"');
    const gameGuid = document.getElementById("gameGuid").value;
    const sessionGuid = document.getElementById("sessionGuid").value;
    console.log(gameGuid);
    var valueInfo = {
        GameGuid: gameGuid, UserName: { Name: user, SessionGuid: sessionGuid }, Row: ri, Column: ci, Value: value };
    var req = getXmlHttp();
    req.onreadystatechange = function () {
        // onreadystatechange активируется при получении ответа сервера
        if (req.readyState == 4) {
            // если запрос закончил выполняться
            if (req.status == 200) {
                // если статус 200 (ОК) - выдать ответ пользователю
                const result = JSON.parse(req.responseText);
                const i = result["row"];
                const j = result["column"];
                const cellIndex = i * 9 + j + 1;
                const cell = document.getElementById("cell" + cellIndex);
                if (result["state"] !== "OK") {
                    cell.disabled = false;
                    cell.value = null;
                }
                else {
                    cell.style.color = "green";
                }
            }
            else
            {
                cell.disabled = false;
                cell.value = null;
            }
        }
    }
    req.open('POST', 'http://localhost:5000/api/game/setvalue', true);
    req.setRequestHeader('Accept', 'application/json');
    req.setRequestHeader('Content-Type', 'application/json');
    req.send(JSON.stringify(valueInfo));  // отослать запрос
}
function createGame() {
    const user = document.getElementById("userInput").value;
    var createInfo = { Author: { name: user } };
    var req = getXmlHttp();
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            if (req.status == 200) {
                //alert("Ответ сервера: " + req.responseText);
                const listElement = document.getElementById("gameList");
                listElement.hidden = true;
                const result = JSON.parse(req.responseText);
                const gameGuid = result["gameGuid"];
                const sessionGuid = result["sessionGuid"];
                document.getElementById("gameGuid").value = gameGuid;
                document.getElementById("sessionGuid").value = sessionGuid;
                for (var i = 0; i < 9; i++) {
                    for (var j = 0; j < 9; j++) {
                        const cellIndex = i * 9 + j + 1;
                        const cell = document.getElementById("cell" + cellIndex);
                        cell.value = null;
                        cell.disabled = false;
                        cell.style.color = "black";
                    }
                }

                showGameSpace();
            }
        }
    }
    req.open('POST', 'http://localhost:5000/api/game/create', true);
    req.setRequestHeader('Accept', 'application/json');
    req.setRequestHeader('Content-Type', 'application/json');
    req.send(JSON.stringify(createInfo));  // отослать запрос
}

function listGame() {
    var req = getXmlHttp();
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            if (req.status == 200) {
                const listElement = document.getElementById("gameList"); 
                const gameElement = document.getElementById("gameSpace");
                gameElement.hidden = true;
                const result = JSON.parse(req.responseText);
                console.log(result.length);
                deleteChilds(listElement);
                for (var i = 0; i < result.length; i++) {
                    const tr = document.createElement("tr");
                    listElement.appendChild(tr);
                    const tdGuid = document.createElement("td");
                    tdGuid.hidden = true;
                    tdGuid.textContent = result[i]["gameGuid"];
                    tr.appendChild(tdGuid);
                    const tdAuthName = document.createElement("td");
                    tdAuthName.textContent = result[i]["authorName"];
                    tr.appendChild(tdAuthName);
                    const tdTime = document.createElement("td");
                    tdTime.textContent = result[i]["startTime"];
                    tr.appendChild(tdTime);
                    const tdButton = document.createElement("td");
                    const button = document.createElement("input");
                    button.setAttribute("type", "button");
                    button.setAttribute("value", "Присоединиться"); 
                    button.setAttribute("gameguid", result[i]["gameGuid"]); 
                    button.addEventListener("click", event => {
                        const button = getTarget(event);
                        const gameGuid = button.getAttribute("gameguid");
                        document.getElementById("gameList").hidden = true;
                        joinGame(gameGuid);
                        event.preventDefault();
                    });
                    tdButton.appendChild(button);
                    tr.appendChild(tdButton);
                }
                listElement.hidden = false;
            }
        }
    }
    req.open('GET', 'http://localhost:5000/api/game/list', true);
    req.setRequestHeader('Accept', 'application/json');
    req.setRequestHeader('Content-Type', 'application/json');
    req.send();  // отослать запрос
}
function joinGame(gameGiud) {
    const user = document.getElementById("userInput").value;
    var joinInfo = { user: { name: user }, gameGuid: gameGiud };
    var req = getXmlHttp();
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            if (req.status == 200) {
                const result = JSON.parse(req.responseText);
                const gameGuid = result["gameGuid"];
                const sessionGuid = result["sessionGuid"];
                document.getElementById("gameGuid").value = gameGuid;
                document.getElementById("sessionGuid").value = sessionGuid;
                const state = result["data"];
                for (var i = 0; i < 9; i++) {
                    for (var j = 0; j < 9; j++) {                        
                        const cellIndex = i * 9 + j + 1;
                        const cell = document.getElementById("cell" + cellIndex);
                        cell.value = state[i][j]; if (state[i][j] != null) {
                            cell.disabled = true;
                            cell.style.color = "green";
                        }
                    }
                }
                showGameSpace();
            }
        }
    }
    req.open('POST', 'http://localhost:5000/api/game/join', true);
    req.setRequestHeader('Accept', 'application/json');
    req.setRequestHeader('Content-Type', 'application/json');
    req.send(JSON.stringify(joinInfo));  // отослать запрос
}
function addResult() {
    const user = document.getElementById("userInput").value;
    const wins = document.getElementById("winCount").value;
    var resultInfo = { userName: user , winCount: wins };
    var req = getXmlHttp();
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            if (req.status == 200) {
                alert("Гоу в топ");
            }
        }
    }
    req.open('POST', 'http://localhost:5000/api/game/addresult', true);
    req.setRequestHeader('Accept', 'application/json');
    req.setRequestHeader('Content-Type', 'application/json');
    req.send(JSON.stringify(resultInfo));  // отослать запрос
}
function showGameSpace() {
    const gameElement = document.getElementById("gameSpace");
    gameElement.hidden = false;
}
function getXmlHttp() {
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function getTarget(e) {
    e = e || window.event;
    return (e.target || e.srcElement);
};
function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}
function deleteChilds(node) {
    while (node.firstChild) {
        node.removeChild(node.firstChild);
    }
}