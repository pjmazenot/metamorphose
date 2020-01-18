<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
