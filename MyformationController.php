<?php

namespace App\Controller;

use App\Entity\Myformation;
use App\Form\MyformationType;
use App\Repository\MyformationRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/form")
 */
class MyformationController extends AbstractController
{
    /**
     * @Route("/", name="myformation_index", methods={"GET"})
     */
    public function index(MyformationRespository $myformationRespository): Response
    {
        return $this->render('myformation/index.html.twig', [
            'myformations' => $myformationRespository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="myformation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $myformation = new Myformation();
        $form = $this->createForm(MyformationType::class, $myformation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();


            $myformation= $form->getData();
            // On récupère les images transmises
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // On copie le fichier dans le dossier uploads

            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $myformation->setImage($fileName);
            $em->persist($myformation);
            $em->flush();



            return $this->redirectToRoute('myformation_index');
        }

        return $this->render('myformation/new.html.twig', [
            'form' => $form->createView(),
        ]);








           $entityManager->persist($myformation);
           $entityManager->flush();

            return $this->redirectToRoute('myformation_index');
        }




    /**
     * @Route("/{id}", name="myformation_show", methods={"GET"})
     */
    public function show(Myformation $myformation): Response
    {
        return $this->render('myformation/show.html.twig', [
            'myformation' => $myformation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="myformation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Myformation $myformation): Response
    {
        $form = $this->createForm(MyformationType::class, $myformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('myformation_index');
        }

        return $this->render('myformation/edit.html.twig', [
            'myformation' => $myformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="myformation_delete", methods={"POST"})
     */
    public function delete(Request $request, Myformation $myformation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$myformation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($myformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('myformation_index');
    }
}
