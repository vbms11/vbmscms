<?php

$result = shell_exec("ffmpeg -ss 00:00:01 -i C:/vbms/workspace/vbmscms/src/files/video/original/123446.mp4 -vframes 1 -q:v 2 C:/vbms/workspace/vbmscms/src/files/video/poster/3678ea833626263e15774d5426703237.jpg");
echo $result;