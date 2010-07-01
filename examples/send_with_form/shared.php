<?php
 	$recording_id = $_GET[ 'recordingID' ];
	$sample_name = "../../uploads/rec_" . $recording_id . ".wav";
    echo "<p>The recording ID set by the server is " . $recording_id . "</p>\n";
    echo "<p>Play WAV file at " . $sample_name . "</p>\n";
 ?>

<applet 
    CODE="com.softsynth.javasonics.recplay.PlayerApplet"
    CODEBASE="../../codebase"
    ARCHIVE="JavaSonicsListenUp.jar"
    NAME="JavaSonicRecorderUploader"
    WIDTH="300" HEIGHT="90">
  <!-- Just play this WAV file. -->
  <?php
            echo '<param name="sampleURL" value="' . $sample_name . "\">\n";
 ?>
  <!-- Play automatically as soon as the Applet starts. -->
  <param name="autoPlay" value="yes">
</applet>
</p>
