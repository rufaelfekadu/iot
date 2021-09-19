<?php

namespace App\Controller;

use App\Entity\Appliance;
use App\Form\ApplianceType;
use App\Repository\ApplianceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appliance")
 */
class ApplianceController extends AbstractController
{
    /**
     * @Route("/", name="appliance_index", methods={"GET","POST"})
     */
    public function index(ApplianceRepository $applianceRepository,Request $request): Response
    {
        if($request->request->get('edit')){
            // $this->denyAccessUnlessGranted("ROLE_ADMIN");

            $id=$request->request->get('edit');
            $appliance=$applianceRepository->findOneBy(['id'=>$id]);
            $form = $this->createForm(applianceType::class, $appliance);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $appliance->setStatus(0);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($appliance);
                $entityManager->flush();
                return $this->redirectToRoute('appliance_index');
            }

            $data=$applianceRepository->findAll();

            return $this->render('appliance/index.html.twig', [
                'appliances' => $data,
                'form' => $form->createView(),
                'edit'=>$id
            ]);

        }
        $appliance = new appliance();
        $form = $this->createForm(applianceType::class, $appliance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $appliance->setStatus(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appliance);
            
            $entityManager->flush();

            return $this->redirectToRoute('appliance_index', [], Response::HTTP_SEE_OTHER);
        }

        if($request->request->get('activate')){
            // dd($request->request->get('activate'));
            $appliance = $applianceRepository->find($request->request->get('activate'));
            // dd($appliance->getStatus());
            $st = $appliance->getStatus();
            $appliance->setStatus(!$st);
            $this->getDoctrine()->getManager()->flush();

        }
        $search = $request->query->get('search');
        $data=$applianceRepository->findAll();
        return $this->render('appliance/index.html.twig', [
            'appliances' => $data,
            'form' => $form->createView(),
            'edit' => false
        ]);
        
    }

    /**
     * @Route("/new", name="appliance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appliance = new Appliance();
        $form = $this->createForm(ApplianceType::class, $appliance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appliance->setStatus(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appliance);
            $entityManager->flush();

            return $this->redirectToRoute('appliance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appliance/new.html.twig', [
            'appliance' => $appliance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="appliance_show", methods={"GET"})
     */
    public function show(Appliance $appliance): Response
    {
        return $this->render('appliance/show.html.twig', [
            'appliance' => $appliance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appliance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Appliance $appliance): Response
    {
        $form = $this->createForm(ApplianceType::class, $appliance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appliance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appliance/edit.html.twig', [
            'appliance' => $appliance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="appliance_delete", methods={"POST"})
     */
    public function delete(Request $request, Appliance $appliance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appliance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appliance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appliance_index', [], Response::HTTP_SEE_OTHER);
    }
}
