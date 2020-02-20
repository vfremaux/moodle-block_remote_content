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
 * Form for editing HTML block instances.
 *
 * @package   block_remote_content
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Form for editing HTML block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_remote_content_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $CFG;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_remote_content'));
        $mform->setType('config_title', PARAM_TEXT);

        $methodoptions = array('soap' => get_string('soap', 'block_remote_content'),
                               'rest' => get_string('rest', 'block_remote_content'),
                               'moodlews' => get_string('moodlews', 'block_remote_content'),
                               'htmlcapture' => get_string('htmlcapture', 'block_remote_content'));

        $mform->addElement('select', 'config_method', get_string('method', 'block_remote_content'), $methodoptions);

        $integrationoptions = array('ajax' => get_string('ajax', 'block_remote_content'),
                               'iframe' => get_string('iframe', 'block_remote_content'));

        $mform->addElement('select', 'config_integration', get_string('integration', 'block_remote_content'), $integrationoptions);

        $mform->addElement('text', 'config_iframeheight', get_string('iframeheight', 'block_remote_content'));
        $mform->setType('config_iframeheight', PARAM_INT);
        $mform->disabledIf('config_iframeheight', 'config_integration', 'neq', 'iframe');

        $attrs = array('cols' => 100, 'rows' => 10);
        $mform->addElement('textarea', 'config_extracss', get_string('extracss', 'block_remote_content'), $attrs);
        $mform->setType('config_extracss', PARAM_TEXT);

        $attrs = array('cols' => 100, 'rows' => 10);
        $mform->addElement('textarea', 'config_mustache', get_string('mustache', 'block_remote_content'), $attrs);
        $mform->setType('config_mustache', PARAM_CLEANHTML);

        $contextoptions = [
            block_remote_content::CONTEXT_NO_SEND => get_string('contextnosend', 'block_remote_content'),
            block_remote_content::CONTEXT_SEND_PLAIN => get_string('contextsendplain', 'block_remote_content'),
            block_remote_content::CONTEXT_SEND_CRYPTED => get_string('contextsendcrypted', 'block_remote_content'),
        ];
        $mform->addElement('select', 'config_sendcontext', get_string('configsendcontext', 'block_remote_content'), $contextoptions);

        $mform->addElement('text', 'config_contextkey', get_string('configcontextkey', 'block_remote_content'));
        $mform->setType('config_contextkey', PARAM_TEXT);

        $cryptooptions = ['internal' => get_string('internal', 'block_remote_content')];
        if (function_exists('openssl_public_encrypt')) {
            $cryptooptions['rsa'] = get_string('rsa', 'block_remote_content');
        }
        if ($CFG->dbtype == 'mysqli' || $CFG->dbtype == 'mariadb') {
            $cryptooptions['aes'] = get_string('aes', 'block_remote_content');
        }
        $mform->addElement('select', 'config_preferedcrypto', get_string('configpreferedcrypto', 'block_remote_content'));
        $mform->setType('config_preferedcrypto', PARAM_ALPHA);
        $mform->setDefault('config_preferedcrypto', 'internal');

        // Soap Call ******************************.

        $mform->addElement('header', 'headersoap', get_string('soapsettings', 'block_remote_content'));

        $mform->addElement('text', 'config_wsdlurl', get_string('wsdlurl', 'block_remote_content'), '');
        $mform->setType('config_wsdlurl', PARAM_URL);
        $mform->disabledIf('config_wsdlurl', 'config_method', 'neq', 'soap');

        $mform->addElement('text', 'config_soapfunction', get_string('soapfunction', 'block_remote_content'), '');
        $mform->setType('config_soapfunction', PARAM_TEXT);
        $mform->disabledIf('config_soapfunction', 'config_method', 'neq', 'soap');

        $attrs = array('cols' => 80, 'rows' => 10);
        $mform->addElement('textarea', 'config_soapparams', get_string('soapparams', 'block_remote_content'), '', $attrs);
        $mform->setType('config_soapparams', PARAM_TEXT);
        $mform->disabledIf('config_soapparams', 'config_method', 'neq', 'soap');

        $mform->addElement('text', 'config_soaplogin', get_string('soaplogin', 'block_remote_content'), '');
        $mform->setType('config_soaplogin', PARAM_TEXT);
        $mform->disabledIf('config_soaplogin', 'config_method', 'neq', 'soap');

        $mform->addElement('password', 'config_soappassword', get_string('soappassword', 'block_remote_content'), '');
        $mform->setType('config_soappassword', PARAM_TEXT);
        $mform->disabledIf('config_soappassword', 'config_method', 'neq', 'soap');

        // Generic Rest URL ******************************.

        $mform->addElement('header', 'headerrest', get_string('restsettings', 'block_remote_content'));

        $mform->addElement('text', 'config_resturl', get_string('url', 'block_remote_content'), ['size' => 120]);
        $mform->setType('config_resturl', PARAM_URL);
        $mform->disabledIf('config_resturl', 'config_method', 'neq', 'rest');

        $receptionformatoptions = array('plain' => get_string('plain', 'block_remote_content'),
                                 'json' => get_string('json', 'block_remote_content'),
                                 'xml' => get_string('xml', 'block_remote_content'));

        $mform->addElement('select', 'config_restformat', get_string('format', 'block_remote_content'), $receptionformatoptions);
        $mform->setDefault('config_restformat', 'plain');

        // Moodle Web service ******************************.

        $mform->addElement('header', 'headermoodlews', get_string('moodlewssettings', 'block_remote_content'));

        $mform->addElement('text', 'config_baseurl', get_string('wsbaseurl', 'block_remote_content'), '');
        $mform->setType('config_baseurl', PARAM_URL);
        $mform->disabledIf('config_baseurl', 'config_method', 'neq', 'moodlews');

        $protocoloptions = array('rest' => get_string('rest', 'block_remote_content'),
                                 'soap' => get_string('soap', 'block_remote_content'));
        $mform->addElement('select', 'config_wsprotocol', get_string('wsprotocol', 'block_remote_content'), $protocoloptions);

        $mform->addElement('text', 'config_wsfunction', get_string('wsfunction', 'block_remote_content'), '');
        $mform->setType('config_wsfunction', PARAM_TEXT);
        $mform->disabledIf('config_wsfunction', 'config_method', 'neq', 'moodlews');

        $mform->addElement('text', 'config_wstoken', get_string('wstoken', 'block_remote_content'), '');
        $mform->setType('config_wstoken', PARAM_RAW_TRIMMED);
        $mform->disabledIf('config_wstoken', 'config_method', 'neq', 'moodlews');

        $mform->addElement('text', 'config_wsparams', get_string('wsparams', 'block_remote_content'), '');
        $mform->setType('config_wsparams', PARAM_TEXT);
        $mform->disabledIf('config_wsparams', 'config_method', 'neq', 'moodlews');

        // HTML Capture ******************************.

        $mform->addElement('header', 'headerhtmlcapture', get_string('htmlcapturesettings', 'block_remote_content'));

        $mform->addElement('text', 'config_captureurl', get_string('url', 'block_remote_content'), '');
        $mform->setType('config_captureurl', PARAM_URL);
        $mform->disabledIf('config_captureurl', 'config_method', 'neq', 'htmlcapture');

        $mform->addElement('text', 'config_frompattern', get_string('frompattern', 'block_remote_content'), '');
        $mform->setType('config_frompattern', PARAM_TEXT);
        $mform->disabledIf('config_frompattern', 'config_method', 'neq', 'htmlcapture');

        $mform->addElement('text', 'config_topattern', get_string('topattern', 'block_remote_content'), '');
        $mform->setType('config_topattern', PARAM_TEXT);
        $mform->disabledIf('config_topattern', 'config_method', 'neq', 'htmlcapture');

    }

}
