<?php
class CourseController extends StudipController
{
    /**
     * This is the default action of this controller.
     */
    function index_action()
    {
        if ($id = Context::getId()) {
            Navigation::activateItem('/course/opencast');
        }
    }
}
