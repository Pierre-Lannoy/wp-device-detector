<?php

declare(strict_types=1);

/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link https://matomo.org
 *
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 */

namespace UDD\Parser\Client;

/**
 * Class MobileApp
 *
 * Client parser for mobile app detection
 */
class MobileApp extends AbstractClientParser
{
    /**
     * @var string
     */
    protected $fixtureFile = 'regexes/client/mobile_apps.yml';

    /**
     * @var string
     */
    protected $parserName = 'mobile app';
}
