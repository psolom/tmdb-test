<?php

namespace Hook;

use Composer\Script\Event;

class Composer
{
    /**
     * Post install hook
     * @param \Composer\Script\Event $event
     */
    public static function postInstall(Event $event)
    {
        self::migrate();
    }
    /**
     * Post update hook
     * @param \Composer\Script\Event $event
     */
    public static function postUpdate(Event $event)
    {
        self::migrate();
    }

    /**
     * Executes migrations and outputs result
     */
    public static function migrate()
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