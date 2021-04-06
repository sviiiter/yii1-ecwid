<?php

  /**
   * Class EcwidRealLoader is implementation of EcwidLoader with real connector
   */
  class EcwidRealLoader extends EcwidLoader
  {
    public function getConnector(): EcwidRestService {
      return Yii::app()->ecwid;
    }
  }