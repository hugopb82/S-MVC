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
            /*if($this->last_checked == null || time() - $this->last_checked > 604800){
            }*/
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
                    foreach($this->getFiles(ROOT . 'Kernel') as $file){
                        unlink(ROOT . 'Kernel/' . $file);
                    }
                    rename(ROOT . 'tmp/S-MVC-master/Kernel', ROOT . 'Kernel');
                }
            }
            $data['version'] = $this->version;
            $data['last_checked'] = time();
            file_put_contents(ROOT . 'Kernel/updater_info.json', json_encode($data));
        }

        private function getFiles($directory){
            $files = array_diff(scandir($directory), array('.', '..'));
            $allFiles = array();
            foreach($files as $file){
                if(is_dir($directory . '/' . $file)){
                    $allFiles = array_merge($this->getFiles($directory . '/' . $file));
                }
                $allFiles[] = $file;
            }
            return $allFiles;
        }

    }
