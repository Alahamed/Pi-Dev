<?php

namespace App\Controller;

use App\Entity\Tester;
use App\Entity\Test;
use App\Form\TesterType;
use App\Repository\TesterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tester")
 */
class TesterController extends AbstractController
{

        /**
     * @Route("/", name="tester_index", methods={"GET"})
     */
    public function index(TesterRepository $testerRepository): Response
    {
        return $this->render('tester/index.html.twig', [
            'testers' => $testerRepository->findAll(),
        ]);
    }

    /**
     * @param TesterRepository $tster
     * @Route("/stats", name="tester_stats")
     */
    public function statistiques(TesterRepository $tster)
    {

        $tster1 = $tster->findAll();
        $res = array();
        $tstid = [];
        $tstnbr = [];
        foreach ($tster1 as $r){
            $tstid[] =  $r->getFormation();
            $tstnbr[] = count((array)$r->getFormation());
        }
        $a=array_unique($tstid);

        $res=array_values(array_count_values($tstid));



        return $this->render('tester/Stats.html.twig',[
            'tstid' =>json_encode($a),
            'tstnbr' => json_encode($res)
        ]);

    }


    /**
     * @Route("/new", name="tester_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tester = new Tester();
        $form = $this->createForm(TesterType::class, $tester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tester);
            $entityManager->flush();

            return $this->redirectToRoute('tester_index');
        }

        return $this->render('tester/new.html.twig', [
            'tester' => $tester,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tester_show", methods={"GET"})
     */
    public function show(Tester $tester): Response
    {
        return $this->render('tester/show.html.twig', [
            'tester' => $tester,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tester_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tester $tester): Response
    {
        $form = $this->createForm(TesterType::class, $tester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tester_index');
        }

        return $this->render('tester/edit.html.twig', [
            'tester' => $tester,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tester_delete", methods={"POST"})
     */
    public function delete(Request $request, Tester $tester): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tester->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tester);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tester_index');
    }







}
