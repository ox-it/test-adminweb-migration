<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Exception\AuthSecurityException;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Filesystem\File;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

  /**
   * Initialization hook method.
   *
   * Use this method to add common initialization code like loading components.
   *
   * e.g. `$this->loadComponent('Security');`
   *
   * @return void
   */
  public function initialize()
  {
    parent::initialize();

    $this->loadComponent('RequestHandler', [
        'enableBeforeRedirect' => false,
    ]);
    $this->loadComponent('Flash');
    $this->loadComponent('Waf');

    /*
     * Enable the following component for recommended CakePHP security settings.
     * see https://book.cakephp.org/3.0/en/controllers/components/security.html
     */
    $this->loadComponent('Security');

    // Always make WafComponent available to views
    $this->set('waf', $this->Waf);
  }

  // For custom timeout message
  public function beforeFilter(Event $event)
  {
      parent::beforeFilter($event);
      $this->Security->setConfig('blackHoleCallback', 'blackhole');
  }

  public function blackhole($type, $exception)
  {

      if ($type === 'auth' && $exception instanceof AuthSecurityException) {
        if ($exception->getMessage() === 'Bad Request') {
            $this->Flash->error("This form has timed out, please try resubmitting, or refresh the page and start again.");
        }
      }

      elseif ($type === 'secure' && $exception instanceof SecurityException)  {
        if ($exception->getMessage() === 'Request is not SSL and the action is required to be secure') {
          $exception->setMessage(__('Please access the requested page through HTTPS'));
        }
        throw $exception;
      }

  }

  // Allows easy access to a Controller's JS script file
  public function script()
  {
    $file = new File(WWW_ROOT . env('jsBaseUrl','js/') . $this->name . '/script.js');
    $script = $file->read();
    $response = $this->response;
    $response->body($script);
    $response = $response->withType('js');
    return $response;
  }

  // Allows easy access to a Controller's CSS style file
  public function style()
  {
    $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . $this->name . '/style.css');
    $css = $file->read();
    $response = $this->response;
    $response->body($css);
    $response = $response->withType('css');
    return $response;
  }

  // Allows easy access to the universal css file
  public function css()
  {
    $file = new File(WWW_ROOT . env('cssBaseUrl','css/') . 'waf.css');
    $css = $file->read();
    $response = $this->response;
    $response->body($css);
    $response = $response->withType('css');
    return $response;
  }

}
