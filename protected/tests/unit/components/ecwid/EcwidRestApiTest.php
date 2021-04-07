<?php

  Yii::import('application.components.ecwid.interfaces', true);
  Yii::import('application.tests.unit.components.ecwid.*');

  class EcwidRestApiTest extends DbTestCase
  {

    protected function setUp() {
      Yii::app()->name = 'site #1';
    }


    /**
     * Check RESTful type class correct parse json
     */
    public function testEcwidProductType() {
      /** @var \PHPUnit\Framework\TestCase|DbTestCase|EcwidRestApiTest $this */
      $response = (array)json_decode($this->_fixtures['EcwidProductType_success']);
      $obj = new EcwidProductType($response['items'][0]);
      $this->assertTrue((int)$obj->geId() > 0);
      $this->assertTrue((int)$obj->getRelatedId() > 0);

      $response = (array)json_decode($this->_fixtures['EcwidProductType_fault']);
      $obj = new EcwidProductType($response['items'][1]);
      $this->assertNull($obj->geId());
      $this->assertNull($obj->getRelatedId());
    }


    /**
     * @depends testEcwidProductType
     */
    public function testIterator() {
      $iterator = new EcwidRealLoader();

      /** @var DummyConnector $connector */
      $connector = $iterator->getConnector();

      $connector->loadResponseFixture($this->_fixtures['rest_response_iterator']);

      /** @var \PHPUnit\Framework\TestCase|DbTestCase|EcwidRestApiTest $this */
      foreach ($iterator as $k => $products) {
        $this->assertTrue(is_array($products));
        foreach ($products as $i) {
          $this->assertInstanceOf(EcwidProductType::class, $i);
        }
      }

      $iterator->rewind();
      // compare
      $this->assertTrue($iterator->valid());
      $this->assertTrue($iterator->key() === 0);
      $this->assertTrue($iterator->current()[0]->geId() == 111);
      $this->assertTrue($iterator->current()[1]->geId() == 222);

      $iterator->next();
      // compare
      $this->assertTrue($iterator->valid());
      $this->assertTrue($iterator->key() === 2);
      $this->assertTrue($iterator->current()[0]->geId() == 333);
      $this->assertTrue($iterator->current()[1]->geId() == 444);


      $iterator->next();
      // compare
      $this->assertFalse($iterator->valid());
    }


    /**
     * Check service returns FALSE whether product has not exported and TRUE otherwise
     *
     * @throws CDbException
     * @throws Exception
     * @depends testEcwidProductType
     */
    public function testSyncProductPrice() {
      $loader = new EcwidRealLoader();

      /** @var DummyConnector $connector */
      $connector = $loader->getConnector();

      $connector->loadResponseFixture($this->_fixtures['rest_response_syncProductPriceById_success']);

      $this->_loadFixture('products');
      /** @var \PHPUnit\Framework\TestCase|DbTestCase|EcwidRestApiTest $this */
      $result = $loader->syncProductPrice(new EcwidProductType((object) ['id' => '1234', 'price' => 0]));
      $this->assertTrue($result);

      $connector->loadResponseFixture($this->_fixtures['rest_response_syncProductPriceById_fault']);
      $result = $loader->syncProductPrice(new EcwidProductType((object) ['id' => '1234', 'price' => 0]));
      $this->assertFalse($result);

      try {
        $loader->syncProductPrice(new EcwidProductType((object)['id' => '1234']));
        $this->fail();
      } catch (Exception $e) {
        // success
      }
    }
  }