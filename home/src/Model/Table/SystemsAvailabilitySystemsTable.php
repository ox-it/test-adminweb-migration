<?php
// src/Model/Table/SystemsAvailabilitySystemsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;

class System {

  /**
   * The name of the pane.
   * @var string
   */
  public $name;

  /**
   * The item's database ID.
   * @var integer
   */
  public $id;

  /**
   * The level of alert for the system. An string that is part of the corresponding schema.
   * @var string
   */
  public $level;

  /**
   * A brief description of the sever's status.
   * @var string
   */
  public $text;

  /**
   * A more detailed description of the system's status.
   * @var string
   */
  public $details;

  /**
   * A URL for the server's location.
   * @var string
   */
  public $url;

  /**
   * How important the System is. This influences the order in which it is displayed.
   *
   * @var integer
   */
  public $priority;

  /**
   * The last time a value for the pane was stored, in the Unix timestamp format.
   * @var int
   */
  public $time_changed;

  /**
   * A list of all pane instances created with the method add_pane();
   * @var array()
   */
  public static $instances = array();

  /**
   * A description of the pane and how its corresponding HTML is organised.
   * @var array
   */
  public static $schema = array(
    'level' => array(
      'type' => 'select',
      'options' => array(), // set in System::init() to System::$levels' keys;
    ),
    'text' => array(
      'type' => 'text',
    ),
    'details' => array(
      'type' => 'text',
    ),
  );

  /**
   *  The construnctor for the System class object only
   * needs to take a name as parameter, because the object
   * will really be filled by unserialization.
   * @param string $name The name of the System
   */
  public function __construct($name) {
    $this->$name = $name;
  }

  /**
   * Return a formatted string of when the item was last changed.
   * @return string Last changed date
   */
  public function time() {
    return date('j F Y, H:i', $this->time_changed); // 12 October 2010, 09:14
    // return date('j F Y, h:ia', $this->time_changed); // 12 October 2010, 09:14am
  }

  /**
   * Return the item's level name, as opposed to the actual level colour.
   * @return string Level name
   */
  public function levelName() {
     if (isset($this->level)) return self::$levels[$this->level];
  }

  /**
   * A array associated level colours with level names.
   * @var Array
   */
  public static $levels = array(
    'green' => 'Available',
    'amber' => 'Partial',
    'red' => 'Unavailable',
  );

  /**
   * When we print the System, we only really need to print
   * its ID.
   *
   * @return string The ID of the system.
   */
  public function __toString() {
    return $this->id;
  }

  /**
   * Add error to the object's list of erros or display them.
   *
   * @param string|bool $where If a bool, whether to return the list of errors.
   * If a string, add the sepcified field as corrupt.
   */
  public function raise_error($where) {
    static $errors = array();
    if ($where === true) return $errors;
    $errors[] = $where;
  }

  /**
   * Simple wrapper for the database function.
   */
  public static function load_from_db() {
    // Sanitize $view;
    $view = isset($_GET['view']) ? (integer) $_GET['view'] : 0;
    $view = $view ? $view : false;
    System::$instances = db_get($view);
  }

  /**
   * Calls and configures PHPTAL. Adds the right data to it
   * and uses it to display the required page.
   *
   * @param string $action Which page to show.
   */
  static public function display($action) {
    if (!file_exists("$action.html")) return;
    $template = new PHPTAL("$action.html");
    $template->setPhpCodeDestination('./tmp/');
    // $template->setPostFilter(new RestoreBrTags());
    $template->instances = self::$instances;
    $template->levels = self::$levels;
    switch ($action) {
      case 'boxes':
        $template->setPostFilter(new RestoreBrTags());
        break;
      case 'manage':
        View::init();
        $template->views = View::$instances;
        break;
    }
    print $template->execute();
  }

  /**
   * Initializes the static data.
   */
  public static function init() {
    self::$schema->level->options = array_keys(self::$levels);
    // Get all the needed views from the database;
    self::load_from_db();

  }
}

class SystemsAvailabilitySystemsTable extends Table
{

		public static function defaultConnectionName() {
				return 'systems_availability-test';
		}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');

		$this->setTable('systems');
		$this->table('systems');    			// Prior to 3.4.0

		$this->belongsToMany('SystemsAvailabilityViews',[
      'through' => 'SystemsAvailabilityRelations',
      //'foreignKey' => 'system_id',
      'targetForeignKey' => 'view_id'
    ]);

    //$this->hasMany('SystemsAvailabilityRelations')->setForeignKey('system_id');

	}

	public function getSystemsForViewID($viewID = null) {
		$query = $this->find('all')
			->contain([ 'SystemsAvailabilityViews' ])
			->matching( 'SystemsAvailabilityViews' )
			->where([ 'SystemsAvailabilityViews.id' => $viewID ])
			->order([ 'SystemsAvailabilityRelations.position' => 'DESC' ])
			;
		$systems = $query->all();
		foreach($systems as $system) {
		  $data = get_object_vars(unserialize($system->data));
		  //print_r($data);
		  $system->url = empty($data['url']) ? '' : $data['url'];
		  $system->level = empty($data['level']) ? 'unknown' : $data['level'];
		  $system->levelName = $this->getNameOfLevel($system->level);
		  $system->text = empty($data['text']) ? '' : $data['text'];
		  $system->details = empty($data['details']) ? '' : $data['details'];
		  $system->time = empty($data['time']) ? time() : $data['time'];
		}
		return $systems;
	}

	private function getNameOfLevel($level) {
	  $names = [ 'green' => 'Available', 'amber' => 'Partial', 'red' => 'Unavailable' ];
    return array_key_exists($level, $names) ? $names[$level] : 'Unknown';
  }

}