<?php

  /**
   * Class EcwidRestService should be implemented in real connectors
   */
  abstract class EcwidRestService extends CComponent
  {

    const OFFSET_STEP = 100;


    /**
     * Get next batch of products
     *
     * @param $offset
     * @param int $limit
     *
     * @return mixed
     */
    abstract public function getProducts($offset, $limit = 100);


    /**
     * Upload the product
     *
     * @param EcwidProductType $product
     *
     * @return mixed
     */
    abstract public function exportProduct(EcwidProductType $product);


    /**
     * Required method to use class as component
     */
    public function init() {}
  }


  /**
   * Class EcwidProductType
   *
   * @property float price
   * @property int id
   */
  class EcwidProductType
  {
    const RELATED_ID_ATTRIBUTE_NAME = 'test id';

    /** @var int */
    protected $id = null;

    /** @var  array */
    protected $attributes;


    public $price = null;


    public function __construct() {
      $params = func_get_args()[0];
      foreach ($params as $key => $param) {
        if (property_exists($this, $key)) {
          $this->$key = $param;
        }
      }
    }


    /**
     * @return int Ecwid's id
     */
    public function geId() {
      return $this->id;
    }


    /**
     * Return local product's id
     *
     * @return int|null
     */
    public function getRelatedId() {
      foreach ((array)$this->attributes as $a) {
        if (mb_strtolower($a->name, 'UTF-8') === self::RELATED_ID_ATTRIBUTE_NAME) {
          return (int)$a->value ?? null;
        }
      }

      return null;
    }
  }