<?php

namespace Fourxxi\TestJobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Fourxxi\TestJobBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('FourxxiTestJobBundle:Security:login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction() {
        
    }

    /**
     * @Route("/newuser", name="newuser")
     */
    public function newUserAction(Request $request) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $newuser = new User();
        $newuser->setUsername($this->get('request')->request->get('_username'));
        $newuser->setPassword($this->get('request')->request->get('_password'));
        $newuser->setFirstName($this->get('request')->request->get('firstName'));
        $newuser->setLastName($this->get('request')->request->get('lastName'));
        $em->persist($newuser);
        $em->flush();

        $token = new UsernamePasswordToken($newuser, $newuser->getPassword(), "secured_area", $newuser->getRoles());
        $securityContext = $this->container->get('security.context');
        $securityContext->setToken($token);

        return $this->redirect($this->generateUrl('home'));
    }

}
