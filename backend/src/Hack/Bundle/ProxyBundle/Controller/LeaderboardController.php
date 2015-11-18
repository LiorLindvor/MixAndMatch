<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class LeaderboardController extends FOSRestController
{
    public function topAction()
    {
        $result = $this->getDoctrine()
            ->getRepository('HackProxyBundle:UserStatistic')
            ->getTop10ByScore();

        $view = $this->view($result, 200)->setFormat("json");

        return $this->get('fos_rest.view_handler')->handle($view);
    }

}