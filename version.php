<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details.
 *
 * @package    block_remote_content
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2017020701;        // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2019051100;        // Requires this Moodle version.
$plugin->component = 'block_remote_content';      // Full name of the plugin (used for diagnostics).
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = '3.7.0 (build 2017020701)';

// Advanced attributes
$plugin->supports = [37,37];
$plugin->incompatible = 38;

// Non Moodle attributes.
$plugin->codeincrement = '3.7.0000';
