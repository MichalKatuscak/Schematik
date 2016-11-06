<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Top;
use AppBundle\Manager\SchemaManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="open")
     */
    public function indexAction()
    {
        /** @var SchemaManager $schemaManager */
        $schemaManager = $this->get(SchemaManager::class);
        $em = $this->getDoctrine()->getManager();

        $tops = $em->getRepository(Top::class)->findBy([], ["points"=>"DESC"], 5);
        $tops_week = $em
                    ->createQuery('SELECT t FROM AppBundle:Top t WHERE t.added > \''.date("Y-m-d",time()-7*24*60*60).'\' ORDER BY t.points DESC')
                    ->setMaxResults(5)
                    ->getResult();

        $schema_1 = $schemaManager->generateSchema(2);
        $schema_2 = $schemaManager->generateSchema(2);

        return $this->render('open.html.twig', [
            'tops' => $tops,
            'tops_week' => $tops_week,
            'schema_1' => $schema_1,
            'schema_2' => $schema_2,
        ]);
    }
}
