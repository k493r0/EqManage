<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
include ('serverconnect.php');
?>
<!DOCTYPE html>
<html>
<?php
include('header.php')
?>
<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <h2>Log</h2>


    <div class="limiter">
        <div class="select-box">
            <label for="select-box1" class="label select-box1"><span class="label-desc">Filter By: </span> </label>
            <input type="radio" id="checkoutDateRadio" name="filter" value="0" <?php $filter = $_GET['filter']; if ($filter == 0 or $filter == null){echo 'checked = "checked"';}else echo null;?>  onclick="changeOption();"><label for="checkoutDateRadio"> Checkout Date</label>
            <input type="radio" id="returnDateRadio" name="filter" value="1" <?php $filter = $_GET['filter']; if ($filter == 1){echo 'checked = "checked"';}else echo null;?> onclick="changeOption();"><label for="returnDateRadio"> Return Date</label>
           <br>
            <label for="select-box1" class="label select-box1" id="selectLabel">Show checkout from: </label>
            <select id="select-box1" class="select" name="filtercat" onchange="changeOption()" style="width: 15%">
                <option value="0" <?php $range = $_GET['range']; if ($range == 0 or $range ==null){echo 'selected';}else echo null;?>>--All Time--</option>
                <option value="1" <?php $range = $_GET['range']; if ($range == 1){echo 'selected';}else echo null;?>>Today</option>
                <option value="2" <?php $range = $_GET['range']; if ($range == 2){echo 'selected';}else echo null;?>>Yesturday</option>
                <option value="3" <?php $range = $_GET['range']; if ($range == 3){echo 'selected';}else echo null;?>>Past 7 days</option>

            </select>

        </div>
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                        <tr class="table100-head">
                            <th class="column1" style="border-bottom: 1px solid black">Log ID</th>
                            <th class="column2" style="border-bottom: 1px solid black">Check Out Request ID</th>
                            <th class="column4" style="border-bottom: 1px solid black">Equipment ID</th>
                            <th class="column5" style="border-bottom: 1px solid black">User ID</th>
                            <th class="column6" style="border-bottom: 1px solid black">Check Out Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Expected Return Date</th>
                            <th class="column6" style="border-bottom: 1px solid black">Return Date</th>

                        </tr>
                        </thead>
                        <tbody id="table" >
                       <?php include('fetchLogTable.php'); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<script>


    function changeOption() {
        var radioSelection = 0;
        var r = document.getElementById("selectLabel");
        r.innerText = "Show from return date: ";
        var e = document.getElementById("select-box1");
        var selectvalue = e.options[e.selectedIndex].value;
        var radios = document.getElementsByName("filter");
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                // do whatever you want with the checked radio
                radioSelection = radios[i].value;
                // only one radio can be logically checked, don't check the rest
                break;
            }
        }
        var url = 'fetchLogTable.php?' + 'filter=' + selectvalue + '&' + 'range=' + radioSelection;
        console.log(url);

        $("#table").load(url);
        console.log("Done")
    }

    window.onload = function () {
        changeOption();
    }


</script>


</body>

