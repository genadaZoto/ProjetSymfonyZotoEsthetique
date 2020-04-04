<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/client/insert", name="client_insert")
     */
    public function clientInsert(Request $request)
    {
      $client = new Client();

      $formulaireClient = $this->createForm(
          ClientType::class,
          $client,[
              'method'=>"POST",
              'action'=>$this->generateUrl("client_insert")
            ]
          );

          $formulaireClient ->handleRequest($request);

          if($formulaireClient->isSubmitted() && $formulaireClient->isValid()){
              $em = $this->getDoctrine()->getManager();
              $em->persist($client);
              $em->flush();

              return $this->render('client/client_insert_traitement.html.twig');
          }
          else{
              return $this->render('client/client_insert.html.twig', ['formulaire'=>$formulaireClient->createView()]);
          }
    }

    


}
