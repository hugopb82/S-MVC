<?php
    namespace Kernel;

    class Updater{

        private $version;
        private $last_checked;

        public function __construct(){
            $json = file_get_contents(ROOT . 'Kernel/updater_info.json');
            $info = json_decode($json);
            $this->version = $info->version;
            $this->last_checked = $info->last_checked;
            $this->check();
        }

        public function check(){
            $last_json = file_get_contents('https://www.github');
            $last_version = file_get_contents();
        }

    }
