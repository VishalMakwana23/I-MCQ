<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <style type="text/css">
        #PopupOverlay {
            display: none;
            position: fixed;
            left: 0px; right: 0px;
            top: 0px; bottom: 0px;
            background-color: #000000;
            opacity:.75;
        }
        #PopupWindow {
            display: none;
            position: absolute;
            width: 350px; height: 150px;
            left: 50%; top: 50%;
            margin: -75px 0 0 -175px;
            border: solid 2px #cccccc;
            background-color: #ffffff;
        }
        #PopupWindow h1 {
            display: block;
            margin: 0;
            padding: 3px 5px;
            background-color: #cccccc;
            text-align: center;
        }
        #PopupWindow p {
            margin: 0px;
            padding: 5px;
            font-size: 90%;
        }
        #PopupWindow a {
            display: block;
            position: absolute;
            top: 50%; left: 50%;
            margin: -70px 0 0 145px;
            width: 25px; height: 25px;
            background-color: #ff3333;
            text-align: center;
            text-decoration: none;
            font-size: 120%;
        }
    </style>
    <script type="text/javascript">
    function OpenPopup() {
        document.getElementById('PopupOverlay').style.display = 'block';
        document.getElementById('PopupWindow').style.display = 'block';
    }
    function ClosePopup() {
        document.getElementById('PopupOverlay').style.display = 'none';
        document.getElementById('PopupWindow').style.display = 'none';
    }
    </script>
</head>
<body>
    <h1>Some thing</h1>
    <p>This is the main content of the site.<br />
        Click <a href="javascript: void(0)" onclick="OpenPopup();">here</a> to show a popup window.
    </p>
    <div id="PopupOverlay"></div>
    <div id="PopupWindow">
        <h1>Popup Window!</h1>
        <p>This is the text inside my popup window!</p>
        <a href="javascript: void(0)" onclick="ClosePopup();">x</a>
    </div>
</body>
</html>