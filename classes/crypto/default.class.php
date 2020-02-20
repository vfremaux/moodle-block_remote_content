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
 * Default Crypto class. (do not crypt);
 *
 * @package   block_remote_content
 * @copyright 1999 onwards Valery Fremaux (https://www.activeprolearn.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

namespace \block_remote_content\crypto;

class default_crypto {

    protected $block;

    /**
     * Constructor
     * @param object $block the block instance
     */
    public function __construct($block) {
        $this->block = $block;
    }

    /**
     * Cryptographic
     * @param string $str the context query string to send.
     * @return the encrypted querystring
     */
    public function crypt($str) {
        return $str;
    }

}