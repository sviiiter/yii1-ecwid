<?php

  /**
   * Class EcwidRestConnector sends request to the Ecwid server through Rest Api version 2
   */
  class EcwidRestConnector extends EcwidRestService
  {

    private $_storeId;

    private $_token_private;

    public $host;

    public $version;


    private static function __send($url, $params, $type) {

      $curl = curl_init();

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HEADER, false);

      curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
      curl_setopt($curl, CURLOPT_URL, $url);

      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);

      if ($params) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
      }

      $out = curl_exec($curl);
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);

      return [
          'code' => $code,
          'data' => $out
        ];
    }


    /**
     * @inheritdoc
     */
    public function exportProduct(EcwidProductType $product) {
      $url = strtr('{host}/api/{version}/{store}/products/{productId}?{query}', [
        '{host}' => $this->host,
        '{version}' => $this->version,
        '{store}' => $this->_storeId,
        '{productId}' => $product->geId(),
        '{query}' => http_build_query(['token' => $this->_token_private])
      ]);

      $result = static::__send($url, json_encode($product), 'PUT');

      if ($result['code'] != 200) {
        Yii::log(sprintf('Api returns: %s', var_export($result, true)), CLogger::LEVEL_WARNING, get_class($this));
        return false;
      }

      return $result['data'];
    }


    /**
     * @inheritdoc
     */
    public function getProducts($offset, $limit = 100) {
      $url = strtr('{host}/api/{version}/{store}/products?{query}', [
        '{host}' => $this->host,
        '{version}' => $this->version,
        '{store}' => $this->_storeId,
        '{query}' => http_build_query([
          'token' => $this->_token_private,
          'offset' => $offset,
          'limit' => $limit
        ])
      ]);
      $result = static::__send($url, null, 'GET');

      if ($result['code'] != 200) {
        Yii::log(sprintf('Api returns: %s', var_export($result, true)), CLogger::LEVEL_WARNING, get_class($this));
        return false;
      }

      return $result['data'];
    }


    public function setStoreId($val) {
      $this->_storeId = $val;
    }


    public function setTokens($val) {
      $this->_token_private = $val['private'];
    }
  }