<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Proxies\__CG__\Hack\Bundle\ProxyBundle\Entity\User;

class UserController extends FOSRestController
{
    public function registerAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $userData = array(
            'firstName' => 'Ebay',
            'lastName' => 'Test',
            'email' => 'ebay@test.host',
            'fbid' => '123717366591727312',
            'ebid' => '900987263132',
        );

        $userEntity = new User();
        $userEntity->setFirstName($userData['firstName']);
        $userEntity->setLastName($userData['lastName']);
        $userEntity->setEmail($userData['email']);
        $userEntity->setFbid($userData['fbid']);
        $userEntity->setEbid($userData['ebid']);
        $em->persist($userEntity);
        $em->flush();

        $view = $this->view(array('state' => 'success', 'message' => $userEntity), 200)->setFormat("json");
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @todo implement full featured authorization
     * @return mixed
     */
    public function authorizeAction()
    {
        $em = $this->getDoctrine();
        $userRepository = $em->getRepository('HackProxyBundle:User');
        $userEntity = $userRepository->find(1);
        $view = $this->view($userEntity, 200)->setFormat("json");
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getStatisticsAction($userId)
    {
        $em = $this->getDoctrine();
        $userRepository = $em->getRepository('HackProxyBundle:UserStatistic');
        $userEntity = $userRepository->find($userId);
        if(!$userEntity) {
            $view = $this->view(array('state' => 'failure'), 200)->setFormat("json");
            return $this->get('fos_rest.view_handler')->handle($view);
        }
        $view = $this->view(array('state' => 'success', 'message' => $userEntity), 200)->setFormat("json");
        return $this->get('fos_rest.view_handler')->handle($view);
    }

}
