<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Manager\PlayerManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlayerController extends Controller
{
    /**
     * @Route("/login/", name="login")
     */
    public function loginAction(Request $request)
    {
        /** @var PlayerManager $playerManager */
        $playerManager = $this->get(PlayerManager::class);
        $playerManager->createPlayer([
            "age" => (int) $request->request->get("age"),
            "name" => $request->request->get("name"),
            "email" => $request->request->get("email"),
            "profession" => $request->request->get("profession"),
            "has_memory" => $request->request->get("has_memory"),
            "ip" => $request->getClientIp()
        ]);

        return $this->redirectToRoute('game_start');
    }
}
