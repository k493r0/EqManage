// Get the modal
$("#eqselect").select2( {
    placeholder: "Scan Barcode",
    allowClear: true,

} );

$("#studentselect").select2( {
    placeholder: "Student Name",
    allowClear: true
} );
$("#checkOutSelect").select2( {
    placeholder: "Request to confirm checkout",
    allowClear: true
} );

$("#returnEqSelect").select2( {
    placeholder: "Scan Barcode",
    allowClear: true
} );

$("#returnStudentSelect").select2( {
    placeholder: "Student Name",
    allowClear: true
} );

$("#returnSelect").select2( {
    placeholder: "Checkout ID",
    allowClear: true
} );

var alert = document.getElementById("alert");
var modal = document.getElementById("checkoutModal");

// Get the button that opens the modal
var btn = document.getElementById("checkoutModalBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    $('#returnEqSelectDiv').load('fetchReturnEq.php');
    $("#returnEqSelect").select2( {
        placeholder: "Scan Barcode",
        allowClear: true
    } );

    $('#eqselectDiv').load('fetchCheckoutEq.php');
    $("#eqselect").select2( {
        placeholder: "Scan Barcode",
        allowClear: true
    } );



    modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};



var returnmodal = document.getElementById("returnModal");

// Get the button that opens the modal
var returnbtn = document.getElementById("returnModalBtn");

// Get the <span> element that closes the modal
var returnspan = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
returnbtn.onclick = function() {
    $('#returnEqSelectDiv').load('fetchReturnEq.php');
    $("#returnEqSelect").select2( {
        placeholder: "Scan Barcode",
        allowClear: true
    } );

    $('#eqselectDiv').load('fetchCheckoutEq.php');
    $("#eqselect").select2( {
        placeholder: "Scan Barcode",
        allowClear: true
    } );

    returnmodal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
returnspan.onclick = function() {
    returnmodal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === returnmodal) {
        returnmodal.style.display = "none";
    }
};




function getQty(studentselect) {
    var qty = studentselect.options[studentselect.selectedIndex].getAttribute('value');
    console.log(qty);

}

function resetReturnOption(){
    $('#returnEqSelect').val(null).trigger('change');
    $('#returnStudentSelect').val(null).trigger('change');
    $('#returnSelect').val(null).trigger('change');
}
function resetCoOption(){
    $('#eqselect').val(null).trigger('change');
    $('#studentselect').val(null).trigger('change');
    $('#checkOutSelect').val(null).trigger('change');
}



//-------------------------------checkoutModal Form Submission---------------------------------

$(document).ready(function() {

    $("#eqselect").change(function () {
        var id = $(this).val();
        console.log("Working");

        $.ajax({
            url: 'fetchName.php',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                $("#studentselect").empty();
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    var eqID = response[i]['eqID'];

                    $("#studentselect").append("<option value=''>Student Name</option><option value='" + id + "' data-eqID='" + eqID + "'>" + name + "" + eqID + "</option>");

                }
            }
        });
    });

    $("#studentselect").change(function () {
        var id = $(this).val();
        var eqID = this.options[this.selectedIndex].getAttribute('data-eqID');
        $.ajax({
            url: 'fetchAllCheckout.php',
            type: 'post',
            data: {id: id, eqID: eqID},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                $("#checkOutSelect").empty();
                $("#checkOutSelect").append("<option value=''></option><option value='0'>All</option>");

                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var requestDate = response[i]['requestDate'];
                    var returnDate = response[i]['returnDate'];
                    var requestOnlyDate = requestDate.split(" ", 1);
                    var returnOnlyDate = returnDate.split(" ", 1);

                    $("#checkOutSelect").append("<option value=''></option><option value='" + id + "'>Requested " + requestOnlyDate + " | Returning " + returnOnlyDate + " " + id + "</option>");

                }
            }
        });
    });

    $("#checkout").click(function () {
        var eq = document.getElementById("eqselect");
        var eqID = eq.options[eq.selectedIndex].value;

        var user = document.getElementById("studentselect");
        var userID = user.options[user.selectedIndex].value;

        var checkout = document.getElementById("checkOutSelect");
        var checkoutID = checkout.options[checkout.selectedIndex].value;

        document.getElementById("checkout").setAttribute("value", "...");

        $.ajax({
            url: "adminCheckout.php",
            type: "POST",
            async: false,
            data: {
                "eqID": eqID,
                "userID": userID,
                "checkoutID": checkoutID,
            },
            success: function (data) {


                document.getElementById("checkout").setAttribute("value", "...");

                setTimeout(() => {
                    document.getElementById("checkout").setAttribute("value", "Checked out successful");
                }, 1000);


                setTimeout(() => {

                    $('#checkoutModal').modal('hide');
                    $('#eqselect').val(null).trigger('change');
                    $('#studentselect').val(null).trigger('change');
                    $('#checkOutSelect').val(null).trigger('change');
                    document.getElementById("checkout").setAttribute("value", "Check out");

                    var sPath = window.location.pathname;
//var sPage = sPath.substring(sPath.lastIndexOf('\\') + 1);
                    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
                    if (sPage === "overdue.php"){
                        $("#table2").load("fetchOverdueTable.php");
                    } else if (sPage === "log.php"){
                        $('#table').load('fetchLogTable.php');
                    }

                    console.log("Checkout reloaded");

                }, 2000);
                // pipe(eqID,userID,checkoutID);


            }

        });

    });});
//-------------------------------------------------------------------------------------------------------

//--------------------------------------returnModal Form Submission-------------------------------------
$(document).ready(function() {
    $("#returnEqSelect").change(function () {
        var id = $(this).val();
        console.log("Is is working");

        $.ajax({
            url: 'fetchReturnName.php',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (response) {


                var len = response.length;

                $("#returnStudentSelect").empty();
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    var eqID = response[i]['eqID'];

                    $("#returnStudentSelect").append("<option value=''>Student Name</option><option value='" + id + "' data-eqID='" + eqID + "'>" + name + "" + eqID + "</option>");

                }
            }
        });
    });

    $("#returnStudentSelect").change(function () {
        var id = $(this).val();
        var eqID = this.options[this.selectedIndex].getAttribute('data-eqID');
        $.ajax({
            url: 'fetchReturnAllCheckout.php',
            type: 'post',
            data: {id: id, eqID: eqID},
            dataType: 'json',
            success: function (response) {

                var len = response.length;

                $("#returnSelect").empty();
                $("#returnSelect").append("<option value=''></option><option value='0'>All</option>");

                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var requestDate = response[i]['requestDate'];
                    var returnDate = response[i]['returnDate'];
                    var requestOnlyDate = requestDate.split(" ", 1);
                    var returnOnlyDate = returnDate.split(" ", 1);

                    $("#returnSelect").append("<option value=''></option><option value='" + id + "'>Requested " + requestOnlyDate + " | Returning " + returnOnlyDate + " " + id + "</option>");

                }
            }
        });
    });

    $("#return").click(function () {
        var eq = document.getElementById("returnEqSelect");
        var eqID = eq.options[eq.selectedIndex].value;

        var user = document.getElementById("returnStudentSelect");
        var userID = user.options[user.selectedIndex].value;

        var checkout = document.getElementById("returnSelect");
        var checkoutID = checkout.options[checkout.selectedIndex].value;

        document.getElementById("return").setAttribute("value", "...");

        $.ajax({
            url: "adminReturn.php",
            type: "POST",
            async: false,
            data: {
                "eqID": eqID,
                "userID": userID,
                "checkoutID": checkoutID,
            },
            success: function (data) {


                document.getElementById("return").setAttribute("value", "...");

                setTimeout(() => {
                    document.getElementById("return").setAttribute("value", "Return successful");
                }, 1000);


                setTimeout(() => {

                    $('#returnModal').modal('hide');
                    $('#returnEqSelect').val(null).trigger('change');
                    $('#returnStudentSelect').val(null).trigger('change');
                    $('#returnSelect').val(null).trigger('change');
                    document.getElementById("return").setAttribute("value", "Return");

                    var sPath = window.location.pathname;
//var sPage = sPath.substring(sPath.lastIndexOf('\\') + 1);
                    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
                    if (sPage === "overdue.php"){
                        $("#table2").load("fetchOverdueTable.php");
                    } else if (sPage === "log.php"){
                        $('#table').load('fetchLogTable.php');
                    }


                    console.log("reloaded");
                }, 2000);
                // pipe(eqID,userID,checkoutID);


            }

        });


    });});

//-------------------------------------------------------------------------------------------------------

// function pipe(eqID,userID,checkoutID){
//     $.ajax({
//         url: "adminCheckout.php",
//         type: "POST",
//         async: false,
//         data: {
//             "display": 1,
//             "eqID":eqID,
//             "userID":userID,
//             "checkoutID":checkoutID
//         },
//         success:function (data) {
//             console.log(data)
//         }
//
//     })
// }
