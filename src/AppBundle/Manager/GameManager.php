<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Image;
use AppBundle\Entity\Top;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

final class GameManager
{
    /**
     * @var SchemaManager
     */
    private $schemaManager;
    
    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var Session
     */
    private $session;

    /**
     * GameManager constructor.
     * @param SchemaManager $schemaManager
     * @param PlayerManager $playerManager
     * @param Session $session
     */
    public function __construct(SchemaManager $schemaManager, PlayerManager $playerManager, Session $session)
    {
        $this->schemaManager = $schemaManager;
        $this->playerManager = $playerManager;
        $this->session = $session;
    }

    public function getPlayer()
    {
        return $this->playerManager->getPlayer();
    }

    public function overGame()
    {
        $results = $this->getPlayer()->getResults();

        $bad = 0;
        $good = 0;

        foreach ($results as $result) {
            $bad += $result->getBad();
            $good += $result->getGood();
        }
        
        $this->playerManager->addToTop($good);

        $this->session->set("player_id", null);

        return [
            $good,
            $bad
        ];
    }

    public function isFirstRound()
    {
        return 0 === $this->playerManager->getPlayer()->getStep();
    }

    public function isGoodTime()
    {
        $session = $this->session;

        // Minuta rezerva kdyby byly problémy s připojením
        return ($session->get("start") + $session->get("limit")) >= (time() + 60);
    }

    public function isValidStep($step)
    {
        return $step != $this->getPlayer()->getStep();
    }

    public function nextRound()
    {
        $schemaManager = $this->schemaManager;
        $session = $this->session;

        $step = $this->getPlayer()->getStep();
        $level = $this->getLevel();
        $limit = $this->getLimit();

        $schema = $schemaManager->generateSchema($level);

        $session->set("limit", $limit);
        $session->set("start", time());
        $session->set("step", $step);
        $session->set("schema_id", $schema->getId());

        $this->playerManager->nextStep();

        return $schema;
    }
    
    public function validateStep($data)
    {
        $session = $this->session;
        
        $schema_id = $session->get("schema_id");
        $schema = $this->schemaManager->find($schema_id);
        $results = (array) \json_decode($schema->getResult());
        $chars = explode(",",$schema->getUsedChars());

        $bad = 0;
        $good = 0;
        foreach ($chars as $iterator => $char) {
            $ok_result = $results[$char];

            if ($data["results_" . $iterator] == $ok_result) {
                $good++;
            } else {
                $bad++;
            }
        }

        $this->playerManager->addResult($schema, $bad, $good);

        if ($bad > 0) {
            return false;
        }

        return true;
    }
    
    public function getLimit()
    {
        if (!$this->getPlayer()) {
            return 0;
        }

        if ($this->isFirstRound()) {
            return 5*60;
        }
        
        return pow(2, $this->getLevel())*60;
    }
    
    public function getLevel()
    {
        if (!$this->getPlayer()) {
            return 0;
        }

        $step = $this->getPlayer()->getStep();
        return floor($step/3) + 1;
    }
}