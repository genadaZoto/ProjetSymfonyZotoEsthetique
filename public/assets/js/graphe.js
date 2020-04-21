btn_envoyer.addEventListener("click", (event) => {
    event.preventDefault();
    let route = Routing.generate("afficher_graphe");

    axios({
        url: route,
        method: 'POST',
        headers: { 'Content-Type': 'multipart/form-data' },
        data: new FormData(document.getElementById('grapheForm'))
    })
        .then(function (response) {
            let prestations = response.data;
            // creer graphe1
            let arrayServices = Object.keys(prestations.montant);
            let arrayValeur = Object.values(prestations.montant);

            let container = document.getElementById('container1');
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            let myChart = document.createElement('canvas');
            container.appendChild(myChart);
            myChart.id = "myChart";

            let servicesChart = new Chart(myChart, {
                type: 'bar',
                data: {
                    labels: arrayServices,
                    datasets: [{
                        label: 'Montant en € gagné par service',
                        data: arrayValeur,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderWidth: 1,
                        borderColor: '#777',
                        hoverBorderwidth: 4,
                        hoverBorderColor: 'grey'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Representation des chiffres d\'affaires pour chaque service pendant un an',
                        fontSize: 20
                    },
                    legend: {
                        display: false
                    }
                }

            });



            //creer II graphe
            let arrayMois= [];
            for(let el of prestations.parMois){
                switch(el.mois){
                    case '1':
                        arrayMois.push('Janvier');
                        break;
                    case '2':
                        arrayMois.push('Fevrier');
                        break;
                    case '3':
                        arrayMois.push('Mars');
                        break;
                    case '4':
                        arrayMois.push('Avril');
                        break;
                    case '5':
                        arrayMois.push('Mai');
                        break;
                    case '6':
                        arrayMois.push('Juin');
                        break;
                    case '7':
                        arrayMois.push('Julliet');
                        break;
                    case '8':
                        arrayMois.push('Aout');
                        break;
                    case '9':
                        arrayMois.push('Septembre');
                        break;
                    case '10':
                        arrayMois.push('Octobre');
                        break;
                    case '11':
                        arrayMois.push('Novembre');
                        break;
                    case '12':
                        arrayMois.push('Decembre');
                        break;
                }
                
            }
          

            let arrayPrestations = [];
            for( let el of prestations.parMois){
                arrayPrestations.push(el.nombres);
            }
            
            let container2 = document.getElementById('container2');
            while (container2.hasChildNodes()) {
                container2.removeChild(container2.lastChild);
            }
            let myChart2 = document.createElement('canvas');
            container2.appendChild(myChart2);
            myChart2.id = "myChart2";

            let servicesChart2 = new Chart(myChart2, {
                type: 'line',
                data: {
                    labels: arrayMois,
                    datasets: [{
                        label: 'Nombre de service par mois',
                        data: arrayPrestations,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderWidth: 1,
                        borderColor: '#777',
                        hoverBorderwidth: 4,
                        hoverBorderColor: 'grey'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Nombre de services par mois pendant un an',
                        fontSize: 20
                    },
                    legend: {
                        display: false
                    }
                }

            });


        })
        .catch(function (error) {
            console.log(error);
        });
});