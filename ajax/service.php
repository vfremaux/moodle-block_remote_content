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

require('../../../config.php');

$blockid = required_param('blockid', PARAM_INT);

$context = context_block::instance($blockid);
$PAGE->set_context($context);

$instance = $DB->get_record('block_instances', array('id' => $blockid));
$theblock = block_instance('remote_content', $instance);

$parentcontext = $DB->get_record('context', ['id' => $instance->parentcontextid]);
if ($parentcontext->instanceid == SITEID) {
    require_login();
} else {
    $course = $DB->get_record('course', ['id' => $parentcontext->instanceid]);
    require_course_login($course);
}

// Security.
// TODO : check what security needs.
// require_login($course);

try {
    echo $theblock->get_remote_content();
} catch (Exception $e) {
    return $OUTPUT->notification(get_string('contentnotavailable', 'block_remote_content'));
}
