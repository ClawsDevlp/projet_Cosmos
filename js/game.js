/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const game = document.getElementById("game");

const text = document.getElementById("text");
const game_badges = document.getElementById("game_badges");
const badges = document.getElementById("badges");
const inventory = document.getElementById("inventory");
const buttons = document.querySelectorAll("button");
const buttonsPlus = document.querySelectorAll("button:not(:first-child)");

const popup_badge_bg = document.getElementById("popup_badge_bg");
const title_popup_badge = document.getElementById("title_popup_badge");
const img_popup_badge = document.getElementById("img_popup_badge");
const description_popup_badge = document.getElementById("description_popup_badge");
const button_popup_badge = document.getElementById("button_popup_badge");

const music = document.getElementById("music");
const music_img = document.getElementById("music_img");
const fx = document.getElementById("fx");
const fx_img = document.getElementById("fx_img");

var id_game;
var isEnd = 0;

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    //Possibility to make a choice for each button
    for (let button of buttons) {
        button.addEventListener("click", function () {
            text.innerHTML = "";
        });
        button.addEventListener("click", makeChoice);
    }

    //Music & FX
    music_img.addEventListener("click", playMusic);
    fx_img.addEventListener("click", playFX);

    //Popup badge
    button_popup_badge.addEventListener("click", function () {
        popup_badge_bg.classList.add("hide");
    });

    //Creation URL
    let url = new URL("api/game/play_game_begin.php", "http://localhost/projetPHP/");
    //AJAX query : begin a game, take info last or new game
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    id_game = data.id_game;
                    displayGame(data);
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

/*------------------------------
Game
------------------------------*/
//Player make a choice
function makeChoice(evt) {
    evt.preventDefault();

    //Play a FX sound
    fx.currentTime = 0;
    fx.play();

    // Hide all choices buttons
    for (let button of buttons) {
        button.classList.add("hide");
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
                    displayGame(data);
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

//Display game
function displayGame(data) {
    if (!(data.text)) {
        //If end of the game
        buttons[0].innerHTML = "Revenir au menu";
        buttons[0].addEventListener("click", function () {
            window.location.href = "home.php";
        });
        buttons[0].classList.remove("hide");

        //Creation URL and queries
        let params = {};
        params["id_game"] = id_game;

        let url = new URL("api/game/end_game.php", "http://localhost/projetPHP/");
        url.search = new URLSearchParams(params);
        //AJAX query : end game (infos end)
        fetch(url)
            .then(response => {
                if (response.status == 200) {
                    response.json().then(data => {
                        isEnd = 1;
                        text.classList.add("end_text");
                        text.innerHTML = "C'était la fin n°" + data.statistics["nb_end"] + ". Vous avez assisté à " + data.statistics["nb_ends"] + " fin sur 10.";
                        typing(isEnd, text.innerHTML);
                        if (data.badges) {
                            for (let badge of data.badges) {
                                let new_img_badge = document.createElement("img");
                                new_img_badge.dataset.idBadge = badge["id_badge"];
                                new_img_badge.src = badge["link"];
                                new_img_badge.alt = badge["name_badge"];
                                new_img_badge.title = badge["name_badge"] + " : " + badge["description_badge"];
                                badges.appendChild(new_img_badge);
                            }
                            game_badges.classList.remove("hide");
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
        }
        updateGame(data.text["id_text"]);
    }

    //Display inventory
    if (data.objects && data.objects != null) {
        while (inventory.hasChildNodes()) {
            inventory.removeChild(inventory.firstChild);
        }
        for (let objet of data.objects) {
            let new_img_objet = document.createElement("img");
            new_img_objet.alt = objet;
            new_img_objet.title = objet;
            new_img_objet.src = data.objects_link;
            inventory.appendChild(new_img_objet);
        }
    }

}

//Update the game
function updateGame(id_text) {
    //Typing text story
    typing(isEnd);

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

    //Creation URL
    url = new URL("api/profile/add_badges_in_game.php", "http://localhost/projetPHP/");
    //AJAX query : add badges in game
    fetch(url, {
            method: "POST",
            body: JSON.stringify(params)
        })
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    if (data.badges) {
                        for (let badge of data.badges) {
                            pop_badge(badge["id_badge"], badge["name_badge"], badge["description_badge"], badge["link"]);
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

//Typing text story
function typing(isEnd, mytxt) {
    if (isEnd == 0) {
        let txtContent = text.textContent;
        let txtLength = txtContent.length;
        text.innerHTML = "";
        var counter = 0;
        //Displaying text content with prompt effect
        var afficherTexte = setInterval(function () {
            text.innerHTML += (txtContent.charAt(counter));
            counter++;
            if (counter >= txtLength) {
                clearInterval(afficherTexte);
            }
        }, 20);
        //Clearing interval when clicking on the text : display whole text
        if (isEnd == 0) {
            game.addEventListener("click", function (evt) {
                evt.preventDefault();
                var target = evt.target;
                if (target.tagName == "BUTTON") {
                    clearInterval(afficherTexte);
                    text.innerHTML = "";
                } else {
                    clearInterval(afficherTexte);
                    text.innerHTML = txtContent;
                }
            }, false);
        }
        //Special case to display the end screen
    } else {
        window.addEventListener("click", function () {
            clearInterval(afficherTexte);
            text.innerHTML = mytxt;
        });
    }
}

//Popup new badge
function pop_badge(id_badge, nom_badge, description_badge, link_img_badge) {
    popup_badge_bg.classList.remove("hide");
    title_popup_badge.innerHTML = "Nouveau badge obtenu : "+nom_badge+".";
    img_popup_badge.dataset.idBadge = id_badge;
    img_popup_badge.src = link_img_badge;
    img_popup_badge.alt = nom_badge;
    description_popup_badge.innerHTML = description_badge;
}

/*------------------------------
Music & FX
------------------------------*/
//Play or pause the music
function playMusic(evt) {
    if (music.muted == true) {
        music_img.src = "images/Logo_Music.png";
        music.muted = false;
    } else {
        music_img.src = "images/Logo_No_Music.png";
        music.muted = true;
    }
}

//Play or pause the sounds FX
function playFX(evt) {
    if (fx.muted == true) {
        fx_img.src = "images/Logo_FX.png";
        fx.muted = false;
    } else {
        fx_img.src = "images/Logo_No_FX.png";
        fx.muted = true;
    }
}