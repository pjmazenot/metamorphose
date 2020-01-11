<?php

namespace Tests\Codeception\Helper;

use Codeception\Module;

/**
 * Class DebugHelper
 *
 * Customer action for debug.
 * All public methods declared in helper class will be available in $I
 *
 * @package Tests\Codeception\Helper
 */
class DebugHelper extends Module
{
    /**
     * Print debug message to the screen.
     *
     * @param $message
     */
    public function debug($message): void {

        codecept_debug($message);

    }
}
