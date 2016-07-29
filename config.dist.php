<?php

return array(

    /**
     * Credentials for database access
     */
    'Database' => array(
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => '',
        'db'     => 'notes',
        'port'   => 3306,
        'socket' => '/var/run/mysqld/mysqld.sock'
    ),

    /**
     * List of allowed users, passwords MUST hashed by SHA1, not plain text!
     * You can build the md5 hashes for example here: http://onlinemd5.com/
     */
    'BasicAuth' => array(
//      'user1' => 'SHA1 hashed password1',
//      'user2' => 'SHA1 hashed password2',
//      ...
    ),

    /**
     * How to list notes in overview and tag search, as
     * - plain : just paragraphs
     * - list  : unordered list
     * - table : striped table
     */
    'List' => 'plain',
//  'List' => 'list',
//  'List' => 'table',

    /**
     * Frontend language
     * en, de
     */
    'Language' => 'en',

    /**
     * Format for created and changed timestamps
     */
    'DateTimeFormat' => 'Y-m-d H:i',
//  'DateTimeFormat' => 'Y-m-d H:i:s',
//  'DateTimeFormat' => 'Y-m-d',
//  'DateTimeFormat' => 'd. M Y \a\t H:i',

    /**
     * Hash tags must
     * - start with a char
     * - followed by chars, digits or underlines (at least one)
     * matches     : #t1 #tt #test #t_123
     * matches NOT : #t #_t #1 #123 #_123
     */
    'HashTagRegex' => '[a-zA-Z][a-zA-Z0-9_]+',

//  Example for a min. length of 4 chars : 1st chars plus 3 or more
//  'HashTagRegex' => '[a-zA-Z][a-zA-Z0-9_]{3,}',
  
);
