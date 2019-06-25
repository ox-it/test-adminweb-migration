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

  function getJobsFeedArray($page=0, $limit=50) {
    static $feed;
    if (is_array($feed)) return $feed;
    $feedxml = $this->getJobsFeedContents();
    try {
      $xml = Xml::build($feedxml);
    } catch (Cake\Utility\Exception\XmlException $e) {
      throw new InternalErrorException();
    }
    $feed = Xml::toArray($xml);

    // Only one vacancy - unlikely!
    if (isset($feed['currentVacancies']['vacancy']['recruitmentId'])) {
      $feed['currentVacancies']['vacancy'] = array($feed['currentVacancies']['vacancy']);
      return $feed;
    }

    foreach($feed['currentVacancies']['vacancy'] as $k => &$a) {
      $closes = empty($a['recruitmentClosesDate']) ? (
        empty($a['externalCloseDate']) ? (
          empty($a['externalCloseDateTime']) ? $a['endDate'] : $a['externalCloseDateTime']
        ) : $a['externalCloseDate']
      ) : $a['recruitmentClosesDate'];
      $a['closes'] = $closes;
    }

    $feed['currentVacancies']['vacancy'] = array_filter($feed['currentVacancies']['vacancy'], function($a) {
        return !empty($a['closes']);
    });

    usort($feed['currentVacancies']['vacancy'], function($a, $b) {
      return (strtotime($a['closes'])) - (strtotime($b['closes']));
    });

    $total = count($feed['currentVacancies']['vacancy']);
    if (count($feed['currentVacancies']['vacancy']) > $limit) {
      if (($page * $limit) > $total) $page = 0;
      $offset = $page * $limit;
      $feed['currentVacancies']['vacancy'] = array_splice($feed['currentVacancies']['vacancy'], $offset, $limit);
      $feed['pager'] = array(
        'offset' => $offset,
        'page' => $page,
        'limit' => $limit,
        'count' => count($feed['currentVacancies']['vacancy']),
        'pages' => ceil($total / $limit),
        'total' => $total
      );
    }

    return $feed;
  }

}