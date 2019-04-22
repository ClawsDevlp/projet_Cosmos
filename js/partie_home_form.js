const button = document.querySelectorAll('.button');
const startButton = document.querySelector('#button-start');
const profileButton = document.querySelector('#button-profile');
let dataContent = "";

//Listeners
startButton.addEventListener('click', event => startGame(event));
profileButton.addEventListener('click', event => goToProfile(event));

//Aller sur la page de profil
const goToProfile = event => {
	event.preventDefault(); //évite de recharger la page
	window.location.href = "profile.html";
}

//Lancer une partie
const startGame = event => {
	event.preventDefault(); //évite de recharger la page

	let params = {};

	params[0] = "Me réveiller";
	console.log(params);

	//Création de l'url et de sa query
	//Le second paramètre est la racine du site
	let url = new URL("/projetPHP/src/partie_home.php", "http://localhost");
	url.search = new URLSearchParams(params);
	console.log(url);

	//Requête HTTP GET
	fetch(url)
		.then(response => response.json())
		.then(data => {

			dataContent = data.content;

			if(dataContent == "Reprendre ?") {
				if(confirm("Souhaitez-vous reprendre votre aventure là où vous vous étiez arrêté.e ?!")) {
					let params = {};

					params[0] = "OK";
					console.log(params);

					//Création de l'url et de sa query
					//Le second paramètre est la racine du site
					let url = new URL("/projetPHP/src/partie_home.php", "http://localhost");
					url.search = new URLSearchParams(params);
					console.log(url);

					//Requête HTTP GET 
					fetch(url)
						.then(response => response.json())
						.then(data => {

							dataContent = data.content;

						})
						.catch(error => { console.log(error); });
				}
				else {
					let params = {};

					params[0] = "Annuler";
					console.log(params);

					//Création de l'url et de sa query
					//Le second paramètre est la racine du site
					let url = new URL("/projetPHP/src/partie_home.php", "http://localhost");
					url.search = new URLSearchParams(params);
					console.log(url);

					//Requête HTTP GET 
					fetch(url)
						.then(response => response.json())
						.then(data => {

							dataContent = data.content;

						})
						.catch(error => { console.log(error); });
				}
			}
		})
		.catch(error => { console.log(error); });			
}

//Permet de contrer l'asynchronicité de l'éxécution des fonctions
const waitForGame = () => {
	if(dataContent == "Continuons !" || dataContent == "Nouvelle partie !") {
		window.location.href = "partie.html";
	}
	else {
		window.setTimeout(waitForGame, 100);
	}
}
waitForGame();