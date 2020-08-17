<?php
/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 */
namespace UDD\Parser\Client;

/**
 * Class PIM
 *
 * Client parser for pim (personal information manager) detection
 *
 * @package UDD\Parser\Client
 */
class PIM extends ClientParserAbstract
{
    protected $fixtureFile = 'regexes/client/pim.yml';
    protected $parserName = 'pim';
}
