<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VideoUtil {
    
    const avi = 1;
    const flv = 2;
    const mp4 = 3;
    const webm = 4;
    
    static function convert ($inputFile, $outputFile, $format) {
        
    }
    
    static function extractImage ($inputFile, $outputFile, $time="00:00:01") {
        shell_exec("ffmpeg -ss $time -i $inputFile -vframes 1 -q:v 2 $outputFile");
    }
    
    static function extractImageInterval ($inputFile, $interval, $resolutionX, $resolutionY, $outputFile) {
        exec("ffmpeg -i $inputFile -an -r $interval -y -s ".$resolutionX."x".$resolutionY." $outputFile%d.jpg");
    }
    
    static function convertMp4toWebm ($inputFile, $outputFile) {
        $command = "ffmpeg -i $inputFile -c:v libvpx-vp9 -crf 30 -b:v 0 -b:a 128k -c:a libopus $outputFile";
        exec($command);
    }
}

class FFMPEGVideoConverter {
    
    /*
    
<?php

      convert video to flash 
     exec("ffmpeg -i video.avi -ar 22050 -ab 32 -f flv -s 320x240 video.flv");

?>

    -i Input file name
    -ar Audio sampling rate in Hz
    -ab Audio bit rate in kbit/s
    -f Output format
    -s Output dimension

Convert Video To JPG Sequence

Another common requested feature is to convert a video into a series of JPEG images. Once again the exec function can be used to wrap the following command line input.
ffmpeg -i video.mpg -an -r 10 -y -s 320x240 video%d.jpg

<?php
    exec("ffmpeg -i video.mpg -an -r 10 -y -s 320x240 video%d.jpg");
?>

    -i Input file name
    -an Disable audio
    -r fps
    -y Overwrite file
    -s Output dimension

Convert Every n seconds to JPEG

The method above graps a whole lotta frames and creates many jpg images. This is good if the goal is to create some sort of animation, but in real world practice, a frame every "n" seconds is generally required. To grab a frame every five seconds, some simple math is required. Every five seconds will be one fifth (1/5) or 0.2, so to grab ever 0.2 frame, this code is used.
ffmpeg -i movie.mpg -r 0.2 -sameq -f image2 thumbs%02d.jpg
Convert Specified Frame To JPG
ffmpeg -i video.mpg -an -ss 00:00:03 -t 00:00:01 -r 1 -y -s 320x240 video%d.jpg

    -ss Record start time
    -t Record end time last for

So if you want to save frame 4 (00:00:04) -ss 00:00:03 -t 00:00:01. Note: it is count from 00:00:00. Even you want to save one jpg, you still need to use %d for naming, it is strange that I grab one frame for one second, it will return two identical jpg files for me
Watermark With Image Overlay

In this example, an image is used as an overlay on the video to create a watermark effect. The image used in this uses a transparent PNG to achieve the effect.
ffmpeg -i movie.mpg -vhook '/usr/lib/vhook/watermark.so -f overlay.png -m 1 -t 222222' -an mm.flv

    -i Input video file
    -vhook Path to watermark.so
    -f Path to overlay image
    -m Mode
    -t Threshold

The movie is converted as seen in earlier examples, and adds the image overlay.png over the top. The threshold is a hex figure the same as used with html codes.
overlay.png
Get the Flash Player to see this player.
Add Timestamp To Video

Adding the date and time to an image is done with the vhook and specifying a font to write onto the image. The font can be a system font and all that is needed is the path to it. This provides options for fancy text etc.
ffmpeg -r 29.97 -s 320x240 -i movie.mpg -vhook '/usr/lib/vhook/imlib2.so -c white -F FreeSans.ttf/12 -x 0 -y 0 -t %A-%D-%T' timestamp.flv

    -r
    -s Video Dimensions
    -i Input file
    -c Color of text
    -F Path to font
    -x X co-ordinate
    -y Y co-ordinate

Get the Flash Player to see this player.
Rip MP3 From Video

A number of sites have emerged that capture video data and rip the sound track from them and convert it to MP3. This is done with the audio codec and is simply done as follows
ffmpeg -i movie.flv -vn -acodec copy movie.mp3
Getting infos from a video file
ffmpeg -i video.avi
Turn X images to a video sequence
ffmpeg -f image2 -i image%d.jpg video.mpg
Turn a video to X images
ffmpeg -i video.mpg image%d.jpg
Encode a video sequence for the iPpod/iPhone
ffmpeg -i source_video.avi input -acodec aac -ab 128kb -vcodec mpeg4 -b 1200kb -mbd 2 -flags +4mv+trell -aic 2 -cmp 2 -subcmp 2 -s 320x180 -title X final_video.mp4
Encode video for the PSP
ffmpeg -i source_video.avi -b 300 -s 320x240 -vcodec xvid -ab 32 -ar 24000 -acodec aac final_video.mp4
Extracting sound from a video, and save it as Mp3
ffmpeg -i source_video.avi -vn -ar 44100 -ac 2 -ab 192 -f mp3 sound.mp3

    Source video : source_video.avi
    Audio bitrate : 192kb/s
    output format : mp3
    Generated sound : sound.mp3

Convert a wav file to Mp3
ffmpeg -i son_origine.avi -vn -ar 44100 -ac 2 -ab 192 -f mp3 son_final.mp3
Convert .avi video to .mpg
ffmpeg -i video_origine.avi video_finale.mpg
Convert .mpg to .avi
ffmpeg -i video_origine.mpg video_finale.avi
Convert .avi to animated gif(uncompressed)
ffmpeg -i video_origine.avi gif_anime.gif
Mix a video with a sound file
ffmpeg -i soound.wav -i original_video.avi new_video.mpg
Convert .avi to .flv
ffmpeg -i video_origine.avi -ab 56 -ar 44100 -b 200 -r 15 -s 320x240 -f flv video_finale.flv
Convert .avi to dv
ffmpeg -i video_origine.avi -s pal -r pal -aspect 4:3 -ar 48000 -ac 2 video_finale.dv
Cut Video with FFmpeg
ffmpeg -sameq -ss [start_seconds] -t [duration_seconds] -i [input_file] [outputfile] 
     */
}
