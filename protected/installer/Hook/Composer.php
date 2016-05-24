<?php

namespace Hook;

use Composer\Script\Event;

class Composer
{
    /**
     * Executes migrations
     * @param \Composer\Script\Event $event
     */
    public static function postUpdate(Event $event)
    {
        // if SQLite doesn't exist
        if(!is_file(dirname(__FILE__).'/../../data/tmdb.db')) {
            $yiic = realpath(dirname(__FILE__).'/../../yiic.php');
            // execute migration command
            $output = shell_exec("php {$yiic} migrate --interactive=0");
            echo "\n{$output}\n";
        }
    }
}