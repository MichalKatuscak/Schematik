<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Top;
use AppBundle\Manager\GameManager;
use AppBundle\Manager\SchemaManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    /**
     * @Route("/zacatek", name="game_start")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $gameManager = $this->get(GameManager::class);

        if (!$gameManager->getPlayer()) {
            return $this->redirectToRoute('open');
        }

        $gameManager = $this->get(GameManager::class);

        $player = $gameManager->getPlayer();

        if ($gameManager->isFirstRound()) {
            $limit = $gameManager->getLimit();
            $schema = $gameManager->nextRound();
        } else {
            return $this->redirectToRoute('game_step', [
                "step" => $player->getStep()
            ]);
        }

        return $this->render('game/index.html.twig', [
            'limit' => $limit,
            'schema' => $schema,
            'player' => $player,
        ]);
    }

    /**
     * @Route("/krok/{step}", name="game_step")
     * @param Request $request
     * @param $step
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function stepAction(Request $request, $step)
    {
        $gameManager = $this->get(GameManager::class);

        if (!$gameManager->getPlayer()) {
            return $this->redirectToRoute('open');
        }

        if (!$gameManager->isGoodTime() || !$gameManager->isValidStep($step)) {
            return $this->redirectToRoute('game_over');
        }
        
        if ($this->isFormPosted($request)) {
            $data = $request->request->all();
            
            if (!$gameManager->validateStep($data)) {
                return $this->redirectToRoute('game_error');
            }
        }

        $player = $gameManager->getPlayer();

        $schema = $gameManager->nextRound();
        $limit = $gameManager->getLimit();

        return $this->render('game/index.html.twig', [
            'limit' => $limit,
            'schema' => $schema,
            'player' => $player,
        ]);
    }
    
    private function isFormPosted(Request $request)
    {
        return count($request->request->all()) > 0;
    }

    /**
     * @Route("/vyprsel_cas", name="game_over")
     */
    public function overAction()
    {
        return $this->over("over");
    }

    /**
     * @Route("/konec", name="game_finish")
     */
    public function finishAction()
    {
        return $this->over("finish");
    }

    /**
     * @Route("/chyba", name="game_error")
     */
    public function errorAction(Request $request)
    {
        return $this->over("error");
    }

    private function over($name)
    {
        $gameManager = $this->get(GameManager::class);

        if (!$gameManager->getPlayer()) {
            return $this->redirectToRoute('open');
        }

        $player = $gameManager->getPlayer();
        list($good, $bad) = $gameManager->overGame();

        $all = $bad + $good;
        if (!$all) $all = 1;
        $percent = round(100/$all*$good);

        return $this->render('game/'.$name.'.html.twig', [
            'player' => $player,
            'bad' => $bad,
            'good' => $good,
            'percent' => $percent,
            'all' => $all,
        ]);
    }

    /**
     * @Route("/schema/{id}", name="schema")
     */
    public function schemaAction($id)
    {
        $gameManager = $this->get(GameManager::class);
        $schemaManager = $this->get(SchemaManager::class);

        if (!$gameManager->getPlayer()) {
            return $this->redirectToRoute('open');
        }

        $schema = $schemaManager->find($id);

        return $this->render('game/schema.html.twig', [
            'schema' => $schema,
        ]);
    }

}
