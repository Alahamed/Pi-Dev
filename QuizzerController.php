<?php

namespace App\Controller;

use App\Entity\Quizzer;
use App\Form\QuizzerType;
use App\Repository\QuizzerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quizzer")
 */
class QuizzerController extends AbstractController
{
    /**
     * @Route("/", name="quizzer_index", methods={"GET"})
     */
    public function index(QuizzerRepository $quizzerRepository): Response
    {
        return $this->render('quizzer/index.html.twig', [
            'quizzers' => $quizzerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quizzer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quizzer = new Quizzer();
        $form = $this->createForm(QuizzerType::class, $quizzer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quizzer);
            $entityManager->flush();

            return $this->redirectToRoute('quizzer_index');
        }

        return $this->render('quizzer/new.html.twig', [
            'quizzer' => $quizzer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idq}", name="quizzer_show", methods={"GET"})
     */
    public function show(Quizzer $quizzer): Response
    {
        return $this->render('quizzer/show.html.twig', [
            'quizzer' => $quizzer,
        ]);
    }

    /**
     * @Route("/{idq}/edit", name="quizzer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quizzer $quizzer): Response
    {
        $form = $this->createForm(QuizzerType::class, $quizzer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quizzer_index');
        }

        return $this->render('quizzer/edit.html.twig', [
            'quizzer' => $quizzer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idq}", name="quizzer_delete", methods={"POST"})
     */
    public function delete(Request $request, Quizzer $quizzer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quizzer->getIdq(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quizzer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quizzer_index');
    }
}
