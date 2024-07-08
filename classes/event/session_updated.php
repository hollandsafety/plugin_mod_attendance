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
 * This file contains an event for when an attendance session is updated.
 *
 * @package    mod_attendance
 * @copyright  2014 onwards Dan Marsden
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_attendance\event;

/**
 * Event for when an attendance session is updated.
 *
 * @property-read array $other {
 *      Extra information about event properties.
 *
 *      string mode Mode of the report viewed.
 * }
 * @package    mod_attendance
 * @since      Moodle 2.7
 * @copyright  2013 onwards Dan Marsden
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class session_updated extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'attendance_sessions';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return 'User with id ' . $this->userid . ' updated attendance session with instanceid ' .
            $this->objectid;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsessionupdated', 'mod_attendance');
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/attendance/sessions.php', ['id' => $this->contextinstanceid,
                                                                     'sessionid' => $this->other['sessionid'],
                                                                     'action' => $this->other['action']]);
    }

    /**
     * Get objectid mapping
     *
     * @return array of parameters for object mapping.
     */
    public static function get_objectid_mapping() {
        return ['db' => 'attendance', 'restore' => 'attendance'];
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        if (empty($this->other['info'])) {
            throw new \coding_exception('The event mod_attendance\\event\\session_updated must specify info.');
        }
        if (empty($this->other['sessionid'])) {
            throw new \coding_exception('The event mod_attendance\\event\\session_updated must specify sessionid.');
        }
        if (empty($this->other['action'])) {
            throw new \coding_exception('The event mod_attendance\\event\\session_updated must specify action.');
        }
        parent::validate_data();
    }
}
