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
 * Form for editing remote_content block instances.
 *
 * @package   block_remote_content
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_remote_content extends block_base {

    const CONTEXT_NO_SEND = 0;
    const CONTEXT_SEND_PLAIN = 1;
    const CONTEXT_SEND_CRYPTED = 2;

    static $remotejsloaded;

    public function init() {
        $this->title = get_string('pluginname', 'block_remote_content');
    }

    public function has_config() {
        return false;
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function specialization() {
        $title = format_string(get_string('newremotecontentblock', 'block_remote_content'));
        $this->title = isset($this->config->title) ? format_string($this->config->title) : $title;
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $debug = optional_param('debug', '', PARAM_TEXT);

        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;

        $this->content = new stdClass;
        $this->content->footer = '';
        if ($this->config->integration == 'iframe') {
            $template = new StdClass;
            $template->id = $this->instance->id;
            $params = ['blockid' => $this->instance->id];
            if (!empty($debug)) {
                $params['debug'] = $debug;
            }
            $template->remotecontenturl = new moodle_url('/blocks/remote_content/ajax/service.php', $params);
            if (!empty($this->config->iframeheight)) {
                $iframeheight = str_replace('%', '', $this->config->iframeheight);
                if (!preg_match('/px$/', $iframeheight)) {
                    $iframeheight .= 'px';
                }
                $template->iframeheight = $iframeheight;
            }
            $this->content->text = $OUTPUT->render_from_template('block_remote_content/iframe', $template);
        } else {
            if ($this->instance->visible) {
                $this->content->text = '<div id="remotecontent-'.$this->instance->id.'" class="remotecontent-content">'.$OUTPUT->pix_icon('i/ajaxloader', '').'</div>';
            } else {
                $this->content->text = '<div id="hidden-remotecontent-'.$this->instance->id.'" class="remotecontent-content">Not visible content</div>';
            }
        }

        return $this->content;
    }

    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return false;
    }

    public function get_remote_content() {

        $str = '';

        if (!empty($this->config->extracss)) {
            $str .= '<STYLE>';
            $str .= $this->config->extracss;
            $str .= '</STYLE>';
        }

        switch ($this->config->method) {

            case 'moodlews': {
                $str .= $this->get_moodlews_content();
                break;
            }

            case 'rest': {
                $str .= $this->get_rest_content();
                break;
            }

            case 'soap': {
                $str .= $this->get_soap_content();
                break;
            }

            case 'htmlcapture': {
                $str .= $this->capture_remote_html();
                break;
            }
        }

        return $str;

    }

    protected function get_moodlews_content() {
        global $PAGE, $CFG;

        $renderer = $PAGE->get_renderer('block_remote_content');

        $params = array('wstoken' => $this->config->wstoken);

        if ($this->config->wsprotocol == 'rest') {
            $params['wsfunction'] = $this->config->wsfunction;
            $params['moodlewsrestformat'] = 'json';
        }

        if ($paramarr = explode('&', $this->config->params)) {
            foreach ($paramarr as $pair) {
                $parts = explode('=', $pair);
                $key = array_shift($parts);
                $value = implode('', $parts);
                $params[$key] = $value;
            }
        }

        if ($this->config->wsprotocol == 'rest') {

            $serviceurl = $this->config->baseurl.'/webservice/rest/server.php';

            $result = $this->send_moodlews($serviceurl, $params);

        } else {
            // Call Moodle WS using a Soap client.
            $serviceurl = $this->config->baseurl.'/webservice/soap/server.php';

            $options = array('trace' => 1);

            $opts = array(
                'http' => array(
                    'user_agent' => 'Moodle SOAP Client'
                )
            );
            $context = stream_context_create($opts);
            $options['stream_context'] = $context;
            $options['cache_wsdl'] = WSDL_CACHE_NONE;

            $options['location'] = $serviceuri;
            $options['uri'] = $CFG->wwwroot;
            $client = new SoapClient(null, $options);

            $result = $client->__soapCall($this->config->wsfunction, $paramarr);
        }

        $data = json_decode($result);

        if (!empty($this->config->mustache)) {

            $content = '';

            if (!is_array($data)) {
                // Converts int a single object array to render one template instance.
                $data = array($data);
            }

            foreach($data as $datum) {
                $mustache = $renderer->get_mustache();
                $mustache->setLoader(new Mustache_Loader_StringLoader());
                $template = $mustache->loadTemplate($this->config->mustache);
                $content .= $template->render($datum);
            }

            return $content;
        } else {
            return print_r($data);
        }
    }

    protected function get_rest_content() {
        static $remotejsloaded = false;

        if (empty($this->config->resturl)) {
            return $OUTPUT->notification(get_string('erroremptyresturl', 'block_remote_content'), 'error');
        }

        if (!$remotejsloaded) {
            $remotejsloaded = true;
            $resturl = $this->config->resturl;
        } else {
            $resturl = $this->config->resturl;
            if (strpos($resturl, '?') !== false) {
                $resturl .= '&nojs=true';
            } else {
                $resturl .= '?nojs=true';
            }
        }

        $content = $this->send_curl_get($resturl);

        return $content;
    }

    protected function get_soap_content() {
        if (empty($this->config->soapurl)) {
            return $OUTPUT->notification(get_string('erroremptysoapurl', 'block_remote_content'), 'error');
        }
        $content = $this->send_soap_request();

        return $content;
    }

    protected function capture_remote_html() {
        $content = $this->send_curl_get($this->config->captureurl);

        $pattern = '/'.str_replace('/', '\\/', $this->config->frompattern);
        $pattern .= '(.*?)'.str_replace('/', '\\/', $this->config->topattern).'/';

        preg_match($pattern, $content, $matches);

        return $matches[1];
    }

    /**
     * Low level remote request
     */
    protected function send_moodlews($serviceurl, $params) {

        $ch = curl_init($serviceurl);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        if (!$result = curl_exec($ch)) {
            throw new Exception("CURL Error : ".curl_errno($ch).' '.curl_error($ch)."\n");
        }

        if (preg_match('/EXCEPTION/', $result)) {
            throw new Exception("Moodle WS Error : ".$result."\n");
        }

        return $result;
    }

    /**
     * Low level remote request: CURL
     */
    protected function send_curl_get($url) {

        if (!empty($this->config->sendcontext)) {
            $this->add_context($url);
        }

        $debug = optional_param('debug', '', PARAM_TEXT);
        if ($debug == 'url') {
            return $url;
        }

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);

        if (!$result = curl_exec($ch)) {
            throw new Exception("CURL Get Error : ".curl_errno($ch).' '.curl_error($ch)."\n");
        }

        return $result;
    }

    /**
     * Low level remote request : SOAP
     */
    protected function send_soap_request() {

        $options = array('trace' => 1);
        if (!empty($this->config->soaplogin)) {
            $options['login'] = $this->config->soaplogin;
            $options['password'] = $this->config->soappassword;
        }
        $client = new SoapClient($this->config->wsdlurl, $options);

        $soapparams = $this->config->soapparams;
        if (!empty($this->config->sendcontext)) {
            $this->add_context($soapparams);
        }

        $argsarr = array();
        if ($argspairs = explode('&', $soapparams)) {
            foreach ($soappairs as $pair) {
                $parts = explode('=', $pair);
                $key = array_shift($pairs);
                $value = implode('=', $parts);
                $argsarr[$key] = $value;
            }
        }

        $options = array('exceptions' => true);
        try {
            $result = $client->__soapCall($this->config->soapfunction, $argsarr, $options);
        } catch (Exception $soape) {
            throw new Exception("SOAP Call Error : ".$soape->getMessage()."\n");
        }

        return $result;
    }

    public function get_required_javascript() {
        global $PAGE;

        $debug = optional_param('debug', '', PARAM_TEXT);

        $PAGE->requires->js_call_amd('block_remote_content/content', 'init', [['debug' => $debug]]);
    }

    /**
     * Usual users, even teacher may NOT be allowed to edit this block's settings.
     */
    public function user_can_edit() {
        if (has_capability('block/remote_content:configure', $this->context)) {
            return true;
        }
    }

    /**
     * Adds dynamic dsplay time context info for the remote
     * content provider.
     * @param stringref $url a url to complete with context.
     */
    protected function add_context(&$url) {
        global $COURSE, $USER, $CFG;

        $group = groups_get_course_group($COURSE);

        $contextquerystring = 'courseid='.$COURSE->id.'&userid='.$USER->id.'&coursecategoryid='.$COURSE->category;
        if ($group) {
            $contextquerystring .= '&groupid='.$group;
        }

        if ($this->config->sendcontext == self::CONTEXT_SEND_PLAIN || empty($this->config->preferedcrypto)) {
            if (strpos($url, '?') !== false) {
                $url .= '&'.$contextquerystring;
            } else {
                $url .= '?'.$contextquerystring;
            }
        } else {
            // Ask for crypto container
            if (!file_exists($CFG->dirroot.'/blocks/remote_content/classes/crypto/'.$this->config->preferedcrypto.'.class.php')) {
                print_error(get_string('errorunknowncrypto', 'block_remote_content', $this->config->preferedcrypto));
            }
            include_once($CFG->dirroot.'/blocks/remote_content/classes/crypto/'.$this->config->preferedcrypto.'.class.php');
            $class = '\\block_remote_content\\crypto\\'.$this->config->preferedcrypto.'_crypto';
            $crypter = new $class($this);

            $cryptedquery = $crypter->crypt($contextquerystring);
            if (strpos($url, '?') !== false) {
                $url .= '&moodlecontext='.urlencode($cryptedquery);
            } else {
                $url .= '?moodlecontext='.urlencode($cryptedquery);
            }
        }
    }
}
