<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class EspaceUserController extends AbstractController
{
    /**
     * @method handleRequest(Request $request)
     */
    #[Route('/espace/user/{id}', name: 'app_profile')]
    public function index(?User $user): Response
    {
        if (!$user)
        {
            return $this->redirectToRoute('home.index');
        }
        return $this->render('espace_user/index.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * This controller allow us to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */

    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('espace_user/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
    /**
     * This controller allow us to logout
     *
     * @return void
     */

    #[Route('/deconnexion', name: 'security.logout')]
    public function logout()
    {
        // Nothing to do here...
    }
    /**
     * This controller allow us to register
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/inscription', 'security.registration', methods:['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $this->addFlash(
                'success',
                'Votre compte a bien ??t?? cr????.'
            );

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security.login');
        }

        return $this->render('espace_user/registration.html.twig', [
            'form'=> $form->createView()
        ]);

    }


}


