<div class=" animated fadeInRight">
    <div class="margin-l-r-0 small-header row wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-xs-8">
            <h2>Your Products</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">
                    <span>Products</span>
                </li>
            </ol>
        </div>
        <div class="col-xs-4">
            <div class="title-action">
                <a href="#products/create" class="btn btn-success btn-sm">Create a Product</a>
            </div>
        </div>
    </div>
</div>
<script>
    function changeFilters(filter, value) {
        $("#search_" + filter).val(value);
        $("#filterForm").submit();
    }
    $(document).ready(function() {
        var url      = window.location.href; 
        var segments = url.split( '/' );
        var params = '';
        if(segments.length == 6){
            params = "&" + segments[5];
        }
        // console.log(segments[5]);
        // $params = "<?php echo $_SERVER["QUERY_STRING"]; ?>";
        // $policies_search = "<?php echo urlencode($_GET['policies_search']);?>";
        // $policies_page = "<?php echo $_GET['policies_page'];?>";
        // $search_fronter = "<?php echo $_GET['search_fronter'];?>";

        // if ($params.search('search_fronter') >= 0){
        //     $params = $params.replace("search_fronter=" + $search_fronter +"&", "");
        // }else{
        //     $params = $params.replace("search_fronter=&", "");
        // }

        // $search_submitToday = "<?php echo $_GET['search_submitToday'];?>";

        // if ($params.search('search_submitToday') >= 0){

        //     $params = $params.replace("search_submitToday=" + $search_submitToday +"&", "");
        //     console.log($params);
        // }else{
        //     $params = $params.replace("search_submitToday=&", "");
        // }

        // if ($params.search('policies_search') >= 0){
        //     $params = $params.replace("policies_search=" + $policies_search +"&", "");
        // }
        // if ($params.search('policies_page') >= 0){
        //     $params = $params.replace("policies_page=" + $policies_page +"&", "");
        // }
        // console.log($params);
        // Attach a submit handler to the form
        $("#searchForm").submit(function(event) {
            // alert($(this).serialize());
            // Stop form from submitting normally
            
            event.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: 'GET',
                data: $(this).serialize() + params,
                // data: $(this).serialize(),
                success: function(result) {
                    $("#results").empty().append(result);
                    console.log("done");
                }
            });
        });
        $('.submissionErrors').click(function() {
            $("#search_page").val("1");
            $("#search_submissionErrors").val("Y");
            $("#filterForm").submit();
            return false;
        });
        $('.pastDue').click(function() {
            $("#search_page").val("1");
            $("#search_pastDue").val("Y");
            $("#filterForm").submit();
            return false;
        });
        $('.followup').click(function() {
            $("#search_page").val("1");
            $("#search_followup").val("Y");
            $("#filterForm").submit();
            return false;
        });
        $('.majorMed').click(function() {
            $("#search_page").val("1");
            $("#search_majorMed").val("Y");
            $("#filterForm").submit();
            return false;
        });
          $('.notPaid').click(function() {
            $("#search_page").val("1");
            $("#search_notPaid").val("Y");
            $("#filterForm").submit();
            return false;
        });
   $('.noPolicyNumber').click(function() {
            $("#search_page").val("1");
            $("#search_noPolicyNumber").val("Y");
            $("#filterForm").submit();
            return false;
        });
        $('.submitToday').click(function() {
            $("#search_page").val("1");
            $("#search_submitToday").val("Y");
            $("#filterForm").submit();
            return false;
        });
        $('.filterLink').click(function() {
            var info = $(this).attr("filter-id");
            var value = $(this).attr("filter-value");
            $("#search_page").val("1");
            $("#" + info).val(value);
            $("#filterForm").submit();
            return false;
        });
         $('.filterLink2').click(function() {
            var info = $(this).attr("filter-id");
            var value = $(this).attr("filter-value");
            $("#search_page").val("1");
            $("#" + info).val(value);
            $("#filterForm").submit();
            return false;
        });
        $('.clearFilters').click(function() {
            $("#search_page").val("1");
            $("#search_fronter").val("");
            $("#search_closer").val("");
            $("#search_carrier").val("");
            $("#search_policy").val("");
            $("#search_status").val("");
            $("#search_submitToday").val("");
            $("#search_pastDue").val("");
            $("#search_followup").val("");
            $("#search_majorMed").val("");
             $("#search_notPaid").val("");
             $("#search_noPolicyNumber").val("");
              $("#search_submissionErrors").val("");
            $("#filterForm").submit();
            return false;
        });
        $("#filterForm").submit(function(event) {
            // Stop form from submitting normally

            event.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: 'GET',
                // data: $(this).serialize() ,
                data: $(this).serialize() + params,
                success: function(result) {
                    $("#results").empty().append(result);
                    console.log("done");
                }
            });
        });
    });
</script>
<form id="filterForm" action='<?php echo $settings[' base_uri '];?>api/leads/products' method="post">
    <input type="hidden" name="policies_page" id="search_page" value="<?php echo $settings['products']['page'];?>">
    <input type="hidden" name="search_fronter" id="search_fronter" value="<?php echo $settings['search_fronter'];?>">
    <input type="hidden" name="search_closer" id="search_closer" value="<?php echo $settings['search_closer'];?>">
    <input type="hidden" name="search_carrier" id="search_carrier" value="<?php echo $settings['search_carrier'];?>">
    <input type="hidden" name="search_policy" id="search_policy" value="<?php echo $settings['search_policy'];?>">
    <input type="hidden" name="search_status" id="search_status" value="<?php echo $settings['search_status'];?>">
    <input type="hidden" name="search_submitToday" id="search_submitToday" value="<?php echo $_REQUEST['search_submitToday'];?>">
    <input type="hidden" name="search_pastDue" id="search_pastDue" value="<?php echo $_REQUEST['search_pastDue'];?>">
    <input type="hidden" name="search_followup" id="search_followup" value="<?php echo $_REQUEST['search_followup'];?>">
    <input type="hidden" name="search_majorMed" id="search_majorMed" value="<?php echo $_REQUEST['search_majorMed'];?>">
    <input type="hidden" name="search_notPaid" id="search_notPaid" value="<?php echo $_REQUEST['search_notPaid'];?>">
    <input type="hidden" name="search_noPolicyNumber" id="search_noPolicyNumber" value="<?php echo $_REQUEST['search_noPolicyNumber'];?>">
    <input type="hidden" name="search_submissionErrors" id="search_submissionErrors" value="<?php echo $_REQUEST['search_submissionErrors'];?>">
     <input type="hidden" name="search_sortFilter" id="search_sortFilter" value="<?php echo $settings['search_sortFilter'];?>">


</form>
<div class="row  margin-l-r-0 animated fadeInRight m-20-15">
    <div class="ibox float-e-margins">
        <div class="ibox-title">

							<div>

								<h4>Product</h4>

							</div>

						</div>
        <div class="ibox-content hblue">
            <div class="row margin-l-r-0">
                <div class="col-xs-8 ">
                    <?PHP
// if (( (empty($_REQUEST['search_submitToday'])) || ($_REQUEST['search_submitToday'] <> "Y")) && ( (empty($_REQUEST['search_pastDue'])) || ($_REQUEST['search_pastDue'] <> "Y")  ) && ( (empty($_REQUEST['search_majorMed'])) || ($_REQUEST['search_majorMed'] <> "Y")  )   ){
//if (( (empty($_REQUEST['search_submitToday'])) || ($_REQUEST['search_submitToday'] <> "Y")) ){
//    echo '<button class="btn btn-secondary submitToday btn-sm"  >Submits Today</button> ';
//} else {
//    echo '<button class="btn btn-warning submitToday btn-sm"  >Submits Today</button> ';
//}
//if (( (empty($_REQUEST['search_submissionErrors'])) || ($_REQUEST['search_submissionErrors'] <> "Y")) ){
//   echo ' <button class="btn btn-secondary submissionErrors btn-sm"  ><i class="fa fa-exclamation"></i></button>';
//} else {
//   echo ' <button class="btn btn-danger submissionErrors btn-sm"  ><i class="fa fa-exclamation"></i></button>';
//}
//  }
                    ?>
                    <?PHP
if ( (!empty($settings['search_fronter'])) || (!empty($settings['search_closer'])) || (!empty($_REQUEST['search_submissionErrors'])) || (!empty($settings['search_carrier'])) || (!empty($_REQUEST['search_submitToday'])) || (!empty($_REQUEST['search_pastDue'])) || (!empty($_REQUEST['search_followup'])) || (!empty($_REQUEST['search_notPaid'])) || (!empty($_REQUEST['search_noPolicyNumber'])) || (!empty($_REQUEST['search_pastDue'])) ||  (!empty($_REQUEST['search_majorMed']))  || (!empty($settings['search_status']))  ){
    echo '<button class="clearFilters btn btn-warning btn-sm btn-bitbucket"><i class="fa fa-remove"></i> Clear Filters</button>';
}
                    ?>
                </div>
                <div class="col-xs-4 pull-right">
                    <form id="searchForm" action='<?php echo $settings[' base_uri '];?>api/leads/products' method="post">
                        <div class="input-group pull-right">
                            <input type="text" name="policies_search" class="form-control" value="<?php echo $settings['products']['search'];?>"></input>
                        <span class="input-group-btn"><input type="submit" class="btn btn-success" value="Search"></span>
                        </div>
                    </form>
            </div>
        </div>
        <?php
echo "<table class='table table-condensed table-striped'>";
echo '<thead><tr>
    <th data-sort="string">Name</th>
    <th data-sort="string">Created</th>
    <th data-sort="string">Email</th>
    <th data-sort="string">Billing Telephone Number</th>
    <th data-sort="string">Agent ID</th>
    <th data-sort="string">Vendor Number</th>
    <th data-sort="string">Lead Type</th>
    <th data-sort="string">Number Of Accounts</th>
    <th data-sort="int">Actions</th>
    </thead>';
if(!empty($result['products'])){
    foreach($result['products'] as $key => $var){

        echo "
        <tr><td><a href='#products/edit/".$personId."'>".$var['AccountFirstName'].' '.$var['AccountLastName']."</td>
        <td>".date("m/d/Y",strtotime($var['_timestampCreated']))."</a></td>
        <td>".$var['Email']."</td>
        <td>".$var['Btn']."</td>
        <td>".$var['AgentId']."</td>
        <td>".$var['VendorNumber'] ."</td>
        <td>".$var['LeadType'] ."</td>
        <td>".$var['NumberOfAccounts'] ."</td>
        <td><a href='#admin/scripts/edit/".$value['_id']."' ><i class='fa fa-pencil'></i></a> <a class='delete-script' href='#' data-scriptid='".$value['_id']."' ><i class='fa fa-trash'></i></a></td>
        </tr>
        ";
    }
} else {
    echo "<tr><td colspan='11'>No products at this time.</td></tr>";
}
echo "</table>";
        ?>
        <div class="row margin-l-r-0">
            <div class="col-sm-6">
                <div class="pagination">Showing
                    <?php echo ($settings['products']['per_page'] * $settings['products']['page']) - $settings['products']['per_page'] + 1;?> to
                    <?php
$totalToShow = $settings['products']['per_page'] * $settings['products']['page'];
if($totalToShow > $result['total']){
    $totalToShow = $result['total'];
}
                    ?>
                    <?php echo $totalToShow;?> of
                    <?php echo $result['total'];?> products
                </div>
            </div>
            <div class="col-sm-6">
                <ul class="pagination pull-right">
                    <?php
if($settings['page'] == 1){
    echo ' <li class="paginate_button previous disabled" aria-controls="DataTables_Table_0" tabindex="0" id="DataTables_Table_0_previous"><a href="#products/page/1">Previous</a></li> ';
} else {
    echo ' <li class="paginate_button previous " tabindex="0" id="DataTables_Table_0_previous"><a href="#products/page/'.($settings['products']['page'] - 1).'">Previous</a></li> ';
}
                    ?>
                    <?php
$i = 1;
if((empty($settings['products']['per_page'])) || ($settings['products']['per_page'] < 1)){
    $settings['products']['per_page'] = 100;
}
for ($x = 1; $x <= $result['total']; $x++) {
    $active = "";
    if($i == $settings['products']['page']){
        $active = "active";
    }
    if(($i > ($settings['products']['page'] - 5)) && ($i < ($settings['products']['page'] + 5))) {
        echo  "<li class='paginate_button ".$active."' tabindex='0'><a href='#' class='filterLink' filter-id='search_page' filter-value='".$i."'>".$i."</a></li>";
    }
    $x = $i * $settings['products']['per_page'];
    $i++;
}
                    ?>
                    <?php
$i--;
if($settings['products']['page'] < $i){
    echo '  <li class="paginate_button next" tabindex="0" id="DataTables_Table_0_next"><a href="#products/page/'. ($settings['products']['page'] + 1) . 'xxxx">Next</a></li> ';
} else {
    echo '  <li class="paginate_button next disabled" tabindex="0" id="DataTables_Table_0_next"><a href="#products/page/'. ($settings['products']['page']) . '">Next</a></li> ';
}
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal inmodal" id="adminPolicyModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Policy Information</h4>
            </div>
            <div class="modal-body" id="adminPolicyModalInfo">
                Getting Policy Information....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function adminPolicy(policy_id) {
        return false;
        $('.modal').hide();
        $("#adminPolicyModalInfo").html("<P>Getting Policy Information.... </P>" + policy_id);
        $('#adminPolicyModal').modal('show');
        $.ajax({
            url: "<?php echo $settings['base_uri'];?>api/leads/admininfo/" + policy_id,
            type: 'POST',
            data: "",
            success: function(result) {
                $("#adminPolicyModalInfo").html(result);
            }
        });
    }
</script>