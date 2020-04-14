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
            let table = document.createElement('table');
            let trHeader = document.createElement('tr');
       
        
        for( el of headerTable){
            let td= document.createElement('th');
            td.innerText = el;
            trHeader.appendChild(td);
        }
        table.appendChild(trHeader);
        contenu.appendChild(table);
        
      
      for(let i = 0; i< arrayPrestations.length; i++){
        let tr = document.createElement('tr');
        let td0= document.createElement('td');
        td0.innerText = i + 1;
        tr.appendChild(td0);
        let td1= document.createElement('td');
        td1.innerText = arrayPrestations[i].datePrestation.date.substring(0,10);
        tr.appendChild(td1);
        let td2= document.createElement('td');
        td2.innerText = arrayPrestations[i].client.prenom.charAt(0).toUpperCase() + arrayPrestations[i].client.prenom.slice(1);
        tr.appendChild(td2);
        let td3= document.createElement('td');
        td3.innerText = arrayPrestations[i].service.nom.charAt(0).toUpperCase() + arrayPrestations[i].service.nom.slice(1);
        tr.appendChild(td3);
        let td4= document.createElement('td');
        td4.innerText = arrayPrestations[i].carteBancaire === true ? "Oui":"Non";
        tr.appendChild(td4);
        let td5= document.createElement('td');
        td5.innerText = arrayPrestations[i].prixService + '€';
        tr.appendChild(td5);

        table.appendChild(tr);
      }
      contenu.appendChild(table);



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
        xlBtn.setAttribute('class', 'xlBtn');
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
