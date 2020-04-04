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

              return $this->redirectToRoute("client_afficher");
          }
          else{
              return $this->render('client/client_insert.html.twig', ['formulaire'=>$formulaireClient->createView()]);
          }
    }

    /**
     * @Route("/client/afficher", name="client_afficher")
     */
    public function clientAfficher(){
        $em = $this->getDoctrine()->getManager();
        $clientRepo = $em->getRepository(Client::class);
        $clients = $clientRepo->findAll();
        $vars = ['clients'=>$clients];

        return $this->render("client/client_afficher.html.twig", $vars);
    }

    /**
     * @Route("/client/delete", name="traitementClient_deleteEdit")
     */
    public function clientDelete(Request $request){
        
        $valButtonEdit = $request->request->get('edit');
        $valButtonDelete = $request->request->get('delete');

        $id = $valButtonDelete | $valButtonEdit;

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->findOneBy(array("id"=>$id));

        if($valButtonDelete != null){
            $em->remove($client);
            $em->flush();
            return $this->redirectToRoute("client_afficher");
        }
        else{
            $vars=['client'=>$client];
            return $this->render("client/client_edit.html.twig", $vars);

        }
    }

    /**
     * @Route("/client/edit", name="traitement_editClient")
     */
    public function clientEdit(Request $request){
    
        $id =$request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->findOneBy(array("id"=>$id));
        $client->setNom($request->request->get('nom'));
        $client->setPrenom($request->request->get('prenom'));
        $client->setAdresse($request->request->get('adresse'));
        $client->setContact($request->request->get('contact'));
        $client->setEmail($request->request->get('email'));
        $client->setIdCard($request->request->get('idCard'));
        $client->setCommentaires($request->request->get('commentaires'));
        
        $em->flush();

        return $this->redirectToRoute("client_afficher");

    }




}
