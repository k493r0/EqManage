// document.getElementById("defaultOpen").click();


function openTab(evt, tabName) {

    var i, tabcontent, tablinks;
    console.log(evt);

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
loadNotification('yes');

function loadNotification(view) {
    //view = 'read' means it has been opened by user, view = 'yes' means it is fetched in the background
    var value = '';
    if ($('#notif-dropdown').hasClass('show')){//If dropdown is already showing
        if (view === 'read'){ //If it is closed by the user (clicked whilst it's opened)
            value = 'read';
        }
    }
    $.ajax({ //It will not do anything if the notification dropdown is just opened, because value = ''
        url:"fetchNotification.php",
        method:"POST",
        data: {
            view:view,
            read:value //read = 'read' means that the notification is being closed, thus needs to bee marked as 'read'
        },
        dataType:"json",
        success:function(data) {
            $('.dropdown-menu-notif').html(data.notification);//load notification into dropdown
            console.log(data.unread_count);
            $('#countBadge').html(data.unread_count);//update the unread count
        }
    })
};
setInterval(function(){
    loadNotification('yes');
}, 1000);

