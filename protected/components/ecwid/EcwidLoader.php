<?php
  Yii::import('application.components.ecwid.types', true);

  /**
   * Class EcwidLoader is the layer between local DB's data and rest connector. Save or select the data.
   */
  abstract class EcwidLoader implements Iterator
  {

    private $_offset;


    /**
     * @var EcwidProductType[]
     */
    private $data = [];


    abstract protected function getConnector(): EcwidRestService;


    public function current() {
      return $this->data;
    }


    public function key() {
      return $this->_offset;
    }


    public function valid() {
      return (bool) $this->data;
    }


    public function next() {
      $connector = $this->getConnector();
      $this->_offset += $connector::OFFSET_STEP;
      $this->data = static::parseIterationResponse($this->getConnector()->getProducts($this->_offset));
    }


    public function rewind() {
      $this->_offset = 0;
      $this->data = static::parseIterationResponse($this->getConnector()->getProducts($this->_offset));
    }


    /**
     * @param $response
     *
     * @return EcwidProductType[]
     * @throws Exception
     */
    private static function parseIterationResponse($response) {
      $aResponse = (array)json_decode($response);

      if (!isset($aResponse['items'])) {
        throw new Exception(sprintf('Unexpected response: %s', var_export($response, true)));
      }

      return  array_map(function($i) {  return new EcwidProductType($i);  } , (array) $aResponse['items']);
    }


    /**
     * Export product to Ecwid's server
     *
     * @param EcwidProductType $obj
     *
     * @return bool
     * @throws Exception
     */
    public function syncProductPrice(EcwidProductType $obj) {
      if ($obj->price === null) {
        throw new Exception('The price is required');
      }

      $response = $this->getConnector()->exportProduct($obj);

      $aResponse = (array)json_decode($response);

      if (!isset($aResponse['updateCount'])) {
        throw new Exception(sprintf('Unexpected response: %s', var_export($response, true)));
      }

      return $aResponse['updateCount'] == 1;
    }
  }