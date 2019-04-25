/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const buttons = document.querySelectorAll("button");
const text = document.getElementById("text");

var id_game;

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    //Possibility to make a choice for each button
    for (let button of buttons) {
        button.classList.add("hide");
        button.addEventListener("click", makeChoice);
    }

    //Creation URL
    let url = new URL("api/game/play_game_begin.php", "http://localhost/projetPHP/");

    //AJAX query : begin a game, take info last or new game
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    id_game = data.id_game;
                    if (!(data.text)) {
                        //If end of the game
                        buttons[0].classList.remove("hide");
                        buttons[0].innerHTML = "Revenir au menu";
                        buttons[0].addEventListener("click", function () {
                            window.location.href = "home.php";
                        });
                        text.innerHTML = "C'était la fin n°. Vous avez assisté à fin sur 10.";
                    } else if (!(data.choices)) {
                        //If no choices
                        buttons[0].classList.remove("hide");
                        buttons[0].dataset.idChoice = 0;
                        buttons[0].innerHTML = "Suivant";
                        text.innerHTML = data.text["text_content"];
                    } else {
                        //If choices
                        for (let i in data.choices) {
                            buttons[i].classList.remove("hide");
                            buttons[i].dataset.idChoice = data.choices[i]["id_choice"];
                            buttons[i].innerHTML = data.choices[i]["text_choice"];
                            text.innerHTML = data.text["text_content"];
                        }
                    }

                });
            } else {
                //Error
                response.json().then(data => {
                    console.log(data.message);
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });
}

//Player make a choice
function makeChoice(evt) {
    event.preventDefault();

    for (let button of buttons) {
        button.classList.add("hide");
        button.addEventListener("click", makeChoice);
    }

    //Creation URL and queries
    let params = {};
    params["choice_player"] = evt.target.dataset.idChoice;
    params["id_game"] = id_game;

    let url = new URL("api/game/play_game.php", "http://localhost/projetPHP/");
    url.search = new URLSearchParams(params);

    //AJAX query : play a game, pick up choice(s) and text
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    if (!(data.text)) {
                        //If end of the game
                        buttons[0].classList.remove("hide");
                        buttons[0].innerHTML = "Revenir au menu";
                        buttons[0].addEventListener("click", function () {
                            window.location.href = "home.php";
                        });
                        text.innerHTML = "C'était la fin n°. Vous avez assisté à fin sur 10.";
                    } else if (!(data.choices)) {
                        //If no choices
                        buttons[0].classList.remove("hide");
                        buttons[0].dataset.idChoice = 0;
                        buttons[0].innerHTML = "Suivant";
                        text.innerHTML = data.text["text_content"];
                        updateGame(data.text["id_text"]);
                    } else {
                        //If choices
                        for (let i in data.choices) {
                            buttons[i].classList.remove("hide");
                            buttons[i].dataset.idChoice = data.choices[i]["id_choice"];
                            buttons[i].innerHTML = data.choices[i]["text_choice"];
                            text.innerHTML = data.text["text_content"];
                            updateGame(data.text["id_text"]);
                        }
                    }
                });
            } else {
                //Error
                response.json().then(data => {
                    console.log(data.message);
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });
}

//Update the game
function updateGame(id_text) {
    //Creation URL and queries
    let url = new URL("api/game/update_game.php", "http://localhost/projetPHP/");

    let params = {};
    params["id_text"] = id_text;
    params["id_game"] = id_game;

    //AJAX query : update a game, insert new text according to player and game
    fetch(url, {
            method: "PUT",
            body: JSON.stringify(params)
        })
        .then(response => {
            if (response.status != 200) {
                //Error
                response.json().then(data => {
                    console.log(data.message);
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });
}