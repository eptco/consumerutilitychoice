
<?php
$us_states = array(
  'AL' => 'Alabama',
  'AK' => 'Alaska',
  'AZ' => 'Arizona',
  'AR' => 'Arkansas',
  'CA' => 'California',
  'CO' => 'Colorado',
  'CT' => 'Connecticut',
  'DE' => 'Delaware',
  'DC' => 'District Of Columbia',
  'FL' => 'Florida',
  'GA' => 'Georgia',
  'HI' => 'Hawaii',
  'ID' => 'Idaho',
  'IL' => 'Illinois',
  'IN' => 'Indiana',
  'IA' => 'Iowa',
  'KS' => 'Kansas',
  'KY' => 'Kentucky',
  'LA' => 'Louisiana',
  'ME' => 'Maine',
  'MD' => 'Maryland',
  'MA' => 'Massachusetts',
  'MI' => 'Michigan',
  'MN' => 'Minnesota',
  'MS' => 'Mississippi',
  'MO' => 'Missouri',
  'MT' => 'Montana',
  'NE' => 'Nebraska',
  'NV' => 'Nevada',
  'NH' => 'New Hampshire',
  'NJ' => 'New Jersey',
  'NM' => 'New Mexico',
  'NY' => 'New York',
  'NC' => 'North Carolina',
  'ND' => 'North Dakota',
  'OH' => 'Ohio',
  'OK' => 'Oklahoma',
  'OR' => 'Oregon',
  'PA' => 'Pennsylvania',
  'RI' => 'Rhode Island',
  'SC' => 'South Carolina',
  'SD' => 'South Dakota',
  'TN' => 'Tennessee',
  'TX' => 'Texas',
  'UT' => 'Utah',
  'VT' => 'Vermont',
  'VA' => 'Virginia',
  'WA' => 'Washington',
  'WV' => 'West Virginia',
  'WI' => 'Wisconsin',
  'WY' => 'Wyoming',
);  
?>
<div class=" animated fadeInRight">

    <div class="row margin-l-r-0 margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">

        <div class="col-lg-4">

            <h2>Reports</h2>

            <ol class="breadcrumb">

                <li><a href="#">Home</a></li>

                <li class="active">

                    <span>Reports</span>

                </li>

            </ol>

        </div>

        <div class="col-sm-8">

            <div class="title-action">

            </div>

        </div>

    </div>

</div>

<div class="row margin-l-r-0  animated fadeInRight">

    <div class="ibox float-e-margins">

        <div class="ibox float-e-margins" id="filterBox">

            <form id="reportsForm" name="reportsForm" method="post" action="<?php echo $settings['base_uri']; ?>api/reports?search=true" class="form-horizontal ">

                <div id="filters" class="ibox-content hblue border-bottom-0">

                    <div class="row margin-l-r-0">

                        <div class="col-sm-4 ">

                            <label>Status</label>

                            <select class="form-control" name="status">
                                <option value="">Any</option>
                                <?php if(!empty($result['status_list'])): foreach ($result['status_list'] as $status): ?>
                                    <option value="<?= $status['name']; ?>" ><?= $status['name']; ?></option>
                                <?php endforeach; endif; ?>
                            </select> 

                        </div>

                        <div class="col-sm-4 ">

                            <label>Start Date</label>

                            <input type="text" name="reportsStartDate" class="form-control  datepicker" data-mask="99/99/9999" value="<?php echo $apiObj->validateTimestamp($result['reportsStartDate'], " m/d/Y "); ?>">

                        </div>

                        <div class="col-sm-4 ">

                            <label>End Date</label>

                            <input type="text" name="reportsEndDate" class="form-control  datepicker" data-mask="99/99/9999" value="<?php echo $apiObj->validateTimestamp($result['reportsEndDate'], " m/d/Y "); ?>">

                        </div>

                    </div>

                    <div class="row margin-l-r-0">

                        <div class="col-sm-4 ">

                            <label>Supplier</label>

                            <select class="form-control" name="supplier">
                                <option value="">Any</option>
                                <?php if(!empty($result['suppliers'])): foreach ($result['suppliers'] as $supplier): ?>
                                    <option value="<?= $supplier['_id']; ?>" ><?= $supplier['supplier_name']; ?></option>
                                <?php endforeach; endif; ?>
                            </select> 

                        </div>

                        <div class="col-sm-4 ">
                            <label>Lead Source</label>
                            <select class="form-control" name="lead_source">
                                <option value="">Any</option>
                                <?php if(!empty($result['lead_sources'])): foreach ($result['lead_sources'] as $lead_source): ?>
                                    <option value="<?= $lead_source['name']; ?>" ><?= $lead_source['name']; ?></option>
                                <?php endforeach; endif; ?>
                            </select> 
                        </div>
                        
                        <div class="col-sm-4 ">

                            <label>State</label>

                        <select id="reportsState" name="reportsState" class=" form-control ">

                            <option value="" selected="">Any</option>

<!--                             <option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
 -->                            
                            <?php foreach ($us_states as $key => $value) { ?> 
                              <option value="<?php echo $key ?>"> <?php echo $key ?> </option>
                            <?php } ?>
                        </select>

                        </div>
                    </div>

                    <div class="row margin-l-r-0">

                        <div class="col-sm-4 ">

                            <label>User</label>

                            <select name="user" id="reportsFronter" class=" form-control ">

                                <option value="">Any</option>

                                <?php
                                if (!empty($result['users'])) {

                                    foreach ($result['users'] as $user) {

                                            echo "<option value='" . $user['_id'] . "' >" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                                    }
                                }
                                ?>

                            </select>

                        </div>


                    </div>

                    <div class="row margin-l-r-0">

                        <div class="col-sm-12 text-right">

                            <div class="title-action">

                                <input type="submit" class="btn btn-success btn-sm " value="Filter Reports">

                            </div>

                        </div>

                    </div>

                </div>

            </form>

            <div id="reportResults">

                <div class="ibox-content border-top-0">

                    <div class="row margin-l-r-0">

                        <div class="col-sm-4 text-center">

                            <div class="yellow-bg no-padding">

                                <div class="p-m">

                                    <h1 class="m-xs"><?php echo number_format($result['lead_count'], 2, '.', ','); ?></h1>

                                    <h3 class="font-bold no-margins">

                                        Total Leads

                                    </h3>

                                </div>

                            </div>

                        </div>

<?php
if ($result['sales']['totalPremium'] == 0) {

    if ($result['sales']['totalPolicies'] == 1) {

        $result['sales']['totalPolicies'] = 0;
    }
}
?>

                        <div class="col-sm-4 text-center">

                            <div class="navy-bg no-padding">

                                <div class="p-m">

                                    <h1 class="m-xs"><?php echo number_format($result['client_count'], 2, '.', ','); ?></h1>

                                    <h3 class="font-bold no-margins">

                                        Total Clients

                                    </h3>

                                </div>

                            </div>

                        </div>

                        <div class="col-sm-4 text-center">

                            <div class="lazur-bg no-padding">

                                <div class="p-m">

                                    <h1 class="m-xs"><?php echo number_format($result['product_count'], 2, '.', ','); ?></h1>

                                    <h3 class="font-bold no-margins">

                                        Total Products

                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row m-t-20">

                    <div class="col-xs-12">

                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active"><a href="#state" aria-controls="state" role="tab" data-toggle="tab" class="tab">State</a></li>

                            <li role="presentation"><a href="#leadsource" aria-controls="leadsource" role="tab" data-toggle="tab" class="tab">Lead Source</a></li>

                            <li role="presentation"><a href="#carrier" aria-controls="carrier" role="tab" data-toggle="tab" class="tab">Supplier</a></li>

                            <li role="presentation"><a href="#fronters" aria-controls="fronters" role="tab" data-toggle="tab" class="tab">Agent</a></li>

                            <li role="presentation"><a href="#closers" aria-controls="closers" role="tab" data-toggle="tab" class="tab">Manager</a></li>
<?php if ((strtoupper($_SESSION['api']['user']['permissionLevel']) == "ADMINISTRATOR")) : ?>
                                <a class="btn btn-success pull-right" id="btn-export-data" style="margin: 10px 20px 0px 0px;">Export</a>
<?php endif; ?>
                        </ul>

                    </div>

                </div>

                <div class="tab-content">

                    <!-- Phone Tabs -->

                    <div role="tabpanel" class="tab-pane active" id="state">

                        <div class="ibox-content hblue">
                            <h3>Sales by State</h3>
                            <div class="table-responsive">

                                <table id="salesByState" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th width="50%" data-sort="int">State </th>

                                            <th class="text-center" data-sort="int">Leads </th>

                                     

                                        </tr>

                                    </thead>

                                    <tbody>

<?php
$total_lead_count = 0;
if (!empty($result['by_state'])) {
    foreach ($result['by_state'] as $state => $array) {
                
        $total_lead_count += $array['lead_count'];
        ?>

                                                <tr>

                                                    <td>
                                                        <a target="_blank" href="<?php echo $settings['base_uri2']; ?>#policies/reportsStatus=<?php echo $result['reportsStatus'] ?>&reportsStartDate=<?php echo $result['reportsStartDateNoFormat'] ?>&reportsEndDate=<?php echo $result['reportsEndDateNoFormat'] ?>&reportsCarrier=<?php echo $result['reportsCarrier']; ?>&reportsCarrierPlan=<?php echo $result['reportsCarrierPlan']; ?>&reportsLeadSource=<?php echo $result['reportsLeadSource']; ?>&reportsFronter=<?php echo $result['reportsFronter']; ?>&reportsCloser=<?php echo $result['reportsCloser']; ?>&reportsState=<?php echo $statInfo['value']; ?>"><?php echo $state; ?></a>
                                                        <!-- <a onClick="changeFilters('State','<?php echo $abbrev; ?>');"><?php echo ucwords(strtolower($abbrev)); ?></a> -->

                                                    </td>

                                                    <td class="text-center">

                                                <?= $array['lead_count']; ?>

                                                    </td>


                                                </tr>

        <?php
    }
}
?>

                                    <thead>

                                        <tr>

                                            <th>Totals: </th>

                                            <th class="text-center">

<?php echo number_format($total_lead_count, 0, '.', ','); ?>

                                            </th>

                                        </tr>

                                    </thead>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="leadsource">

                        <div class="ibox-content hblue">
                            <h3>Sales By Lead Source</h3>
                            <div class="table-responsive">

                                <table  id="salesByLeadSource" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th width="50%" data-sort="string">Lead Source </th>

                                            <th class="text-center" data-sort="int">Leads </th>

                                        </tr>

                                    </thead>

                                    <tbody>

<?php
$total_lead_count = 0;
if (!empty($result['by_lead_source'])) {
    foreach ($result['by_lead_source'] as $lead_source => $array) {
        
        $total_lead_count += $array['lead_count'];
        ?>

                                                <tr>

                                                    <td nowrap>
        <?php
        if (empty($lead_source))
            $lead_source = 'UNKNOWN';
        ?>
                                                        <a target="_blank" href="<?php echo $settings['base_uri2']; ?>#policies/reportsStatus=<?php echo $result['reportsStatus'] ?>&reportsStartDate=<?php echo $result['reportsStartDateNoFormat'] ?>&reportsEndDate=<?php echo $result['reportsEndDateNoFormat'] ?>&reportsCarrier=<?php echo $result['reportsCarrier']; ?>&reportsCarrierPlan=<?php echo $result['reportsCarrierPlan']; ?>&reportsLeadSource=<?php echo $leadInfo['id']; ?>&reportsFronter=<?php echo $result['reportsFronter']; ?>&reportsCloser=<?php echo $result['reportsCloser']; ?>&reportsState=<?php echo $result['reportsState']; ?>"> <?php echo ucwords(strtolower($lead_source)); ?></a>

        <!-- <a onClick="changeFilters('LeadSource','<?php echo $leadInfo['id']; ?>');"><?php echo ucwords(strtolower($abbrev)); ?></a> -->

                                                    </td>

                                                    <td class="text-center">

                                                <?php echo $array['lead_count']; ?>

                                                    </td>

                                                </tr>

        <?php
    }
}
?>

                                    <thead>

                                        <tr>

                                            <th>Totals: </th>

                                            <th class="text-center">

<?php echo number_format($total_lead_count, 0, '.', ','); ?>

                                            </th>

                                        </tr>

                                    </thead>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <!-- Carrier Tab -->

                    <div role="tabpanel" class="tab-pane" id="carrier">

                        <div class="ibox-content hblue">

                            <h3>Sales by Supplier</h3>        

                            <div id="reportResults">

                                <div class="table-responsive">

                                    <table id="salesByCarrier" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="50%" data-sort="string">Supplier </th>

                                            <th class="text-center" data-sort="int">Leads </th>

                                            </tr>

                                        </thead>

                                        <tbody>

<?php
$total_lead_count = 0;
if (!empty($result['by_supplier'])) {
    foreach ($result['by_supplier']  as $array) {
        $total_lead_count += $array['lead_count'];
        ?>

                                                    <tr>

                                                        <td nowrap>

                                        <!-- <a onClick="changeFilters('Carrier','<?php echo $carrInfo['id']; ?>');"><?php echo ucwords(strtolower($carrId)); ?></a> -->
                                                            <a target="_blank" href="<?php echo $settings['base_uri2']; ?>#policies/reportsStatus=<?php echo $result['reportsStatus'] ?>&reportsStartDate=<?php echo $result['reportsStartDateNoFormat'] ?>&reportsEndDate=<?php echo $result['reportsEndDateNoFormat'] ?>&reportsCarrier=<?php echo $carrInfo['id']; ?>&reportsCarrierPlan=<?php echo $result['reportsCarrierPlan']; ?>&reportsLeadSource=<?php echo $result['reportsLeadSource']; ?>&reportsFronter=<?php echo $result['reportsFronter']; ?>&reportsCloser=<?php echo $result['reportsCloser']; ?>&reportsState=<?php echo $result['reportsState']; ?>"> <?php echo ucwords(strtolower($array['name'])); ?></a>
                                                        </td>

                                                        <td class="text-center">

        <?php echo $array['lead_count']; ?>

                                                        </td>

                                                    </tr>

        <?php
    }
}
?>

                                        <thead>

                                            <tr>

                                                <th>Totals: </th>

                                                <th class="text-center">

                                                    <?php echo number_format($total_lead_count, 0, '.', ','); ?>

                                                </th>

                                            </tr>

                                        </thead>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Fronter Tab -->

                    <div role="tabpanel" class="tab-pane" id="fronters">

                        <div class="ibox-content hblue">

                            <div id="reportResults">

                                <h3>Sales by Agent</h3>
                                <div class="table-responsive">

                                    <table id="salesByFronter" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="50%" data-sort="string">Agent </th>

                                                <th class="text-center" data-sort="int">Leads </th>

                                            </tr>

                                        </thead>

                                        <tbody>

<?php
$total_lead_count = 0;
if (!empty($result['by_agents'])) {
    foreach ($result['by_agents'] as $array) {
                $total_lead_count += $array['lead_count'];
        ?>

                                                    <tr>

                                                        <td nowrap>
                                                            <a target="_blank" href="<?php echo $settings['base_uri2']; ?>#policies/reportsStatus=<?php echo $result['reportsStatus'] ?>&reportsStartDate=<?php echo $result['reportsStartDateNoFormat'] ?>&reportsEndDate=<?php echo $result['reportsEndDateNoFormat'] ?>&reportsCarrier=<?php echo $result['reportsCarrier']; ?>&reportsCarrierPlan=<?php echo $result['reportsCarrierPlan']; ?>&reportsLeadSource=<?php echo $result['reportsLeadSource']; ?>&reportsFronter=<?php echo $userInfo['id']; ?>&reportsCloser=<?php echo $result['reportsCloser']; ?>&reportsState=<?php echo $result['reportsState']; ?>"> <?php echo ucwords(strtolower($array['name'])); ?></a>

        <!-- <a onClick="changeFilters('Fronter','<?php echo $userInfo['id']; ?>');"><?php echo ucwords(strtolower($userInfo['name'])); ?></a> -->

                                                        </td>

                                                        <td class="text-center">

        <?php echo $array['lead_count']; ?>

                                                        </td>

                                                    </tr>

        <?php
    }
}
?>

                                        <thead>

                                            <tr>

                                                <th>Totals: </th>

                                                <th class="text-center">

<?php echo number_format($total_lead_count, 0, '.', ','); ?>

                                                </th>

                                            </tr>

                                        </thead>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Closer Tab -->

                    <div role="tabpanel" class="tab-pane" id="closers">

                        <div class="ibox-content hblue">

                            <div id="reportResults">
                                <h3>Sales by Managers</h3>
                                <div class="table-responsive">

                                    <table  id="salesByCloser" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="50%" data-sort="string">Closer </th>

                                                <th class="text-center" data-sort="int">Leads </th>

                                            </tr>

                                        </thead>

                                        <tbody>

<?php
$total_lead_count = 0;
if (!empty($result['by_managers'])) {
    foreach ($result['by_managers'] as $array) {
                $total_lead_count += $array['lead_count'];
        ?>
                                                    <tr>

                                                        <td nowrap>
                                                            <a target="_blank" href="<?php echo $settings['base_uri2']; ?>#policies/reportsStatus=<?php echo $result['reportsStatus'] ?>&reportsStartDate=<?php echo $result['reportsStartDateNoFormat'] ?>&reportsEndDate=<?php echo $result['reportsEndDateNoFormat'] ?>&reportsCarrier=<?php echo $result['reportsCarrier']; ?>&reportsCarrierPlan=<?php echo $result['reportsCarrierPlan']; ?>&reportsLeadSource=<?php echo $result['reportsLeadSource']; ?>&reportsFronter=<?php echo $result['reportsFronter']; ?>&reportsCloser=<?php echo $userInfo['id']; ?>&reportsState=<?php echo $result['reportsState']; ?>"><?php echo ucwords(strtolower($array['name'])); ?></a>
                                                            <!-- <a onClick="changeFilters('Closer','<?php echo $userInfo['id']; ?>');"><?php echo ucwords(strtolower($userInfo['name'])); ?></a> -->
                                                        </td>

                                                        <td class="text-center">

        <?php echo $array['lead_count']; ?>

                                                        </td>


                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            ?>

                                        <thead>

                                            <tr>

                                                <th>Totals: </th>

                                                <th class="text-center">

<?php echo number_format($total_lead_count, 0, '.', ','); ?>

                                                </th>

                                            </tr>

                                        </thead>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>





    <script>
        $("#btn-export-data").click(function () {
            // alert("SDFDSf");
            toastr.warning('Export Running...', 'Server Response', {'timeOut': 100000});
            $.ajax({
                url: "<?php echo $settings['base_uri']; ?>api/reports/export-csv",
                type: 'GET',
                // data: {reportsStatus:  'ANY'},
                // data: $(this).serialize(),
                data: {reportsStatus: $("#reportsStatus").val(),
                    reportsStartDate: $('input[name=reportsStartDate]').val(),
                    reportsEndDate: $('input[name=reportsEndDate]').val(),
                    reportsCarrier: $("#reportsCarrier").val(),
                    reportsCarrierPlan: $("#reportsCarrierPlan").val(),
                    reportsLeadSource: $("#reportsLeadSource").val(),
                    reportsFronter: $("#reportsFronter").val(),
                    reportsCloser: $("#reportsCloser").val(),
                    reportsState: $("#reportsState").val()
                },
                success: function (result) {
                    toastr.remove();
                    var obj = jQuery.parseJSON(result);
                    window.open("api/reports/files/" + obj.file_name);
                }

            });
        });
        $(function () {

            $(".datepicker").pickadate({
                format: 'mm/dd/yyyy',
                selectYears: 100,
                selectMonths: true,
            });

        });



        function stateSet(state) {

            $("#reportsState option[value=" + state + "]").attr("selected", "selected");

        }

        $(document).ready(function () {

            // Collapse ibox function

            $('.filterToggle').click(function () {

                var button = $(this).find('i');

                $('#filters').slideToggle(200);

                button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');

                $('#filterBox').toggleClass('').toggleClass('border-bottom');

                setTimeout(function () {

                    $('#filterBox').resize();

                    $('#filterBox').find('[id^=map-]').resize();

                }, 50);

            });

            $("#reportsForm").submit(function (event) {
                toastr.warning('Reports Running...', 'Server Response', {'timeOut': 100000});

                // Stop form from submitting normally

                event.preventDefault();

                $.ajax({
                    url: $(this).attr("action"),
                    type: 'GET',
                    data: $(this).serialize(),
                    success: function (result) {
                        toastr.remove();
                        $("#results").empty().append(result);

                        toastr.success('Reports Completed', 'Server Response');





                    }

                });

            });







        });



        $(document).ready(function ()

        {

            $(".table").tablesorter();

        }

        );



    </script>











