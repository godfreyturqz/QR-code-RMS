<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RMS Test upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="upload.js"></script>
</head>
<body>
   <div>
     <input id="files" type="file" name="files[]" multiple/>
     <button id="upload">Upload</button>
     <div id="progress-wrp">
        <div class="progress-bar"></div>
        <div class="status">0%</div>
    </div>
   </div> 
   <input id="result" placeholder="google drive link"/>
</body>
</html>