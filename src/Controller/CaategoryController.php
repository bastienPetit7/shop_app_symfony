<?php

namespace App\Controller;

use App\Entity\Caategory;
use App\Form\CaategoryType;
use App\Repository\CaategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/caategory")
 */
class CaategoryController extends AbstractController
{
    /**
     * @Route("/", name="caategory_index", methods={"GET"})
     */
    public function index(CaategoryRepository $caategoryRepository): Response
    {
        return $this->render('caategory/index.html.twig', [
            'caategories' => $caategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="caategory_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $caategory = new Caategory();
        $form = $this->createForm(CaategoryType::class, $caategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataImage = $form->get('image')->getData();

            if($dataImage)
            {
                $originalFilename = pathinfo($dataImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid(). '.' . $dataImage->guessExtension(); 

                $dataImage->move(
                    $this->getParameter('app_images_directory'),
                    $newFilename
                );

                $caategory->setImagePathUrl('/uploads/' . $newFilename );
            
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caategory);
            $entityManager->flush();

            return $this->redirectToRoute('caategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caategory/new.html.twig', [
            'caategory' => $caategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="caategory_show", methods={"GET"})
     */
    public function show(Caategory $caategory): Response
    {
        return $this->render('caategory/show.html.twig', [
            'caategory' => $caategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="caategory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caategory $caategory): Response
    {
        $form = $this->createForm(CaategoryType::class, $caategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('caategory/edit.html.twig', [
            'caategory' => $caategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="caategory_delete", methods={"POST"})
     */
    public function delete(Request $request, Caategory $caategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('caategory_index', [], Response::HTTP_SEE_OTHER);
    }
}
