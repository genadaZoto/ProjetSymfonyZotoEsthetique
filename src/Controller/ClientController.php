<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Client;
use App\Form\ClientType;
use App\Form\ClientPrenomType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    /**
     * @Route("/client/recherche", name="client_recherche")
     */
    public function clientRecherche ()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository(Client::class)->findAll();
        $vars = ["clients"=>$clients];

          return $this->render('client/client_recherche.html.twig', $vars);

    }

    /**
     * @Route("/client/recherche/traitement", name="traitement_rechercheClient")
     */
    public function rechercheClientTraitement(Request $request)
    {
        $clientId = $request->request->get('clientId');
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery ('SELECT photo,client FROM App\Entity\Photo photo JOIN photo.client client WHERE client.id = :input');
        $query->setParameter('input', $clientId );

        $client = $query->getResult();
        $vars=['client'=>$client];
        //dd($vars);
        return $this->render('client/client_rechercheTraitement.html.twig', $vars);
      
    }
    /**
     * @Route("/client/delete/photo",options={"expose"=true}, name="delete_photo")
     */
    public function deletePhoto(Request $request)
    {
        $id = $request->request->get("delete");
     
        $em = $this->getDoctrine()->getManager();
        $photo = $em->getRepository(Photo::class)->findOneBy(array("id"=>$id));
       
        $em->remove($photo);
        $em->flush();
        return $this->redirectToRoute("client_rechercheAjax");
      
        
    }
    //////////////////////////recherche client Ajax/////////////////////

    /**
     * @Route("/client/recherche/ajax", name="client_rechercheAjax")
     */
    public function clientRechercheAjax ()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository(Client::class)->findAll();
        $vars = ["clients"=>$clients];

          return $this->render('client/client_rechercheAjax.html.twig', $vars);

    }

    /**
     * @Route("/client/recherche/traitement/ajax", options={"expose"=true}, name="traitement_rechercheClientAjax")
     */
    public function rechercheClientAjax(Request $request)
    {

        $clientId = $request->request->get('clientId');
        
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery ('SELECT photo,client FROM App\Entity\Photo photo JOIN photo.client client WHERE client.id = :input');
            $query->setParameter('input', $clientId );
    
            $client = $query->getArrayResult();

            return new JsonResponse($client);
    }

}
