<?php

namespace Fourxxi\TestJobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fourxxi\TestJobBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction() {
        $doctrine = $this->getDoctrine();
        $users = $doctrine->getRepository('FourxxiTestJobBundle:User')->findAll();
        $curentUserId = $this->getUser()->getId();
        $messages = $doctrine->getRepository('FourxxiTestJobBundle:Message')->findAll();
        return $this->render('FourxxiTestJobBundle:Default:index.html.twig', array(
                    'users' => $users,
                    'usersid' => $curentUserId,
                    'messages' => $messages
        ));
    }

    /**
     * @Route("/message")
     * @Template()
     */
    public function messageAction(Request $request) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repo = $doctrine->getRepository('FourxxiTestJobBundle:Message');
        $user = $this->getUser();
        $curentUserId = $user->getId();
        
        if ($request->getMethod() !== 'POST') {
            throw $this->createNotFoundException('POST data not found');
        }
        $id = $request->request->get('id', null);
        $body = $request->request->get('body', null);
        if (!$body) {
            throw $this->createNotFoundException('BODY not found');
        }
        if ($id) {
            $message = $repo->find($id);
        } else {
            $message = new Message();
            $message->setUser($user);
        }
        $message->setBody($body);
        $em->persist($message);
        $em->flush();
        return $this->render('FourxxiTestJobBundle:Default:message.html.twig', array(
                    'usersid' => $curentUserId,
                    'message' => $message
        ));

    }

}
