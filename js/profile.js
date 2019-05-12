/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const form_profile = document.getElementById("form_profile");
const pseudo = document.getElementsByName("pseudo")[0];
const planete = document.getElementsByName("planete")[0];
const avatars = document.querySelector("#form_profile .avatar_choice");

const nb_ends = document.getElementById("nb_ends");
const nb_games = document.getElementById("nb_games");

const info_badges = document.getElementById("info_badges");

const popup = document.getElementById("popup"); 
const validate_btn = document.getElementById("validate");
const cancel_btn = document.getElementById("cancel");

const slider = document.getElementById("slider");
const slider_message = document.getElementById("slider_message");

/*------------------------------
Popup functions
------------------------------*/
let isAimated=false;
function pop(evt) {
    evt.preventDefault();
    popup.style.display="flex";
    popup.classList.add("popup_animation");
}

function unpop(evt) {
    evt.preventDefault();
    popup.classList.remove("popup_animation");
    popup.style.display="none";
}

function wrongPwd() {
    isAimated=true;
    slider_message.innerHTML = "Mot de passe incorrect.";
    slider.classList.add("slider_animation");
    
    window.setTimeout(function() {
        slider.classList.remove("slider_animation");
        isAnimated = false;
    }, 5000)    
}


/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    //Creation URL and queries
    let url = new URL("api/profile/add_badges.php", "http://localhost/projetPHP/");

    //AJAX query : add badges
    fetch(url, {
            method: "POST"
        })
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    console.log(data.message);
                });
            }else{
                //Error
                response.json().then(data => {
                    console.log(data);
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });

    //Creation URL and queries
    url = new URL("api/profile/have_profile.php", "http://localhost/projetPHP/");

    //AJAX query : have profile
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    pseudo.value = data.player.pseudo;
                    planete.value = data.player.planete;
                    avatars.querySelector("input[value='"+ data.player.id_avatar+"']").checked = true;
                    
                    if (data.statistics) {
                        nb_ends.innerHTML = data.statistics.nb_ends;
                        nb_games.innerHTML = data.statistics.nb_games;
                    }
                    if (data.badges) {
                        for (let badge of data.badges) {
                            let img_badge = info_badges.querySelector("img[data-idBadge='" + badge["id_badge"] + "']");
                            if (img_badge) {
                                img_badge.src = badge["link"];
                                img_badge.title = badge["name_badge"] + " : " + badge["description_badge"];
                            } else {
                                let new_img_badge = document.createElement("img");
                                new_img_badge.dataset.idBadge = badge["id_badge"];
                                new_img_badge.src = badge["link"];
                                new_img_badge.alt = badge["name_badge"];
                                new_img_badge.title = badge["name_badge"] + " : " + badge["description_badge"];
                                info_badges.appendChild(new_img_badge);
                            }
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

    form_profile.addEventListener("submit", pop);
    validate_btn.addEventListener("click", sendUpdateProfile);
    cancel_btn.addEventListener("click", unpop);
}

//Send update profile
function sendUpdateProfile(evt) {
    evt.preventDefault();

    //Creation URL and queries
    let url = new URL("api/profile/update_profile.php", "http://localhost/projetPHP/");

    let params = {};
    if (form_profile.pseudo.value) params["pseudo"] = form_profile.pseudo.value;
    if (form_profile.pwd.value) params["pwd"] = form_profile.pwd.value;
    params["avatar"] = form_profile.avatar.value;
    if (form_profile.planete.value) params["planete"] = form_profile.planete.value;

    //AJAX query : registration
    fetch(url, {
            method: "PUT",
            body: JSON.stringify(params)
        })
        .then(response => {
            if (response.status != 200) {
                response.json().then(data => {
                    console.log(data.message);
                });
            }else{
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