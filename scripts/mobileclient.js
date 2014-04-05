/**
 * Application logic for the mobile client frontend
 */

// *******************************************************************************************************
//  Global vars
// *******************************************************************************************************

// Loader
var msgText = "Loading...";
var textVisible = true;
var textOnly = true;

// Labels of errors and messages
var errorMsg = "Error";
var loginError = "Unknown username/password combination";
var noResults = "No results";
var noMessages = "No messages";

// Toast message control
var onScreen = false;

// Localtime offset
var timeOffset = new Date().getTimezoneOffset();

// *******************************************************************************************************
//  Messages and users management
// *******************************************************************************************************

var page = {

	/** @var mobile client global vars */
	username : null,
    userId : 0,
    messages: null,
    friends : null,
    friendId : null,
    friendName : null,
    autoRefresh : false,

	/**
	 * Login user or show an error
	 */
	login: function() {
		$.mobile.loading( "show", {text: msgText, textonly: textOnly, textVisible: textVisible});
        page.loading = true;

	    var c = $("input#username").val(),
	        b = $("input#password").val(); 

	   	$.post( "login", { username: c, password: b })
			.done(function( data ) {

				if (data.indexOf( loginError ) != -1)
				{
					toast( loginError );
				}
				else
				{ 
                    page.username = c;  // Get username and ID of the current user
                    page.firstLoad();   // Call first load method before to change page
                }
            }) 
            .fail(function() {
                toast(errorMsg);
            })
            .always(function() {
            });
    },

    /**
     * Logout current user and return to login page
     */
    logout: function() {
        $.get( "logout" )
            .done(function( data ) {
                page.autoRefresh = false;
                $.mobile.changePage("#page1");
            });   
    },

    /**
     * Load the starting users, messages and userId data.
     */
    firstLoad: function() {

        $.when( $.ajax( "api/users?orderDesc=1" ), $.ajax( "api/messages?orderDesc=1&orderBy=TimeStamp" ), $.ajax( "api/getid" ) ).done(function( friends, messages, userId ) {
            page.friends = $.parseJSON(JSON.stringify(friends[0], undefined, 2));
            page.messages = $.parseJSON(JSON.stringify(messages[0], undefined, 2));
            userData = $.parseJSON(JSON.stringify(userId[0], undefined, 2));
            page.userId = userData.id;

            page.autoRefresh = true;

            $.mobile.loading( "hide" );
            
            page.loadHomeList();
            $.mobile.changePage("#page2");
            $("ul#homeList").listview("refresh");
        });

        var nextRefresh = setTimeout(page.serverPolling, 10000);
    },

    /**
     * Gets friends data
     */
    getUsrData: function() {
        var results = $.get( "api/users?orderDesc=1" )
            .done(function( data ) {
                page.friends = $.parseJSON(JSON.stringify(data, undefined, 2)); //Parse JSON and save users
            }) 
            .fail(function() {
                toast(errorMsg);
            })
    },

    /**
     * Gets messages data
     */
    getMsgData: function() {
        var results = $.get( "api/messages?orderDesc=1&orderBy=TimeStamp" )
            .done(function( data ) {
                page.messages = $.parseJSON(JSON.stringify(data, undefined, 2)); //Parse JSON and save messages
            }) 
            .fail(function() {
                toast(errorMsg);
            })
    },  

    /**
     * Create a new message for friendId and sends it to the server
     */ 
    sendNewMsg: function(msg) {

        if (page.friendId != 0) // Current user friend selected
        {
            data = JSON.stringify({ "id": null, "contents": msg, timeStamp: now(false, true), sourceUserId: page.userId, sourceTargetId: page.friendId, read: "0" });

            // Create new msg and send it to the server
            $.post( "api/message", data)
            .done(function( data ) {  
                page.loadMessageList(); // Load the last messages

                // Create the new message instantly (on the list)
                var a = $("<li/>");
                var b = "<p style='text-align: right;'>" + msg + "</p>";
                a.append(b);
                $("ul#msgList").append(a);

                $("ul#msgList").listview("refresh");

                // Move the scroll to show the last one automatically
                $(document).scrollTop($(document).height());
            }) 
            .fail(function() {
                toast(errorMsg);
            })
        }
    },

    /**
     * Get messages and friends (update page.messages and page.friends)
     */
    getAllData: function() {
        page.getMsgData();
        page.getUsrData();
    },

    /**
     * Updates all the data and the DOM of the Home list (last messages)
     */
    loadHomeList: function() {

        // Create items of the Home List (Username + Contents and datetime of the last message without duplicates)
        var list3 = $("ul#homeList");
        list3.empty();
        
        var lastFriends = new Array();
        
        for (i = 0; i < page.messages.totalResults; i++)
        {
            // Store the friends with recent activity
            lastFriendId = -1;
            lastFriendName = "";
            currentMsg = page.messages.rows[i];

            // Check for duplicates            
            if ( ((currentMsg.sourceUserId == page.userId) && (lastFriends.indexOf(currentMsg.sourceTargetId) == -1))
            ||   ((currentMsg.sourceTargetId == page.userId) && (lastFriends.indexOf(currentMsg.sourceUserId) == -1)) )
            {
                if (currentMsg.sourceUserId == page.userId) // Check if we need to store the source or the target user id.
                {
                    lastFriendId = currentMsg.sourceTargetId;
                } else {
                    lastFriendId = currentMsg.sourceUserId;
                }

                lastFriends.push(lastFriendId);                
                found = false;

                // Search for the name of the last friend found
                for (k = 0; k < page.friends.totalResults; k++)
                {
                    if (page.friends.rows[k].id == lastFriendId) 
                    {
                        lastFriendName = page.friends.rows[k].username;
                        found = true;
                        break;
                    }
                } 

                // Unknown user (message received from a user without a friendship)
                if (!found) lastFriendName = "(Unknown user)";

                h = $("<li/>");
                e = "<h4>" + lastFriendName + "</h4>";
                m = "<p>" + currentMsg.contents + "</p>";
                j = $("<a/>", {
                    href: "#",
                    "data-transition" : "slide",
                    "data-id": lastFriendId,
                    "data-username" : lastFriendName,
                    click: function () {   
                        page.friendId = $(this).data("id");
                        page.friendName = $(this).data("username");

                        // Update Header with the friend name
                        $('h1#friendname').text(page.friendName);
                        $.mobile.changePage("#page3");

                        page.loadMessageList();
                        $("ul#msgList").listview("refresh");
                    }
                });
                j.append(e);
                j.append(m);
                h.append(j);
                list3.append(h);
            }
        };
    },

    /**
     * Updates user data and the DOM of the Friend list
     */
    loadFriendList: function() {

        // Create the items of the Friend List (Username)
        var list = $("ul#friendList");
        list.empty();
        
        for (i = 0; i < page.friends.totalResults; i++)
        {
            f = $("<li/>");
            e = "<h4>" + page.friends.rows[i].username + "</h4>";
            m = "<p>" + page.friends.rows[i].lastSeen + "</p>";
            d = $("<a/>", {
                href: "#",
                "data-transition" : "slide",
                "data-id": page.friends.rows[i].id,
                "data-username" : page.friends.rows[i].username,
                click: function () {   
                    page.friendId = $(this).data("id");
                    page.friendName = $(this).data("username");

                    // Update Header with the friend name
                    $('h1#friendname').text(page.friendName);
                    $.mobile.changePage("#page3");

                    page.loadMessageList();
                    $("ul#msgList").listview("refresh");

                    // Move the scroll to show the last one automatically
                    $(document).scrollTop($(document).height());
                }
            });
            d.append(e);
            d.append(m);
            f.append(d);
            list.append(f);
        };
    },

    /**
     * Updates messages data and the DOM of the Messages list
     */
    loadMessageList: function() {

        // Create the Message List (Only of the selected user -source or target-, show the contents)
        var list2 = $("ul#msgList");
        list2.empty();
        
        //$.each(page.friends.rows, function(i)
        for (i = page.messages.totalResults - 1; i >= 0; i--) // The oldest first
        {
            // I wrote the message
            if ( (page.messages.rows[i].sourceUserId == page.userId) && (page.messages.rows[i].sourceTargetId == page.friendId) )
            {
                f = $("<li/>");
                m = "<p style='text-align: right;'>" + page.messages.rows[i].contents + "</p>";
                f.append(m);
                list2.append(f);
            }

            // My current friend wrote the message
            if ( (page.messages.rows[i].sourceTargetId == page.userId) && (page.messages.rows[i].sourceUserId == page.friendId) )
            {
                f = $("<li/>");
                m = "<p style='text-align: left;'>" + page.messages.rows[i].contents + "</p>";
                f.append(m);
                list2.append(f);
            }
        };
    },

    /**
     * Updates all the data retrieving from the server all the information only when the user has ben logged into.
     */
    serverPolling: function() {

        if (page.autoRefresh)
        {
            console.log("Give me the info");
            updateFriends = false;
            updateMessages = false;

            $.when( $.ajax( "api/users?orderDesc=1" ), $.ajax( "api/messages?orderDesc=1&orderBy=TimeStamp" ) ).done(function( friends, messages ) {
                tempFriends = $.parseJSON(JSON.stringify(friends[0], undefined, 2));
                tempMessages = $.parseJSON(JSON.stringify(messages[0], undefined, 2));
                
                // Simple comparison (the server returns always the JSON sorted)
                if (!(JSON.stringify(page.friends) === JSON.stringify(tempFriends))) updateFriends = true; 
                if (!(JSON.stringify(page.messages) === JSON.stringify(tempMessages))) updateMessages = true; 

                if (updateFriends)
                {
                    console.log("Friends update");
                    page.friends = tempFriends;
                    
                    page.loadFriendList();
                    $("ul#friendList").listview("refresh");
                }

                if (updateMessages)
                {
                    console.log("Messages update");
                    page.messages = tempMessages;

                    page.loadMessageList();
                    $("ul#msgList").listview("refresh");

                    // Move the scroll to show the last one automatically
                    $(document).scrollTop($(document).height());
                }

                if ((updateFriends) || (updateMessages))
                {
                    page.loadHomeList();
                    $("ul#homeList").listview("refresh");                    
                }
            });

            // Program next polling interval (>10s -> more server load)
            var nextRefresh = setTimeout(page.serverPolling, 10000);
        }
    }
};


// *******************************************************************************************************
//  Click events 
// *******************************************************************************************************

$(document).ready(function() {

	$('input#loginBtn').click(function() {
		page.login();
	});

    $('a#logoutBtn').click(function() {    
        page.logout();
    });

    // Create New Msg (load Friends page)
    $('a#newMsgBtn').click(function() {    
        page.loadFriendList();
        $.mobile.changePage("#page4");
        $("ul#friendList").listview("refresh");
    });

    // Send New Msg (send the info the server)
    $('input#sendMsgBtn').click(function() {

        // Send the message and clear the input message.
        var inputMsg = $('input#msgInput');
        page.sendNewMsg(inputMsg.val());
        inputMsg.val("");
    });

    $('input#msgInput').on('input keyup keypress change', function(e) {
        if ($('input#msgInput').val() == "")
        {
            $('#sendMsgBtn').button( "option", "disabled", true );
        }
        else
        {
            $('#sendMsgBtn').button( "option", "disabled", false );
        }
    });
});

// *******************************************************************************************************
//  Secondary Functions
// *******************************************************************************************************

/** 
 * Returns local or GMT tiem
 * @param local= true:local, false:GMT
 * @param toStore= true:database format, false: to show on screen
 */
function now(local, toStore) {
    var currentdate = new Date(); 
    var hora, datetime;

    if (local) hora = parseInt(currentdate.getHours()) + (timeOffset * (-1) / 60);
    else hora = currentdate.getHours();
    
    if (toStore)
    {
        datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    +  currentdate.getDate() + " ";
    }
    else
    {
        datetime = currentdate.getDate() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getFullYear() + " ";
    }

    datetime += hora + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
    return datetime;
}

/**
 * Show a toast with a message on screen for a while
 */
var toast = function(msg)
{
    if (!onScreen)
    {
        onScreen = true;
        $("<div class='ui-loader ui-overlay-shadow ui-body-e ui-corner-all'><h3>"+msg+"</h3></div>")
        .css({ display: "block", 
            position: "fixed",
            padding: "7px",
            "text-align": "center",
            backgroundColor: "#f0f0f0",
            width: "80%",
            top: "50%",
            left: "10%" })
        .appendTo( $.mobile.pageContainer ).delay( 1500 )
        .fadeOut( 400, function(){
            $(this).remove();
            onScreen = false;
        });
    }
}
