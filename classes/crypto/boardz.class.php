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
 * Boardz Crypto class. (crypt using "one of" a set of methods);
 *
 * this crypto class encrypts the context querystring with several methods
 * to send to a Boardz Server. the Boardz Server is a "global moodle dedicated
 * data Extract/Transform and Render software for deep data analytics.
 * @see boardz.docs.activeprolearn.com
 *
 * @package   block_remote_content
 * @copyright 1999 onwards Valery Fremaux (https://www.activeprolearn.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

namespace \block_remote_content\crypto;
require_once($CFG->dirroot.'/blocks/remote_content/classes/crypto/default.class.php');

/**
 * Boardz crypto implements algorithms to send crypted context to a Boardz 2 Server.
 */
class boardz_crypto extends default_crypto {

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
        global $DB, $CFG;

        if (empty($this->block->config->contextkey)) {
            return $str;
        }

        $method = $this->block->config->preferedcrypto;

        if ($method == 'internal') {
            // Internal algorithm. Not robust. No environement dependency.
            $key = $this->block->config->contextkey;

            while (strlen($key) < strlen($str)) {
                // Pad key onto itself to get a key larger than the text.
                $key .= $key;
            }

            $encrypted = '';

            // Iterate through each character
            for ($i = 0; $i < strlen($str); $i++) {
                    $encrypted .= $str{$i} ^ $key{$i};
            }
        } else if ($method == 'rsa') {
            // RSA algorithm. Robust. Dependency to openssl.
            include_once($CFG->dirroot.'/mnet/lib.php');
            $keypair = mnet_get_keypair();

            if (!openssl_public_encrypt($str, $encrypted, $keypair['publickey'])) {
                print_error("Failed making encoded ticket");
            }
        } else {
            // AES algorithm. Robust. Dependency to mysql librairies. Not working on POSTgreSQL.
            $pkey = substr(base64_encode($this->block->config->contextkey), 0, 16);

            $sql = "
                SELECT
                    HEX(AES_ENCRYPT(?, ?)) as result
            ";

            if ($result = $DB->get_record_sql($sql, array($str, $pkey))) {
                $encrypted = $result->result;
            } else {
                $encrypted = 'encryption error';
            }
        }

        return base64_encode($encrypted); // Make sure we can emit this ticket through an URL.
    }
}