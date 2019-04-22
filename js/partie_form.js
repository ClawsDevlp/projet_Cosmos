//Variables
const button = document.querySelectorAll('.button');
const button1 = document.querySelector('#button-1');
const button2 = document.querySelector('#button-2');
const button3 = document.querySelector('#button-3');
const text = document.querySelector('#main-text');
let id_partie;
let id_joueur;

//Fonction pour afficher le premier texte et les premières réponses en fonction de la dernière partie correspondant au joueur
const printFirstValues = () => {
	
	let params = {};

	params[0] = text.innerHTML;
	console.log(params);

	//Création de l'url et de sa query
	//Le second paramètre est la racine du site
	let url = new URL("/projetPHP/src/partie_FirstText.php", "http://localhost");
	url.search = new URLSearchParams(params);
	console.log(url);

	//Requête HTTP GET
	fetch(url)
		.then(response => response.json())
		.then(data => {

			if(data.answer2 == "") {
					button2.style.display="none";
				}
				else {
					button2.style.display="inline";
				}
				if(data.answer3 == "") {
					button3.style.display="none";
				}
				else {
					button3.style.display="inline";
				}
				
				text.innerHTML = data.text;
				button1.innerHTML = data.answer1;
				button2.innerHTML = data.answer2;
				button3.innerHTML = data.answer3;
				id_partie = data.id_partie;
				id_joueur = data.id_joueur;
			
		})
		.catch(error => { console.log(error); });	
}

//Exécute la fonction
printFirstValues();

//Ajoute des events à chaque bouton
for (var i = 0; i < button.length; i++){  
	button[i].addEventListener('click', event => changeTexts(event));  
}

//Fonction pour modifier les textes et les réponses
const changeTexts = event => {
	event.preventDefault(); //évite de recharger la page

	//Si c'est le texte de fin alors on recharge/change de page
	if(button1.innerHTML == "Retour au menu !") {
		window.location.href = "partie_home.html";
	}
	else {
		let params = {};

		params[0] = text.innerHTML;
		params[1] = event.target.innerHTML;
		params[2] = id_partie;
		params[3] = id_joueur;
		console.log(params);

		//Création de l'url et de sa query
		//Le second paramètre est la racine du site
		let url = new URL("/projetPHP/src/partie.php", "http://localhost");
		url.search = new URLSearchParams(params);
		console.log(url);

		//Requête HTTP GET 
		fetch(url)
			.then(response => response.json())
			.then(data => {

				if(data.answer2 == "") {
					button2.style.display="none";
				}
				else {
					button2.style.display="inline";
				}
				if(data.answer3 == "") {
					button3.style.display="none";
				}
				else {
					button3.style.display="inline";
				}
				

				text.innerHTML = data.text;
				button1.innerHTML = data.answer1;
				button2.innerHTML = data.answer2;
				button3.innerHTML = data.answer3;
				id_partie = data.id_partie;
				id_joueur = data.id_joueur;

			})
			.catch(error => { console.log(error); });	
	}
}