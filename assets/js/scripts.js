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
load_unseen_notification('yes');
function load_unseen_notification(view) {
    var value = '';
    if ($('#notif-dropdown').hasClass('show')){

        if (view === 'read'){
            value = 'read';
        }
    }
    $.ajax({
        url:"fetchNotification.php",
        method:"POST",
        data: {
            view: view,
            read:value
        },
        dataType:"json",
        success:function(data)
        {
            $('.dropdown-menu-notif').html(data.notification);
            console.log(data.unread_count);
            $('#countBadge').html(data.unread_count);
        }
    })
};
//
setInterval(function(){
    load_unseen_notification('yes');
}, 1000);

