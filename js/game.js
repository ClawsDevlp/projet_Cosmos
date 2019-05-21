/*------------------------------
General
------------------------------*/
"use strict"; //Force to declare any variable used

const text = document.getElementById("text");
const game_badges = document.getElementById("game_badges");
const badges = document.getElementById("badges");
const inventory = document.getElementById("inventory");
const buttons = document.querySelectorAll("button");
const buttonsPlus = document.querySelectorAll("button:not(:first-child)");

const current_badge = document.getElementById("popup_badge");
const current_badge_content = document.getElementById("contenu_popup");
const img_popup = document.getElementById("img_popup");

const music_button = document.querySelector('#music_button');
const music_img = document.querySelector('#music_img');
const fx_button = document.querySelector('#fx_button');
const fx_img = document.querySelector('#fx_img');

var isEnd = 0;
var id_game;

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
	isEnd = 0;
    console.log(buttonsPlus);
    //Possibility to make a choice for each button
    for (let button of buttons) {
		button.addEventListener("click", function(){
			text.innerHTML = "";
		});
        button.addEventListener("click", makeChoice);
    }
    for (let button of buttonsPlus) {
        button.classList.add("hide");
    }

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

//Player make a choice
function makeChoice(evt) {
	
    event.preventDefault();

    //Play a little sound FX
    document.querySelector('#button_sound').play();

    for (let button of buttonsPlus) {
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
					//console.log(data);
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
						console.log("C'est la finnn");
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
		if(data.badges_popup != undefined){
			pop_badge(data.badges_popup["nom_badge"], data.badges_popup["link"]);
		}
        //If no choices
        buttons[0].dataset.idChoice = 0;
        buttons[0].innerHTML = "Suivant";
        text.innerHTML = data.text["text_content"];
        updateGame(data.text["id_text"]);
    } else {
		if(data.badges_popup != undefined){
			pop_badge(data.badges_popup["nom_badge"], data.badges_popup["link"]);
		}
        //If choices
        for (let i in data.choices) {
            buttons[i].classList.remove("hide");
            buttons[i].dataset.idChoice = data.choices[i]["id_choice"];
            buttons[i].innerHTML = data.choices[i]["text_choice"];
			
            text.innerHTML = data.text["text_content"];
        }
        updateGame(data.text["id_text"]);
    }
	
	

    if(data.objects && data.objects != null){
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
	
	typing(isEnd);
    //Creation URL and queries
    let url = new URL("api/game/update_game.php", "http://localhost/projetPHP/");

    let params = {};
    params["id_text"] = id_text;
    params["id_game"] = id_game;
	
    //AJAX query : update a game, insert new text according to player and game
	//Display popup if an achivement has been obtained
	
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
	
	
    url = new URL("api/profile/add_badges_in_game.php", "http://localhost/projetPHP/");	
	
	
    //AJAX query : add badges in game
    fetch(url, {
            method: "POST",
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

function typing(isEnd, mytxt){
	//console.log(isEnd);
	if(isEnd == 0){	
		let txtContent = text.textContent;
		let txtLength = txtContent.length;
		//Empty text content
		text.innerHTML = "";
		var counter = 0;
		
		//Displaying text content with prompt effect
		var afficherTexte = setInterval(function(){
			text.innerHTML += (txtContent.charAt(counter));
			counter++;
			if(counter >= txtLength){
				clearInterval(afficherTexte);
			}
			
		},20);
		
		//Clearing interval when clicking on the text : display whole text
		if(isEnd == 0){ 
			document.addEventListener('click', function(e) {
				var target = e.target;
				if(target.tagName == "BUTTON"){
					clearInterval(afficherTexte);
					text.innerHTML = "";
				}else{
					clearInterval(afficherTexte);
					text.innerHTML = txtContent;
				}
			}, false);
		}
	//special case to display the end screen	
	//special case to display the end screen	
	}else{
		window.addEventListener("click",function(){
			clearInterval(afficherTexte);
			text.innerHTML = mytxt;
		});
	}
}

function pop_badge(nom_badge , link_img) {
	current_badge.style.display = "block";
    current_badge.classList.add("popup_animation");
	current_badge_content.innerHTML = "Nouveau badge obtenu : " + nom_badge;
	img_popup.innerHTML = "<img src = '" + link_img + "' alt =/>" 
}

function closePopup(){
	current_badge.style.display = "none";
}

document.getElementById("pop_button").addEventListener("click", function(e){
	e.preventDefault;
	closePopup();
});

//Play or pause the music
music_button.addEventListener('click', evt => {
    evt.preventDefault();
    const music = document.querySelector('#music');

    if(music.paused) {
        music_img.src = "images/Logo_Music.png";
        music.play();
    }
    else {
        console.log("Mise en pause");
        music_img.src = "images/Logo_No_Music.png";
        music.pause();
    }

});

//Play or pause the sounds FX
fx_button.addEventListener('click', evt => {
    evt.preventDefault();
    const fx = document.querySelector('#button_sound');

    if(fx.muted == true) {
        fx_img.src = "images/Logo_FX.png";
        fx.muted = false;      
    }
    else {
        fx_img.src = "images/Logo_No_FX.png";
        fx.muted = true;  
    }
});