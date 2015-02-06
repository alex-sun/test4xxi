<?php

namespace Fourxxi\TestJobBundle\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Fourxxi\TestJobBundle\Entity\User;

class OAuthUserProvider extends \HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider {

    private $container = NULL;

    private function getContainer() {
        if (is_null($this->container)) {
            global $kernel;
            $this->container = $kernel->getContainer();
        }
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $resp = $response->getResponse();
        $doctrine = $this->getContainer()->get('doctrine');
        if ($user = $doctrine->getRepository('FourxxiTestJobBundle:User')->findOneByFbId($resp['id'])) {
            return $user;
        } else {
            $em = $doctrine->getManager();
            $newuser = new User();
            $newuser->setFbId($resp['id']);
            $newuser->setFirstName($resp['first_name']);
            $newuser->setLastName($resp['last_name']);
            $newuser->setUsername($response->getNickname());
            $em->persist($newuser);
            $em->flush();
            return $newuser;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        return $class === 'Fourxxi\\TestJobBundle\\Entity\\User';
    }

}
