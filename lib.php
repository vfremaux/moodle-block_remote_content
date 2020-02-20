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

defined('MOODLE_INTERNAL') || die();

/**
 * This function is not implemented in this plugin, but is needed to mark
 * the vf documentation custom volume availability.
 */
function block_remote_content_supports_feature($feature) {
    assert(1);
}

function block_remote_content_get_types() {
    return array('rest' => get_string('rest', 'block_remote_content'),
                 'soap' => get_string('soap', 'block_remote_content')
    );
}

function block_remote_content_get_authtypes() {
    return array('sitetoken' => get_string('sitetoken', 'block_remote_content'),
                 'usertoken' => get_string('usertoken', 'block_remote_content')
    );
}

function block_remote_content_get_dataformat() {
    return array(
        'raw' => get_string('raw', 'block_remote_content'),
        'customcss' => get_string('customcss', 'block_remote_content'),
        'templatedjson' => get_string('templatedjson', 'block_remote_content')
    );
}