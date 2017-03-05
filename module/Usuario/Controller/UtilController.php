<?php

namespace Usuario\Controller;

trait UtilController
{
    protected function getDataPost()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}