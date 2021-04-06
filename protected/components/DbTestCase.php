<?php

/**
 * Changed variant of `CDbTestCase` to load fixture file located nearby a test
 * file. On setUp() loads fixture file <test_filename>.fixture.php from the same
 * directory as a test file. Provides protected method to load fixture data
 * into database.
 *
 * Fixture file structure:
 * ```
 * return [
 *   '<fixture_name>' => [
 *     '<model_class_name>' => [
 *       '<column_name>' => <value>,
 *       ...
 *       '<column_name>' => <value>
 *      ], [
 *       '<column_name>' => <value>,
 *       ...
 *       '<column_name>' => <value>
 *      ]
 *   ]
 * ]
 * ```
 *
 * Example:
 * ```
 * return [
 *   'stock_update' => [
 *     'Supplier' => [
 *       'supplier_id' => 1,
 *       'name' => 'Test'
 *     ],
 *     [
 *       'supplier_id' => 2,
 *       'name' => 'Test #2'
 *     ]
 *   ]
 * ]
 * ```
 *
 * Usage from test:
 * ```
 *   $this->_loadFixture(<fixture_name>);
 * ```
 */
abstract class DbTestCase extends CDbTestCase {

  /**
   * @var mixed
   */
  protected $_fixtures;

  public function __construct() {
    parent::__construct(...func_get_args());

    // get inherited class file location
    $file = (new ReflectionClass(get_class($this)))->getFileName();
    $fixtureFile = dirname($file) . DIRECTORY_SEPARATOR . basename($file, '.php') . '.fixture.php';
    $this->_fixtures = require $fixtureFile;
  }

  /**
   * Create model schema in database if not exists, truncate existing table data
   * and replace by the data from fixture.
   *
   * @param $name string Fixture name
   * @throws CDbException
   * @throws CException
   */
  protected function _loadFixture($name) {
    // Drop all database tables if any.
    $tables = Yii::app()->db->schema->getTableNames();
    foreach ($tables as $table) {
      Yii::app()->db->createCommand()->dropTable($table);
    }
    // Reload the database schemas after deletion.
    Yii::app()->db->schema->refresh();

    foreach ($this->_fixtures[$name] as $modelName => $rows) {
      // Create new model tables.
      foreach ($modelName::model()->getTableCreateSchemas() as $schema) {
        $this->_getDbConnection()->createCommand($schema)->execute();
      }

      // Load a fixture data into the tables.
      foreach ($rows as $row) {
        $model = new $modelName();
        foreach ($row as $name => $value) {
          $model->$name = $value;
        }

        if (!$model->save()) {
          throw new CDbException(__LINE__ . ' : ' . var_export($model->getErrors(), true));
        }
      }
    }
  }

  /**
   * Return current database connection.
   *
   * @return CDbConnection
   * @throws CException
   */
  protected function _getDbConnection() {
    $connection = Yii::app()->getComponent('db');
    if (!$connection instanceof CDbConnection) {
      throw new CException(
        Yii::t('yii', 'The "db" application component must be configured to be a CDbConnection object.')
      );
    }
    return $connection;
  }

  /**
   * Return FixtureManager component.
   *
   * @return CDbFixtureManager
   */
  protected function _getFixtureManager() {
    return Yii::app()->getComponent('fixture');
  }
}
