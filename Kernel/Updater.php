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
            $last_json = file_get_contents('https://raw.githubusercontent.com/hugopb82/S-MVC/master/Kernel/updater_info.json');
            $last_info = json_decode($last_json);
            $last_version = $last_info->version;
            if($this->version != $last_version){
                file_put_contents(ROOT . 'latest.zip', fopen("https://github.com/hugopb82/S-MVC/archive/master.zip", 'r'));

                $zip = new \ZipArchive;
                $res = $zip->open(ROOT . 'latest.zip');
                if($res === TRUE){
                    $zip->extractTo(ROOT . 'tmp');
                    $zip->close();
                    unlink(ROOT . 'latest.zip');
                    rmdir(ROOT . 'Kernel');
                    rename(ROOT . 'tmp/S-MVC-master/Kernel', ROOT . 'Kernel');
                }
            }
        }

    }
