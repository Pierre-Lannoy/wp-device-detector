<?php
/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 */
namespace UDD\Parser\Client;

/**
 * Class Library
 *
 * Client parser for tool & software detection
 *
 * @package UDD\Parser\Client
 */
class Library extends ClientParserAbstract
{
    protected $fixtureFile = 'regexes/client/libraries.yml';
    protected $parserName = 'library';
}
