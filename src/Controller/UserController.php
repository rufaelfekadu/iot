<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
     /**
     * @Route("/", name="user_index", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository,Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        if($request->request->get('edit')){
            $this->denyAccessUnlessGranted("ROLE_ADMIN");

            $id=$request->request->get('edit');
            $user=$userRepository->findOneBy(['id'=>$id]);
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $user->getFirstName().".".$user->getLastName()
                    ))
                    ->setUsername($user->getFirstName().".".$user->getLastName());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('user_index');
            }

            $data=$userRepository->findAll();
            // $data=$paginator->paginate(
            //     $queryBuilder,
            //     $request->query->getInt('page',1),
            //     5
            // );
            return $this->render('user/index.html.twig', [
                'users' => $data,
                'form' => $form->createView(),
                'edit'=>$id
            ]);

        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getFirstName().".".$user->getLastName()
                ))
                ->setUsername($user->getFirstName().".".$user->getLastName());
            // $user->setRoles(["ROLE_".$user->getOffice()]); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $search = $request->query->get('search');
        $data=$userRepository->findAll();
    
        // $queryBuilder=$userRepository->finduser($search);
        // $data=$paginator->paginate(
        //     $queryBuilder,
        //     $request->query->getInt('page',1),
        //     5
        // );
        return $this->render('user/index.html.twig', [
            'users' => $data,
            'form' => $form->createView(),
            'edit' => false
        ]);
        // return $this->render('user/index.html.twig', [
        //     'users' => $userRepository->findAll(),
        // ]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $user->getPassword()
                        ));
            $user->setRoles(["ROLE_".$user->getOffice()]);      
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/password/{id}", name="change_password", methods={"GET","POST"})
     */
    public function show(UserRepository $userRepository,Request $request,$id,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $currpass = $passwordEncoder->encodePassword($user,$form->getData()['current_password']);
            $curr_pass = $passwordEncoder->encodePassword($user,$user->getPassword());
            // dd($curr_pass);
            if($currpass == $currpass){
                $pass = $passwordEncoder->encodePassword($user,$form->getData()['new_password']);
                $user->setPassword($pass)
                    //  ->setRoles(["ROLE_USER"])
                    //  ->setUserName($user->getFirstName().".".$user->getLastName())
                     ;
                     $this->addFlash('save', 'password changed!');
                
                $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($user);
                $entityManager->flush();
                

            }else{
                $this->addFlash('error', 'Wrong password!');
                return $this->redirect($request->headers->get('referer'));
                
            }

            return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
            
            // return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}


