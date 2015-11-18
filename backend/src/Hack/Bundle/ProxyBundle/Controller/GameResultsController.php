<?php

namespace Hack\Bundle\ProxyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Hack\Bundle\ProxyBundle\Entity\GameResult;
use Proxies\__CG__\Hack\Bundle\ProxyBundle\Entity\UserStatistic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameResultsController extends FOSRestController
{
    public function storeAction(
        $userId, $itemId, $categoryName, $scoreIncrease, $isLevelUp
    )
    {
        $em = $this->getDoctrine()->getEntityManager();

        $scoreIncrement = $scoreIncrease ? 10 : 0;
        $levelIncrement = $isLevelUp ? 1 : 0;

        $userRepo = $em->getRepository('HackProxyBundle:User');
        $userEntity = $userRepo->find($userId);
        if(!$userEntity) {
            $view = $this->view(array('state' => 'failure', 'message' => 'NO_USER'), 200)->setFormat("json");
            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $entity = new GameResult();
        $entity->setUserId($userEntity)
            ->setItemId($itemId)
            ->setChosenCategory($categoryName)
            ->setScoreBonus($scoreIncrement);

        $em->persist($entity);

        $statRepo = $em->getRepository('HackProxyBundle:UserStatistic');

        /** @var \Hack\Bundle\ProxyBundle\Entity\UserStatistic $statEntity */
        $statEntity = $statRepo->findOneBy(array('userId' => $userId));
        if($statEntity) {
            $statEntity->setScore($statEntity->getScore()+$scoreIncrement);
            $statEntity->setAnswersReplied($statEntity->getAnswersReplied()+1);
            $statEntity->setUserLevel($statEntity->getUserLevel()+$levelIncrement);
        }

        if(!$statEntity) {
            $statEntity = new UserStatistic();
            $statEntity->setUserId($userEntity);
            $statEntity->setScore(0+$scoreIncrement);
            $statEntity->setAnswersReplied(1);
            $statEntity->setUserLevel(1+$levelIncrement);
        }
        $em->persist($statEntity);
        $em->flush();

        $view = $this->view(array('state' => 'success', 'message' => $statEntity), 200)->setFormat("json");
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @todo : when full featured will come - add game creation and tracking,
     * @todo : then this action will come in to play.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullGameResultAction()
    {
        return $this->render('HackProxyBundle:GameResults:getFullGameResult.html.twig', array(
                // ...
            ));    }

}
