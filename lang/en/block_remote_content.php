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
 * @package   block_remote_content
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['remote_content:addinstance'] = 'Add a new HTML block';
$string['remote_content:myaddinstance'] = 'Add a new HTML block to Dashboard';
$string['remote_content:configure'] = 'Configure the block source';
$string['remote_content:manageownsources'] = 'Manage own source definitions';

// Privacy.
$string['privacy:metadata'] = 'The Remote content Block does not directly store any personal data about any user.';

$string['allowadditionalcssclasses'] = 'Allow additional CSS classes';
$string['configallowadditionalcssclasses'] = 'Adds a configuration option to HTML block instances allowing additional CSS classes to be set.';
$string['configclasses'] = 'Additional CSS classes';
$string['configclasses_help'] = 'The purpose of this configuration is to aid with theming by helping distinguish HTML blocks from each other. Any CSS classes entered here (space delimited) will be appended to the block\'s default classes.';
$string['configtitle'] = 'Block title';
$string['configpreferedcrypto'] = 'Prefered crypto algorithm';
$string['internal'] = 'Internal';
$string['rsa'] = 'RSA (using MNET)';
$string['aes'] = 'AES (using Mysql)';
$string['leaveblanktohide'] = 'leave blank to hide the title';
$string['integration'] = 'Integration mode';
$string['ajax'] = 'Ajax';
$string['iframe'] = 'IFrame';
$string['iframeheight'] = 'Iframe height';
$string['pluginname'] = 'Remote Content';
$string['blockname'] = 'Remote Content';
$string['newremotecontentblock'] = 'New remote content';
$string['extracss'] = 'Additional css';
$string['configsendcontext'] = 'Send context';
$string['configsendcontext_help'] = 'If enabled, information such as current courseid, userid, group is sent along with the content query.';
$string['configcontextkey'] = 'Context crypto key';
$string['contextnosend'] = 'Do not send context';
$string['contextsendplain'] = 'Send context as plain parameters';
$string['contextsendcrypted'] = 'Send context as crypted string';
$string['errorunknowncrypto'] = 'Error : this crypto algorithm {$a} does no exist.';

$string['soap'] = 'Soap';
$string['rest'] = 'Rest';
$string['moodlews'] = 'Moodle WS';
$string['htmlcapture'] = 'HTML Capture';
$string['mustache'] = 'Mustache template';

$string['format'] = 'Response Format';
$string['xml'] = 'XML';
$string['plain'] = 'Plain HTML';
$string['json'] = 'JSON';

$string['method'] = 'Method';

$string['soapsettings'] = 'Soap settings';
$string['soapfunction'] = 'Soap function';
$string['soapparams'] = 'Soap params';
$string['wsdlurl'] = 'WSDL Url';
$string['soaplogin'] = 'Soap login';
$string['soappassword'] = 'Soap password';

$string['restsettings'] = 'Rest settings';
$string['url'] = 'Remote Url';

$string['moodlewssettings'] = 'Moodle web services settings';
$string['wsbaseurl'] = 'Moodle Server base url';
$string['wsprotocol'] = 'Protocol';
$string['wsfunction'] = 'Function name';
$string['wstoken'] = 'Service token';
$string['wsparams'] = 'Service param string';

$string['htmlcapturesettings'] = 'Raw HTML Capture settings';
$string['frompattern'] = 'Capture start pattern';
$string['topattern'] = 'Capture end pattern';

$string['erroremptyresturl'] = 'Protocol is REST, but rest url is empty.';
