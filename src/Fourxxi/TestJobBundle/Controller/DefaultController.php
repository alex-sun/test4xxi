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
     * @Template("FourxxiTestJobBundle:Default:index.html.twig")
     */
    public function indexAction() {
        $doctrine = $this->getDoctrine();
        $users = $doctrine->getRepository('FourxxiTestJobBundle:User')->findAll();
        $curentUserId = $this->getUser()->getId();
        $messages = $doctrine->getRepository('FourxxiTestJobBundle:Message')->findAll();
        return array(
            'users' => $users,
            'usersid' => $curentUserId,
            'messages' => $messages
        );
    }

    /**
     * @Route("/message")
     * @Template("FourxxiTestJobBundle:Default:message.html.twig")
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
        return array(
            'usersid' => $curentUserId,
            'message' => $message
        );
    }

    /**
     * @Route("/profile", name="profile")
     * @Template("FourxxiTestJobBundle:Default:profile.html.twig")
     */
    public function profileAction(Request $request) {
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
                ->add('firstName', null, array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('lastName', null, array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

}
