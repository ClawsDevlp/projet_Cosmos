/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const log_out = document.getElementById("log_out");
const start_game = document.getElementById("start_game");
const go_profile = document.getElementById("go_profile");
const avatar = document.getElementById("avatar");

const popup = document.getElementById("popup"); 
const popup_bg = document.getElementById("popup_bg");
const validate_btn = document.getElementById("validate");
const cancel_btn = document.getElementById("cancel");

/*------------------------------
Popup functions
------------------------------*/
function pop(evt) {
    evt.preventDefault();
    popup.style.display="flex";
    popup_bg.style.display="flex";
    popup.classList.add("popup_animation");
    validate_btn.style = "width: 200px; margin: 25px;";
    cancel_btn.style = "width: 200px; margin: 25px;";
}

function unpopAndContinueGame(evt) {
    evt.preventDefault();
    popup.classList.remove("popup_animation");
    popup.style.display="none";
    popup_bg.style.display="none";
    window.location.href = "game.php";
    validate_btn.style = "";
    cancel_btn.style = "";
}

function unpopAndRestartGame(evt) {
    evt.preventDefault();
    popup.classList.remove("popup_animation");
    popup.style.display="none";
    popup_bg.style.display="none";
    validate_btn.style = "";
    cancel_btn.style = "";
    createGame();
}

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    //Creation URL
    let url = new URL("api/profile/have_avatar.php", "http://localhost/projetPHP/");

    //AJAX query : have avatar
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    avatar.dataset.idAvatar = data.id_avatar;
                    avatar.src = data.link;
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
    
    log_out.addEventListener("click", logOut);
    go_profile.addEventListener("click", function () {
        window.location.href = "profile.php";
    });
    start_game.addEventListener("click", startGame);
}

function logOut(evt) {
    event.preventDefault();

    //Creation URL
    let url = new URL("api/identification/deconnection.php", "http://localhost/projetPHP/");

    //AJAX query
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    window.location.href = "index.php";
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

function startGame(evt) {
    event.preventDefault();
    pop(evt);

    //Creation URL
    let url = new URL("api/game/play_game_begin.php", "http://localhost/projetPHP/");

    //AJAX query
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    if (data.id_game) {
                       /* if (confirm("Souhaitez-vous reprendre votre aventure là où vous vous étiez arrêté.e ?")) {
                            window.location.href = "game.php";
                        } else {
                            createGame();
                        }*/
                        validate_btn.addEventListener("click", unpopAndContinueGame);
                        cancel_btn.addEventListener("click", unpopAndRestartGame);
                    } else {
                        createGame();
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

// reate a new game
function createGame() {
    //Creation URL
    let url = new URL("api/game/create_game.php", "http://localhost/projetPHP/");

    //AJAX query
    fetch(url, {
            method: "POST"
        })
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    window.location.href = "game.php";
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