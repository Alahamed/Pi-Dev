<?php

namespace App\Controller;

use App\Entity\Tester;
use App\Form\Tester1Type;
use App\Repository\TesterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/tester")
 */
class UserTesterController extends AbstractController
{
    /**
     * @Route("/", name="user_tester_index", methods={"GET"})
     */
    public function index(TesterRepository $testerRepository): Response
    {
        return $this->render('user_tester/index.html.twig', [
            'testers' => $testerRepository->findBy(array('idUser'=>'3'),array('id'=>"Desc"))
        ]);
    }

    /**
     * @Route("/new", name="user_tester_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tester = new Tester();
        $form = $this->createForm(Tester1Type::class, $tester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tester);
            $entityManager->flush();

            return $this->redirectToRoute('user_tester_index');
        }

        return $this->render('user_tester/new.html.twig', [
            'tester' => $tester,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_tester_show", methods={"GET"})
     */
    public function show(Tester $tester): Response
    {
        return $this->render('user_tester/show.html.twig', [
            'tester' => $tester,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_tester_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tester $tester): Response
    {
        $form = $this->createForm(Tester1Type::class, $tester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_tester_index');
        }

        return $this->render('user_tester/edit.html.twig', [
            'tester' => $tester,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_tester_delete", methods={"POST"})
     */
    public function delete(Request $request, Tester $tester): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tester->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tester);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_tester_index');
    }
}
