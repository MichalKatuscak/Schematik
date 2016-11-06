<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\Schema;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SchemaTest extends WebTestCase
{
    public function testReturning()
    {
        $schema = new Schema();

        $this->assertNotEquals("", (string) $schema);
    }

    public function testIsReturnArray()
    {
        $schema = new Schema();

        $this->assertTrue(is_array($schema->getSchema()));
        $this->assertTrue(!empty($schema->getSchema()["data"]));
        $this->assertTrue(!empty($schema->getSchema()["result"]));
        $this->assertTrue(!empty($schema->getSchema()["used_chars"]));
    }

    public function testHaveSchemaWellCountElements()
    {
        for($level=1;$level<20;$level++) {
            $schema = new Schema($level);
            $this->assertEquals($this->getElementCounts($schema), $level);
        }
    }

    private function getElementCounts(Schema $schema)
    {
        $xml = @simplexml_load_string($schema->getSchema()["data"]);

        return $xml->children()->polyline->count() / 2 / 2;
    }
}