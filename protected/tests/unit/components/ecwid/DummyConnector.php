<?php

  /**
   * Class DummyConnector returns fixture's case
   */
  class DummyConnector extends EcwidRestService
  {

    const OFFSET_STEP = 2;

    /** @var  array */
    private $_loaded_fixture;


    protected function toObj($array) {
      return json_encode($array);
    }

    /**
     * @inheritdoc
     */
    public function getProducts($offset, $limit = 100) {
      return $this->_loaded_fixture[__FUNCTION__  . '_' . $offset];
    }

    /**
     * @inheritdoc
     */
    public function exportProduct(EcwidProductType $product) {
      return $this->_loaded_fixture[__FUNCTION__];
    }


    public function loadResponseFixture(array $fixture) {
      $this->_loaded_fixture = $fixture;
    }
  }