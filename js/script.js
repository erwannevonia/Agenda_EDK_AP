//Défintion de l'URL à appeler
const URL = "https://randomuser.me/api?results=200";

//Lancement de l'appel
fetch(URL)
  .then(function (response) {
    //Debug de la réponse et affichage dans la console
    //console.log(response);

    //Renvoi de la transformation de la réponse en JSON
    return response.json();
  })

  .then((data) => {
    //Affichage du résultat de la transformation en JSON
    console.log(data.results);
    // On sélectionne l'endroit où on va mettre les données dans le fichier html
    const tableBody = document.getElementById("Tableau");

    // On parcourt le tableau, création de nouvelle ligne pour chaque utilisateur
    data.results.forEach((user) => {
      const row = tableBody.insertRow();
      row.insertCell(0).textContent = user.name.last + " " + user.name.first;
      // Créez une cellule pour l'image de l'utilisateur
      const imageCell = row.insertCell(1);

      // Création d'un élément 'img' pour afficher l'image de l'utilisateur
      const userImage = document.createElement("img");
      userImage.src = user.picture.thumbnail;

      // Ajout de l'élément <img> à la cellule de l'image
      imageCell.appendChild(userImage);
      row.insertCell(2).textContent = user.email;

      // Si l'utilisateur est un homme
      if (user.gender === "male") {
        // On définit la cellule dans laquelle on met l'icône
        const imageCell = row.insertCell(3);
        // Création d'un élément 'img' pour afficher le genre de l'utilisateur
        const genderImage = document.createElement("img");
        genderImage.src = "img/masculin.png";
        imageCell.appendChild(genderImage);
      }

      // Si l'utilisateur est une femme
      else {
        // On définit la cellule dans laquelle on met l'icône
        const imageCell = row.insertCell(3);
        // Création d'un élément 'img' pour afficher le genre de l'utilisateur
        const genderImage = document.createElement("img");
        genderImage.src =
          "img/feminin.png";
        imageCell.appendChild(genderImage);
      }

      row.insertCell(4).textContent = user.location.city;

      var flagCell = row.insertCell(5);
      let flag = user.nat;
      flag = flag.toLowerCase();
      flagCell.innerHTML = "<span class='fi fi-" + flag + "'></span>";
    });
  });