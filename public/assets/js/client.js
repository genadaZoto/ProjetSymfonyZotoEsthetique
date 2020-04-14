btn_envoyer.addEventListener("click", (event)=>{
    event.preventDefault();

    let route1 = Routing.generate("traitement_rechercheClientAjax");
    
    axios({
        url : route1,
        method : 'POST',
        header: {'Content-Type': 'multipart/form-data'},
        data: new FormData (document.getElementById("leFormulaire"))
    })
    .then(function (response){
        //console.log(response.data);
        let arrayClient = response.data;
        //console.log(arrayClient);
        let contenu = document.getElementById('contenu');
        contenu.innerHTML="";

        if(arrayClient.length == 0){
            let msg = document.createElement('div');
            msg.innerText = "Il n'y a pas encore de photo pour ce client!"
            contenu.appendChild(msg);
        }
        else{

          
            let nom = document.createElement('div');
            let prenom = document.createElement('div');
            let adresse = document.createElement('div');
            let contact = document.createElement('div');
            let email = document.createElement('div');

            for( let i=0; i< arrayClient.length; i++){
                nom.innerText = "Nom: " + arrayClient[i].client.nom;
                prenom.innerText = "Prenom: " + arrayClient[i].client.prenom;
                adresse.innerText = "Adresse: " + arrayClient[i].client.adresse;
                contact.innerText = "Contact: " + arrayClient[i].client.contact;
                email.innerText = "Email: " + arrayClient[i].client.email;
            }
            contenu.appendChild(nom);
            contenu.appendChild(prenom);
            contenu.appendChild(adresse);
            contenu.appendChild(contact);
            contenu.appendChild(email);

            let form = document.createElement("form");
            form.setAttribute('id','leFormulaire2');
            form.setAttribute('method', 'post');
            form.setAttribute('action', '/client/delete/photo')
            
            for(let i =0; i <arrayClient.length; i++){
                let conteneur = document.createElement('div');
                conteneur.setAttribute('class', 'conteneur');
                let img = document.createElement("IMG");
                img.setAttribute('src', '/dossierFichiers/'+arrayClient[i].lienImage+ '');
                let div = document.createElement('div');
                div.setAttribute('class', 'infoPhoto');
                let label = document.createElement("p");
                label.innerText = "Label: " + arrayClient[i].label;
                let date = document.createElement('p');
                date.innerText = "Date: " + arrayClient[i].datePhoto.date.substring(0,10);
                let btn = document.createElement("BUTTON");
                btn.classList.add("fa", "fa-trash-alt", "fa-6");
                btn.name = "delete";
                btn.type = "submit";
                btn.setAttribute('id', 'btn');
                btn.setAttribute('value', arrayClient[i].id);
                conteneur.appendChild(img);
                div.appendChild(label);
                div.appendChild(date);
                div.appendChild(btn);
                conteneur.appendChild(div);
                form.appendChild(conteneur);
            }
            contenu.appendChild(form);
            
        }

    })
    .catch (function (error){
        console.log(error)
    });
});


