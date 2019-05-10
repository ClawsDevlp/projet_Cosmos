/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const connection = document.getElementById("menu_connection");
const form_connection = document.getElementById("form_connection");
const go_registration = document.getElementById("go_registration");

const registration = document.getElementById("menu_registration");
const form_registration = document.getElementById("form_registration");

const back = document.getElementById("back");

const slider = document.getElementById("slider");
const slider_message = document.getElementById("slider_message");

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    if (typeof connection !== "undefined" && connection !== null) {
        form_connection.addEventListener("submit", sendConnection);
        go_registration.addEventListener("click", goRegistration);
    }
}

/*------------------------------
Slider functions
------------------------------*/
function wrongLoginSlider() {
    slider_message.innerHTML = "Login(s) incorrect(s).";
    slider.style.display = "flex";
}

function accountCreatedSlider() {
    slider_message.innerHTML = "Ton compte à bien été créé.";
    slider.style.display = "flex";
}

function errorAccountCreationSlider(message) {
    slider_message.innerHTML = "Ce pseudo est déjà utilisé.";
    slider.style.display = "flex";
}

/*------------------------------
Menu connection
------------------------------*/
//Send connection
function sendConnection(evt) {
    evt.preventDefault();

    //Creation URL and queries
    let params = {};
    if (form_connection.pseudo.value) params["pseudo"] = form_connection.pseudo.value;
    if (form_connection.pwd.value) params["pwd"] = form_connection.pwd.value;

    let url = new URL("api/identification/connection.php", "http://localhost/projetPHP/");
    url.search = new URLSearchParams(params);

    //AJAX query : connection
    fetch(url)
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    window.location.href = "home.php";
                });
            } else {
                //Error
                response.json().then(data => {
                    console.log(data.message);
                    wrongLoginSlider();
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });
}

/*------------------------------
Menu registration
------------------------------*/
//Go to menu registration
function goRegistration(evt) {
    connection.classList.toggle("hide");
    registration.classList.toggle("hide");
    back.classList.toggle("hide");

    form_registration.addEventListener("submit", sendRegistration);
}

//Send registration
function sendRegistration(evt) {
    evt.preventDefault();

    //Creation URL and queries
    let url = new URL("api/identification/registration.php", "http://localhost/projetPHP/");

    let params = {};
    if (form_registration.pseudo.value) params["pseudo"] = form_registration.pseudo.value;
    if (form_registration.pwd.value) params["pwd"] = form_registration.pwd.value;
    if (form_registration.planete.value) params["planete"] = form_registration.planete.value;
    params["id_avatar"] = form_registration.avatar.value;

    //AJAX query : registration
    fetch(url, {
            method: "POST",
            body: JSON.stringify(params)
        })
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    form_registration.reset();
                    connection.classList.toggle("hide");
                    registration.classList.toggle("hide");
                    accountCreatedSlider();
                });
            } else {
                //Error
                response.json().then(data => {
                    console.log(data.message);
                    errorAccountCreationSlider(data.message);
                });
            }
        })
        //Network error
        .catch(error => {
            console.log(error)
        });
}