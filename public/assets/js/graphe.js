btn_envoyer.addEventListener("click", (event) =>{
    event.preventDefault();
    let route = Routing.generate("afficher_graphe");

    axios ({
        url : route,
        method : 'POST',
        headers: {'Content-Type': 'multipart/form-data'},
        data: new FormData (document.getElementById('grapheForm'))
    })
    .then(function (response){
        let prestations = response.data;
        let arrayServices = Object.keys(prestations);
        let arrayValeur = Object.values(prestations);

        
let myChart = document.getElementById('myChart').getContext('2d');

let servicesChart = new Chart(myChart,{
    type:'bar',
    data:{
        labels: arrayServices,
        datasets:[{
            label: 'Montant en € gagné par service',
            data: arrayValeur,
            backgroundColor:[
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(255, 99, 132, 0.6)',
            ],
            borderWidth:1,
            borderColor: '#777',
            hoverBorderwidth: 4,
            hoverBorderColor: '#000'
        }]
    },
    options:{
        title:{
            display:true,
            text:'Representation des chiffres d\'affaires pour chaque service pendant un an',
            fontSize:20
        },
        legend:{
            display:false
        }
    }
});
})
.catch(function (error){
    console.log(error);
});
});