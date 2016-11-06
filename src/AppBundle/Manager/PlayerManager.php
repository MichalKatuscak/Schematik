<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use AppBundle\Entity\Top;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

final class PlayerManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    private $playerRepository;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var Session
     */
    private $session;

    /**
     * PlayerManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, Session $session)
    {
        $player_id = (int) $session->get("player_id");

        $this->entityManager = $entityManager;
        $this->playerRepository = $entityManager->getRepository(Player::class);
        $this->player = $this->playerRepository->find($player_id);
        $this->session = $session;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Increment step in player parameter and save
     */
    public function nextStep()
    {
        $player = $this->player;
        $player->setStep($player->getStep() + 1);
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }

    public function addResult($schema, $bad, $good)
    {
        $result = new Result();
        $result->setBad($bad);
        $result->setGood($good);
        $result->setImage($schema);
        $result->setPlayer($this->player);
        $result->setIsPassibleMoreResult(false);
        $this->entityManager->persist($result);

        $this->entityManager->flush();
    }

    public function addToTop($good)
    {
        /** @var Top $top */
        $top = new Top();
        $top->setPlayer($this->player);
        $top->setAdded(new \DateTime());
        $top->setPoints($good);

        $this->entityManager->persist($top);
        $this->entityManager->flush();
    }

    public function createPlayer($data)
    {
        if ($data["has_memory"]) {
            setcookie("age", $data["age"], time()+60*60*24*31, "/");
            setcookie("name", $data["name"], time()+60*60*24*31, "/");
            setcookie("profession", $data["profession"], time()+60*60*24*31, "/");
            setcookie("email", $data["email"], time()+60*60*24*31, "/");
        }

        $player = new Player();
        $player->setIp($data["ip"]);
        $player->setAge($data["age"]);
        $player->setProfession($data["profession"]);
        $player->setName($data["name"]);
        $player->setEmail($data["email"]);
        $player->setStep(0);

        $this->entityManager->persist($player);
        $this->entityManager->flush();

        $this->session->set("player_id", $player->getId());
    }
}