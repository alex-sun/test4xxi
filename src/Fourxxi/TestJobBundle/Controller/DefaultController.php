<?php

namespace Fourxxi\TestJobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $users = $doctrine->getRepository('FourxxiTestJobBundle:User')->findAll();
        return $this->render('FourxxiTestJobBundle:Default:index.html.twig',array(
            'users' => $users
        ));
    }
}
