<?php 
  
  $MeetingId = $_GET['meetingid'];
  $PersonName = $_GET['personname'];

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Video Conferencing</title>
</head>
<body>
    <script>
      var script = document.createElement("script");
      script.type = "text/javascript";

      script.addEventListener("load", function (event) {
        const meeting = new VideoSDKMeeting();
      
        const config = {
          name: "<?php echo $PersonName; ?>",
          apiKey: "0090659a-17ef-4bc9-84a8-76c750fa2af7", 
          meetingId: "<?php echo $MeetingId; ?>", 

          redirectOnLeave: "http://localhost/dashboard/doctor/",

          micEnabled: true,
          webcamEnabled: true,
          chatEnabled: true,
          participantCanToggleSelfWebcam: true,
          participantCanToggleSelfMic: true,

          joinScreen: {
            visible: true, // Show the join screen ?
            title: "Join with Doctor", // Meeting title
            meetingUrl: window.location.href, // Meeting joining url
          },
        };

        meeting.init(config);
      });

      script.src = "https://sdk.videosdk.live/rtc-js-prebuilt/0.1.29/rtc-js-prebuilt.js";
      document.getElementsByTagName("head")[0].appendChild(script);

    </script>
      
</body>
</html>
