<?php

require '../app.php';
$app->config(array(
    'templates.path' => './',
));

$app->get('/export-clients', function () use ($app, $settings) {
    if (strtoupper($_SESSION['api']['user']['permissionLevel']) != "ADMINISTRATOR") {
        echo 'Permission define';
        return;
    }
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=clients.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    fputcsv($output, array('ID', 'Firstname', 'Lastname', 'Date of Birth', 'Phone', 'Email', 'Social Security Number', 'Street Address 1', 'Street Address 2', 'State', 'City', 'Zip Code', 'County'));


    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    $collectionQuery = array();

    $apiObj->mongoSetCollection("systemForm");
    $cursor2 = $apiObj->mongoFind(false);
    if ($cursor2->count() == 0) {
        $result['systemForm'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            $result['systemForm'][$doc2['name']] = $doc2;
        }
    }

    $apiObj->mongoSetCollection("person");
    $countLeadResouces = $apiObj->mongoCount($collectionQuery);
    // echo $countLeadResouces . '</br>';die(); 
    $take = 1000;
    $skip = intval($countLeadResouces / $take);
    if (is_float($countLeadResouces / $take)) {
        $skip = intval($skip) + 1;
    }
    if ($skip == 0)
        $result['person'][] = array();

    // echo $skip;
    // for ($i=0; $i < $skip; $i++) { 
    // for ($i=0; $i < 1; $i++) { 	
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    // $cursor2 = $apiObj->mongoFind2($collectionQuery, $i, $take);
    foreach (iterator_to_array($cursor2) as $doc2) {

        // x. Get email 
        $apiObj->mongoSetCollection("emails");
        $itemEmail = $apiObj->mongofindOne(array('_parentId' => $doc2['_id']));
        if (empty($itemEmail)) {
            
        } else {
            $doc2['email'] = $itemEmail['email'];
        }

        // x. Get phone 
        $apiObj->mongoSetCollection("phones");
        $itemPhone = $apiObj->mongofindOne(array('_parentId' => $doc2['_id']));
        if (empty($itemPhone)) {
            
        } else {
            $doc2['phoneNumber'] = $itemPhone['phoneNumber'];
        }

        // x. Get address 
        $apiObj->mongoSetCollection("addresses");
        $itemAddress = $apiObj->mongofindOne(array('_parentId' => $doc2['_id']));
        if (empty($itemAddress)) {
            
        } else {
            $doc2['street1'] = $itemAddress['street1'];
            $doc2['street2'] = $itemAddress['street2'];
            $doc2['city'] = $itemAddress['city'];
            $doc2['state'] = $itemAddress['state'];
            $doc2['zipCode'] = $itemAddress['zipCode'];
            $doc2['country'] = $itemAddress['country'];

            if (!empty($result['systemForm']['state']['options']) && !empty($doc2['state'])) {
                foreach ($result['systemForm']['state']['options'] as $sKey => $sVal) {
                    if ($sVal['value'] == strtoupper($doc2['state'])) {
                        $state = strtoupper($sVal['label']);
                        // $stateValue = $sVal['value'];
                        // var_dump($sVal);die();
                        $doc2['state2'] = $state;
                        break;
                    }
                }
            }
        }

        $doc2['socialSecurityNumber2'] = $apiObj->getDecrypt($doc2['socialSecurityNumber']);

        if (!empty($doc2['dateofBirth']))
            $doc2['dateOfBirth2'] = date("m/d/Y", strtotime($doc2['dateOfBirth']));
        // var_dump($doc2);
        fputcsv($output, array($doc2['_id'], $doc2['firstName'], $doc2['lastName'], $doc2['dateOfBirth2'], $doc2['phoneNumber'], $doc2['email'], $doc2['socialSecurityNumber2'], $doc2['street1'], $doc2['street2'], $doc2['state2'], $doc2['city'], $doc2['zipCode'], $doc2['country']));
    }
    // return;
    // }// End for
});

$app->get('/', function () use ($app, $settings) {
    $result['leads'] = array();
    $apiObj = new apiclass($settings);
    $docIds = array();
    $result['page_label'] = "Leads";

    if ($apiObj->userLoggedIn()) {
        
    } else {
        echo "User Not Logged In";
        exit();
    }
    $apiObj->mongoSetDB($settings['database']);
    $apiObj->mongoSetCollection("user");
    $result['users'] = $apiObj->mongoFind(array());
    $app->render('leadlist.php', array('result' => $result, "apiObj" => $apiObj, "settings" => $settings));
    peakmemory();
    // header("Content-Type: application/json");
    //echo json_encode($result);
});

$app->post('/data/', function () use ($app, $settings) {

    $result['leads'] = array();
    $apiObj = new apiclass($settings);
    $docIds = array();
    $params = $_REQUEST;
    if ($apiObj->userLoggedIn()) {
        $apiObj->mongoSetDB($settings['database']);
        $apiObj->mongoSetCollection("history");
        $apiObj->mongoSetCollection("leads");
        $collectionQuery = false;
        if (!empty($params["start_date"]) && !empty($params["end_date"])) {

            $result['StartDate'] = $apiObj->validateDate($params["start_date"], "m/d/Y", "Ymd000000");
            $result['EndDate'] = $apiObj->validateDate($params["end_date"], "m/d/Y", "Ymd235959");

            $collectionQuery = array(
                "_dateCreated" => array(
                    '$gte' => $result['StartDate'],
                    '$lte' => $result['EndDate']
                )
            );
        }

        if (!empty($params['client'])) {

            $collectionQuery['$and'][]['$or'] = array(
                array('electric_supply_product_status' => 'Sale'),
                array('gas_supply_product_status' => 'Sale'),
                array('internet_supply_product_status' => 'Sale')
            );
        }
        if ($_SESSION['api']['user']['permissionLevel'] != "ADMINISTRATOR" && $_SESSION['api']['user']['permissionLevel'] != "MANAGER") {

            $collectionQuery['$or'] = array(
                array('assignedTo' =>
                    array('$in' => array($_SESSION['api']['user']['_id']))),
                array('_userId' => $_SESSION['api']['user']['_id'])
            );
        } elseif (!empty($params["user_id"])) {

            $collectionQuery['_userId'] = $params["user_id"];
        }

        if (!empty(trim($params['search']['value']))) {
            $searchType = "NAME";
            $settings['leads']['search'] = trim($params['search']['value']);

            $nameparts = explode(" ", $settings['leads']['search']);

            //debug($collectionQuery);
            if ($searchType == "NAME") {
                if (count($nameparts) > 1) {
                    $collectionQuery['first_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                    $collectionQuery['last_name']['$regex'] = new MongoRegex("/" . $nameparts[1] . ".*/i");
                } else {
                    if (!empty($nameparts[0])) {
                        $collectionQuery['$or'][]['first_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                        $collectionQuery['$or'][]['last_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                    }
                }
            }
        }

        $cursor = $apiObj->mongoFind($collectionQuery)->limit($params['length']);

        if (!empty($cursor)) {
            $order = ($params['order'][0]['dir'] == 'asc') ? 1 : -1;
            if ($params['order'][0]['column'] == 1) {

                $cursor->sort(array('first_name' => $order));
            } elseif ($params['order'][0]['column'] == 4) {

                $cursor->sort(array('lead_source' => $order));
            } elseif ($params['order'][0]['column'] == 5) {

                $cursor->sort(array('service_city' => $order));
            } else {

                $cursor->sort(array('_dateCreated' => $order));
            }

            $x = 0;
            if (false) {
                $result['total'] = 0;
            } else {
                $result['total'] = $cursor->count();
                if ((!empty($params['start'])) && ($params['start'] > 0)) {
                    $cursor->skip($params['start']);
                }
//                echo $cursor->count();

                $apiObj->mongoSetCollection("user");
                $index = 0;
                foreach (iterator_to_array($cursor) as $doc) {
                    $docIds[] = $doc['_id'];
                    $lead = $doc;
                    $assignedTo = array();

                    if (!empty($doc['assignedTo'])) {

                        foreach ($doc['assignedTo'] as $agentId) {
                            $user = $apiObj->mongoFindOne(array('_id' => $agentId));
                            $assignedTo[] = $user['firstname'] . ' ' . $user['lastname'];
                        }
                    }
                    $productCount = 0;

                    if (!empty($doc['electric_supply_product']))
                        $productCount++;
                    if (!empty($doc['gas_supply_product']))
                        $productCount++;
                    if (!empty($doc['internet_supply_product']))
                        $productCount++;

                    $coulumns = 0;
                    if (empty($params['client'])) {

                        $data[$index][$coulumns++] = '<input type="checkbox" class="assignLead" data-leadid=' . $doc['_id'] . '>';
                    }

                    $data[$index][$coulumns++] = '<a href="#lead/edit/' . $doc['_id'] . '">' . $doc['first_name'] . ' ' . $doc['last_name'] . '</a>';
                    $data[$index][$coulumns++] = date("m/d/Y", strtotime($doc['_dateCreated']));
                    $data[$index][$coulumns++] = implode(', ', $assignedTo);
                    $data[$index][$coulumns++] = (!empty($doc['lead_source'])) ? $doc['lead_source'] : '';
                    $data[$index][$coulumns++] = $doc['service_city'] . ', ' . $doc['service_state'];
                    $data[$index][$coulumns++] = $productCount;
                    $action = '';
                    if ($_SESSION['api']['user']['permissionLevel'] == 'ADMINISTRATOR' || $_SESSION['api']['user']['permissionLevel'] == 'MANAGER')
                        $action .= '<a href="#lead/edit/' . $doc['_id'] . '"><i class="fa fa-pencil"></i></a> ';

                    if ($_SESSION['api']['user']['permissionLevel'] == 'ADMINISTRATOR')
                        $action .= '<a data-leadid="' . $doc['_id'] . '" href="#" class="delete-lead"><i class="fa fa-trash"></i></a>';

                    $data[$index][$coulumns++] = $action;
                    $index++;
                }
            }
        } else {
            $result['leads'] = array();
        }
    } else {
        echo "User Not Logged In";
        exit();
    }
    $data = (!empty($data)) ? $data : array();
    $json_data = array(
        "draw" => intval($params['draw']),
        "recordsTotal" => intval($result['total']),
        "recordsFiltered" => intval($result['total']),
        "data" => $data   // total data array
    );
    echo json_encode($json_data);
    // header("Content-Type: application/json");
    //echo json_encode($result);
});

$app->get('/clients', function () use ($app, $settings) {
    $result['leads'] = array();
    $apiObj = new apiclass($settings);
    $docIds = array();
    $result['page_label'] = "Customers";

    if ($apiObj->userLoggedIn()) {
        
    } else {
        echo "User Not Logged In";
        exit();
    }
    $app->render('clientlist.php', array('result' => $result, "apiObj" => $apiObj, "settings" => $settings));
    peakmemory();
    // header("Content-Type: application/json");
    //echo json_encode($result);
});

$app->get('/groups/test/', function() use ($app) {
    $test = $app->request()->get('fields');
    echo "This is a GET route with $test";
});

$app->get('/policies', function () use ($app, $settings) {
    $result['products'] = array();
    $apiObj = new apiclass($settings);
    $docIds = array();
    $result['page_label'] = "Products";

    if ($apiObj->userLoggedIn()) {
        $apiObj->mongoSetDB($settings['database']);
        $userIds = $apiObj->getUserIds();
        $apiObj->mongoSetCollection("products");
        $collectionQuery = false;
        if (!empty($_GET["start_date"]) && !empty($_GET["end_date"])) {

            $result['StartDate'] = $apiObj->validateDate($_GET["start_date"], "m/d/Y", "Ymd000000");
            $result['EndDate'] = $apiObj->validateDate($_GET["end_date"], "m/d/Y", "Ymd235959");

            $collectionQuery = array(
                "_dateCreated" => array(
                    '$gte' => $result['StartDate'],
                    '$lte' => $result['EndDate']
                )
            );
        }
        if (trim($settings['products']['search']) == "") {
            $collectionQuery['_userId']['$in'] = $userIds;
        }

        if (trim($settings['products']['search']) <> "") {
            $searchType = "NAME";
            $settings['products']['search'] = trim($settings['leads']['search']);

            $nameparts = explode(" ", $settings['products']['search']);

            //debug($collectionQuery);
            if ($searchType == "NAME") {
                if (count($nameparts) > 1) {
                    $collectionQuery['first_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                    $collectionQuery['last_name']['$regex'] = new MongoRegex("/" . $nameparts[1] . ".*/i");
                } else {
                    if (!empty($nameparts[0])) {
                        $collectionQuery['$or'][]['first_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                        $collectionQuery['$or'][]['last_name']['$regex'] = new MongoRegex("/" . $nameparts[0] . ".*/i");
                    }
                }
            }
        }

        $cursor = $apiObj->mongoFind($collectionQuery);
        if (!empty($cursor)) {
            $cursor->sort(array('_timestampCreated' => -1));
            $x = 0;
            if ($cursor->count() == 0) {
                $result['total'] = 0;
            } else {
                $result['total'] = $cursor->count();
                if ((!empty($settings['products']['page'])) && ($settings['products']['page'] > 1)) {
                    $cursor->skip($settings['products']['per_page'] * ($settings['products']['page'] - 1));
                }
                //echo $cursor->count();
                $cursor->limit($settings['products']['per_page']);
                foreach (iterator_to_array($cursor) as $doc) {
                    $docIds[] = $doc['_id'];
                    $result['products'][] = $apiObj->get_thing_display($doc);
                    //$result['leads'][] = $doc;
                    $x++;
                    if ($x == $settings['products']['per_page']) {
                        break;
                    }
                }
            }
        } else {
            $result['products'] = array();
        }
    } else {
        echo "User Not Logged In";
        exit();
    }


    $app->render('policylist.php', array('result' => $result, "apiObj" => $apiObj, "settings" => $settings));
    peakmemory();
});





$app->get('/edit/:leadId', function ($leadId) use ($app, $settings) {
    header('X-Frame-Options: SAMEORIGIN');
    $result['lead'] = array();
    $apiObj = new apiclass($settings);
    if ($apiObj->userLoggedIn()) {
        $apiObj->mongoSetDB($settings['database']);

        $apiObj->mongoSetCollection("leads");
        $collectionQuery = array('_id' => $leadId);
        $result['lead'] = $apiObj->mongoFindOne($collectionQuery);

        $apiObj->mongoSetCollection("notes");
        $collectionQuery = array('lead_id' => $leadId);
        $result['lead']['notes'] = iterator_to_array($apiObj->mongoFind($collectionQuery));
        if (!empty($result['lead']['notes'])) {

            $apiObj->mongoSetCollection("user");
            foreach ($result['lead']['notes'] as $index => $note) {

                $collectionQuery = array('_id' => $note['_userId']);

                $user = $apiObj->mongoFindOne($collectionQuery);

                $result['lead']['notes'][$index]['created_by'] = $user['firstname'] . ' ' . $user['lastname'];
            }
        }
        $result['users'] = array();
        $apiObj->mongoSetCollection("user");
        $collectionQuery = array();
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if (!empty($cursor2)) {
            if ($cursor2->count() == 0) {
                $result['users'][] = array();
            } else {
                foreach (iterator_to_array($cursor2) as $doc2) {
                    $result['users'][] = $apiObj->get_thing_display($doc2);
                }
            }
        }
    } else {
        echo "User Not Logged In";
        exit();
    }

    $apiObj->mongoSetCollection("statusList");
    $collectionQuery = array();
    $result['status_list'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("leadSources");
    $collectionQuery = array();
    $result['lead_sources'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('supplier_type' => 'electric');
    $result['electric_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'gas');
    $result['gas_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'internet');
    $result['internet_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));

    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('_id' => $result['lead']['electric_supplier']);
    $result['lead']['electric_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
    $collectionQuery = array('_id' => $result['lead']['gas_supplier']);
    $result['lead']['gas_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
    $collectionQuery = array('_id' => $result['lead']['internet_supplier']);
    $result['lead']['internet_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];

    $apiObj->mongoSetCollection("supplierProducts");
    $collectionQuery = array('_id' => $result['lead']['electric_supply_product']);
    $result['lead']['electric_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];
    $collectionQuery = array('_id' => $result['lead']['gas_supply_product']);
    $result['lead']['gas_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];
    $collectionQuery = array('_id' => $result['lead']['internet_supply_product']);
    $result['lead']['internet_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];


    if ($seller === false) {
        $userIds = $apiObj->getUserIds();
        if (in_array($result['leads'][0]['assignedTo'], $userIds)) {
            $podmanager = TRUE;
        }
    }
    $history = new stdClass();
    $history->lead_id = $leadId;
    $history->note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' Viewed this lead';
    $history->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

    $apiObj->mongoSetCollection('history');
    if (empty($_GET['popup']) || !empty($_GET['popup']) && $_GET['popup'] != 'closed') {

        $apiObj->saveHistory($history);
    }
    $result['history'] = $apiObj->mongofind(array('lead_id' => $leadId));
    $apiObj->mongoSetCollection("sms");
    $result['sms'] = $apiObj->mongofind(array('lead_id' => $leadId));
    if (
            ((!empty($result['leads'][0]['assignedTo'])) && ($result['leads'][0]['assignedTo'] == $_SESSION['api']['user']['_id'])) || ((!empty($_SESSION['api']['user']['permissionLevel'])) && ($_SESSION['api']['user']['permissionLevel'] == "ADMINISTRATOR")) || ((!empty($_SESSION['api']['user']['permissionLevel'])) && ($_SESSION['api']['user']['permissionLevel'] == "MANAGER")) || ((!empty($_SESSION['api']['user']['permissionLevel'])) && ($_SESSION['api']['user']['permissionLevel'] == "INSUREHC")) || ($seller === TRUE) || ($podmanager === TRUE) || (($result['leads'][0]['leadSource'] == "PRECISELEADS") && ($result['leads'][0]['assignedTo'] == "20151005154138-k7N1dHZi-4I7ZoB2J") )
    ) {

        $size_people = 1;
        $item_people = createItemPeople($apiObj->getValue($result['leads'][0], "dateOfBirth"), $apiObj->getValue($result['leads'][0], "smokerTabacco"), 'a');

        // debug($result['leads'][0]);
        // Spouses
        if (isset($result['leads'][0]['spouse']) && is_array($result['leads'][0]['spouse'])) {
            $size_people += count($result['leads'][0]['spouse']);
            foreach ($result['leads'][0]['spouse'] as $spouse) {
                $item_people .= ',' . createItemPeople($spouse['spouseDateOfBirth'], $spouse['spouseSmoker'], 'b');
            }
        }

        // Dependents
        if (isset($result['leads'][0]['dependents']) && is_array($result['leads'][0]['dependents'])) {
            $size_people += count($result['leads'][0]['dependents']);
            foreach ($result['leads'][0]['dependents'] as $spouse) {
                $item_people .= ',' . createItemPeople($spouse['dependentsDateOfBirth'], '', 'd');
            }
        }
        $zip_code = '';
        // debug($result);
        if (isset($result['addresses']) && is_array($result['addresses'])) {
            if (count($result['addresses']) > 0)
                $zip_code = $result['addresses'][0]['zipCode'];
        }

        $income = '';
        // debug($result['leads'][0]['taxes']);
        if (isset($result['leads'][0]['taxes']) && is_array($result['leads'][0]['taxes'])) {
            if (count($result['leads'][0]['taxes']) > 0)
                $income = $result['leads'][0]['taxes'][0]['estimatedYearlyIncome'];
        }

        $iframe_url = "https://www.healthsherpa.com/find-plans/plans?zip_code=$zip_code&people=[$item_people]
&income=$income&size=$size&cs=premium&year=2017&page=1&_agent_id=lisa-jackson-lerW0g";
        // echo $iframe_url;
        $app->render('leadform.php', array('iframe_url' => $iframe_url, 'result' => $result, 'settings' => $settings, "apiObj" => $apiObj, 'personId' => $personId));
    } else {
        //	$app->render('leadform.php', array('result' => $result, 'settings'=>$settings, "apiObj"=>$apiObj, 'personId'=>$personId));
        $app->render('leadview.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj, 'personId' => $personId));
    }
    peakmemory();
});

$app->post('/updateLead', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!empty($_SESSION['api']['user']['_id'])) {
        if (!empty($_POST['person_0_id'])) {
            $post['person_0_createThing'] = "Y";
            $post['person_0_id'] = $_POST['person_0_id'];
            $post['person_0_history_0_createThing'] = "Y";
            $post['person_0_history_0_note'] = "User Saved/Edited this lead";
            $post['person_0_history_0_userId'] = $_SESSION['api']['user']['_id'];
            $post['person_0_history_0_userName'] = $_SESSION['api']['user']['firstname'] . " " . $_SESSION['api']['user']['lastname'];
            //$apiObj->save_things($post);
        }
    }
    if (!empty($_POST)) {
        $apiObj->saveAll($_POST, "lead");
        if ($apiObj->save_things($_POST)) {
            $result['message'] = "Things Saved";
        } else {
            $result['message'] = "There was an error saving your Things.";
        }
    }
});
$app->post('/assign', function () use ($app, $settings) {

    $apiObj = new apiclass($settings);
    if (!$apiObj->userLoggedIn()) {

        $message = array();
        $message['errors']['type'] = 'session_expired';
        $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    $apiObj->mongoSetDB($settings['database']);
    if (!empty($_POST)) {

        $data = $app->core->request->getJSONObject();

        foreach ($data->leadIds as $value) {
            $lead = new stdClass();
            $lead->_id = $value;
            $lead->assignedTo = is_array($data->agents) ? $data->agents : array($data->agents);

            $leads[] = $apiObj->saveLead($lead);
        }

        if ($leads) {
            echo $app->core->response->json($leads, FALSE);
        } else {
            $result['message'] = "There was an error saving your Things.";
        }
    }
});
$app->group('/products/', function () use ($app, $settings) {

    $app->get('create', function () use ($app, $settings) {

        header('X-Frame-Options: SAMEORIGIN');

        $apiObj = new apiclass($settings);
        if ($apiObj->userLoggedIn()) {


            $app->render('productform.php', array());
        } else {
            echo "User Not Logged In";
            exit();
        }
        peakmemory();
    });

    $app->get('edit/:productId', function ($productId) use ($app, $settings) {

        header('X-Frame-Options: SAMEORIGIN');

        $apiObj = new apiclass($settings);
        if ($apiObj->userLoggedIn()) {
            $apiObj->mongoSetCollection("products");
            $collectionQuery = array('_id' => $productId);
            $result['product'] = $apiObj->mongoFindOne($collectionQuery);

            $app->render('productform.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
        } else {
            echo "User Not Logged In";
            exit();
        }
        peakmemory();
    });

    $app->post('', function () use ($app, $settings) {
        $apiObj = new apiclass($settings);
        if (!$apiObj->userLoggedIn()) {

            $message = array();
            $message['errors']['type'] = 'session_expired';
            $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
            echo $app->core->response->json($message, FALSE, array('success' => false));
            exit();
        }
        $apiObj->mongoSetDB($settings['database']);
        if (!empty($_POST)) {
            $product = $apiObj->saveProduct($app->core->request->getJSONObject());
            if ($product) {
                echo $app->core->response->json($product, FALSE);
            } else {
                $result['message'] = "There was an error saving your Things.";
            }
        }
    });
});
$app->post('/saveLead', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    if (!$apiObj->userLoggedIn()) {

        $message = array();
        $message['errors']['type'] = 'session_expired';
        $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    $apiObj->mongoSetDB($settings['database']);
    if (!empty($_POST)) {

        $input = $app->core->request->getJSONObject();
        if (strlen($input->first_name) > 50) {
            $message = array();
            $message['errors']['type'] = 'validation';
            $message['errors']['array']['first_name'][] = 'First name can not be greater than 50 characters long';
            echo $app->core->response->json($message, FALSE, array('success' => false));
            exit();
        } elseif (strlen($input->last_name) > 50) {
            $message = array();
            $message['errors']['type'] = 'validation';
            $message['errors']['array']['last_name'][] = 'Last name can not be greater than 50 characters long';
            echo $app->core->response->json($message, FALSE, array('success' => false));
            exit();
        } elseif (strlen($input->phone_number) > 14) {
            $message = array();
            $message['errors']['type'] = 'validation';
            $message['errors']['array']['phone_number'][] = 'Phone number can not be greater than 10 characters long';
            echo $app->core->response->json($message, FALSE, array('success' => false));
            exit();
        } elseif (strlen($input->email_address) > 100) {
            $message = array();
            $message['errors']['type'] = 'validation';
            $message['errors']['array']['email_address'][] = 'Email can not be greater than 100 characters long';
            echo $app->core->response->json($message, FALSE, array('success' => false));
            exit();
        }
        if (!empty($input->_id)) {
            $note = array();
            $apiObj->mongoSetCollection('leads');
            $oldData = $apiObj->mongoFindOne(array('_id' => $input->_id));

            foreach ($input as $key => $value) {

                if (($input->billing_info_different == 0 && strpos($key, 'billing') !== false) || $key == 'billing_info_different') {

                    continue;
                }

                if ($oldData[$key] != $value) {

                    if ($key == 'electric_supplier' || $key == 'gas_supplier' || $key == 'internet_supplier') {

                        $apiObj->mongoSetCollection('suppliers');
                        $value = $apiObj->mongoFindOne(array('_id' => $value))['supplier_name'];
                        $oldData[$key] = $apiObj->mongoFindOne(array('_id' => $oldData[$key]))['supplier_name'];
                    }

                    if ($key == 'electric_supply_product' || $key == 'gas_supply_product' || $key == 'internet_supply_product') {

                        $apiObj->mongoSetCollection('supplierProducts');
                        $value = $apiObj->mongoFindOne(array('_id' => $value))['name'];
                        $oldData[$key] = $apiObj->mongoFindOne(array('_id' => $oldData[$key]))['name'];
                    }

                    $note[] = ucfirst(str_replace('_', ' ', $key)) . ' ' . $oldData[$key] . ' to ' . $value;
                }
            }

            if (!empty($note)) {

                $note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' changed ' . implode(', ', $note) . ' on ' . date('m/d/Y H:i:s');
            } else {

                $note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' updated this lead on ' . date('m/d/Y H:i:s');
            }
        } else {

            $note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' created this lead on ' . date('m/d/Y H:i:s');
        }
//        $apiUrl = $settings['calibrus_api_endpoint'] . '?wsdl';
//        $client = new \SoapClient($apiUrl);
//
//        $xmlr = new SimpleXMLElement("<SubmitRecord></SubmitRecord>");
//        $xmlr->addChild('AuthorizationFirstName', $input->first_name);
//        $xmlr->addChild('AuthorizationLastName', $input->last_name);
//        $xmlr->addChild('Btn', $input->phone_number);
//        $xmlr->addChild('Email', $input->email_address);
//
//        $params = new stdClass();
//        $params->xml = $xmlr->asXML();
//
//        $result = $client->SubmitRecord($params);
        $lead = $apiObj->saveLead($input);
        $history = new stdClass();
        $history->lead_id = $lead->_id;
        $history->note = $note;
        $history->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

        $apiObj->saveHistory($history);

        if ($lead) {
            echo $app->core->response->json($lead, FALSE);
        } else {
            $result['message'] = "There was an error saving your Things.";
        }
    }
});
$app->post('/saveNote', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    if (!$apiObj->userLoggedIn()) {

        $message = array();
        $message['errors']['type'] = 'session_expired';
        $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    $apiObj->mongoSetDB($settings['database']);
    if (!empty($_POST)) {

        $input = $app->core->request->getJSONObject();

        if (!empty($input->_id)) {

            $text = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' updated a note with ID ' . $input->_id . ' on ' . date('m/d/Y H:i:s');
        } else {

            $text = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' created a note on ' . date('m/d/Y H:i:s');
        }

        $note = $apiObj->saveNote($input);
        $history = new stdClass();
        $history->lead_id = $note->lead_id;
        $history->note = $text;
        $history->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

        $apiObj->saveHistory($history);

        if ($note) {
            echo $app->core->response->json($note, FALSE);
        } else {
            $result['message'] = "There was an error saving your Things.";
        }
    }
});
$app->get('/template/:type/:index/:crtThng', function ($type, $index, $crtThng) use ($app, $settings) {
    $apiObj = new apiclass($settings);
    $app->render('form_partials.php', array('index' => $index, 'type' => $type, 'crtThng' => $crtThng, 'settings' => $settings, "apiObj" => $apiObj));
});
$app->get('/create', function () use ($app, $settings) {
    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);

    $apiObj->mongoSetCollection("statusList");
    $collectionQuery = array();
    $result['status_list'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("leadSources");
    $collectionQuery = array();
    $result['lead_sources'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('supplier_type' => 'electric');
    $result['electric_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'gas');
    $result['gas_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'internet');
    $result['internet_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $apiObj->mongoSetCollection("scripts");
    $collectionQuery = array('status' => 'active');
    $result['active_script'] = $apiObj->mongoFindOne($collectionQuery);
    $app->render('leadcreateform.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
});
$app->get('/importLeads', function () use ($app, $settings) {

    $app->render('importlead.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
});
$app->post('/uploadLeadFile', function () use ($app, $settings) {
    if (!$apiObj->userLoggedIn()) {

        $message = array();
        $message['errors']['type'] = 'session_expired';
        $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    move_uploaded_file($_FILES['file']['tmp_name'], '../../files/' . $_FILES['file']['name']);
    $file = fopen('../../files/' . $_FILES['file']['name'], 'r');
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0);
    $flag = true;
    $apiObj->mongoSetCollection("imports");
    $collectionQuery = array('file_name' => $_FILES['file']['name']);
    $imported = $apiObj->mongoFindOne($collectionQuery);
    if ($imported) {
        $message = array();
        $message['errors']['type'] = 'validation';
        $message['errors']['array']['file'][] = 'File already Imported.';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

        if ($flag) {
            $flag = false;
            continue;
        }
        $input = new stdClass();
        $input->first_name = $data[0];
        $input->middle_name = $data[1];
        $input->last_name = $data[2];
        $input->name_prefix = $data[3];
        $input->service_address = $data[4];
        $input->service_apt = $data[5];
        $input->service_city = $data[6];
        $input->service_state = $data[7];
        $input->service_zip = $data[8];
        $input->service_z4 = $data[9];
        $input->service_county = $data[10];
        $input->billing_address = $data[4];
        $input->billing_apt = $data[5];
        $input->billing_city = $data[6];
        $input->billing_state = $data[7];
        $input->billing_zip_code = $data[8];
        $input->billing_z4 = $data[9];
        $input->billing_county = $data[10];
        $input->phone_number = $data[11];
        $input->type = 'lead';
        $lead = $apiObj->saveLead($input);
        $history = new stdClass();
        $history->lead_id = $lead->_id;
        $history->note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' created this lead on ' . date('m/d/Y H:i:s') . ' via import tool.';
        $history->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

        $apiObj->saveHistory($history);
    }
    fclose($file);

    if (true) {
        $import = new stdClass();
        $import->file_name = $_FILES['file']['name'];
        $import->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

        $apiObj->saveImport($import);
        $data = array('message' => 'Upload successful');
        echo $app->core->response->json($data, FALSE);
    } else {

        $result['message'] = "There was an error saving your Things.";
    }
});
$app->get('/clients/create', function () use ($app, $settings) {
    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);

    $apiObj->mongoSetCollection("scripts");
    $collectionQuery = array('status' => 'active');
    $result['active_script'] = $apiObj->mongoFindOne($collectionQuery);

    $apiObj->mongoSetCollection("statusList");
    $collectionQuery = array();
    $result['status_list'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("leadSources");
    $collectionQuery = array();
    $result['lead_sources'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));

    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('supplier_type' => 'electric');
    $result['electric_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'gas');
    $result['gas_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'internet');
    $result['internet_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $app->render('clientform.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
});
$app->get('/clients/edit/:leadId', function ($leadId) use ($app, $settings) {
    $result = array();
    $apiObj = new apiclass($settings);
    if ($apiObj->userLoggedIn()) {
        $apiObj->mongoSetDB($settings['database']);
        $apiObj->mongoSetCollection("scripts");
        $collectionQuery = array('status' => 'active');
        $result['active_script'] = $apiObj->mongoFindOne($collectionQuery);
        $apiObj->mongoSetCollection("leads");
        $collectionQuery = array('_id' => $leadId);
        $result['lead'] = $apiObj->mongoFindOne($collectionQuery);
    } else {
        echo "User Not Logged In";
        exit();
    }

    $apiObj->mongoSetCollection("statusList");
    $collectionQuery = array();
    $result['status_list'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("leadSources");
    $collectionQuery = array();
    $result['lead_sources'] = $apiObj->mongoFind($collectionQuery)->sort(array('sort' => 1));
    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('supplier_type' => 'electric');
    $result['electric_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'gas');
    $result['gas_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));
    $collectionQuery = array('supplier_type' => 'internet');
    $result['internet_suppliers'] = $apiObj->mongoFind($collectionQuery)->sort(array('supplier_sort' => 1));

    $apiObj->mongoSetCollection("suppliers");
    $collectionQuery = array('_id' => $result['lead']['electric_supplier']);
    $result['lead']['electric_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
    $collectionQuery = array('_id' => $result['lead']['gas_supplier']);
    $result['lead']['gas_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];
    $collectionQuery = array('_id' => $result['lead']['internet_supplier']);
    $result['lead']['internet_supplier_text'] = $apiObj->mongoFindOne($collectionQuery)['supplier_name'];

    $apiObj->mongoSetCollection("supplierProducts");
    $collectionQuery = array('_id' => $result['lead']['electric_supply_product']);
    $result['lead']['electric_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];
    $collectionQuery = array('_id' => $result['lead']['gas_supply_product']);
    $result['lead']['gas_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];
    $collectionQuery = array('_id' => $result['lead']['internet_supply_product']);
    $result['lead']['internet_supply_product_text'] = $apiObj->mongoFindOne($collectionQuery)['name'];

    $app->render('clientform.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
});
$app->get('/delete/:leadId', function ($leadId) use ($app, $settings) {
    $result = array();
    $apiObj = new apiclass($settings);
    if (!$apiObj->userLoggedIn()) {

        $message = array();
        $message['errors']['type'] = 'session_expired';
        $message['errors']['redirect_url'] = $settings['base_url'] . 'api/auth/login';
        echo $app->core->response->json($message, FALSE, array('success' => false));
        exit();
    }
    $apiObj->mongoSetDB($settings['database']);

    $apiObj->mongoSetCollection("leads");
    $collectionQuery = array('_id' => $leadId);
    $apiObj->mongoRemove($collectionQuery);
    echo $app->core->response->json(array('message' => 'success!'), FALSE);
});
$app->get('/addrecording', function () use ($app, $settings) {
    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB("trentTest");
    $post["recordings_0_createThing"] = "Y";
    $post["recordings_0_temp"] = "Y";
    $allGetVars = $app->request->get();
    $allPostVars = $app->request->post();
    $allPutVars = $app->request->put();
    if (!empty($allPostVars)) {
        foreach ($allPostVars as $key => $var) {
            $post["recordings_0_post" . preg_replace('/[^a-zA-Z0-9]/', '', $key)] = $var;
        }
    }
    if (!empty($allGetVars)) {
        foreach ($allGetVars as $key => $var) {
            $post["recordings_0_get" . preg_replace('/[^a-zA-Z0-9]/', '', $key)] = $var;
        }
    }
    $apiObj->save_things($post);
    echo "Thank You";
    exit();
});

$app->map('/recordingsview/:personId', function ($personId) use ($app, $settings) {
    echo 'sdfsdf';
    $result = array();
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    $apiObj->mongoSetCollection("phones");
    $phones = $apiObj->mongoFind(array('_parentId' => $personId));

    foreach ($phones as $phone) {
        array_push($result, $phone);
    }
    $app->render('recordings.php', array('result' => $result, 'settings' => $settings));
})->via('GET', 'POST');
$app->map('/recordingsnumber/:number', function ($number) use ($app, $settings) {
    $result = array();
    $a['phoneNumber'] = $number;
    array_push($result, $a);
    $app->render('recordings.php', array('result' => $result, 'settings' => $settings));
})->via('GET', 'POST');

$app->get('/export', function () use ($app, $settings) {
    //exit();
    //ini_set('max_execution_time', 300);
    //$settings['database'] = "ehealthbrokers";
    $result['policies'] = array();
    $apiObj = new apiclass($settings);
    $docIds = array();
    if ($apiObj->userLoggedIn()) {
        $userIds = $apiObj->getUserIds();
        $apiObj->mongoSetDB($settings['database']);
        $collectionQuery = false;
        $collectionQuery['_timestampCreated']['$gte'] = "20160830144430";
        $collectionQuery['_timestampCreated']['$lt'] = "20160906125803";
        $apiObj->mongoSetCollection("policy");
        $cursor = $apiObj->mongoFind($collectionQuery);
        $cursor->sort(array('_timestampCreated' => 1));
        $x = 0;
        if ($cursor->count() == 0) {
            $result['total'] = 0;
        } else {
            $result['total'] = $cursor->count();
            $cursor->limit(10000);
            foreach (iterator_to_array($cursor) as $doc) {
                $docIds[] = $doc['_parentId'];
                //$result['policies'][] = $apiObj->get_thing_display($doc);
                $result['policies'][] = $doc;
                //$result['leads'][] = $doc;
            }
        }
    } else {
        exit();
    }


    // Get Person
    $result['persons'] = array();
    $apiObj->mongoSetCollection("person");
    $collectionQuery = array('_id' => array('$in' => $docIds));
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if (!empty($cursor2)) {
        if ($cursor2->count() == 0) {
            $result['persons'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                //$result['persons'][] = $apiObj->get_thing_display($doc2);
                $result['persons'][] = $doc2;
            }
        }
    }
    //  debug($result);
    //exit();
    // Get Carriers
    $result['carriers'] = array();
    $apiObj->mongoSetCollection("carrier");
    $collectionQuery = array();
    $collectionQuery['status']['$eq'] = "ACTIVE";
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if (!empty($cursor2)) {
        if ($cursor2->count() == 0) {
            $result['carriers'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                //$result['carriers'][] = $apiObj->get_thing_display($doc2);
                $result['carriers'][] = $doc2;
            }
        }
    }
    // Get Carrier Plans
    $result['carrierPlans'] = array();
    $apiObj->mongoSetCollection("carrierPlan");
    $collectionQuery = array();
    $collectionQuery['status']['$eq'] = "ACTIVE";
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if (!empty($cursor2)) {
        if ($cursor2->count() == 0) {
            $result['carrierPlans'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                //$result['carrierPlans'][] = $apiObj->get_thing_display($doc2);
                $result['carrierPlans'][] = $doc2;
            }
        }
    }
    // Get Users
    $result['users'] = array();
    $apiObj->mongoSetCollection("user");
    $collectionQuery = array();
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if (!empty($cursor2)) {
        if ($cursor2->count() == 0) {
            $result['users'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                //$result['users'][] = $apiObj->get_thing_display($doc2);
                $result['users'][] = $doc2;
            }
        }
    }




    // Get Addresses
    $apiObj->mongoSetCollection("addresses");
    $collectionQuery = array('_parentId' => array('$in' => $docIds));
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['addresses'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['addresses'][] = $apiObj->get_thing_display($doc2);
            $result['addresses'][] = $doc2;
        }
    }
    // Get Phones
    $apiObj->mongoSetCollection("phones");
    $collectionQuery = array('_parentId' => array('$in' => $docIds));
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['phones'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['phones'][] = $apiObj->get_thing_display($doc2);
            $result['phones'][] = $doc2;
        }
    }
    // Get Emails
    $apiObj->mongoSetCollection("emails");
    $collectionQuery = array('_parentId' => array('$in' => $docIds));
    $cursor2 = $apiObj->mongoFind($collectionQuery);
    if ($cursor2->count() == 0) {
        $result['emails'][] = array();
    } else {
        foreach (iterator_to_array($cursor2) as $doc2) {
            //$result['emails'][] = $apiObj->get_thing_display($doc2);
            $result['emails'][] = $doc2;
        }
    }


    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $settings['database'] . '_export_' . date("YmdHis") . '.csv');
    $out = fopen('php://output', 'w');
    // output the column headings
    fputcsv($out, array('ID', 'First Name', 'Middle Name', 'Last Name', 'Gender', 'SSN', 'Date Created', 'Lead Status', 'Email', 'Phone 1', 'Phone 2', 'Address', 'AptNo', 'City', 'State', ' Zip', 'DOB', 'Policy Entered Date', 'Policy Number', 'Carrier', 'Coverage Type', 'Status', 'Premium', 'Setup Fee', 'Subsidy', 'Pay Schedule', 'Effecitve Date', 'Submission Date', 'Policy Submitted', 'Renewal Date', 'Term Date', 'Banking Info', 'Credit Card Info', 'Fronter', 'Closer'));



    if (!empty($result['policies'])) {
        foreach ($result['policies'] as $key => $var) {
            $person = "";
            $personId = "";
            if (!empty($result['persons'])) {
                foreach ($result['persons'] as $key2 => $var2) {

                    if ($var['_parentId'] == $var2['_id']) {
                        $personId = $var2['_id'];
                        $person['firstname'] = $apiObj->getValues($var2, "firstName");
                        $person['middlename'] = $apiObj->getValues($var2, "middleName");
                        $person['lastname'] = $apiObj->getValues($var2, "lastName");
                        $person['lastname'] = $apiObj->getValues($var2, "lastName");
                        $person['gender'] = $apiObj->getValues($var2, "gender");
                        $person['ssn'] = $apiObj->getDecrypt($apiObj->getValues($var2, "socialSecurityNumber"));
                        $person['dateOfBirth'] = date("m/d/Y", strtotime($apiObj->getValues($var2, "dateOfBirth")));
                        $person['smokerTabacco'] = $apiObj->getValues($var2, "smokerTabacco");
                        $person['disposition'] = $apiObj->getValues($var2, "disposition");
                        $person['hasBankInfo'] = "N";
                        if ((!empty($var2['banking'][0]['paymentBankRoutingNumber']) ) && (!empty($var2['banking'][0]['paymentBankAccountNumber']) )) {
                            $person['hasBankInfo'] = "Y";
                        }
                        $person['hasCreditCard'] = "N";
                        if ((!empty($var2['creditcard'][0]['paymentCardNumber']) ) && (!empty($var2['creditcard'][0]['paymentCreditCardMonth']) ) && (!empty($var2['creditcard'][0]['paymentCreditCardYear']) )) {
                            $person['hasCreditCard'] = "Y";
                        }
                        break;
                    }
                }
            }

            $phones = array();
            if (!empty($result['phones'])) {
                foreach ($result['phones'] as $key2 => $var2) {
                    if ($var['_parentId'] == $var2['_parentId']) {
                        $phones[] = $apiObj->getValues($var2, "phoneNumber");
                        break;
                    }
                }
            }

            $address = array();
            if (!empty($result['addresses'])) {
                foreach ($result['addresses'] as $key2 => $var2) {
                    if ($var['_parentId'] == $var2['_parentId']) {


                        $address[] = array(
                            "street1" => $var2['street1'],
                            "street2" => $var2['street2'],
                            "city" => $var2['[city'],
                            "state" => $var2['state'],
                            "zipCode" => $var2['zipCode'],
                            "county" => $var2['county']
                        );
                    }
                }
            }
            $carrier = "";
            if (!empty($result['carriers'])) {
                foreach ($result['carriers'] as $key2 => $var2) {
                    if ($var['carrier'] == $var2['_id']) {
                        $carrier = $apiObj->getValues($var2, "name");
                        break;
                    }
                }
            }
            $carrierPlan = "";
            if (!empty($result['carrierPlans'])) {
                foreach ($result['carrierPlans'] as $key2 => $var2) {
                    if ($var['coverageType'] == $var2['_id']) {
                        $carrierPlan = $apiObj->getValues($var2, "name");
                        break;
                    }
                }
            }
            $fronter = "";
            if (!empty($result['users'])) {
                foreach ($result['users'] as $key2 => $var2) {
                    if ($var['soldBy'] == $var2['_id']) {
                        $fronter = $apiObj->getValues($var2, "firstname") . " " . $apiObj->getValues($var2, "lastname");
                        break;
                    }
                }
            }
            $closer = "";
            if (!empty($result['users'])) {
                foreach ($result['users'] as $key2 => $var2) {
                    if ($var['closedBy'] == $var2['_id']) {
                        $closer = $apiObj->getValues($var2, "firstname") . " " . $apiObj->getValues($var2, "lastname");
                        break;
                    }
                }
            }
            if (empty($var['policySubmitted'])) {
                $var['policySubmitted'] = "";
            }
            $row = array();
            $row['id'] = $var['_id'];
            $row['firstname'] = $person['firstname'];
            $row['middlename'] = $person['middlename'];
            $row['lastname'] = $person['lastname'];
            $row['gender'] = $person['gender'];
            $row['ssn'] = $person['ssn'];
            $row['datecreated'] = date("m/d/Y", strtotime($var['_timestampCreated']));
            $row['leadstatus'] = $person['disposition'];
            $row['Email'] = $carrier;
            $row['phone1'] = $phones[0];
            if (empty($phones[1])) {
                $phones[1] = "";
            }
            $row['phone2'] = $phones[1];
            if (empty($address[0])) {
                $address[0]['street1'] = "";
                $address[0]['street2'] = "";
                $address[0]['city'] = "";
                $address[0]['state'] = "";
                $address[0]['zipCode'] = "";
                $person['dateOfBirth'] = "";
            }
            $row['address'] = $address[0]['street1'];
            $row['aptno'] = $address[0]['street2'];
            $row['city'] = $address[0]['city'];
            $row['state'] = $address[0]['state'];
            $row['zip'] = $address[0]['zipCode'];
            $row['dob'] = date("m/d/Y", strtotime($person['dateOfBirth']));
            $row['policyentereddate'] = date("m/d/Y", strtotime($var['_timestampCreated']));
            $row['policynumber'] = $var['policyNumber'];
            $row['Carrier'] = $carrier;
            $row['Coverage Type'] = $carrierPlan;
            $row['Status'] = ucwords(strtolower($var['status']));
            $row['Premium'] = $var['premiumMoney'];
            $row['SetupFee'] = $var['SetupFee'];
            $row['Subsidy'] = $var['subsidyMoney'];
            $row['Pay Schedule'] = $carrier;
            $row['Effective Date'] = date("m/d/Y", strtotime($var['effectiveDate']));
            $row['Submission Date'] = date("m/d/Y", strtotime($var['effectiveDate']));
            $row['Policy Submitted'] = $var['policySubmitted'];
            $row['Renewal Date'] = date("m/d/Y", strtotime($var['renewalDate']));
            $row['Term Date'] = date("m/d/Y", strtotime($var['termDate']));
            $row['Has Bank Info'] = $person['hasBankInfo'];
            $row['Has Credit Card'] = $person['hasCreditCard'];
            $row['Fronter'] = $fronter;
            $row['Closer'] = $closer;

            fputcsv($out, $row);
        }
    }


    fclose($out);
    exit();
});




/*
  $apiObj->mongoSetDB($settings['database']);
  $post['userGroups_0_createThing'] = "Y";
  $post['userGroups_0_id'] = "SF6sRxUq-USlDmYfU-MrXSBWgx";
  $post['userGroups_0_label'] = "Sales";
  $post['userGroups_0_users_0_userId'] = "20151005143440-ZpL1bu2Q-0rKCOjTg";
  $post['userGroups_0_users_0_level'] = "manager";
  $apiObj->mongoSetDB($settings['database']);
  $post['userGroups_0_createThing'] = "Y";
  $post['userGroups_0_id'] = "SF6sRxUq-USlDmYfU-MrXSBWgx";
  $post['userGroups_0_label'] = "Sales";
  //  $post['userGroups_0_users_0_id'] =  'sj2R9KF4-Esn18eXl-PCrdFghV';
  $post['userGroups_0_users_0_userId'] = "20151005094323-eNsOqMnP-cfqe1KQL";
  $post['userGroups_0_users_0_level'] = "admin";
  //  $post['userGroups_0_users_1_id'] =  'F9dHAL54-RsAsQj3m-9U1kKG8U';
  $post['userGroups_0_users_1_userId'] = "20151005133707-sqSkuwWt-q2tLHqXU";
  $post['userGroups_0_users_1_level'] = "user";
  $post['userGroups_0_users_2_userId'] = "20151005133721-yxysRHVa-dRHl82gP";
  $post['userGroups_0_users_2_level'] = "user";
  $post['userGroups_0_users_3_userId'] = "20151005133852-nkhEQwXS-dt8BHSd5";
  $post['userGroups_0_users_3_level'] = "user";
  $post['userGroups_0_users_4_userId'] = "20151005134133-XnakJJkb-G9KC7MU8";
  $post['userGroups_0_users_4_level'] = "user";
  $post['userGroups_0_users_5_userId'] = "20151005134247-QtJ59VVa-8YmNLKzT";
  $post['userGroups_0_users_5_level'] = "user";
  //  $post['userGroups_0_users_2_userId'] = "2d20b1dc-9cf6-2f66-981e-54b5ad871df4";
  //  $post['userGroups_0_users_2_level'] = "user";
  //    $post['userGroups_0_users_3_userId'] = "dwFfagta-xmeUr4K4-S7coafmJ";
  //    $post['userGroups_0_users_3_level'] = "manager";
  //  $post['userGroups_0_users_4_userId'] = "906cd740-04d7-1986-431c-550c41acd635";
  // $post['userGroups_0_users_4_level'] = "user";
  //$post['userGroups_0_permission_0_admin'] = "viewLevel,viewBelow,groupReports,individualReports,assignUers,export";
  //$post['userGroups_0_permission_1_manager'] = "viewLevel,viewBelow,groupReports,individualReports,assignUsers";
  //$post['userGroups_0_permission_2_user'] = "viewLevel,viewBelow,individualReports";
  $apiObj->save_things($post);
 */
/*
  $app->get('/phoneremove/:phone_id', function ($phone_id) use ($app,$settings) {
  if((!empty($phone_id))){
  $apiObj = new apiclass($settings);
  if($apiObj->userLoggedIn()){
  $apiObj->mongoSetDB($settings['database']);
  $apiObj->mongoSetCollection("phones");
  $collectionQuery = array('_id' => $phone_id);
  $apiObj->mongoRemove($collectionQuery);
  } else {
  echo "User Not Logged In";
  exit();
  }
  }
  });
 */


$app->map('/admininfo/:policyid', function ($policyid) use ($app, $settings) {
    $result = array();
    // etc.

    $apiObj = new apiclass($settings);
    if ($apiObj->userLoggedIn()) {
        $apiObj->mongoSetDB($settings['database']);

        $apiObj->mongoSetCollection("policy");
        $collectionQuery = array('_id' => $policyid);
        $cursor = $apiObj->mongoFind($collectionQuery);
        $x = 0;
        if ($cursor->count() == 0) {
            
        } else {
            foreach (iterator_to_array($cursor) as $doc) {
                if (!empty($doc['_timestampCreated'])) {
                    $doc['date_created'] = date("m/d/Y", $doc['_timestampCreated']);
                } else {
                    $doc['date_created'] = "New";
                }
                $result['policy'][] = $apiObj->get_thing_display($doc);
                //$result['leads'][] = $doc;

                $parent_id = $doc['_parentId'];
            }
        }
        // Get Addresses
        $apiObj->mongoSetCollection("addresses");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['addresses'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['addresses'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get Phones
        $apiObj->mongoSetCollection("phones");
        $collectionQuery = array('_parentId' => $doc['_id']);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['phones'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['phones'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get Emails
        $apiObj->mongoSetCollection("emails");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['emails'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['emails'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get Notes
        $apiObj->mongoSetCollection("notes");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['notes'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['notes'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get Policies
        $apiObj->mongoSetCollection("person");
        $collectionQuery = array('_id' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['person'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['person'][] = $apiObj->get_thing_display($doc2);
            }
        }


        if (!empty($_SESSION['api']['user']['_id'])) {
            $post['person_0_createThing'] = "Y";
            $post['person_0_id'] = $parent_id;
            $post['person_0_history_0_createThing'] = "Y";
            $post['person_0_history_0_note'] = "Admin Viewed this lead";
            $post['person_0_history_0_userId'] = $_SESSION['api']['user']['_id'];
            $post['person_0_history_0_userName'] = $_SESSION['api']['user']['firstname'] . " " . $_SESSION['api']['user']['lastname'];
            $apiObj->save_things($post);
        }

        // Get Appointments
        $apiObj->mongoSetCollection("appointment");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['appointment'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['appointment'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get Employer
        $apiObj->mongoSetCollection("employer");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['employer'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['employer'][] = $apiObj->get_thing_display($doc2);
            }
        }
        // Get History
        $apiObj->mongoSetCollection("history");
        $collectionQuery = array('_parentId' => $parent_id);
        $cursor2 = $apiObj->mongoFind($collectionQuery);
        if ($cursor2->count() == 0) {
            $result['history'][] = array();
        } else {
            foreach (iterator_to_array($cursor2) as $doc2) {
                $result['history'][] = $apiObj->get_thing_display($doc2);
            }
        }
    } else {
        echo "User Not Logged In";
        exit();
    }

    $app->render('admintab.php', array('result' => $result, 'settings' => $settings, "apiObj" => $apiObj));
})->via('GET', 'POST');
$app->map('/attSend', function () use ($app, $settings) {
    $apiObj = new apiclass($settings);
    $apiObj->mongoSetDB($settings['database']);
    if (!empty($_FILES)) {
        if (!empty($_POST['attachmentCount'])) {
            $i = $_POST['attachmentCount'];
        } else {
            $i = 0;
        }

        foreach ($_FILES['file']['name'] as $key => $attachment) {
            $info = pathinfo($attachment);
            $ext = $info['extension']; // get the extension of the file

            $newname = str_replace('/tmp/', '', pathinfo($_FILES['file']['name'][$key], PATHINFO_FILENAME))  . '-' . time() . '.' . $ext;
            $target = '../../files/' . $newname;
            move_uploaded_file($_FILES['file']['tmp_name'][$key], $target);
            $input = new stdClass();
            $input->tmpName = $_FILES['file']['tmp_name'][$key];
            $input->size = $_FILES['file']['tmp_name'][$key];
            $input->type = $_FILES['file']['type'][$key];
            $input->error = $_FILES['file']['error'][$key];
            $input->lead_id = $_POST['lead_id'];
            $input->name = $newname;
            $attachments[] = $apiObj->saveAttachment($input);
        $history = new stdClass();
        $history->lead_id = $_POST['lead_id'];
        $history->note = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'] . ' uploaded an attachment: '.$newname.' on ' . date('m/d/Y H:i:s');
        $history->userName = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];

        $apiObj->saveHistory($history);            
        }
        
    }

    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body(json_encode($attachments));
})->via('GET', 'POST');


$app->run();
