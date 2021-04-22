<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Services\Mailer;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        $reclamations = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }


    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request )
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $request->files->get('reclamation')['screenshot'];
            $uploads_directory = $this->getParameter('kernel.root_dir') . '/../public/img';
            $filename = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $uploads_directory,
                $filename
            );

            $reclamation->setScreenshot($filename);
            $reclamation->setStatut("en attente");
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();


            return $this->redirectToRoute('reclamation_show');
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReclamation}", name="reclamation_show", methods={"GET","POST"})
     */
    public function show(Reclamation $reclamation, Request $request ): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('reclamation_index');
        }
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Valider/{idReclamation}", name="valider_rec" , methods={"GET","POST"})
     */
    public function valider($idReclamation, ReclamationRepository $repository)
    {
        $reclamation = $repository->find($idReclamation);
        $reclamation->setStatut("validée");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        /*
                $mailer->send(
                    'emails/email.html.twig',
                    'inovvat@gmail.com',
                    'inovvat@gmail.com',
                    'emails/email.html.twig'
                );

        */

        return $this->redirectToRoute('reclamation_index');
        return $this->render('reclamation/show.html.twig');
    }

    /**
     * @Route("/Supp/{idReclamation}", name="reclamation_delete")
     */
    public function delete($idReclamation, ReclamationRepository $repository)
    {
        $reclamation = $repository->find($idReclamation);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();


        return $this->redirectToRoute('reclamation_index');
    }

    /**
     * @Route("Imprimer/{idReclamation}", name="Imprimer", methods={"GET","POST"})
     */
    public function Imprimer(Reclamation $reclamation): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // $Reclamation=$repository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('Reclamation/pdf.html.twig', [
            'reclamation' => $reclamation,
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Reclamation.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/chart", name="chart")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function piechartAction()
    {
        $data = [
            ['type', 56.33],

        ];

        $ob = new Highchart();
        $ob->chart->renderTo('container');
        $ob->chart->type('pie');
        $ob->title->text('My Pie Chart');
        $ob->series(array(array("data" => $data)));

        return $this->render('dashboard/test.html.twig', [
            'mypiechart' => $ob
        ]);
    }

    /**
     * @Route("/occurence", name="occurence_rec" )
     */
    public function occurence(): Response
    {   $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $Reclamation = $repository->findAll();
        $em = $this->getDoctrine()->getManager();
        $Contenu = 0;
        $ServiceTechnique = 0;
        $percV = 0;
        $percNV = 0;
        $NBrec = 0;
        foreach ($Reclamation as $reclamation) {
            $NBrec += 1;
            if ($reclamation->getType() == "Contenu")  :

                $Contenu += 1;
            elseif ($reclamation->getType() == "Service technique"):

                $ServiceTechnique += 1;
            else :
            endif;
        }
        $percV = number_format(($Contenu / $NBrec) * 100, 2);
        $percNV = number_format(($ServiceTechnique / $NBrec) * 100, 2);

        return new Response('percentage claims Validates : ' . $percV . ' %');
    }

        /*
            public function search(Request $request)
            {
                $em = $this->getDoctrine()->getManager();
                $requestString = $request->get('q');
                $reclamation =  $em->getRepository('reclamation')->findEntitiesByString($requestString);
                if(!$reclamation) {
                    $result['reclamation']['error'] = "reclamation Not found :( ";
                } else {
                    $result['reclamation'] = $this->getRealEntities($reclamation);
                }
                return new Response(json_encode($result));
            }

            /** @noinspection PhpUndefinedVariableInspection
            public function getRealEntities($reclamation){
                foreach ($reclamation as $reclamation){
                    $realEntities[$reclamation->getId()] = [$reclamation->getStatut(),$reclamation->getText()];

                }
                return $realEntities;
            }
        */
    }
