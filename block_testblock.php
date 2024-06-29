<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Block testblock is defined here.
 *
 * @package     block_testblock
 * @copyright   2024 Oliver Tiemann mail@olivertiemann.eu
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_testblock extends block_list {

    /**
     * Initializes class member variables.
     */
    public function init() {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_testblock');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {
        // Check if content is cached.
        if ($this->content !== null) {
            return $this->content;
        }

        // Create a new stdClass object.
        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        // Get all the courses that this user is enrolled in.
        if ($mycourses = enrol_get_my_courses()) {
            foreach ($mycourses as $mycourse) {
                $this->content->items[] = $mycourse->fullname;
            }
        }

        // Message if the user is editing the page.
        if ($this->page->user_is_editing()) {
            $this->content->footer = '<br>' . html_writer::tag('div', get_string('editingmessage', 'block_testblock'));
        }

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization() {

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_testblock');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats() {
        return array(
            'all' => true,
            'course-view' => true,
            'site-index' => true
        );
    }

}
