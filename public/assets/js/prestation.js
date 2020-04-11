btn_envoyer.addEventListener ("click", (event) => {
    event.preventDefault ();

    let route = Routing.generate("rechercheTraitementAjax");
    axios ({
        url : route,
        method : 'POST',
        headers: {'Content-Type': 'multipart/form-data'},
        data: new FormData (document.getElementById("leFormulaire"))
    })
    .then (function (response){
        
        let arrayPrestations = response.data;
        console.log(arrayPrestations);
        let contenu = document.getElementById('contenu');
        contenu.innerHTML="";
        if(arrayPrestations.length == 0){
            let msg = document.createElement('div');
            msg.innerText = "Il n'y a pas de prestations pour la periode rechercher!"
            contenu.appendChild(msg);
        }
        else{
            const headerTable= ['Nº', 'Date Service', 'Nom Client', 'Nom Service', 'Carte Bancaire', 'Prix Service'];
        let ulHeader = document.createElement('ul');
       
        
        for( el of headerTable){
            let li= document.createElement('li');
            li.innerText = el;
            ulHeader.appendChild(li);
            ulHeader.appendChild(li);
        }
        contenu.appendChild(ulHeader);
        ulHeader.classList.add("list-header");
      

        function createLi(article){
            let li= document.createElement('li');
            li.innerText = article;
            ul.appendChild(li);
        }

        
      let ul = document.createElement('ul');
      ul.classList.add("list-inline");
      for(let i = 0; i< arrayPrestations.length; i++){
        let br = document.createElement("BR");
        ul.appendChild(br);
        createLi(i+1);
        createLi(arrayPrestations[i].datePrestation.date.substring(0,10));
        createLi(arrayPrestations[i].client.prenom.charAt(0).toUpperCase() + arrayPrestations[i].client.prenom.slice(1));
        createLi(arrayPrestations[i].service.nom.charAt(0).toUpperCase() + arrayPrestations[i].service.nom.slice(1));
        createLi(arrayPrestations[i].carteBancaire === true ? "Oui":"Non");
        createLi(arrayPrestations[i].prixService + '€'); 
      }
      contenu.appendChild(ul);


       let total = 0;
        for(el of arrayPrestations){
           total += parseFloat(el.prixService);
        }
        let prixTotal = document.createElement('div');
        prixTotal.innerText = "Le total pour cette periode est:    " + total + " €.";
        contenu.appendChild(prixTotal);
        let prestationTotal = document.createElement('div');
        prestationTotal.innerText = "Nombre total de prestations trouvé: " + arrayPrestations.length;
        contenu.appendChild(prestationTotal);

        //creation du button pour telecharger le fichier format xl
      
        
        let fin = arrayPrestations.length - 1;
        let dFin = arrayPrestations[0].datePrestation.date.substring(0,10);
        let dDebut = arrayPrestations[fin].datePrestation.date.substring(0,10);
       
        console.log(dDebut);
        console.log(dFin);


        let form = document.createElement("form");
        form.setAttribute('method', 'POST');
        form.setAttribute('action', '/prestation/xlFile');

        let dateDebut = document.createElement("input");
        dateDebut.type = "hidden";
        dateDebut.name = "dateDebut";
        dateDebut.value = dDebut;

        let dateFin = document.createElement("input");
        dateFin.type = "hidden";
        dateFin.name = "dateFin";
        dateFin.value = dFin;

        let xlBtn = document.createElement("Button");
        xlBtn.type = "submit";
        xlBtn.innerText= "Télécharger en Excel"

        form.appendChild(dateDebut);
        form.appendChild(dateFin);
        form.appendChild(xlBtn);
        contenu.appendChild(form);

        }
              
    })
    .catch (function (error){
        console.log (error);
    });
});
