<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRespository;
use App\Entity\Participation;

use App\Form\ParticipationType;
use App\Repository\ParticipationRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participation")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/", name="participation_index", methods={"GET"})
     */
    public function index(ParticipationRespository $participationRespository): Response
    {
        return $this->render('participation/index.html.twig', [
            'participations' => $participationRespository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $participation = new Participation();

        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('events_indexuser');
        }

        return $this->render('participation/new.html.twig', [
            'participation' => $participation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idParticipation}", name="participation_show", methods={"GET"})
     */
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }



    /**
     * @Route("/{idParticipation}", name="participation_delete", methods={"POST"})
     */
    public function delete(Request $request, Participation $participation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getIdParticipation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participation_index');
    }
    /**
     * @Route("/part/{id}", name="part")
     */
    public  function  participerEventAction(Request $request,int $idEvent):Response
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Events::class)->find($idEvent);

        $part = new Participation();
        $form = $this->createForm(ParticipationType::class, $part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->getRepository(Events::class)->find($idEvent);
            $entityManager->persist($part);
            $entityManager->flush();


            return $this->redirectToRoute("events_indexuser");
        }

        return $this->render("events/indexuser.html.twig", [
            "form" => $form->createView(), 'event' => $event, 'part' => $part
        ]);
    }

}
