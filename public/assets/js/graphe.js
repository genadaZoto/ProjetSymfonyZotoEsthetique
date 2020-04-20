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

let container = document.getElementById('container');
while(container.hasChildNodes()){
    container.removeChild(container.lastChild);
}
let myChart = document.createElement('canvas');
container.appendChild(myChart);
myChart.id = "myChart";

let servicesChart = new Chart(myChart,{
    type:'bar',
    data:{
        labels: arrayServices,
        datasets:[{
            label: 'Montant en € gagné par service',
            data: arrayValeur,
            backgroundColor:'#F09819',
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