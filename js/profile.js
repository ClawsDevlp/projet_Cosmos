/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const pseudo = document.getElementsByName("pseudo")[0];
const mail = document.getElementsByName("mail")[0];
const avatars = document.querySelector("#form_profile .avatar_choice");

const nb_ends = document.getElementById("nb_ends");
const nb_games = document.getElementById("nb_games");

const info_badges = document.getElementById("info_badges");

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

    //Creation URL and queries
    url = new URL("api/profile/have_profile.php", "http://localhost/projetPHP/");

    //AJAX query : have profile
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    pseudo.value = data.player.pseudo;
                    mail.value = data.player.mail;
                    avatars.querySelector("input[value='avatar_" + data.player.id_avatar + "']").checked = true;

                    nb_ends.innerHTML = data.statistics.nb_ends;
                    nb_games.innerHTML = data.statistics.nb_games;
                    for (let badge of data.badges) {
                        let img_badge = info_badges.querySelector("img[data-idBadge='" + badge["id_badge"] + "']");
                        if (img_badge) {
                            img_badge.src = badge["link"];
                            img_badge.title = badge["name_badge"]+" : "+badge["description_badge"];
                        } else {
                            let new_img_badge = document.createElement("img");
                            new_img_badge.dataset.idBadge = badge["id_badge"];
                            new_img_badge.src = badge["link"];
                            new_img_badge.alt = badge["name_badge"];
                            new_img_badge.title = badge["name_badge"]+" : "+badge["description_badge"];
                            info_badges.appendChild(new_img_badge);
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