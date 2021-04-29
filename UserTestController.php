<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Tester;
use App\Form\Test1Type;
use App\Form\Tester1Type;
use App\Repository\TestRepository;
use App\Repository\TesterRepository;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/test")
 */
class UserTestController extends AbstractController
{
    /**
     * @Route("/", name="user_test_index", methods={"GET"})
     */
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('user_test/index.html.twig', [
            'tests' => $testRepository->findBy(array(
            ),array(
                    'idTest'=>"DESC")
                ,10,0),
        ]);
    }



    /**
     * @param $idTest
     * @param $formation
     * @Route("/new", name="user_test_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $test = new Tester();
        $param = $request->get('idTest');
        $param1 = $request->get('categories');
        $param2 = $request->get('tst');


       // $form = $this->createForm(Tester1Type::class, $test);
       // $test->handleRequest($request);
        $test->setFormation($param1);
        $test->setIdTest($param);
        $test->setDate();
        $test->setIdUser(3);
        $test->setNote(null);

         {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            //return $this->redirectToRoute($param2);
             return $this->redirect($param2);
        }


    }

    /**
     * @Route("/{idTest}", name="user_test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        return $this->render('user_test/show.html.twig', [
            'test' => $test,
        ]);
    }

    /**
     * @Route("/{idTest}/edit", name="user_test_edit", methods={"GET","POST"})
     */

    public function edit(Request $request, Tester $test): Response
    {
        $form = $this->createForm(Tester1Type::class, $test);
        $form->handleRequest($request);

        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_test_index');
        }


    }
    /*public function edit(Request $request, Test $test): Response
    {
        $form = $this->createForm(Test1Type::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_test_index');
        }

        return $this->render('user_test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }
    */

    /**
     * @Route("/{idTest}", name="user_test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getIdTest(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_test_index');
    }




}
