<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends FOSRestController
{
    protected $_availableCategories = [
        'Electronics',
        'Fashion',
        'Motors',
        'Home & Garden',
        'Sporting goods',
        'Toys & hobbies',
    ];

    // @todo :: get data from ebay module.
    public function getAllAction()
    {
        $api = 'Trading';
        $callName = 'GetCategories';

        /* @todo :: follow ebay call code
        $ebay = $this->get('web_consul_ebay_api.main');
        $call = $ebay->getInstance($api, $callName);

        $service = $this->get('web_consul_ebay_api.make_call');
        $output = $service->getResponse($call);

        $xml = simplexml_load_string($output);
        $xml = json_decode(json_encode((array)$xml), TRUE);
        */
        $view = $this->view($this->_availableCategories, 200)->setFormat("json");
        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
