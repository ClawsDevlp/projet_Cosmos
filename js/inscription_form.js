// document ready in ES6
Document.prototype.ready = callback => {
	if(callback && typeof callback === 'function') {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return callback();
			}
		});
	}
};

document.getElementById('inscription-send').onclick = event => {
	event.preventDefault();

	const formIn = document.getElementById("form-inscription");

	// construction des queries
	let params = {};
	if(formIn.pseudo.value) params['pseudo'] = formIn.pseudo.value;
	if(formIn.mail.value) params['mail'] = formIn.mail.value;
	if(formIn.mdp.value) params['mdp'] = /*sha(*/formIn.mdp.value;

	// création de l'URL et de ses queries
	// on indique en second paramètres du constructeur URL la racine du site
	let url = new URL("src/inscription_back.php", "http://localhost/projetPHP/");
	fetch(url, 
			{
				method: 'POST',
				body: JSON.stringify(params)
			}
		)
		.then( response => response.json() )
		.then( data => {
			console.log(data);
		} )
		.catch( error => { console.log(error) } );		
};
