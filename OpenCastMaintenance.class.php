<?php
/*
 * OpenCast.class.php - A course plugin for Stud.IP which includes an opencast player
 */

class OpenCastMaintenance extends StudipPlugin implements SystemPlugin
{
    /**
     * Initialize a new instance of the plugin.
     */
    function __construct()
    {
        parent::__construct();

        if (Navigation::hasItem('/admin/config/oc-config')) {
            Navigation::removeItem('/admin/config/oc-config');
            Navigation::removeItem('/admin/config/oc-resources');
            Navigation::removeItem('/start/opencast');
        }

        if (Context::getId()) {
            $this->addStylesheet('stylesheets/oc.less');

            if (Navigation::hasItem('/course/opencast')) {
                Navigation::removeItem('/course/opencast');

                $main = new Navigation("Opencast");
                $main->setURL(PluginEngine::getURL($this, [], 'course'));

                Navigation::addItem('/course/opencast', $main);
            }
        }

        // replace opencast icons on seminar overview
        PageLayout::addScript($this->getPluginUrl() . '/static/application.js');
    }

    /**
     * check, if the oc-plugin (not this plugin) is activated in this course/institute
     * @param  [type]  $course_id [description]
     * @return boolean            [description]
     */
    private function opencastIsActivated($course_id)
    {
        $db = DBManager::get();
        $plugin_id = DBManager::get()->query("SELECT pluginid
            FROM plugins
            WHERE pluginclassname == 'OpenCast'")->fetchColumn();

        $plugin_manager = PluginManager::getInstance();
        return $plugin_manager->isPluginActivated($plugin_id, $course_id);
    }

    /**
     * Return the name of this plugin.
     */
    public function getPluginName()
    {
        return 'Opencast - Wartungsmodus';
    }
}
