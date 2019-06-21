<?php
// src/Form/JobsForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Xml;
use Cake\Utility\Exception\XmlException;

class JobsForm extends Form
{

  static $replace = [
    ["\xc2\x96","\xc2\x91","\xc2\x92","\n","\r"],
    ['&ndash;' ,'&lsquo;' ,'&rsquo;', '',  '' ]
  ];

  function getJobsFeedContents() {
    static $contents;
    if (!empty($contents)) return $contents;

    $file = new File(ROOT . '/includes/jobs-feed.xml');
    $contents = $file->read();
    //$contents = mb_convert_encoding($contents, 'UTF-8', 'ISO-8859-1');
    $contents = str_replace(self::$replace[0], self::$replace[1], $contents);

    return $contents;
  }

  function getJobsFeedArray() {
    static $feed;
    if (is_array($feed)) return $feed;
    $feedxml = $this->getJobsFeedContents();
    try {
      $xml = Xml::build($feedxml);
    } catch (Cake\Utility\Exception\XmlException $e) {
      throw new InternalErrorException();
    }
    $feed = Xml::toArray($xml);
    return $feed;
  }

}