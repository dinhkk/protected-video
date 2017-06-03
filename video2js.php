
<?php
/*
In this example the source media is located at
rtmp://server.test.com:1935/vod/mp4:sample.mp4
Flow player has the name split by 2 part. They are stored in respective variables below.
*/
$base_url = 'http://domain.com:8018/videos/';
$video_url = 'dtHuong-dan-su-dung.mp4/playlist.m3u8';

$today = gmdate("n/j/Y g:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$key = "@abc12345"; //enter your key here
$validminutes = 20;
$str2hash = $ip . $key . $today . $validminutes;
$md5raw = md5($str2hash, true);
$base64hash = base64_encode($md5raw);
$urlsignature = "server_time=" . $today ."&hash_value=" . $base64hash. "&validminutes=$validminutes";
$base64urlsignature = base64_encode($urlsignature);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>videojs-contrib-hls embed</title>
  
  <!--
                            videojs-contrib-hls setup                       
      !>

    <!
       Make sure to include the video.js CSS. This could go in
       the <head>, too.
      -->
    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">

    <!--
       Include video.js and videojs-contrib-hls in your page
      -->

    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="https://unpkg.com/videojs-contrib-hls/dist/videojs-contrib-hls.js"></script>
</head>
<body>
  <h1>Video.js Example Embed</h1>

  <video id="my_video_1" controls="true" class="video-js vjs-default-skin" controls preload="auto" width="640" height="268" 
  data-setup='{}'>
    <source src="http://www.streambox.fr/playlists/x36xhzz/x36xhzz.m3u8" type="application/x-mpegURL">
  </video>
  
  <script>
    
    var player = videojs('my_video_1');
    videojs.Hls.xhr.beforeRequest = function(opt){
      
      opt['headers'] = {
        'X-Requested-Player' : 'videojs'
      }

      return opt;
    }

    player.src({
      src: "<?php echo "{$base_url}{$video_url}?wmsAuthSign=$base64urlsignature"; ?>",
      //src: "http://www.streambox.fr/playlists/x36xhzz/x36xhzz.m3u8",
      type: 'application/x-mpegURL',
    });
    
  </script>

  
</body>
</html>
