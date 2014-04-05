<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link href="styles/jquery.mobile-1.4.0.css" rel="stylesheet">
  <script src="scripts/libs/jquery.min.js"></script>
  <script src="scripts/libs/jquery.mobile-1.4.0.min.js"></script>

  <script src="scripts/mobileclient.js"></script>

<?php
    $this->assign('title','MICHAT Mobile Client');
    $this->assign('nav','mobile');
?>

</head>
<body>
<div data-role="page" data-control-title="Login" id="page1">
    <div data-theme="a" data-role="header" data-position="fixed">
        <h1 class="ui-title">
            MICHAT Mobile Client
        </h1>
    </div>
    <div role="main" class="ui-content">
        <div class="ui-field-contain" data-controltype="textinput">
            <label for="username">
                Username
            </label>
            <input name="username" id="username" placeholder="" value="" type="text">
        </div>
        <div class="ui-field-contain" data-controltype="textinput">
            <label for="password">
                Password
            </label>
            <input name="password" id="password" placeholder="" value="" type="password">
        </div>
        <input id="loginBtn" type="submit" data-inline="true" data-theme="b" data-icon="check"
        data-iconpos="right" value="Login">
    </div>
</div>
<div data-role="page" data-control-title="Home" id="page2">
    <div data-theme="a" data-role="header" data-position="fixed">
        <h1 class="ui-title">
            Home
        </h1>
        <a id="logoutBtn" data-rel="back" data-transition="slidedown" data-icon="back"
        data-iconpos="left" class="ui-btn ui-btn-left ui-icon-back ui-btn-icon-left">
            Logout
        </a>
        <a id="newMsgBtn" data-transition="flip" data-icon="plus" data-iconpos="left"
        class="ui-btn ui-btn-right ui-icon-plus ui-btn-icon-left">
            New
        </a>
    </div>
    <div role="main" class="ui-content">
        <ul id="homeList" data-role="listview" data-divider-theme="a" data-inset="false" 
        class="homeList">
            <!-- <li data-theme="a">
                <a href="#page3" data-transition="slide">
                    Button
                </a>
            </li> -->
        </ul>
    </div>
</div>
<div data-role="page" data-control-title="Chat" id="page3">
    <div data-theme="a" data-role="header" data-position="fixed">
        <h1 id="friendname" class="ui-title">
            Chat
        </h1>
        <a data-rel="back" data-transition="slidedown" href="#page3" data-icon="back"
        data-iconpos="left" class="ui-btn ui-btn-left ui-icon-back ui-btn-icon-left">
            Back
        </a>
    </div>
    <div role="main" class="ui-content">
        <ul id="msgList" data-role="listview" data-divider-theme="a" data-inset="false"
        class="msgList">
            <!-- 
            <li data-role="list-divider" role="heading">
                Divider
            </li>
            -->
            <!-- 
            <li data-theme="c">
                Button
            </li>
            -->
        </ul>
    </div>
    <div data-theme="a" data-role="footer" data-position="fixed">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <input type="text" id="msgInput" name="msgInput" />
            </div>
            <div class="ui-block-b">
                <input id="sendMsgBtn" type="button" value="Send" disabled/>
            </div>
        </div>
    </div>
</div>
<div data-role="page" data-control-title="Friends" id="page4">
    <div data-theme="a" data-role="header" data-position="fixed">
        <h1 class="ui-title">
            My Friends
        </h1>
        <a data-rel="back" data-transition="slidedown" href="#page3" data-icon="back"
        data-iconpos="left" class="ui-btn ui-btn-left ui-icon-back ui-btn-icon-left">
            Back
        </a>
    </div>
    <div role="main" class="ui-content">
        <ul id="friendList" data-role="listview" data-divider-theme="a" data-inset="false"
        class="friendList" data-filter="true">
            <!-- <li data-theme="c">
                <a data-transition="slide" href="#" onclick="openFriendPage(1, 'Manolo');return false;"> 
                    Manolo
                </a>
            </li> -->
        </ul>
    </div>
</div>
</body>
</html>