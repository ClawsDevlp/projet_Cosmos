/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const buttons = document.querySelectorAll("button");
const choice_1 = document.getElementById("choice_1");
const choice_2 = document.getElementById("choice_2");
const choice_3 = document.getElementById("choice_3");
const story = document.getElementById("story");
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
    params[0] = story.innerHTML;
    console.log(params);

    let url = new URL("api/game/partie_firstText.php", "http://localhost/projetPHP/");
    url.search = new URLSearchParams(params);
    console.log(url);

    //AJAX query
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.answer2 == "") {
                choice_2.style.display = "none";
            } else {
                choice_2.style.display = "block";
            }
            if (data.answer3 == "") {
                choice_3.style.display = "none";
            } else {
                choice_3.style.display = "block";
            }

            story.innerHTML = data.text;
            choice_1.innerHTML = data.answer1;
            choice_2.innerHTML = data.answer2;
            choice_3.innerHTML = data.answer3;
            id_game = data.id_partie;
            id_player = data.id_joueur;

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
    if (choice_1.innerHTML == "Retour au menu !") {
        window.location.href = "home.php";
    }
    //Change texts
    else {
        //Creation URL and queries
        let params = {};
        params[0] = story.innerHTML;
        params[1] = evt.target.innerHTML;
        params[2] = id_game;
        params[3] = id_player;
        console.log(params);

        let url = new URL("api/game/partie_back.php", "http://localhost/projetPHP/");
        url.search = new URLSearchParams(params);
        console.log(url);

        //AJAX query
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.answer2 == "") {
                    choice_2.style.display = "none";
                } else {
                    choice_2.style.display = "block";
                }
                if (data.answer3 == "") {
                    choice_3.style.display = "none";
                } else {
                    choice_3.style.display = "block";
                }
            
                story.innerHTML = data.text;
                choice_1.innerHTML = data.answer1;
                choice_2.innerHTML = data.answer2;
                choice_3.innerHTML = data.answer3;
                id_game = data.id_partie;
                id_player = data.id_joueur;

            })
            .catch(error => {
                console.log(error);
            });
    }
}