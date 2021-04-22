<?php

namespace App\Controller;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Events;
use App\Form\EventsType;
use App\Repository\EventsRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{
 /**
 * @Route("/user", name="events_indexuser")
 */

    public function user(EventsRespository $eventsRespository,Request $request):Response
    {


        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
        $events= [];

        if($form->isSubmitted() && $form->isValid()) {


            //on récupère le nom d'article tapé dans le formulaire
            $nomEvent = $propertySearch->getNomEvent();
            //si si aucun nom n'est fourni on affiche tous les articles

            if ($nomEvent!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce usernamme
                $events= $this->getDoctrine()->getRepository(Events::class)->findBy(['nomEvent' => $nomEvent] );
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $events= $this->getDoctrine()->getRepository(Events::class)->findAll();
        }


        return  $this->render('events/indexuser.html.twig',[ 'form' =>$form->createView(), 'events' => $events]);
    }


    /**
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function index(EventsRespository $eventsRespository,Request $request, PaginatorInterface $paginator):Response
    {
        $donnees = $this->getDoctrine()->getRepository(Events::class)->findAll();

        $events = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="events_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image=$request->files->get('events')['image'];
            $uploads_directory=$this->getParameter('kernel.root_dir'). '/../public/img';
            $filename=md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $uploads_directory,
                $filename
            );

            $event->setImage($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvent}", name="events_show", methods={"GET"})
     */
    public function show(Events $event): Response
    {

        return $this->render('events/show.html.twig', [
            'event' => $event,
        ]);
    }



    /**
     * @Route("/{idEvent}/edit", name="events_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Events $event): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image=$request->files->get('events')['image'];
            $uploads_directory=$this->getParameter('kernel.root_dir'). '/../public/img';
            $filename=md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $uploads_directory,
                $filename
            );

            $event->setImage($filename);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvent}", name="events_delete")
     */
    public function delete(Request $request, Events $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getIdEvent(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index');
    }
    /**
     * @Route("/searchEventsx ", name="searchStudentx")
     */
    public function searchEventsx(Request $request,NormalizerInterface $Normalizer)
  {
$repository = $this->getDoctrine()->getRepository(Events::class);
$requestString=$request->get('searchValue');
$events = $repository->findEventsBynomEvent($requestString);
$jsonContent = $Normalizer->normalize($events, 'json',['groups'=>' events:read']);
$retour=json_encode($jsonContent);
return new Response($retour);
}
}