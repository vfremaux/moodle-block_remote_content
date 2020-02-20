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
 * Javascript controller for controlling content update.
 *
 * @module     block_remote_content/content
 * @package    block_remote_content
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// jshint unused: true, undef:true
define(['jquery', 'core/config', 'core/log'], function($, cfg, log) {

    var remotecontent = {

        params: [],

        init: function(params) {
            this.params = params;
            log.debug('AMD Remote content initialized');
            log.debug(JSON.stringify(params));

            // $(this.update_content);
        },

        update_content: function() {

            $('.remotecontent-content').each(function() {
                var that = $(this);

                var blockid = that.attr('id').replace('remotecontent-', '');

                var url = cfg.wwwroot + '/blocks/remote_content/ajax/service.php?';
                url += 'blockid=' + blockid;
                if (this.params['debug'] == 'url') {
                    url += '&debug=' + this.params['debug'];
                }

                $.get(url, function(data) {
                    that.html(data);
                });
            });
        }
    };

    return remotecontent;
});