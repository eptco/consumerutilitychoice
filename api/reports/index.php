<?php

use Sendinblue\Mailin;

ini_set('memory_limit', '512M');
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
require '../app.php';
$app->config(array(
    'templates.path' => './',
));

$app->get('/export-csv', function () use ($app, $settings) {



    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!$apiObj->userLoggedIn()) {
        echo "";
        exit();
    }
    $userIds = $apiObj->getUserIds();

    $result = searchData($apiObj);
    // var_dump($result);
    // var_dump($result['salesByLead']['leadsources']);
    // x. Create folder files
    if (!file_exists('files')) {
        mkdir('files', 0755, true);
    }

    $date = date_create();
    // x. Create name file
    $filename = 'report-' . date_timestamp_get($date) . '.csv';

    // x. Open file
    $fp = fopen('files/' . $filename, 'w');

    // ************** State **************
    $line = array('Sales by State');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('State', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByState']['states'])) {
        // x. State
        foreach ($result['salesByState']['states'] as $row) {

            $line = array(
                ucwords(strtolower($row['id'])),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByState']['totalPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByState']['totalAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByState']['totalPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    // ************** Lead Source **************
    $line = array('Sales By Lead Source');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('Lead Source', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByLead']['leadsources'])) {
        // x. Lead Source
        foreach ($result['salesByLead']['leadsources'] as $key => $row) {

            $line = array(
                ucwords(strtolower($key)),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByLead']['totalPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByLead']['totalAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByLead']['totalPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    // ************** Carrire **************
    $line = array('Sales by Carrier');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('Carrier', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByCarrier']['carrier'])) {
        // x. Lead Source
        foreach ($result['salesByCarrier']['carrier'] as $key => $row) {

            $line = array(
                ucwords(strtolower($key)),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByCarrier']['totalCarrierPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByCarrier']['totalCarrierAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByCarrier']['totalCarrierPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    // ************** Coverage **************
    $line = array('Sales by Coverage');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('Coverage', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByCarrier']['carrierPlan'])) {
        // x. Lead Source
        foreach ($result['salesByCarrier']['carrierPlan'] as $key => $row) {

            $line = array(
                ucwords(strtolower($key)),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByCarrier']['totalCarrierPlanPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByCarrier']['totalCarrierPlanAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByCarrier']['totalCarrierPlanPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    // ************** Fronter **************
    $line = array('Sales by Fronter');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('Fronter', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByUsers']['fronters'])) {
        // x. Lead Source
        foreach ($result['salesByUsers']['fronters'] as $key => $row) {

            $line = array(
                ucwords(strtolower($row['name'])),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByUsers']['totalFronterPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByUsers']['totalFronterAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByUsers']['totalFronterPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    // ************** Closer **************
    $line = array('Sales by Closer');
    fputcsv($fp, $line, ',');
    // x. Add headder 
    $line = array('Closer', 'Policies', 'Average', 'Premium');
    fputcsv($fp, $line, ',');
    if (!empty($result['salesByUsers']['closers'])) {
        // x. Lead Source
        foreach ($result['salesByUsers']['closers'] as $key => $row) {

            $line = array(
                ucwords(strtolower($row['name'])),
                $row['policies'],
                '$ ' . number_format($row['average'], 2, '.', ','),
                '$ ' . number_format($row['premium'], 2, '.', ',')
            );
            // x. Add line 
            fputcsv($fp, $line, ',');
        }
    }
    $line = array('Total',
        number_format($result['salesByUsers']['totalCloserPolicies'], 0, '.', ','),
        '$ ' . number_format($result['salesByUsers']['totalCloserAverage'], 2, '.', ','),
        '$ ' . number_format($result['salesByUsers']['totalCloserPremium'], 2, '.', ','),
    );
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');
    $line = array('', '', '', '');
    fputcsv($fp, $line, ',');

    fclose($fp);
    // echo 'success';
    echo json_encode(array('code' => 1, 'msg' => 'success', 'file_name' => $filename));
});

$app->get('/test3', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    $form['systemForm_0_createThing'] = "Y";
    $form['systemForm_0_id'] = 'Ar51WmbX-mZI39NTX-7iNnklDG';
    $form['systemForm_0_options_0_parentId'] = 'Ar51WmbX-mZI39NTX-7iNnklDG';
    $form['systemForm_0_options_0_parentThing'] = 'systemForm';
    $form['systemForm_0_options_0_default'] = 'N';
    $form['systemForm_0_options_0_label'] = 'Withdrawn by Carrier';
    $form['systemForm_0_options_0_value'] = 'WITHDRAWNBYCARRIER';

    $apiObj->save_things($form);

    $form['systemForm_0_createThing'] = "Y";
    $form['systemForm_0_id'] = 'Ar51WmbX-mZI39NTX-7iNnklDG';
    $form['systemForm_0_options_0_parentId'] = 'Ar51WmbX-mZI39NTX-7iNnklDG';
    $form['systemForm_0_options_0_parentThing'] = 'systemForm';
    $form['systemForm_0_options_0_default'] = 'N';
    $form['systemForm_0_options_0_label'] = 'Pending UW Requirements';
    $form['systemForm_0_options_0_value'] = 'PENDINGUWREQUIREMENTS';

    $apiObj->save_things($form);

    $form['systemForm_0_createThing'] = "Y";
    $form['systemForm_0_id'] = '20151112142720-kF1F33Fv-zeXtzMKJ';
    $form['systemForm_0_options_0_parentId'] = '20151112142720-kF1F33Fv-zeXtzMKJ';
    $form['systemForm_0_options_0_parentThing'] = 'systemForm';
    $form['systemForm_0_options_0_default'] = 'N';
    $form['systemForm_0_options_0_label'] = 'Withdrawn by Carrier';
    $form['systemForm_0_options_0_value'] = 'WITHDRAWNBYCARRIER';

    $apiObj->save_things($form);

    echo 'success';
});

$app->get('/test2', function () use ($app, $settings) {
    $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'XL3fh7Ir9VBYCAGQ');

    $data = array("to" => "+841687818717",
        "from" => "From",
        "text" => "Good morning - test",
        "type" => "transactional"
    );

    var_dump($mailin->send_sms($data));
    die();
    $data = array();
    debug($mailin->get_campaign_v2($data));
    // var_dump($mailin->get_campaign_v2($data));
    // die();
    // var_dump($mailin->get_account());
    // $data = array( "to" => array("ftcntr@gmail.com"=>"test"),
    //         "from" => array("info@insurtainty.com","test"),
    //         "subject" => "My subject test",
    //         "text" => "This is the text test",
    //         "html" => "This is the <h1>HTML</h1><br/> test"
    // );
    // var_dump($mailin->send_email($data));
    //  $data = array( "id" => 4,
    //   "to" => "ftcntr@gmail.com",
    //   "attr" => array("FIRSTNAME"=>"bboy bon")
    //   // "headers" => array("Content-Type"=> "text/html;charset=iso-8859-1", "FIRSTNAME"=> "tainguyen")
    // );
    // var_dump($mailin->send_transactional_template($data));

    $data = array("id" => 1,
        "lang" => "en",
        "email_subject" => "Campaign id 1 report",
        "email_to" => array("ftcntr@gmail.com"),
        "email_content_type" => "html",
        "email_body" => "Please check the report of campaign id 2"
    );

    // var_dump($mailin->campaign_report_email($data));

    die();
    $data = array("id" => 2);

    var_dump($mailin->get_campaign_v2($data));

    $data = array("id" => 2,
        "lang" => "en",
        "email_subject" => "Campaign id 2 report",
        "email_to" => array("test1@example.net", "test2@example.net"),
        "email_content_type" => "html",
        "email_bcc" => array("testbcc@example.net"),
        "email_cc" => array("testcc@example.net"),
        "email_body" => "Please check the report of campaign id 2"
    );

    var_dump($mailin->campaign_report_email($data));
});

$app->get('/test', function () use ($app, $settings) {
    // $apiObj = new apiclass($settings);
    // $apiObj->mongoSetDB($settings['database']);
    // if(!$apiObj->userLoggedIn()){
    //    echo "";
    //    exit();
    // }
    // $apiObj->mongoSetCollection("policy");
    // echo 'Total polices = ' .  $apiObj->mongoCount(array()) . '</br>';
    // $apiObj->mongoSetCollection("person");
    // echo 'Total persons = ' .  $apiObj->mongoCount(array()) . '</br>';
    // $apiObj->mongoSetCollection("addresses");
    // echo 'Total addresses = ' .  $apiObj->mongoCount(array()) . '</br>';
    // $apiObj->mongoSetCollection("carrier");
    // echo 'Total carrier = ' .  $apiObj->mongoCount(array()) . '</br>';
    // $apiObj->mongoSetCollection("carrierPlan");
    // echo 'Total carrierPlan = ' .  $apiObj->mongoCount(array()) . '</br>';
    // echo 'Total user = ' .  $apiObj->mongoCount(array()) . '</br>';

    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!$apiObj->userLoggedIn()) {
        echo "";
        exit();
    }
    $collectionQuery['email']['$eq'] = 'fahd@internetcloudtechnologies.com';
    //$collectionQuery['email']['$eq'] = 'patrick.anderson@internetcloudtechnologies.com';
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    foreach ($cursor2 as $key => $item) {
        $mongoCriteria = array("_id" => $item["_id"]);
        $collectionUpdates = array("permissionLevel" => 'ADMINISTRATOR', "level" => 'ADMINISTRATOR');
        // $collectionUpdates = array("permissionLevel" => 'MANAGER', "level" => 'MANAGER');
        $apiObj->mongoUpdate($mongoCriteria, $collectionUpdates, $createNew = FALSE);
    }

    $cursor2 = $apiObj->mongoFind($collectionQuery);
    foreach ($cursor2 as $key => $item) {
        var_dump($item);
    }
    echo 'update ok';
    // $apiObj->mongoSetCollection("mail");
    // echo 'Total mail = ' .  $apiObj->mongoCount(array()) . '</br>';
});

function searchData($apiObj) {
    $result = array();

    $userIds = $apiObj->getUserIds();
    $result['reportsStatus'] = "ANY";
    $result['reportsStartDate'] = date("Ymd000000");
    $result['reportsEndDate'] = date("Ymd235959");
    $result['reportsCarrier'] = "ANY";
    $result['reportsCarrierPlan'] = "ANY";
    $result['reportsLeadSource'] = "ANY";
    $result['reportsFronter'] = "ANY";
    $result['reportsCloser'] = "ANY";
    $result['reportsState'] = "ANY";
    $result['reportsLeadSource'] = "ANY";
    // debug($_GET);
    if (!empty($_GET["reportsStatus"])) {
        $result['reportsStatus'] = $_GET["reportsStatus"];
    }
    if (!empty($_GET["reportsStartDate"])) {
        $result['reportsStartDate'] = $apiObj->validateDate($_GET["reportsStartDate"], "m/d/Y", "Ymd000000");
        $result['reportsStartDateNoFormat'] = urlencode($_GET["reportsStartDate"]);
    }
    if (!empty($_GET["reportsEndDate"])) {
        $result['reportsEndDate'] = $apiObj->validateDate($_GET["reportsEndDate"], "m/d/Y", "Ymd235959");
        $result['reportsEndDateNoFormat'] = urlencode($_GET["reportsEndDate"]);
    }
    if (!empty($_GET['reportsCloser'])) {
        $result['reportsCloser'] = $_GET['reportsCloser'];
    }
    if (!empty($_GET['reportsFronter'])) {
        $result['reportsFronter'] = $_GET['reportsFronter'];
    }
    if (!empty($_GET['reportsCarrier'])) {
        $result['reportsCarrier'] = $_GET['reportsCarrier'];
    }
    if (!empty($_GET['reportsCarrierPlan'])) {
        $result['reportsCarrierPlan'] = $_GET['reportsCarrierPlan'];
    }
    if (!empty($_GET['reportsState'])) {
        $result['reportsState'] = $_GET['reportsState'];
    }
    if (!empty($_GET['reportsLeadSource'])) {
        $result['reportsLeadSource'] = $_GET['reportsLeadSource'];
    }
    // debug($result); //die();
    // Get Policies
    $apiObj->mongoSetCollection("policy");
    // $collectionQuery['$or'][]['soldBy']['$in'] = $userIds;
    // $collectionQuery['$or'][]['closedBy']['$in'] = $userIds;
    if ($result['reportsStatus'] == "ANY") {
        $collectionQuery['_timestampCreated']['$lte'] = $result['reportsEndDate'];
        $collectionQuery['_timestampCreated']['$gte'] = $result['reportsStartDate'];
    } else {
        $collectionQuery['_timestampCreated']['$lte'] = $result['reportsEndDate'];
        $collectionQuery['_timestampCreated']['$gte'] = $result['reportsStartDate'];
        $collectionQuery['status']['$eq'] = $result['reportsStatus'];
    }
    // $result['params'] = $_SERVER["QUERY_STRING"];
    if ($result['reportsCloser'] != "ANY") {
        $collectionQuery['closedBy']['$eq'] = $result['reportsCloser'];
    }
    if ($result['reportsFronter'] != "ANY") {
        $collectionQuery['soldBy']['$eq'] = $result['reportsFronter'];
    }
    if ($result['reportsCarrier'] != "ANY") {
        $collectionQuery['carrier']['$eq'] = $result['reportsCarrier'];
    }
    if ($result['reportsCarrierPlan'] != "ANY") {
        $collectionQuery['coverageType']['$eq'] = $result['reportsCarrierPlan'];
    }
    if ($result['reportsLeadSource'] != "ANY") {
        $collectionQuery['leadSource']['$eq'] = $result['reportsLeadSource'];
    }
    $policCollectionQuery = $collectionQuery;
    // var_dump($collectionQuery);die();

    $policCollectionQuery['$and'][]['carrier']['$exists'] = TRUE;
    $policCollectionQuery['$and'][]['carrier']['$ne'] = "";

    if ((!empty($_SESSION['api']['user']['permissionLevel'])) && (strtoupper($_SESSION['api']['user']['permissionLevel']) <> "ADMINISTRATOR") && (strtoupper($_SESSION['api']['user']['permissionLevel']) <> "INSUREHC")) {
        $policCollectionQuery['$or'][]['soldBy']['$in'] = $userIds;
        $policCollectionQuery['$or'][]['closedBy']['$eq'] = $_SESSION['api']['user']['_id'];
    }
    // var_dump($policCollectionQuery);
    $take = 500;
    $personIds = array();
    $countPolices = $apiObj->mongoCount($policCollectionQuery);
    // echo $countPolices . '</br>';

    $skip = intval($countPolices / $take);
    if (is_float($countPolices / $take)) {
        $skip = intval($skip) + 1;
    }
    if ($skip == 0)
        $result['policies'][] = array();
    for ($i = 0; $i < $skip; $i++) {
        $cursor2 = $apiObj->mongoFind2($policCollectionQuery, $i, $take);
        foreach (iterator_to_array($cursor2) as $doc2) {
            $personIds[] = $doc2['_parentId'];
            $result['policies'][] = $doc2;
        }
    }
    // $is_police = true;
    // var_dump($result['policies']);
    // echo count($result['policies']); die();
    // $cursor2 = $apiObj->mongoFind($policCollectionQuery);
    // if($cursor2->count() == 0){
    //     $result['policies'][] = array();
    // } else {
    //     foreach (iterator_to_array($cursor2) as $doc2) {
    //         $personIds[] = $doc2['_parentId'];
    //         //$result['policies'][] = $apiObj->get_thing_display($doc2);
    //         $result['policies'][] = $doc2;
    //     }
    // }
    $collectionQuery = false;
    $apiObj->mongoSetCollection("person");
    $collectionQuery['_id']['$in'] = $personIds;

    // $cursor2 = $apiObj->mongoFind($collectionQuery);
    // $result['leadSources'] = array();
    // // echo $apiObj->mongoCount($policCollectionQuery);die();
    // if($cursor2->count() == 0){
    //     $result['person'][] = array();
    // } else {
    //     foreach (iterator_to_array($cursor2) as $doc2) {
    //         if(!empty($doc2['leadSource'])){
    //             $result['leadSources'][$doc2['_id']] = $doc2['leadSource'];
    //         }
    //         //$result['person'][] = $apiObj->get_thing_display($doc2);
    //         $result['person'][] = $doc2;
    //     }
    // }
    $countLeadResouces = $apiObj->mongoCount($collectionQuery);
    // echo $countLeadResouces . '</br>'; die();

    $skip = intval($countLeadResouces / $take);
    if (is_float($countLeadResouces / $take)) {
        $skip = intval($skip) + 1;
    }
    if ($skip == 0)
        $result['person'][] = array();

    for ($i = 0; $i < $skip; $i++) {
        $cursor2 = $apiObj->mongoFind2($collectionQuery, $i, $take);
        foreach (iterator_to_array($cursor2) as $doc2) {
            if (!empty($doc2['leadSource'])) {
                $result['leadSources'][$doc2['_id']] = $doc2['leadSource'];
            }
            // $result['person'][] = $doc2;
        }
    }
    // echo count($result['person']); die();
    $collectionQuery = false;
    $apiObj->mongoSetCollection("addresses");
    $collectionQuery['_parentId']['$in'] = $personIds;
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    $result['addressesState'] = array();
    if ($cursor2->count() == 0) {
        $result['addresses'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            if (!empty($doc2['state'])) {
                // echo $/doc2['_parentId'];die();
                $result['addressesState'][$doc2['_parentId']] = $doc2['state'];
            }
            // $result['addresses'][] = $apiObj->get_thing_display($doc2);
            // $result['addresses'][] = $doc2;
        }
    }
    $collectionQuery = false;
    $apiObj->mongoSetCollection("carrier");
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['carrier'][] = array();
    } else {
        $cursor2->sort(array('sort' => 1));
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['carrier'][$doc2['_id']] = $apiObj->get_thing_display($doc2);
            $result['carrier'][$doc2['_id']] = $doc2;
        }
    }
    $collectionQuery = false;
    $apiObj->mongoSetCollection("carrierPlan");
    $collectionQuery['status']['$eq'] = "ACTIVE";
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['carrierPlan'][] = array();
    } else {
        $cursor2->sort(array('sort' => 1));
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['carrierPlan'][$doc2['_id']] = $apiObj->get_thing_display($doc2);
            $result['carrierPlan'][$doc2['_id']] = $doc2;
        }
    }
    $collectionQuery = false;
    $apiObj->mongoSetCollection("user");
    $cursor2 = $apiObj->mongoFind($collectionQuery);

    if ($cursor2->count() == 0) {
        $result['user'][] = array();
    } else {
        $cursor2->sort(array('status' => 1, 'firstname' => 1));

        foreach (iterator_to_array($cursor2) as $doc2) {
            // $result['user'][$doc2['_id']] = $apiObj->get_thing_display($doc2);
            $result['user'][$doc2['_id']] = $doc2;
        }
    }
    $collectionQuery = false;
    $apiObj->mongoSetCollection("systemForm");
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['systemForm'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['systemForm'][$doc2['name']] = $apiObj->get_thing_display($doc2);
            $result['systemForm'][$doc2['name']] = $doc2;
        }
    }
    $result['sales']['totalPremium'] = 0;
    $result['sales']['totalPolicies'] = 0;
    $result['sales']['averagePrmium'] = 0;
    // STATE TOTALS
    $result['salesByState'] = array();
    $result['salesByState']['totalPremium'] = 0;
    $result['salesByState']['totalAverage'] = 0;
    $result['salesByState']['totalPolicies'] = 0;
    // echo count($result['policies']);
    foreach ($result['policies'] as $key => $value) {
        $leadsource = "UNKNOWN";
        $carrier = "UNKNOWN";
        $policy = "UNKNOWN";
        $fronter = "UNKNOWN";
        $closer = "UNKNOWN";
        $state = "UNKNOWN";

        // STATE SET
        if (!empty($result['addressesState'][$value['_parentId']])) {
            $state = $result['addressesState'][$value['_parentId']];
            // var_dump($state);die();
        }
        // var_dump($state);
        // LEAD SOURCE SET
        if (!empty($result['leadSources'][$value['_parentId']])) {
            $leadsource = $result['leadSources'][$value['_parentId']];
        }
        // echo $state .'</br>';
        if (($result['reportsState'] == "ANY" ) || ($result['reportsState'] == strtoupper($state))) {//var_dump($value['_id']);
            //TOTALS
            $result['sales']['totalPremium'] = $result['sales']['totalPremium'] + $value['premiumMoney'];
            $result['sales']['totalPolicies'] ++;
            $result['sales']['totalAverage'] = $result['sales']['totalPremium'] / $result['sales']['totalPolicies'];

            $stateValue = '';
            // STATE
            if (!empty($result['systemForm']['state']['options'])) {
                foreach ($result['systemForm']['state']['options'] as $sKey => $sVal) {
                    if ($sVal['value'] == strtoupper($state)) {
                        $state = strtoupper($sVal['label']);
                        $stateValue = $sVal['value'];
                        // var_dump($sVal);die();
                    }
                }
            }
            if (empty($result['salesByState']['states'][$state])) {
                $result['salesByState']['states'][$state]['value'] = $stateValue;
                $result['salesByState']['states'][$state]['id'] = $state;
                $result['salesByState']['states'][$state]['premium'] = 0;
                $result['salesByState']['states'][$state]['policies'] = 0;
                $result['salesByState']['states'][$state]['average'] = 0;
            }
            $result['salesByState']['states'][$state]['premium'] = $result['salesByState']['states'][$state]['premium'] + $value['premiumMoney'];
            $result['salesByState']['states'][$state]['policies'] ++;
            $result['salesByState']['states'][$state]['average'] = $result['salesByState']['states'][$state]['premium'] / $result['salesByState']['states'][$state]['policies'];
            $result['salesByState']['totalPremium'] = $result['salesByState']['totalPremium'] + $value['premiumMoney'];
            $result['salesByState']['totalPolicies'] ++;
            $result['salesByState']['totalAverage'] = $result['salesByState']['totalPremium'] / $result['salesByState']['totalPolicies'];
            // CARRIER
            if (!empty($result['carrier'][$value['carrier']]['name'])) {
                $carrier = $result['carrier'][$value['carrier']]['name'];
                $carrierId = $result['carrier'][$value['carrier']]['_id'];
            }
            if (empty($result['salesByCarrier']['carrier'][$carrier])) {
                $result['salesByCarrier']['carrier'][$carrier]['id'] = $carrierId;
                $result['salesByCarrier']['carrier'][$carrier]['premium'] = 0;
                $result['salesByCarrier']['carrier'][$carrier]['policies'] = 0;
                $result['salesByCarrier']['carrier'][$carrier]['average'] = 0;
            }
            $result['salesByCarrier']['carrier'][$carrier]['premium'] = $result['salesByCarrier']['carrier'][$carrier]['premium'] + $value['premiumMoney'];
            $result['salesByCarrier']['carrier'][$carrier]['policies'] ++;
            $result['salesByCarrier']['carrier'][$carrier]['average'] = $result['salesByCarrier']['carrier'][$carrier]['premium'] / $result['salesByCarrier']['carrier'][$carrier]['policies'];
            $result['salesByCarrier']['totalCarrierPremium'] = $result['salesByCarrier']['totalCarrierPremium'] + $value['premiumMoney'];
            $result['salesByCarrier']['totalCarrierPolicies'] ++;
            $result['salesByCarrier']['totalCarrierAverage'] = $result['salesByCarrier']['totalCarrierPremium'] / $result['salesByCarrier']['totalCarrierPolicies'];
            // CARRIER PLAN
            if (!empty($result['carrierPlan'][$value['coverageType']]['name'])) {
                $policy = $result['carrierPlan'][$value['coverageType']]['name'];
                $policyId = $result['carrierPlan'][$value['coverageType']]['_id'];
            }
            if (empty($result['salesByCarrier']['carrierPlan'][$policy])) {
                $result['salesByCarrier']['carrierPlan'][$policy]['id'] = $policyId;
                $result['salesByCarrier']['carrierPlan'][$policy]['premium'] = 0;
                $result['salesByCarrier']['carrierPlan'][$policy]['policies'] = 0;
                $result['salesByCarrier']['carrierPlan'][$policy]['average'] = 0;
            }
            $result['salesByCarrier']['carrierPlan'][$policy]['premium'] = $result['salesByCarrier']['carrierPlan'][$policy]['premium'] + $value['premiumMoney'];
            $result['salesByCarrier']['carrierPlan'][$policy]['policies'] ++;
            $result['salesByCarrier']['carrierPlan'][$policy]['average'] = $result['salesByCarrier']['carrierPlan'][$policy]['premium'] / $result['salesByCarrier']['carrierPlan'][$policy]['policies'];
            $result['salesByCarrier']['totalCarrierPlanPremium'] = $result['salesByCarrier']['totalCarrierPlanPremium'] + $value['premiumMoney'];
            $result['salesByCarrier']['totalCarrierPlanPolicies'] ++;
            $result['salesByCarrier']['totalCarrierPlanAverage'] = $result['salesByCarrier']['totalCarrierPlanPremium'] / $result['salesByCarrier']['totalCarrierPlanPolicies'];
            // FRONTER
            if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                $fronter = $value['soldBy'];
            }
            if (empty($result['salesByUsers']['fronters'][$fronter])) {
                $result['salesByUsers']['fronters'][$fronter]['premium'] = 0;
                $result['salesByUsers']['fronters'][$fronter]['policies'] = 0;
                $result['salesByUsers']['fronters'][$fronter]['average'] = 0;
                $result['salesByUsers']['fronters'][$fronter]['name'] = "UNKNOWN";
                if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                    $result['salesByUsers']['fronters'][$fronter]['id'] = $result['user'][$value['soldBy']]['_id'];
                    $result['salesByUsers']['fronters'][$fronter]['name'] = $result['user'][$value['soldBy']]['firstname'] . " " . $result['user'][$value['soldBy']]['lastname'];
                }
            }
            $result['salesByUsers']['fronters'][$fronter]['premium'] = $result['salesByUsers']['fronters'][$fronter]['premium'] + $value['premiumMoney'];
            $result['salesByUsers']['fronters'][$fronter]['policies'] ++;
            $result['salesByUsers']['fronters'][$fronter]['average'] = $result['salesByUsers']['fronters'][$fronter]['premium'] / $result['salesByUsers']['fronters'][$fronter]['policies'];
            $result['salesByUsers']['totalFronterPremium'] = $result['salesByUsers']['totalFronterPremium'] + $value['premiumMoney'];
            $result['salesByUsers']['totalFronterPolicies'] ++;
            $result['salesByUsers']['totalFronterAverage'] = $result['salesByUsers']['totalFronterPremium'] / $result['salesByUsers']['totalFronterPolicies'];
            // FRONTER POLICY TYPES
            if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                $fronter = $value['soldBy'];
            }
            if (empty($result['salesByUsersByType']['fronters'][$fronter][$policy])) {
                $result['salesByUsersByType']['fronters'][$fronter][$policy]['premium'] = 0;
                $result['salesByUsersByType']['fronters'][$fronter][$policy]['policies'] = 0;
                $result['salesByUsersByType']['fronters'][$fronter][$policy]['average'] = 0;
                $result['salesByUsersByType']['fronters'][$fronter][$policy]['name'] = "UNKNOWN";
                if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                    $result['salesByUsersByType']['fronters'][$fronter]['name'] = $result['user'][$value['soldBy']]['firstname'] . " " . $result['user'][$value['soldBy']]['lastname'];
                }
            }
            $result['salesByUsersByType']['fronters'][$fronter]['clients'][$value['_parentId']] = 1;
            $result['salesByUsersByType']['fronters'][$fronter][$policy]['premium'] = $result['salesByUsersByType']['fronters'][$fronter][$policy]['premium'] + $value['premiumMoney'];
            $result['salesByUsersByType']['fronters'][$fronter][$policy]['policies'] ++;
            $result['salesByUsersByType']['fronters'][$fronter][$policy]['average'] = $result['salesByUsersByType']['fronters'][$fronter][$policy]['premium'] / $result['salesByUsersByType']['fronters'][$fronter][$policy]['policies'];
            $result['salesByUsersByType']['totalFronterPremium'] = $result['salesByUsersByType']['totalFronterPremium'] + $value['premiumMoney'];
            $result['salesByUsersByType']['totalFronterPolicies'] ++;
            $result['salesByUsersByType']['totalFronterAverage'] = $result['salesByUsersByType']['totalFronterPremium'] / $result['salesByUsersByType']['totalFronterPolicies'];
            // CLOSER
            if (!empty($result['user'][$value['closedBy']]['firstname'])) {
                $closer = $value['closedBy'];
            }
            if (empty($result['salesByUsers']['closers'][$closer])) {
                $result['salesByUsers']['closers'][$closer]['premium'] = 0;
                $result['salesByUsers']['closers'][$closer]['policies'] = 0;
                $result['salesByUsers']['closers'][$closer]['average'] = 0;
                $result['salesByUsers']['closers'][$closer]['name'] = "UNKNOWN";
                if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                    // var_dump($result['user'][$value['closedBy']]['_id'] );die();
                    $result['salesByUsers']['closers'][$closer]['id'] = $result['user'][$value['closedBy']]['_id'];
                    $result['salesByUsers']['closers'][$closer]['name'] = $result['user'][$value['closedBy']]['firstname'] . " " . $result['user'][$value['closedBy']]['lastname'];
                }
            }
            $result['salesByUsers']['closers'][$closer]['premium'] = $result['salesByUsers']['closers'][$closer]['premium'] + $value['premiumMoney'];
            $result['salesByUsers']['closers'][$closer]['policies'] ++;
            $result['salesByUsers']['closers'][$closer]['average'] = $result['salesByUsers']['closers'][$closer]['premium'] / $result['salesByUsers']['closers'][$closer]['policies'];
            $result['salesByUsers']['totalCloserPremium'] = $result['salesByUsers']['totalCloserPremium'] + $value['premiumMoney'];
            $result['salesByUsers']['totalCloserPolicies'] ++;
            $result['salesByUsers']['totalCloserAverage'] = $result['salesByUsers']['totalCloserPremium'] / $result['salesByUsers']['totalCloserPolicies'];
            $leadsourceId = '';
            // LEAD SOURCE
            if (!empty($result['systemForm']['leadSource']['options'])) {
                foreach ($result['systemForm']['leadSource']['options'] as $sKey => $sVal) {
                    if ($sVal['value'] == strtoupper($leadsource)) {
                        $leadsource = strtoupper($sVal['label']);
                        $leadsourceId = $sVal['_id'];
                    }
                }
            }

            if (empty($result['salesByLead']['leadsources'][$leadsource])) {
                $result['salesByLead']['leadsources'][$leadsource]['id'] = $leadsourceId;
                $result['salesByLead']['leadsources'][$leadsource]['premium'] = 0;
                $result['salesByLead']['leadsources'][$leadsource]['policies'] = 0;
                $result['salesByLead']['leadsources'][$leadsource]['average'] = 0;
            }
            // $result['salesByLead']['leadsources'][$leadsource]['id'] = $leadsourceId;
            $result['salesByLead']['leadsources'][$leadsource]['premium'] = $result['salesByLead']['leadsources'][$leadsource]['premium'] + $value['premiumMoney'];
            $result['salesByLead']['leadsources'][$leadsource]['policies'] ++;
            $result['salesByLead']['leadsources'][$leadsource]['average'] = $result['salesByLead']['leadsources'][$leadsource]['premium'] / $result['salesByLead']['leadsources'][$leadsource]['policies'];
            $result['salesByLead']['totalPremium'] = $result['salesByLead']['totalPremium'] + $value['premiumMoney'];
            $result['salesByLead']['totalPolicies'] ++;
            $result['salesByLead']['totalAverage'] = $result['salesByLead']['totalPremium'] / $result['salesByLead']['totalPolicies'];
            // CLOSER   By Type
            if (!empty($result['user'][$value['closedBy']]['firstname'])) {
                $closer = $value['closedBy'];
            }
            if (empty($result['salesByUsersByType']['closers'][$closer][$policy])) {
                $result['salesByUsersByType']['closers'][$closer][$policy]['premium'] = 0;
                $result['salesByUsersByType']['closers'][$closer][$policy]['policies'] = 0;
                $result['salesByUsersByType']['closers'][$closer][$policy]['average'] = 0;
                $result['salesByUsersByType']['closers'][$closer][$policy]['name'] = "UNKNOWN";
                if (!empty($result['user'][$value['soldBy']]['firstname'])) {
                    $result['salesByUsersByType']['closers'][$closer]['name'] = $result['user'][$value['closedBy']]['firstname'] . " " . $result['user'][$value['closedBy']]['lastname'];
                }
            }
            $result['salesByUsersByType']['closers'][$closer]['clients'][$value['_parentId']] = 1;
            $result['salesByUsersByType']['closers'][$closer][$policy]['premium'] = $result['salesByUsersByType']['closers'][$closer][$policy]['premium'] + $value['premiumMoney'];
            $result['salesByUsersByType']['closers'][$closer][$policy]['policies'] ++;
            $result['salesByUsersByType']['closers'][$closer][$policy]['average'] = $result['salesByUsersByType']['closers'][$closer][$policy]['premium'] / $result['salesByUsersByType']['closers'][$closer][$policy]['policies'];
            $result['salesByUsersByType']['totalCloserPremium'] = $result['salesByUsersByType']['totalCloserPremium'] + $value['premiumMoney'];
            $result['salesByUsersByType']['totalCloserPolicies'] ++;
            $result['salesByUsersByType']['totalCloserAverage'] = $result['salesByUsersByType']['totalCloserPremium'] / $result['salesByUsers']['totalCloserPolicies'];
        }

        unset($result['policies'][$key]);
    }
    if (!empty($result['salesByState']['states'])) {
        arsort($result['salesByState']['states']);
    }
    if (!empty($result['salesByState']['carrier'])) {
        arsort($result['salesByCarrier']['carrier']);
    }
    if (!empty($result['salesByState']['carrierPlan'])) {
        arsort($result['salesByCarrier']['carrierPlan']);
    }
    if (!empty($result['salesByState']['fronters'])) {
        arsort($result['salesByUsers']['fronters']);
    }
    if (!empty($result['salesByState']['closers'])) {
        arsort($result['salesByUsers']['closers']);
    }
    // var_dump($result['salesByLead']['leadsources']);die();
    return $result;
}

$app->get('/', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!$apiObj->userLoggedIn()) {
        echo "";
        exit();
    }

    if (!empty($_GET['search'])) {
        $status = $supplier = $lead_source = $user = $date = $state = array();
        if (!empty($_REQUEST['status'])) {

            $status['$or'] = array(
                array('electric_supply_product_status' => $_REQUEST['status']),
                array('gas_supply_product_status' => $_REQUEST['status']),
                array('internet_supply_product_status' => $_REQUEST['status'])
            );
        }
        if (!empty($_REQUEST['reportsStartDate'])) {

            $date['_dateCreated']['$gt'] = date('YmdHis', strtotime($_REQUEST['reportsStartDate']));
        }
        if (!empty($_REQUEST['reportsEndDate'])) {

            $date['_dateCreated']['$lt'] = date('YmdHis', strtotime($_REQUEST['reportsEndDate']));
        }
        if (!empty($_REQUEST['reportsState'])) {

            $state['service_state'] = $_REQUEST['reportsState'];
        }
        if (!empty($_REQUEST['supplier'])) {

            $supplier['$or'] = array(
                array('electric_supplier' => $_REQUEST['supplier']),
                array('gas_supplier' => $_REQUEST['supplier']),
                array('internet_supplier' => $_REQUEST['supplier'])
            );
        }
        if (!empty($_REQUEST['lead_source'])) {

            $lead_source = array('lead_source' => $_REQUEST['lead_source']);
        }
        if (!empty($_REQUEST['user'])) {

            $user = array('_userId' => $_REQUEST['user']);
        }
        $apiObj->mongoSetCollection("leads");
        $collectionQuery = array();
        $collectionQuery = array_merge($collectionQuery, $status, $lead_source, $user, $date, $state);
        $leads = $apiObj->mongoFind($collectionQuery);
        $result['lead_count'] = $leads->count();
        $apiObj->mongoSetCollection("products");
        $collectionQuery = array();
        $collectionQuery = array_merge($collectionQuery, $user, $date);
        $products = $apiObj->mongoFind($collectionQuery);
        $result['product_count'] = $products->count();
        $apiObj->mongoSetCollection("suppliers");
        $clientCount = 0;


        foreach ($leads as $lead) {

            if ($lead['electric_supply_product_status'] == 'Sale' || $lead['gas_supply_product_status'] == 'Sale' || $lead['internet_supply_product_status'] == 'Sale') {

                $clientCount++;
            }            
            $users[$lead['_userId']]['lead_count'] ++;
            $result['by_state'][trim($lead['service_state'])]['lead_count'] ++;
            $result['by_lead_source'][$lead['lead_source']]['lead_count'] ++;
            if (!empty($lead['electric_supplier'])) {
                $result['by_supplier'][$lead['electric_supplier']]['lead_count'] ++;
                $collectionQuery = array('_id' => $lead['electric_supplier']);
                $result['by_supplier'][$lead['electric_supplier']]['name'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
            }
            if (!empty($lead['gas_supplier'])) {
                $collectionQuery = array('_id' => $lead['gas_supplier']);
                $result['by_supplier'][$lead['gas_supplier']]['name'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
                $result['by_supplier'][$lead['gas_supplier']]['lead_count'] ++;
            }
            if (!empty($lead['internet_supplier'])) {
                $collectionQuery = array('_id' => $lead['internet_supplier']);
                $result['by_supplier'][$lead['internet_supplier']]['name'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
                $result['by_supplier'][$lead['internet_supplier']]['lead_count'] ++;
            }
        }
        $apiObj->mongoSetCollection("user");
        if (!empty($users)) {

            foreach ($users as $id => $count) {

                if (count($result['managers']) < 10) {

                    $user = $apiObj->mongoFindOne(array('_id' => $id));

                    if ($user['permissionLevel'] == 'MANAGER' || $user['permissionLevel'] == 'ADMINISTRATOR') {

                        $result['by_managers'][] = array('name' => $user['firstname'] . ' ' . $user['lastname'], 'lead_count' => $count['lead_count']);
                    }
                }

                if (count($result['agents']) < 10) {

                    $user = $apiObj->mongoFindOne(array('_id' => $id));

                    if ($user['permissionLevel'] == 'AGENT' || empty($user['permissionLevel'])) {

                        $result['by_agents'][] = array('name' => $user['firstname'] . ' ' . $user['lastname'], 'lead_count' => $count['lead_count']);
                    }
                }
            }
        }

        if (!empty($result['agents'])) {

            $agents = array();
            foreach ($result['agents'] as $key => $row) {
                $agents[$key] = $row['lead_count'];
            }
            array_multisort($agents, SORT_DESC, $result['agents']);
        }
        if (!empty($result['managers'])) {

            $managers = array();
            foreach ($result['managers'] as $key => $row) {
                $managers[$key] = $row['lead_count'];
            }
            array_multisort($managers, SORT_DESC, $result['managers']);
        }
        $result['client_count'] = $clientCount;
    }
    $apiObj->mongoSetCollection("statusList");
    $collectionQuery = array();
    $result['status_list'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("leadSources");
    $collectionQuery = array();
    $result['lead_sources'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array();
    $result['suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $apiObj->mongoSetCollection("user");
    $collectionQuery = array();
    $result['users'] = $apiObj->mongoFind($collectionQuery);

    $app->render('reports.php', array('result' => $result, "apiObj" => $apiObj, "settings" => $settings));
    peakmemory();
});
$app->run();
