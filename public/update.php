<?php
chdir(__DIR__);
echo '<pre>';
echo shell_exec('cd /home/vagrant/code/blogwork/  git pull 2>&1');