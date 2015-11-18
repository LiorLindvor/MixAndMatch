<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use WebConsul\EbayApiBundle\Type\ItemFilter;
use WebConsul\EbayApiBundle\Type\PaginationInput;

class ProductsController extends FOSRestController
{
    protected $_dataToLeave = array(
        'galleryURL' => 0,
        'title' => 0,
        'itemId' => 0,
        'primaryCategory' => 0
    );

    protected $_availableCategories = [
        'Electronics',
        'Fashion',
        'Motors',
        'Home & Garden',
        'Sporting goods',
        'Toys & hobbies',
    ];

    public function CheapestAndExpensiveAction()
    {
/*        $result = array(
            'min' => $this->bringItem(true),
            'max' => $this->bringItem(),
        );
*/
        $view = $this->view($this->bringItem(true), 200)->setFormat("json");

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    protected function bringItem($isCheapest = false)
    {
        $api = 'Finding';
        $callName = 'findItemsAdvanced';
        $order = $isCheapest === false ? 'PricePlusShippingHighest' : 'PricePlusShippingLowest';

        $ebay = $this->get('web_consul_ebay_api.main');
        /** @var \WebConsul\EbayApiBundle\Call\Finding\FindItemsAdvancedCall $call */
        $call = $ebay->getInstance($api, $callName);

        $pagination = new PaginationInput();
        $pageNumber = rand(1,10);
        $pagination->setEntriesPerPage(20)->setPageNumber($pageNumber);

        //$categoriesAmount = count($this->_availableCategories);
        //$categoryName = $this->_availableCategories[rand(1, $categoriesAmount)-1];
        $categoryName = 'Cell Phones & Accessories';
        $itemFilterStack = [];
        $item = new ItemFilter();
        $item->setParamName('listingType')->setParamValue('FixedPrice');
        $itemFilterStack[] = $item;

        $call->setCategoryId($categoryName);
        $call->setDescriptionSearch(true);
        $call->setKeywords('phone'); // @todo : what we do with keyword???
        $call->setSortOrder($order);
        $call->setPaginationInput($pagination);
        $call->setItemFilter($itemFilterStack);

        $service = $this->get('web_consul_ebay_api.make_call');
        $output = $service->getResponse($call);

        $xml = simplexml_load_string($output);
        $output = null;
        $xml = json_decode(json_encode((array)$xml), TRUE);

        if(!isset($xml['searchResult'])) {
            return null;
        }
        return $this->filterProductsData($xml['searchResult']['item']);

    }

    /**
     * @todo : move out. temporarily here. 15:53 is here...
     * @param $data
     * @return array
     */
    protected function filterProductsData($data)
    {
        $newData = array();
        foreach($data as $item) {
            $tmp = [];
            foreach($item as $k=>$v) {
                if(true === isset($this->_dataToLeave[$k])) {
                    $tmp[$k] = $v;
                }
            }
            $newData[] = $tmp;
        }
        return $newData;
    }
}
