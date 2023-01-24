<?php

namespace Model;

use db\MySQLConnection;
use model\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{

    /**
     * Tests set and get of ID of model
     *
     * @return void
     */
    public function testSetGetId(): void
    {
        $model = new Model(MySQLConnection::getDatabaseConnection());
        $setIdValue = 6;
        $model->ModelData = new \stdClass();
        $model->setId($setIdValue);
        $this->assertSame(
            $model->getId(),
            $setIdValue
        );
    }

    /**
     * Tests setting instance core as in getInstance()
     *
     * @return void
     */
    public function testSetInstanceCoreInstance(): void
    {
        $expectedIdOfModelInstance = 5;
        $model = Model::setInstanceCore(
            "model\\User",
            MySQLConnection::getDatabaseConnection(),
            $expectedIdOfModelInstance
        );
        $this->assertInstanceOf(
            "model\\User",
            $model,
        );
    }

    /**
     * Tests setting instance core as in getInstance()
     *
     * @return void
     */
    public function testSetInstanceCoreId(): void
    {
        $expectedIdOfModelInstance = 5;
        $model = Model::setInstanceCore(
            "model\\User",
            MySQLConnection::getDatabaseConnection(),
            $expectedIdOfModelInstance
        );
        $this->assertSame(
            $expectedIdOfModelInstance,
            $model->getId(),
        );
    }

}
