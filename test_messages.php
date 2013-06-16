<?php
/**
 * Created by JetBrains PhpStorm.
 * User: D056999
 * Date: 06.06.13
 * Time: 21:07
 * To change this template use File | Settings | File Templates.
 */
$currentTime = mktime(date("H")+3,date("i"),date("s"),date("m"),date("d"),date("Y"));
echo $timestamp = date('Y-m-d H:i:s', $currentTime);