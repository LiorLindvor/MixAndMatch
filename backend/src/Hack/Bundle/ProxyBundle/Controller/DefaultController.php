<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HackProxyBundle:Default:index.html.twig');
    }
}
