/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const home = document.getElementById("home");

const log_out = document.getElementById("log_out");
const start_game = document.getElementById("start_game");
const go_profile = document.getElementById("go_profile");
const pseudo = document.getElementById("pseudo");
const avatar = document.getElementById("avatar");

const popup_bg = document.getElementById("popup_bg");
const validate_btn = document.getElementById("validate");
const validate_no_btn = document.getElementById("validate_no");
const cancel_btn = document.getElementById("cancel");

const slider = document.getElementById("slider");

/*------------------------------
Popup general & slider functions
------------------------------*/
function pop() {
    popup_bg.classList.remove("hide");
}

function unpop() {
    popup_bg.classList.add("hide");
}

function continueGame() {
    window.location.href = "game.php";
}

function restartGame() {
    createGame();
}

function slide(message, color) {
    slider.className = "";
    slider.classList.add(color);
    slider_message.innerHTML = message;
    window.requestAnimationFrame(function (time) {
        window.requestAnimationFrame(function (time) {
            slider.classList.add("slider_animation");
        });
    });
}

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    //Creation URL
    let url = new URL("api/profile/have_infos_player.php", "http://localhost/projetPHP/");

    //AJAX query : have avatar
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    pseudo.innerHTML = data.pseudo;
                    avatar.dataset.idAvatar = data.id_avatar;
                    avatar.src = data.link;
                    home.classList.remove("hide");
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
    
    testPreviousPage();
    log_out.addEventListener("click", logOut);
    go_profile.addEventListener("click", function () {
        window.location.href = "profile.php";
    });
    start_game.addEventListener("click", startGame);
}

// Test previous page to show connection slider
function testPreviousPage() {
    if((document.referrer).substr(-9) == "index.php") {
        slide("Vous êtes maintenant dans votre navette. Que voulez-vous faire ?", "slider_green");
    }  
}

/*------------------------------
Deconnection
------------------------------*/
function logOut(evt) {
    event.preventDefault();

    //Creation URL
    let url = new URL("api/identification/deconnection.php", "http://localhost/projetPHP/");
    //AJAX query : deconnect the player
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

/*------------------------------
Start the game
------------------------------*/
function startGame(evt) {
    event.preventDefault();

    //Creation URL
    let url = new URL("api/game/check_new_game.php", "http://localhost/projetPHP/");
    //AJAX query : look if create new game
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    if (data.id_game && data.text.id_text > 4 && data.text.nb_end == null) {
                        pop(evt);
                        validate_btn.addEventListener("click", continueGame);
                        validate_no_btn.addEventListener("click", restartGame);
                        cancel_btn.addEventListener("click", unpop);
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

// Create a new game
function createGame() {

    //Creation URL
    let url = new URL("api/game/create_game.php", "http://localhost/projetPHP/");
    //AJAX query : create a new game
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