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

const popup = document.getElementById("popup");
const return_btn = document.getElementById("return");

const cgu = document.getElementById("cgu_link");

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    form_connection.addEventListener("submit", sendConnection);
    go_registration.addEventListener("click", goRegistration);
    
    back.addEventListener("click", goRegistration);
    form_registration.addEventListener("submit", sendRegistration);
    cgu.addEventListener("click", pop);
    return_btn.addEventListener("click", unpop);
}

/*------------------------------
Slider general & popup functions
------------------------------*/
function pop(evt) {
    evt.preventDefault();
    popup_bg.classList.remove("hide");
}

function unpop(evt) {
    popup_bg.classList.add("hide");
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
                    slide("Login(s) incorrect(s). Réessayez.", "slider_red");
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
    connection.classList.add("hide");
    registration.classList.remove("hide");
    back.classList.remove("hide");
}

function goBack(evt) {
    connection.classList.remove("hide");
    registration.classList.add("hide");
    back.classList.add("hide");
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
    params["id_avatar"] = document.querySelector("input[name=avatar]:checked").value;
    //AJAX query : registration
    fetch(url, {
            method: "POST",
            body: JSON.stringify(params)
        })
        .then(response => {
            if (response.status == 200) {
                response.json().then(data => {
                    form_registration.reset();
                    goBack(evt);
                    slide("Vous avez été retenu pour la mission. Embarquez dans votre navette !", "slider_green");
                });
            } else if (response.status == 409){
                response.json().then(data => {
                    slide("Ce pseudo existe déjà dans l'univers.", "slider_red");
                });
            } else {
                //Other errors
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