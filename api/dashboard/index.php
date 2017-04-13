<?php

require '../app.php';
$app->config(array(
    'templates.path' => './',
));
$app->get('/(:duration)', function ($duration = null) use ($app, $settings) {

    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if ($apiObj->userLoggedIn()) {

        if ($duration == '1' || $duration == null) {
            $beginOfDay = strtotime("midnight");
            $date['_dateCreated']['$gt'] = date('YmdHis', $beginOfDay);
            $date['_dateCreated']['$lt'] = date('YmdHis');

            $productData[] = array(0, $apiObj->productsCreated($date));
        } elseif ($duration == 'week') {
            $beginOfDay = strtotime("Monday this week");
            $date['_dateCreated']['$gt'] = date('YmdHis', $beginOfDay);
            $date['_dateCreated']['$lt'] = date('YmdHis');

            $point = 0;
            $currentTimeStamp = $beginOfDay;
            while (true) {
                $currentDate['_dateCreated']['$gt'] = date('Ymd', $currentTimeStamp) . '000000';
                $currentDate['_dateCreated']['$lt'] = date('Ymd', $currentTimeStamp) . '235959';
                $productData[] = array($point, $apiObj->productsCreated($currentDate));

                if ($currentTimeStamp >= time()) {

                    break;
                } else {

                    $currentTimeStamp = $currentTimeStamp + 86400;
                }
                $point++;
            }
        } elseif ($duration == 'preweek') {
            $beginOfDay = strtotime("Monday last week");
            $endOfDay = strtotime("Sunday last week");
            $date['_dateCreated']['$gt'] = date('YmdHis', $beginOfDay);
            $date['_dateCreated']['$lt'] = date('YmdHis', $endOfDay);

            $point = 0;
            $currentTimeStamp = $beginOfDay;
            while (true) {
                $currentDate['_dateCreated']['$gt'] = date('Ymd', $currentTimeStamp) . '000000';
                $currentDate['_dateCreated']['$lt'] = date('Ymd', $currentTimeStamp) . '235959';
                $productData[] = array($point, $apiObj->productsCreated($currentDate));

                if ($currentTimeStamp >= $endOfDay) {

                    break;
                } else {

                    $currentTimeStamp = $currentTimeStamp + 86400;
                }
                $point++;
            }
        } elseif ($duration == '30') {
            $beginOfDay = strtotime("-30 days");
            $date['_dateCreated']['$gt'] = date('YmdHis', $beginOfDay);
            $date['_dateCreated']['$lt'] = date('YmdHis');

            $point = 0;
            $currentTimeStamp = $beginOfDay;
            while (true) {
                $currentDate['_dateCreated']['$gt'] = date('Ymd', $currentTimeStamp) . '000000';
                $currentDate['_dateCreated']['$lt'] = date('Ymd', $currentTimeStamp) . '235959';
                $productData[] = array($point, $apiObj->productsCreated($currentDate));

                if ($currentTimeStamp >= time()) {

                    break;
                } else {

                    $currentTimeStamp = $currentTimeStamp + 86400;
                }
                $point++;
            }
        } elseif ($duration == '60') {
            $beginOfDay = strtotime("-60 days");
            $date['_dateCreated']['$gt'] = date('YmdHis', $beginOfDay);
            $date['_dateCreated']['$lt'] = date('YmdHis');

            $point = 0;
            $currentTimeStamp = $beginOfDay;
            while (true) {
                $currentDate['_dateCreated']['$gt'] = date('Ymd', $currentTimeStamp) . '000000';
                $currentDate['_dateCreated']['$lt'] = date('Ymd', $currentTimeStamp) . '235959';
                $productData[] = array($point, $apiObj->productsCreated($currentDate));

                if ($currentTimeStamp >= time()) {

                    break;
                } else {

                    $currentTimeStamp = $currentTimeStamp + 86400;
                }
                $point++;
            }
        }

        $apiObj->mongoSetCollection("leads");
        $leads = $apiObj->mongoFind($date);
        $clientCount = 0;
        foreach ($leads as $lead) {

            if ($lead['electric_supply_product_status'] == 'Sale' || $lead['gas_supply_product_status'] == 'Sale' || $lead['internet_supply_product_status'] == 'Sale') {

                $clientCount++;;
            }
            
            $users[$lead['_userId']]['lead_count'] ++;
        }
        $apiObj->mongoSetCollection("user");
        if (!empty($users)) {

            foreach ($users as $id => $count) {

                if (count($result['managers']) < 10) {

                    $user = $apiObj->mongoFindOne(array('_id' => $id));

                    if ($user['permissionLevel'] == 'MANAGER' || $user['permissionLevel'] == 'ADMINISTRATOR') {

                        $result['managers'][] = array('_id' => $user['_id'], 'name' => $user['firstname'] . ' ' . $user['lastname'], 'lead_count' => $count['lead_count']);
                    }
                }

                if (count($result['agents']) < 10) {

                    $user = $apiObj->mongoFindOne(array('_id' => $id));

                    if ($user['permissionLevel'] == 'AGENT' || empty($user['permissionLevel'])) {

                        $result['agents'][] = array('_id' => $user['_id'], 'name' => $user['firstname'] . ' ' . $user['lastname'], 'lead_count' => $count['lead_count']);
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
        
        $apiObj->mongoSetCollection("products");
        $collectionQuery = array();
        $collectionQuery = array_merge($collectionQuery, $date);
        $products = $apiObj->mongoFind($collectionQuery);

        $leadPercent = 0;

        try {

            $result['widgets']['policies']['label'] = "<a href='#products'>Products Sold</a>";
            $result['widgets']['policies']['time'] = "Created";
            $result['widgets']['policies']['amount'] = '<a style="color: darkblue;" target="_blank" href="#products/start_date=' . $date['_dateCreated']['$gt'] . '&end_date=' .$date['_dateCreated']['$lt']. '">' . $products->count() . '</a>';
            $result['widgets']['policies']['percent'] = number_format(0, 4) . "%";
            $result['widgets']['policies']['note'] = "Total Products Sold";
            $result['widgets']['leads']['label'] = "<a href='#lead'>Leads Created</a>";
            $result['widgets']['leads']['time'] = "Created";
            $result['widgets']['leads']['amount'] = '<a style="color: darkblue;" target="_blank" href="#lead/start_date=' . $date['_dateCreated']['$gt'] . '&end_date=' .$date['_dateCreated']['$lt']. '">' . $leads->count() . '</a>';
            $result['widgets']['leads']['percent'] = number_format($leadPercent, 4) . "%";
            $result['widgets']['leads']['note'] = "Total Leads Conversion";
            $result['widgets']['clients']['label'] = "<a href='#clients'>Customers</a>";
            $result['widgets']['clients']['time'] = "Calculated";
            $result['widgets']['clients']['amount'] = '<a style="color: darkblue;" target="_blank" href="#clients/start_date=' . $date['_dateCreated']['$gt'] . '&end_date=' .$date['_dateCreated']['$lt']. '">' . $clientCount . '</a>';
            $result['widgets']['clients']['percent'] = number_format($averagePerClient, 4);
            $result['widgets']['clients']['note'] = "Average Products Per Client";
            $result['date']['start'] = $date['_dateCreated']['$gt'];
            $result['date']['end'] = $date['_dateCreated']['$lt'];
            $result['duration'] = $duration;

            $result['graph'] = $productData;
            $result['product_count'] = $products->count();

            $app->render('dashboard1.php', array('result' => $result, "apiObj" => $apiObj, "settings" => $settings));
            peakmemory();
        } catch (Exception $e) {
            // debug($e);
            echo 'Please create your first leads and policies';
        }
    } else {
        echo "Please Log In";
    }
});
$app->map('/info/:table', function ($table) use ($app, $settings) {
    $result = array();
    $result['headers'] = array(
        0 => "Name",
        1 => "Products",
    );
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!$apiObj->userLoggedIn()) {
        echo "";
        exit();
    }
    $apiObj->mongoSetCollection("user");
    $cursor1 = $apiObj->mongoFind();
    if ($cursor1->count() == 0) {
        $userList = array();
    } else {
        foreach (iterator_to_array($cursor1) as $doc2) {
            $userList[$doc2['_id']] = $doc2['firstname'] . " " . $doc2['lastname'];
        }
    }
    //$userIds = $apiObj->getUserIds();
    $apiObj->mongoSetCollection("policy");
    $collectionQuery['_timestampCreated']['$lte'] = date("Ymd235959");
    $collectionQuery['_timestampCreated']['$gte'] = date("Ymd000000");


    $start_var = -7;
    $end_var = 1;
    $result['timeIncrement'] = "1";
    if (!empty($_SESSION['timeIncrement'])) {
        $result['timeIncrement'] = $_SESSION['timeIncrement'];
    }
    if (!empty($_GET['timeIncrement'])) {
        $result['timeIncrement'] = $_GET['timeIncrement'];
    }
    $start_var = (-$result['timeIncrement']) + 1;
    $start_date = date('YmdHis', mktime(0, 0, 0, date("m"), date("d") + $start_var, date("Y")));
    $end_date = date('YmdHis');

    $reportsStartDate = date('m/d/Y', mktime(0, 0, 0, date("m"), date("d") + $start_var, date("Y")));
    $reportsEndDate = date('m/d/Y');

    $collectionQuery = array(
        "_timestampCreated" => array(
            '$gte' => $start_date,
            '$lte' => $end_date
        )
    );
    if (($result['timeIncrement'] == "week") || ($result['timeIncrement'] == "prevweek")) {
        $day = date('w');
        if ($result['timeIncrement'] == "prevweek") {
            $start_date = date('Ymd000000', strtotime('-' . ($day + 7) . ' days'));
            $end_date = date('Ymd235959', strtotime('+' . (6 - ($day + 7)) . ' days'));
            $reportsStartDate = date('m/d/Y', strtotime('-' . ($day + 7) . ' days'));
            $reportsEndDate = date('m/d/Y', strtotime('+' . (6 - ($day + 7)) . ' days'));

            $start_var = -$day - 7;
            $end_var = $end_var - 7;
        } else {
            $start_date = date('Ymd000000', strtotime('-' . $day . ' days'));
            $end_date = date('Ymd235959', strtotime('+' . (6 - $day) . ' days'));
            $reportsStartDate = date('m/d/Y', strtotime('-' . $day . ' days'));
            $reportsEndDate = date('m/d/Y', strtotime('+' . (6 - $day) . ' days'));
            $start_var = -$day;
        }
        $collectionQuery = array(
            "_timestampCreated" => array(
                '$gte' => $start_date,
                '$lte' => $end_date
            )
        );
    }


    $statuses = array("HOLD", "SOLD");
    $collectionQuery['status']['$in'] = $statuses;
    $collectionQuery['soldBy']['$ne'] = "";
    $collectionQuery['closedBy']['$ne'] = "";
    // var_dump($collectionQuery);die();
    // $collectionQuery['$or'][]['soldBy']['$in'] = $userIds;
    //$collectionQuery['$or'][]['closedBy']['$in'] = $userIds;
    $personIds = array();
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $policies = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            $personIds[] = $doc2['_parentId'];
            // var_dump($doc2);
            if (empty($policies['closed'][$doc2['closedBy']]['premium'])) {
                $policies['closed'][$doc2['closedBy']]['premium'] = 0;
            }
            if (empty($policies['fronter'][$doc2['soldBy']]['premium'])) {
                $policies['fronter'][$doc2['soldBy']]['premium'] = 0;
            }
            $policies['closed'][$doc2['closedBy']]['policies'][$doc2['_id']]['personId'] = $doc2['_parentId'];
            $policies['closed'][$doc2['closedBy']]['count'] = count($policies['closed'][$doc2['closedBy']]['policies']);
            $policies['closed'][$doc2['closedBy']]['premium'] = $policies['closed'][$doc2['closedBy']]['premium'] + $doc2['premiumMoney'];
            $policies['closed'][$doc2['closedBy']]['closedBy'] = $doc2['closedBy'];
            $policies['fronter'][$doc2['soldBy']]['policies'][$doc2['_id']]['personId'] = $doc2['_parentId'];
            $policies['fronter'][$doc2['soldBy']]['count'] = count($policies['fronter'][$doc2['soldBy']]['policies']);
            $policies['fronter'][$doc2['soldBy']]['premium'] = $policies['fronter'][$doc2['soldBy']]['premium'] + $doc2['premiumMoney'];
            $policies['fronter'][$doc2['soldBy']]['soldBy'] = $doc2['soldBy'];
        }
    }
    try {
        foreach ($policies['closed'] as $key => $row) {
            $volume[$key] = $row['count'];
            $premium[$key] = $row['premium'];
        }

        array_multisort($volume, SORT_DESC, $premium, SORT_DESC, $policies['closed']);
        foreach ($policies['fronter'] as $key => $row) {
            $volume2[$key] = $row['count'];
            $premium2[$key] = $row['premium'];
        }
        // var_dump($volume2);die();
        array_multisort($volume2, SORT_DESC, $premium2, SORT_DESC, $policies['fronter']);
        if ($table == "closerTable") {
            foreach ($policies['closed'] as $key => $info) {
                $result['rows'][] = array(
                    // ucwords(strtolower($userList[$key])),
                    '<a target="_blank" href="#policies/dashboardStatus=Y&reportsStatus=ANY&reportsStartDate=' . urlencode($reportsStartDate) . '&reportsEndDate=' . urlencode($reportsEndDate) . '&reportsCarrier=ANY&reportsCarrierPlan=ANY&reportsLeadSource=ANY&reportsFronter=ANY&reportsCloser=' . $info['closedBy'] . '&reportsState=ANY">' . ucwords(strtolower($userList[$key])) . '</a>',
                    $policies['closed'][$key]['count'],
                    "$" . number_format(($premium[$key] / $volume[$key]), 2, '.', ','),
                    "$" . number_format($premium[$key], 2, '.', ','),
                );
            }
        } else {
            foreach ($policies['fronter'] as $key => $info) {
                $result['rows'][] = array(
                    '<a target="_blank" href="#policies/dashboardStatus=Y&reportsStatus=ANY&reportsStartDate=' . urlencode($reportsStartDate) . '&reportsEndDate=' . urlencode($reportsEndDate) . '&reportsCarrier=ANY&reportsCarrierPlan=ANY&reportsLeadSource=ANY&reportsFronter=' . $info['soldBy'] . '&reportsCloser=ANY&reportsState=ANY">' . ucwords(strtolower($userList[$key])) . '</a>',
                    $policies['fronter'][$key]['count'],
                    "$" . number_format(($premium2[$key] / $volume2[$key]), 2, '.', ','),
                    "$" . number_format($premium2[$key], 2, '.', ','),
                );
            }
        }
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response['X-Powered-By'] = 'EBC';
        $response->status(200);
        // etc.
        $response->body(json_encode($result));
    } catch (Exception $e) {
        $result['rows'][] = array(
            "None",
            0,
            "$0.00",
            "$0.00",
        );
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response['X-Powered-By'] = 'EBC';
        $response->status(200);
        // etc.
        $response->body(json_encode($result));
    }
})->via('GET', 'POST');

function record_sort($records, $field, $reverse = false) {
    $hash = array();
    $item = 1.00000000001;
    foreach ($records as $key => $record) {
        $item = $item + 0.00000000001;
        $hash[$record[$field] . $item] = $record;
    }
    ($reverse) ? krsort($hash) : ksort($hash);
    $records = array();
    foreach ($hash as $record) {
        $records [] = $record;
    }
    return $records;
}

$app->map('/grouptables', function () use ($app, $settings) {
    $result = array();
    $result['headers'] = array(
        0 => "Name",
        1 => "Total Policies",
        2 => "Sold",
        3 => "Hold",
        4 => "Follow Up",
        5 => "Cancelled",
        6 => "Payment Issue",
        7 => "Unknown",
        8 => "Premium"
    );
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!$apiObj->userLoggedIn()) {
        echo "";
        exit();
    }
    $apiObj->mongoSetCollection("userGroups");
    $cursor1 = $apiObj->mongoFind();
    if ($cursor1->count() == 0) {
        $userGroupList = array();
    } else {
        foreach (iterator_to_array($cursor1) as $doc2) {
            $userGroupList[$doc2['_id']] = $doc2;
        }
    }
    // debug($userGroupList);
    $apiObj->mongoSetCollection("user");
    $cursor1 = $apiObj->mongoFind();
    if ($cursor1->count() == 0) {
        $userList = array();
    } else {
        foreach (iterator_to_array($cursor1) as $doc2) {
            $userList[$doc2['_id']] = $doc2['firstname'] . " " . $doc2['lastname'];
        }
    }
    $userGroups = array();
    foreach ($userList as $key => $var) {
        foreach ($userGroupList as $key2 => $var2) {
            if (!empty($var2['users'])) {
                foreach ($var2['users'] as $key3 => $var3) {
                    if ($key == $var3['userId']) {
                        if (strtoupper($var3['level']) == "USER") {
                            $userGroups[$var3['userId']] = $key2;
                        }
                    }
                }
            }
        }
    }
    // var_dump($userGroups);die();
    $apiObj->mongoSetCollection("policy");
    $start_var = -7;
    $end_var = 1;
    $result['timeIncrement'] = "1";
    if (!empty($_SESSION['timeIncrement'])) {
        $result['timeIncrement'] = $_SESSION['timeIncrement'];
    }
    if (!empty($_GET['timeIncrement'])) {
        $result['timeIncrement'] = $_GET['timeIncrement'];
    }
    $start_var = (-$result['timeIncrement']) + 1;
    $start_date = date('Ymd000000', mktime(0, 0, 0, date("m"), date("d") + $start_var, date("Y")));
    $end_date = date('Ymd235959');

    $reportsStartDate = date('m/d/Y', mktime(0, 0, 0, date("m"), date("d") + $start_var, date("Y")));
    $reportsEndDate = date('m/d/Y');
    $collectionQuery = array(
        "_timestampCreated" => array(
            '$gte' => $start_date,
            '$lte' => $end_date
        )
    );
    if (($result['timeIncrement'] == "week") || ($result['timeIncrement'] == "prevweek")) {
        $day = date('w');
        if ($result['timeIncrement'] == "prevweek") {
            $start_date = date('Ymd000000', strtotime('-' . ($day + 7) . ' days'));
            $end_date = date('Ymd235959', strtotime('+' . (6 - ($day + 7)) . ' days'));
            $reportsStartDate = date('m/d/Y', strtotime('-' . ($day + 7) . ' days'));
            $reportsEndDate = date('m/d/Y', strtotime('+' . (6 - ($day + 7)) . ' days'));
            $start_var = -$day - 7;
            $end_var = $end_var - 7;
        } else {
            $start_date = date('Ymd000000', strtotime('-' . $day . ' days'));
            $end_date = date('Ymd235959', strtotime('+' . (6 - $day) . ' days'));
            $start_var = -$day;
            $reportsStartDate = date('m/d/Y', strtotime('-' . $day . ' days'));
            $reportsEndDate = date('m/d/Y', strtotime('+' . (6 - $day) . ' days'));
        }
        $collectionQuery = array(
            "_timestampCreated" => array(
                '$gte' => $start_date,
                '$lte' => $end_date
            )
        );
    }

    $personIds = array();
    $cursor2 = $apiObj->mongoFind($collectionQuery);

    if ($cursor2->count() == 0) {
        $policies = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            if ($userGroups[$doc2['soldBy']] <> "") {
                if (empty($policies[$userGroups[$doc2['soldBy']]]['name'])) {
                    $policies[$userGroups[$doc2['soldBy']]]['name'] = $userGroupList[$userGroups[$doc2['soldBy']]]['label'];
                    $policies[$userGroups[$doc2['soldBy']]]['userGroup'] = $userGroups[$doc2['soldBy']];
                }
                if (empty($policies[$userGroups[$doc2['soldBy']]]['TOTAL'])) {
                    $policies[$userGroups[$doc2['soldBy']]]['TOTAL'] = 0;
                }
                // echo $policies[$userGroups[$doc2['soldBy']]]['TOTAL'];
                $policies[$userGroups[$doc2['soldBy']]]['TOTAL'] ++;
                if (empty($policies[$userGroups[$doc2['soldBy']]]['premium'])) {
                    $policies[$userGroups[$doc2['soldBy']]]['premium'] = 0;
                }
                $policies[$userGroups[$doc2['soldBy']]]['premium'] = $policies[$userGroups[$doc2['soldBy']]]['premium'] + $doc2['premiumMoney'];
                if ($doc2['status'] == "") {
                    $doc2['status'] = "UNKNOWN";
                }
                if (empty($policies[$userGroups[$doc2['soldBy']]][strtoupper($doc2['status'])])) {
                    $policies[$userGroups[$doc2['soldBy']]][strtoupper($doc2['status'])] = 0;
                }
                $policies[$userGroups[$doc2['soldBy']]][strtoupper($doc2['status'])] = $policies[$userGroups[$doc2['soldBy']]][strtoupper($doc2['status'])] + 1;
            }
        } // End foreach
        // die();
    }
    try {
        $policies = record_sort($policies, "TOTAL", TRUE);
        foreach ($policies as $key => $var) {
            if ($var['TOTAL'] == "") {
                $var['TOTAL'] = 0;
            }
            if ($var['SOLD'] == "") {
                $var['SOLD'] = 0;
            }
            if ($var['HOLD'] == "") {
                $var['HOLD'] = 0;
            }
            if ($var['FOLLOWUP'] == "") {
                $var['FOLLOWUP'] = 0;
            }
            if ($var['CANCELLED'] == "") {
                $var['CANCELLED'] = 0;
            }
            if ($var['PAYMENTISSUE'] == "") {
                $var['PAYMENTISSUE'] = 0;
            }

            if ($var['UNKNOWN'] == "") {
                $var['UNKNOWN'] = 0;
            }
            $result['rows'][] = array(
                // $var['name'],
                '<a target="_blank" href="#policies/reportsStatus=ANY&reportsStartDate=' . urlencode($reportsStartDate) . '&reportsEndDate=' . urlencode($reportsEndDate) . '&reportsCarrier=ANY&reportsCarrierPlan=ANY&reportsLeadSource=ANY&reportsFronter=ANY&reportsCloser=ANY&reportsState=ANY&reportsUserGroup=' . $var['userGroup'] . '">' . $var['name'] . '</a>',
                $var['TOTAL'],
                $var['SOLD'],
                $var['HOLD'],
                $var['FOLLOWUP'],
                $var['CANCELLED'],
                $var['PAYMENTISSUE'],
                $var['UNKNOWN'],
                "$" . number_format($var['premium'], 2, '.', ','),
            );
        }
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response['X-Powered-By'] = 'EBC';
        $response->status(200);
        // etc.
        $response->body(json_encode($result));
    } catch (Exception $e) {
        $result['rows'][] = array(
            "None",
            0,
            "$0.00",
            "$0.00",
        );
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response['X-Powered-By'] = 'EBC';
        $response->status(200);
        // etc.
        $response->body(json_encode($result));
    }
})->via('GET', 'POST');
$app->run();
