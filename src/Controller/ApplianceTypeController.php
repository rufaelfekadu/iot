<?php

namespace App\Controller;

use App\Entity\ApplianceType;
use App\Form\ApplianceTypeType;
use App\Repository\ApplianceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type")
 */
class ApplianceTypeController extends AbstractController
{
    /**
     * @Route("/", name="appliance_type_index", methods={"GET"})
     */
    public function index(ApplianceTypeRepository $applianceTypeRepository): Response
    {
        return $this->render('appliance_type/index.html.twig', [
            'appliance_types' => $applianceTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="appliance_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $applianceType = new ApplianceType();
        $form = $this->createForm(ApplianceTypeType::class, $applianceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($applianceType);
            $entityManager->flush();

            return $this->redirectToRoute('appliance_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appliance_type/new.html.twig', [
            'appliance_type' => $applianceType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="appliance_type_show", methods={"GET"})
     */
    public function show(ApplianceType $applianceType): Response
    {
        return $this->render('appliance_type/show.html.twig', [
            'appliance_type' => $applianceType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appliance_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApplianceType $applianceType): Response
    {
        $form = $this->createForm(ApplianceTypeType::class, $applianceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appliance_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appliance_type/edit.html.twig', [
            'appliance_type' => $applianceType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="appliance_type_delete", methods={"POST"})
     */
    public function delete(Request $request, ApplianceType $applianceType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$applianceType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($applianceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appliance_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
