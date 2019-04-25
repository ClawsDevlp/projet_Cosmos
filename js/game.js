/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const buttons = document.querySelectorAll("button");
const choice1 = document.getElementById("choice1");
const choice2 = document.getElementById("choice2");
const choice3 = document.getElementById("choice3");
const text = document.getElementById("text");

var id_game;
var id_player;

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    
    //Display the first text and the first choices according to the last part corresponding to the player

    //Creation URL and queries
    let params = {};
    params[0] = text.innerHTML;
    console.log(params);

    let url = new URL("api/game/play_game_begin.php", "http://localhost/projetPHP/");
    url.search = new URLSearchParams(params);
    console.log(url);

    //AJAX query
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.choice2 == "") {
                choice2.style.display = "none";
            } else {
                choice2.style.display = "block";
            }
            if (data.choice3 == "") {
                choice3.style.display = "none";
            } else {
                choice3.style.display = "block";
            }

            text.innerHTML = data.text;
            choice1.innerHTML = data.choice1;
            choice2.innerHTML = data.choice2;
            choice3.innerHTML = data.choice3;
            id_game = data.id_game;
            id_player = data.id_player;

        })
        .catch(error => {
            console.log(error);
        });

    //Possibility to make a choice for each button
    for (let button of buttons) {
        button.addEventListener("click", makeChoice);
    }

}

//Player make a choice
function makeChoice(evt) {
    event.preventDefault();

    //Change page if end text
    if (choice1.innerHTML == "Retour au menu !") {
        window.location.href = "home.php";
    }
    //Change texts
    else {
        //Creation URL and queries
        let params = {};
        params["text"] = text.innerHTML;
        params["choice_player"] = evt.target.innerHTML;
        params["id_game"] = id_game;
        params["id_player"] = id_player;
        console.log(params);

        let url = new URL("api/game/play_game.php", "http://localhost/projetPHP/");
        url.search = new URLSearchParams(params);
        console.log(url);

        //AJAX query
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.choice2 == "") {
                    choice2.style.display = "none";
                } else {
                    choice2.style.display = "block";
                }
                if (data.choice3 == "") {
                    choice3.style.display = "none";
                } else {
                    choice3.style.display = "block";
                }
            
                text.innerHTML = data.text;
                choice1.innerHTML = data.choice1;
                choice2.innerHTML = data.choice2;
                choice3.innerHTML = data.choice3;
                id_game = data.id_game;
                id_player = data.id_player;

            })
            .catch(error => {
                console.log(error);
            });
    }
}