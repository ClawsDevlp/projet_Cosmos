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
var id_game;

/*------------------------------
Initialisation
------------------------------*/
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    console.log(buttonsPlus);
    //Possibility to make a choice for each button
    for (let button of buttons) {
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
                        text.innerHTML = "C'était la fin n°" + data.statistics["nb_end"] + ". Vous avez assisté à " + data.statistics["nb_ends"] + " fin sur 10.";
						typing();
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
        buttons[0].dataset.idChoice = 0;
        buttons[0].innerHTML = "Suivant";
        text.innerHTML = data.text["text_content"];
        updateGame(data.text["id_text"]);
		//console.log("suivant");
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

    if(data.objects && data.objects != null){
        while (inventory.hasChildNodes()) {
            inventory.removeChild(inventory.firstChild);
        } 
        for (let objet of data.objects) {
            let new_img_objet = document.createElement("img");
            new_img_objet.src = "http://placehold.it/50x50/ff69B4/fff&text=1";
            new_img_objet.alt = objet;
            new_img_objet.title = objet;
            inventory.appendChild(new_img_objet);
        }
    }
}

//Update the game
function updateGame(id_text) {
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

    url = new URL("api/profile/add_badges_in_game.php", "http://localhost/projetPHP/");
	
	//sets typing effects on text
	typing();

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

function typing(){

	let txtContent = text.textContent;
	let txtLength = txtContent.length;
	//Empty text content
	text.innerHTML = "";
	var counter = 0;
	
	//Displaying text content with prompt effect
	var afficherTexte = setInterval(function(){
		text.innerHTML += (txtContent.charAt(counter) +"<div id='trait'>A</div>");
		counter++;
		if(counter >= txtLength){
			clearInterval(afficherTexte);
		}
		let trait = document.querySelector("#trait");
		trait.parentNode.removeChild(trait);
	},20);
	
	//Clearing interval when clicking on the text : display whole text
	window.addEventListener("click",function(){
		clearInterval(afficherTexte);
		text.innerHTML = txtContent;
	});
	
	//Clearing interval when clicking on buttons to prevent texts from mixing
	buttons.forEach(e => {
		e.addEventListener("click", function(){
			clearInterval(afficherTexte);
		});
	})
}