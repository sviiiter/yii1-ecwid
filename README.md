# yii1-ecwid
upload product to Ecwid server

Usage:
```php
Yii::import('application.components.ecwid.*'); // whether it wasn't imported yet with config

class ExportCommand extends CConsoleCommand
{

public function actionEcwidSyncProducts() {
  $iterator = new EcwidRealLoader();
  
  /** @var EcwidLoader $iterator */
  foreach ($iterator as $k => $products) { // request next batch of products from remote server
    
   /** @var EcwidProductType[] $products */
   foreach ($products as $ecwidProductObject) {
    $ecwidProductObject->price = floatval(100);
       
    // upload to remote server
    $iterator->syncProductPrice($ecwidProductObject);
   }
}
```

Start:


```
cd protected
composer install
php vendor/bin/codecept build
php yiic.php export ecwidSyncProducts
```
