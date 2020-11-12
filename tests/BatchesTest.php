<?php

use PHPUnit\Framework\TestCase;

\ShipEngine\ShipEngine::setApiKey('TEST_F1CUc3ZlfjwGaHZ9dEmgvOH9WHiVM+IB7zWCiyg8WZ4');

class BatchesTest extends TestCase
{
    public function testCreate(): void
    {

    }

    public function testList()
    {
        $list = ShipEngine\Batch::list();

        $this->assertIsArray($list);
        $this->assertArrayHasKey('batches', $list);
    }

//    public function testCreate()
//    {
//
//    }
//
//    public function testGetByExternalId()
//    {
//
//    }
//
//    public function testDelete()
//    {
//
//    }
//
//    public function testGetById()
//    {
//
//    }
//
//    public function testUpdateById()
//    {
//
//    }
//
//    public function testAddToBatch()
//    {
//
//    }
//
//    public function testGetErrors()
//    {
//
//    }
//
//    public function testProcess()
//    {
//
//    }
//
//    public function testRemoveFromBatch()
//    {
//
//    }
}
