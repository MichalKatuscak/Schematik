<?php

namespace AppBundle\Controller;

use AppBundle\Manager\SchemaManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SchemaController extends Controller
{
    /**
     * @Route("/schema/{id}", name="schema")
     */
    public function indexAction($id)
    {
        $schemaManager = $this->get(SchemaManager::class);

        $schema = $schemaManager->find($id);

        return $this->render('game/schema.html.twig', [
            'schema' => $schema,
        ]);
    }

}
