<script>

    var totalForms = [];

    function setFormCount(type, count) {

        if (totalForms[type] == undefined) {

            totalForms[type] = 0;

        }

        totalForms[type] = count;

    }

</script>

<?php

function createPartial($type, $label, $createThing, $prefix, $result, $apiObj, $multi = TRUE) {
    ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">

            <div class="margin-l-r-0 margin-l-r-0 row">

                <div class="col-xs-11 text-left">

                    <h4><?php echo $label; ?></h4>

                </div>

                <div class="col-xs-1  text-center">

                    <?php if ($multi === TRUE) { ?>

                        <a id="newItemButton" data-toggle="modal" data-target="#<?= $type; ?>Modal" class="btn-dark"><i class="fa fa-plus"></i></a>

                    <?php } ?>

                </div>

            </div>

        </div>

        <div id="<?php echo $type; ?>List">

            <?php
            if (empty($result[$type])) {
                $result[$type][0] = array();
            }

            $resultData = $result[$type];

            if ($createThing <> "Y") {

                // Nested Documents of leads

                if (!empty($result['leads'][0][$type])) {

                    $resultData = $result['leads'][0][$type];
                }
            }

            if ($type == "notes") {

                krsort($resultData);
            }
            ?>

            <?php if ($type == "notes") { ?>

                <div class="ibox-content hblue" id="<?php echo $type; ?>Item_<?php echo $index; ?>">

                    <div class="margin-l-r-0 row">

                        <div class=" col-sm-12 col-md-12">

                            <div class=" col-sm-12 col-md-12">

                                <div class="form-group">

                                    <label>

                                        Create a Note for this customer

                                    </label>

                                    <input type="hidden" name="person_0_notes_0_createThing" value="Y">

                                    <textarea name='person_0_notes_0_information' id="person_0_notes_0_information" class="form-control" style="min-height: 200px"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

    <?php
}
?>

<form id="leadform" class="form-horizontal ">

    <div class=" animated fadeInRight">

        <div class="small-header margin-l-r-0 row wrapper border-bottom white-bg page-heading ng-scope">

            <div class="col-lg-10">

                <h2>Create a Lead</h2>
                <span>Let's get basic information.</span>
            </div>

            <div class="col-lg-2">

                <ol class="breadcrumb" style="margin-top:20px; margin-bottom: 10px">

                    <li><a href="#">Home</a></li>

                    <li><a href="#lead">Leads</a></li>

                    <li class="active">

                        <span>Create</span>

                    </li>

                </ol>

            </div>

        </div>

    </div>

    <div class="margin-l-r-0 row animated fadeInRight">
        <div id="leadId" style="display:none" data-leadid="<?= !empty($result['lead']['_id']) ? $result['lead']['_id'] : ''; ?>"></div>
        <div>

            <div class="margin-l-r-0 row">

                <div class="padding-l-r-0 col-lg-12 col-xs-12">

                    <div ng-controller="TabsDemoCtrl">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active"><a href="#contact" aria-controls="phone" role="tab" data-toggle="tab">Contact</a></li>

                            <li role="presentation"><a href="#banking" aria-controls="banking" role="tab" data-toggle="tab">Payment</a></li>

                            <li role="presentation"><a href="#quotes" aria-controls="quotes" role="tab" data-toggle="tab">Quotes</a></li>

                            <li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a></li>

                            <li role="presentation"><a href="#emails" aria-controls="emails" role="tab" data-toggle="tab">Emails</a></li>

                            <li role="presentation"><a href="#admin" aria-controls="admin" role="tab" data-toggle="tab" style="display:none">Admin</a></li>

                            <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">Attachments</a></li>

                            <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>

                        </ul>

                        <!-- Tab panes -->

                        <div class="tab-content">

                            <!-- Phone Tabs -->

                            <div role="tabpanel" class="tab-pane active hblue" id="contact">

                                <div class="row m-20-15">

                                    <div class="col-md-12">
                                        <div class="table-responsive" id="partialPhoneInfo">
                                            <table cellpadding="1" cellspacing="1" class="table table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Personal Information</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><a class="btn  btn-xs btn-dark" data-toggle="modal" data-target="#personalInfoModal"><i class="fa fa-pencil"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="bold">First Name</td><td><span class="dynamic-field" data-field-key="first_name"><?= $result['lead']['first_name']; ?></span></td><td class="bold">Last Name</td><td><span class="dynamic-field" data-field-key="last_name"><?= $result['lead']['last_name']; ?></span></td><td class="bold">Phone Number</td><td><span class="dynamic-field" data-field-key="phone_number"><?= $result['lead']['phone_number']; ?></span> <?php if (!empty($result['lead']['_id'])): ?><button type="button" id="newSms" data-toggle="modal" data-target="#modal" data-phonenumber="<?php echo preg_replace(" /[^0-9]/ ", " ", $result['lead']['phone_number']); ?>" class="newSms btn btn-xs btn-success">Sms</button><?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Email Address</td><td><span class="dynamic-field" data-field-key="email_address"><?= $result['lead']['email_address']; ?></span></td><td class="bold">Lead Source</td><td><span class="dynamic-field" data-field-key="lead_source"><?= $result['lead']['lead_source']; ?></span></td><td class="bold">Service Address</td><td><span class="dynamic-field" data-field-key="service_address"><?= $result['lead']['service_address']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Service Zip</td><td><span class="dynamic-field" data-field-key="service_zip"><?= $result['lead']['service_zip']; ?></span></td><td class="bold">Service State</td><td><span class="dynamic-field" data-field-key="service_state"><?= $result['lead']['service_state']; ?></span></td> <td class="bold">Service City</td><td><span class="dynamic-field" data-field-key="service_city"><?= $result['lead']['service_city']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Electric Supplier</td><td><span class="dynamic-field" data-field-key="electric_supplier_text"><?= $result['lead']['electric_supplier_text']; ?></span></td><td class="bold">Gas Supplier</td><td><span class="dynamic-field" data-field-key="gas_supplier_text"><?= $result['lead']['gas_supplier_text']; ?></span></td><td class="bold">Internet Supplier</td><td><span class="dynamic-field" data-field-key="internet_supplier_text"><?= $result['lead']['internet_supplier_text']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Product</td><td><span class="dynamic-field" data-field-key="electric_supply_product_text"><?= $result['lead']['electric_supply_product_text']; ?></span></td><td class="bold">Product</td><td><span class="dynamic-field" data-field-key="gas_supply_product_text"><?= $result['lead']['gas_supply_product_text']; ?></span></td><td class="bold">Product</td><td><span class="dynamic-field" data-field-key="internet_supply_product_text"><?= $result['lead']['internet_supply_product_text']; ?></span></td>
                                                    </tr>      
                                                    <tr>
                                                        <td class="bold">Account Number</td><td><span class="dynamic-field" data-field-key="electric_supply_account_number"><?= $result['lead']['electric_supply_account_number']; ?></span></td><td class="bold">Account Number</td><td><span class="dynamic-field" data-field-key="gas_supply_account_number"><?= $result['lead']['gas_supply_account_number']; ?></span></td><td class="bold">Account Number</td><td><span class="dynamic-field" data-field-key="internet_supply_account_number"><?= $result['lead']['internet_supply_account_number']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Product 1 Status</td><td><span class="dynamic-field" data-field-key="electric_supply_product_status"><?= $result['lead']['electric_supply_product_status']; ?></span></td><td class="bold">Product 2 Status</td><td><span class="dynamic-field" data-field-key="gas_supply_product_status"><?= $result['lead']['gas_supply_product_status']; ?></span></td><td class="bold">Product 3 Status</td><td><span class="dynamic-field" data-field-key="internet_supply_product_status"><?= $result['lead']['internet_supply_product_status']; ?></span></td>
                                                    </tr>                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 billingInfoBox" style="<?php if ($result['lead']['billing_info_different'] != 1): ?>display:none<?php endif; ?>">
                                        <div class="table-responsive" id="partialPhoneInfo">
                                            <table cellpadding="1" cellspacing="1" class="table table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Billing Information</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="bold">Billing First Name</td><td><span class="dynamic-field" data-field-key="billing_first_name"><?= $result['lead']['billing_first_name']; ?></span></td><td class="bold">Billing Last Name</td><td><span class="dynamic-field" data-field-key="billing_last_name"><?= $result['lead']['billing_last_name']; ?></span></td><td class="bold">Relationship</td><td><span class="dynamic-field" data-field-key="billing_info_relationship"><?= $result['lead']['billing_info_relationship']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Billing Address</td><td><span class="dynamic-field" data-field-key="billing_address"><?= $result['lead']['billing_address']; ?></span></td><td class="bold">Billing Zip Code</td><td><span class="dynamic-field" data-field-key="billing_zip_code"><?= $result['lead']['billing_zip_code']; ?></span></td><td class="bold">Billing Phone Number</td><td><span class="dynamic-field" data-field-key="billing_phone_number"><?= $result['lead']['billing_phone_number']; ?></span><?php if (empty($result['lead']['_id'])): ?><button type="button" id="newSms" data-toggle="modal" data-target="#modal" selectedNumber="<?php echo preg_replace(" /[^0-9]/ ", " ", $result['lead']['billing_phone_number']); ?>" _parentId="<?php echo $result['lead']['_id']; ?>" class="btn newSms btn-xs btn-success">Sms</button><?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Billing State</td><td><span class="dynamic-field" data-field-key="billing_state"><?= $result['lead']['billing_state']; ?></span></td> <td class="bold">Billing City</td><td colspan="3"><span class="dynamic-field" data-field-key="billing_city"><?= $result['lead']['billing_city']; ?></span></td>
                                                    </tr>                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>                                    
                                </div>                                                                                           

                            </div>

                            <div role="tabpanel" class="tab-pane hblue" id="quotes">
                                <!-- Quotes -->
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <div class="margin-l-r-0 row">
                                            <div class="col-xs-11 text-left">
                                                <h4>Quotes</h4>
                                            </div>
                                            <div class="col-xs-1  text-center">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="quotesList">
                                        <div class="ibox-content" id="notesItem_">
                                            <div class="margin-l-r-0 row">
                                                <div class="col-lg-4 col-xs-4">
<!--                                                    <iframe style="border: 0; width: 100%; height: 500px" src="https://quotenatgen.ngic.com/agent/234572"></iframe>
                                                    </br>
                                                    </br>
                                                    </br>
                                                    </br>
                                                    <iframe style="border: 0; width: 100%; height: 500px" src="http://www.1enrollment.com/index.cfm?id=161786"></iframe>
                                                     <iframe  style="border: 0; width: 100%; height: 500px" src="https://enroll.revolutioninsure.net/UserAccount/Login?ReturnUrl=%2FMultiQuote%2FReviewQuote%2FCreateQuote"></iframe> -->


                                                </div>
                                                <div class="col-lg-8 col-xs-8">
                                                    <!--<iframe style="border: 0; width: 100%; height: 800px" src="<?php echo $iframe_url; ?>"></iframe>-->

                                                </div>
                                                <div class="margin-l-r-0 row">
                                                    <div class="col-xs-12">
                                                        <div id="assurantSubmitList" style="display:none">Getting Quote</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="notes">

                                <!-- Notes -->
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <div class="margin-l-r-0 row">
                                            <div class="col-md-10 text-left">
                                                <h4>Notes for <?= $result['lead']['first_name']; ?> <?= $result['lead']['last_name']; ?></h4>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#note">Create note</button>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <?php if ($result['lead']['notes']): foreach ($result['lead']['notes'] as $note): ?>
                                                <div class="ibox m-t-20">
                                                    <div class="ibox-title">
                                                        <div class="margin-l-r-0 row">
                                                            <div class="col-md-11 text-left">
                                                                <span>Created by: <strong><?= $note['created_by']; ?></strong></span>
                                                                <span></span>
                                                            </div>
                                                            <div class="col-md-1  text-center">
                                                                <a class="btn  btn-xs btn-dark edit-note" data-noteid="<?= $note['_id']; ?>"><i class="fa fa-pencil"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content hblue">
                                                        <div class="margin-l-r-0 row">
                                                        <div class="col-md-12 text-left note-text">
                                                            <?= $note['text']; ?>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane hblue" id="banking">

                                <div class="row m-20-15">
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="partialPhoneInfo">
                                            <table cellpadding="1" cellspacing="1" class="table table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th>Bank Account Type</th>
                                                        <th>Bank Routing Number</th>
                                                        <th>Bank Account Number</th>
                                                        <th class="text-right"><a class="btn  btn-xs btn-dark" data-toggle="modal" data-target="#bankingModal"><i class="fa fa-plus"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>                                            
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-20-15">
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="partialPhoneInfo">
                                            <table cellpadding="1" cellspacing="1" class="table table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Credit Card Type</th>
                                                        <th>Name On Card</th>
                                                        <th>Card Number</th>
                                                        <th>CCV</th>
                                                        <th>Expiration Month</th>
                                                        <th>Expiration Year</th>
                                                        <th class="text-right"><a class="btn  btn-xs btn-dark" data-toggle="modal" data-target="#creditcardModal"><i class="fa fa-plus"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>                                            
                                            </table>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                            <div role="tabpanel" class="tab-pane hblue" id="emails" >
                                <div class="ibox-content m-b-sm">
                                    <div class="margin-l-r-0 row">
                                        <div class="col-sm-12" style="display:none">
                                            <label>Check 24HourMail: </label>
                                            <?php
                                            $emailsfound = false;
                                            if (!empty($result['emails'][0])) {
                                                $pos = strpos(strtolower($result['emails'][0]['email']), "24hourmail");
                                                if ($pos === false) {
                                                    
                                                } else {
                                                    $emailsfound = true;
                                                    echo "<p><a href='http://24hourmail.net/lookup.php?email=" . trim($result['emails'][0]['email']) . "' target='_blank'>" . $result['emails'][0]['email'] . "</a></P>";
                                                }
                                            }
                                            if (!empty($result['emails'][1])) {
                                                $pos = strpos(strtolower($result['emails'][1]['email']), "24hourmail");
                                                if ($pos === false) {
                                                    
                                                } else {
                                                    $emailsfound = true;
                                                    echo "<p><a href='http://24hourmail.net/lookup.php?email=" . trim($result['emails'][1]['email']) . "' target='_blank'>" . $result['emails'][1]['email'] . "</a></P>";
                                                }
                                            }
                                            if (!empty($result['emails'][2])) {
                                                $pos = strpos(strtolower($result['emails'][2]['email']), "24hourmail");
                                                if ($pos === false) {
                                                    
                                                } else {
                                                    $emailsfound = true;
                                                    echo "<p><a href='http://24hourmail.net/lookup.php?email=" . trim($result['emails'][2]['email']) . "' target='_blank'>" . $result['emails'][2]['email'] . "</a></P>";
                                                }
                                            }
                                            if ($emailsfound === false) {
                                                echo "<P>No Emails at this time</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div id="foundEmails">
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane hblue" id="history">

                                <div class="ibox float-e-margins">
                                    <div id="recordingDiv" class="ibox float-e-margins">

                                        <div class="ibox-title">

                                            <h4>Sms</h4>

                                        </div>

                                        <div class="ibox-content">

                                            <table class="table table-bordered table-striped">
                                                <tr><th>Number</th><th>Message</th><th>Created Date</th><th>Created By</th></tr>

<?php if (!empty($result['sms'])): foreach ($result['sms'] as $sms): ?>
                                                        <tr>
                                                            <td><?= $sms['to_number']; ?></td>
                                                            <td><?= $sms['message']; ?></td>
                                                            <td><?= date("m/d/Y", strtotime($sms['_timestampCreated'])); ?></td>
                                                            <td><?= $sms['userName']; ?></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </table>
                                        </div>

                                    </div>
                                    <div id="recordingDiv" class="ibox float-e-margins">

                                        <div class="ibox-title">

                                            <h4>Recordings</h4>

                                        </div>

                                        <div class="ibox-content">

                                            <a target="_blank" href="#recordings/view/<?php echo $result['leads'][0]['id']; ?>">Get Recordings</a>

                                        </div>

                                    </div>

                                    <div class="ibox float-e-margins">

                                        <div class="ibox-title">

                                            <div class="margin-l-r-0 row">

                                                <div class="col-xs-11 text-left">

                                                    <h4>History</h4>

                                                </div>

                                                <div class="col-xs-1  text-center">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="ibox-content" id="<?php echo $type; ?>Item_<?php echo $index; ?>">

                                            <div class="margin-l-r-0 row">

                                                <?php
                                                if (!empty($result['history'])) {

                                                    echo "<ul>";

                                                    foreach ($result['history'] as $hKey => $hVal) {

                                                        echo "<li><strong>User:</strong> " . $hVal['userName'] . " - <strong>Action:</strong> " . $hVal['note'] . " - <strong>Date:</strong> " . date("m/d/Y H:i:s", strtotime($hVal['_timestampCreated']));
                                                    }

                                                    echo "</ul>";
                                                }
                                                ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane" id="attachments">

                                <div class="ibox float-e-margins">

                                    <div class="ibox float-e-margins">

                                        <div class="ibox-content" id="<?php echo $type; ?>Item_<?php echo $index; ?>">

                                            <div class="margin-l-r-0 row" id="attachmentsDiv">

                                                <?php
                                                try {

                                                    include ("./pelican.php");
                                                } catch (Exception $e) {
                                                    
                                                }
                                                ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div style="padding-top:30px; padding-bottom: 30px;">

                            <div class="margin-l-r-0 row">

                                <div class="col-xs-10">



                                </div>

                                <div class="col-xs-2 text-right" style="display:none">

<?php if (!empty($apiObj->getValue($result['leads'][0], "firstName"))) { ?>

                                        <a deleteId="<?php echo $result['leads'][0]['id']; ?>" class="btn btn-warning leadDelete">Delete</a>

<?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</form>

<div class="modal" id="personalInfoModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-sm" style="width: 80%">

        <div class="modal-content animated bounceInRight">
            <form id="personalInfoForm" data-parsley-validate>
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title">Lead information</h4>

                </div>

                <div class="modal-body" id="assurantDirectLinkModalList">
                    <h6>Personal Information</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ibox hblue">
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        First Name *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" data-parsley-maxlength="50" name="first_name" value="<?= $result['lead']['first_name']; ?>" class="form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Last name *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" data-parsley-maxlength="50" name="last_name" value="<?= $result['lead']['last_name']; ?>" class="form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Phone Number *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="tel" data-parsley-maxlength="10" name="phone_number" value="<?= $result['lead']['phone_number']; ?>" class="phone_us form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Email Address *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="email" name="email_address" value="<?= $result['lead']['email_address']; ?>" class="form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Lead Source *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="lead_source" required>
                                                            <option value="">Choose lead source</option>
                                                            <?php foreach ($result['lead_sources'] as $lead_source): ?>
                                                                <option value="<?= $lead_source['name']; ?>" <?= $lead_source['name'] == $result['lead']['lead_source'] ? 'selected' : ''; ?>><?= $lead_source['name']; ?></option>
<?php endforeach; ?>
                                                        </select>   
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Service Address
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="service_address" id="service_address" value="<?= $result['lead']['service_address']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Service Zip *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input data-type="service" type="text" name="service_zip" value="<?= $result['lead']['service_zip']; ?>" class="service form-control zip-state-city" required placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Service State *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="service_state" value="<?= $result['lead']['service_state']; ?>" class="service form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Service City *
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="service_city" value="<?= $result['lead']['service_city']; ?>" class="service form-control " required placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Electric Supplier 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="electric_supplier">
                                                            <option value="">Choose supplier</option>
                                                            <?php foreach ($result['electric_suppliers'] as $supplier): ?>
                                                                <option value="<?= $supplier['_id']; ?>" <?= $supplier['_id'] == $result['lead']['electric_supplier'] ? 'selected' : ''; ?>><?= $supplier['supplier_name']; ?></option>
<?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Gas Supplier
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="gas_supplier">
                                                            <option value="">Choose supplier</option>
                                                            <?php foreach ($result['gas_suppliers'] as $supplier): ?>
                                                                <option value="<?= $supplier['_id']; ?>" <?= $supplier['_id'] == $result['lead']['gas_supplier'] ? 'selected' : ''; ?>><?= $supplier['supplier_name']; ?></option>
<?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Internet Supplier 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="internet_supplier">
                                                            <option value="">Choose supplier</option>
                                                            <?php foreach ($result['internet_suppliers'] as $supplier): ?>
                                                                <option value="<?= $supplier['_id']; ?>" <?= $supplier['_id'] == $result['lead']['internet_supplier'] ? 'selected' : ''; ?>><?= $supplier['supplier_name']; ?></option>
<?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Product
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="electric_supply_product">
                                                            <option value="">Choose product</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Product 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="gas_supply_product">
                                                            <option value="">Choose product</option>
                                                        </select>                                                                                                               
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Product
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="internet_supply_product">
                                                            <option value="">Choose product</option>
                                                        </select>                                                             
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Account Number
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="electric_supply_account_number" value="<?= $result['lead']['electric_supply_account_number']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Account Number
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="gas_supply_account_number" value="<?= $result['lead']['gas_supply_account_number']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Account Number 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="internet_supply_account_number" value="<?= $result['lead']['internet_supply_account_number']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Status 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="electric_supply_product_status">
                                                            <option value="">Choose status</option>
                                                            <?php foreach ($result['status_list'] as $status): ?>
                                                                <option value="<?= $status['name']; ?>" <?= $status['name'] == $result['lead']['electric_supply_product_status'] ? 'selected' : ''; ?>><?= $status['name']; ?></option>
<?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Status 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="gas_supply_product_status">
                                                            <option value="">Choose status</option>
                                                            <?php foreach ($result['status_list'] as $status): ?>
                                                                <option value="<?= $status['name']; ?>" <?= $status['name'] == $result['lead']['gas_supply_product_status'] ? 'selected' : ''; ?>><?= $status['name']; ?></option>
<?php endforeach; ?>
                                                        </select>                                                        
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Status
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select class="form-control" name="internet_supply_product_status">
                                                            <option value="">Choose status</option>
                                                            <?php foreach ($result['status_list'] as $status): ?>
                                                                <option value="<?= $status['name']; ?>" <?= $status['name'] == $result['lead']['internet_supply_product_status'] ? 'selected' : ''; ?>><?= $status['name']; ?></option>
<?php endforeach; ?>
                                                        </select> 
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>

                                </div>  
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="pull-left">Billing Information</h6> <div class="pull-right" style="margin-top: 10px;margin-bottom: 10px;"><input type="checkbox" name="billing_info_different" value="1" <?= ($result['lead']['billing_info_different'] == 1) ? 'checked' : ''; ?>> <label id="billing_info_different">Different from above</label></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row billingInfoBox" style="<?php if ($result['lead']['billing_info_different'] != 1): ?>display:none<?php endif; ?>" >
                        <div class="col-md-12">
                            <div class="ibox hblue">
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing First Name
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_first_name" value="<?= $result['lead']['billing_first_name']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing Last name 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_last_name" value="<?= $result['lead']['billing_last_name']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Relationship
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_info_relationship" value="<?= $result['lead']['billing_info_relationship']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing Address
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_address" value="<?= $result['lead']['billing_address']; ?>" class="form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing Zip Code
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_zip_code" value="<?= $result['lead']['billing_zip_code']; ?>" class="form-control zip-state-city " placeholder="">  
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing Phone Number
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_phone_number" value="<?= $result['lead']['billing_phone_number']; ?>" class="phone_us form-control " placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing State
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_state" value="<?= $result['lead']['billing_state']; ?>" class="form-control service" placeholder="">  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-sm-12 col-md-4">
                                                <div class="form-group ">
                                                    <label>
                                                        Billing City
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" name="billing_city" value="<?= $result['lead']['billing_city']; ?>" class="form-control service" placeholder="">  
                                                    </div>
                                                </div>
                                            </div>                                     
                                        </div> 
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> <button type="submit" class="btn btn-success">Save Changes</button>

                </div>
            </form>
        </div>

    </div>

</div>

<div class="modal" id="note" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-sm" style="width: 80%">

        <div class="modal-content animated bounceInRight">
            <form id="noteForm" data-parsley-validate>
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title"><span class="verb">Add</span> Note</h4>

                </div>

                <div class="modal-body" id="assurantDirectLinkModalList">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ibox hblue">
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-12">
                                                <div class="form-group ">
                                                    <label>
                                                        Notes
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <textarea name="text" class="form-control " required >  </textarea>
                                                    </div>
                                                </div>
                                            </div>                                  
                                        </div> 
                                    </div>

                                </div>  
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="_id">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> <button type="submit" class="btn btn-success">Save Changes</button>

                </div>
            </form>
        </div>

    </div>

</div>
<div class="modal" id="bankingModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-sm" style="width: 80%">

        <div class="modal-content animated bounceInRight">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                <h4 class="modal-title">Lead information</h4>

            </div>

            <div class="modal-body" id="assurantDirectLinkModalList">
                <h6>Banking Information</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox hblue">
                            <div class="ibox-content">
<?php $apiObj->displayThingForm("banking", $result['leads'], 0); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> <button type="submit" class="btn btn-success" data-dismiss="modal">Save Changes</button>

            </div>

        </div>

    </div>

</div>

<div class="modal" id="creditcardModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-sm" style="width: 80%">

        <div class="modal-content animated bounceInRight">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>

                <h4 class="modal-title">Lead information</h4>

            </div>

            <div class="modal-body" id="assurantDirectLinkModalList">
                <h6>Credit Card Information</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox hblue">
                            <div class="ibox-content">
<?php $apiObj->displayThingForm("creditcard", $result['leads'], 0); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> <button type="button" class="btn btn-success" data-dismiss="modal">Save Changes</button>

            </div>

        </div>

    </div>

</div>

<script>
    function initMapsAutocomplete(input, zip_code, state, city) {
        var autocomplete = new google.maps.places.Autocomplete($(input)[0]);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var placeLocation = this.getPlace();
            var route = '';
            var streetNumber = '';
            console.log(placeLocation.address_components);
            $.each(placeLocation.address_components, function (index, item) {
                switch (item.types[0]) {
                    case 'street_number':
                        streetNumber = item.long_name;
                        break;
                    case 'route':
                        route = item.short_name;
                        break;
                    case 'locality':
                        $(city).val(item.long_name);
                        break;
                    case 'administrative_area_level_1':
                        $(state).val(item.long_name);
                        break;
                    case 'postal_code':
                        $(zip_code).val(item.long_name);
                        break;
                }
            });

            if (route) {
                $(input).val(streetNumber && route
                        ? streetNumber + ' ' + route
                        : route);
            }

        });
    }
    $(function () {

        $(".datepicker").pickadate({
            format: 'mm/dd/yyyy',
            min: '01/01/1920',
            max: '01/01/2020',
            selectYears: 100,
            selectMonths: true,
        });

    });

</script>

<script>

    var saveLeadInfo = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/leads/saveLead',
            verb: 'POST',
            data: JSON.stringify(data.body)
        });
    }
    var saveNote = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/leads/saveNote',
            verb: 'POST',
            data: JSON.stringify(data.body)
        });
    }    
    var getSupplierProducts = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/admin/getSupplierProducts/' + data.supplier_id,
            verb: 'GET',
            data: JSON.stringify(data.body)
        });
    }

    $('#uniMod').load('api/twilio/smsModal?leadId=<?= $result['lead']['_id']; ?>');

    $(document).ready(function () {
        
        $('body').off('click', '.edit-note').on('click', '.edit-note', function(){
            
            var noteId = $(this).data('noteid');
            var noteText = $(this).closest('.ibox').find('.note-text').text();
            $('#noteForm textarea[name="text"]').val(noteText);
            $('#noteForm input[name="_id').val(noteId);
            
            $('#note').modal('show');
            
        });
        
        $('body').off('submit', '#noteForm').on('submit', '#noteForm', function (e) {

            e.preventDefault()
            var form = $(this);
            form.parsley().reset();
            form.parsley().validate();
            if (form.parsley().isValid()) {
                var data = {};
                var formData = form.serializeObject();
                formData.lead_id = $('#leadId').data('leadid');
                data.body = formData;

                $.when(saveNote(data)).then(function (response) {

                    if (response.meta.success) {

                        $('#note').modal('hide');
                        $('#noteForm textarea[name="text"]').val('');
                        $('#noteForm input[name="_id').val('');
                        window.location.hash = '#lead/edit/' + formData.lead_id + '?popup=closed&ts=<?= time(); ?>';
                        toastr.success('Save Successful', 'Server Response');
                    }
                });
            }
        });

<?php if (!empty($_GET['popup']) && $_GET['popup'] == 'closed'): ?>

<?php else: ?>
            $('#personalInfoModal').modal('show');
<?php endif; ?>
        $('.dropzone.dz-clickable').html('<i class="fa fa-plus dz-default dz-message text-success clickuploadbtn"></i>');
        $('.dropzone.dz-clickable').addClass('hviolet');
        $('body').off('change', 'select[name="electric_supplier"]').on('change', 'select[name="electric_supplier"]', function () {
            var data = {};
            data.supplier_id = $(this).find(':selected').val();
            if (data.supplier_id) {
                $.when(getSupplierProducts(data)).then(function (response) {

                    var products = response.data;
                    var options = '<option value="">Choose Product</otion>';
                    $.each(products, function (index, product) {

                        if (product._id == '<?= $result['lead']['electric_supply_product']; ?>') {

                            var selected = 'selected';
                        }
                        options += '<option ' + selected + ' value="' + product._id + '">' + product.name + '</option>';
                    });
                    $('select[name="electric_supply_product"]').html(options);
                });
            }
        });
        $('body').off('change', 'select[name="gas_supplier"]').on('change', 'select[name="gas_supplier"]', function () {
            var data = {};
            data.supplier_id = $(this).find(':selected').val();
            if (data.supplier_id) {
                $.when(getSupplierProducts(data)).then(function (response) {

                    var products = response.data;
                    var options = '<option value="">Choose Product</otion>';
                    $.each(products, function (index, product) {

                        if (product._id == '<?= $result['lead']['gas_supply_product']; ?>') {

                            var selected = 'selected';
                        }
                        options += '<option ' + selected + ' value="' + product._id + '">' + product.name + '</option>';
                    });
                    $('select[name="gas_supply_product"]').html(options);
                });
            }
        });
        $('body').off('change', 'select[name="internet_supplier"]').on('change', 'select[name="internet_supplier"]', function () {
            var data = {};
            data.supplier_id = $(this).find(':selected').val();
            if (data.supplier_id) {
                $.when(getSupplierProducts(data)).then(function (response) {

                    var products = response.data;
                    var options = '<option value="">Choose Product</otion>';
                    $.each(products, function (index, product) {

                        if (product._id == '<?= $result['lead']['internet_supply_product']; ?>') {

                            var selected = 'selected';
                        }
                        options += '<option ' + selected + ' value="' + product._id + '">' + product.name + '</option>';
                    });
                    $('select[name="internet_supply_product"]').html(options);
                });
            }
        });
<?php if ($result['lead']['_id']): ?>
            $('select[name="electric_supplier"]').trigger('change');
            $('select[name="gas_supplier"]').trigger('change');
            $('select[name="internet_supplier"]').trigger('change');
<?php endif; ?>
        $('body').off('submit', '#personalInfoForm').on('submit', '#personalInfoForm', function (e) {

            e.preventDefault()
            var form = $(this);
            form.parsley().reset();
            form.parsley().validate();
            if (form.parsley().isValid()) {
                var data = {};
                var formData = form.serializeObject();
                formData._id = $('#leadId').data('leadid');
                data.body = formData;
<?php if (empty($result['lead']['_id'])): ?>
                    data.body.type = 'lead';
<?php endif; ?>
                if (!$('input[name="billing_info_different"]').is(':checked')) {

                    data.body.billing_first_name = data.body.first_name;
                    data.body.billing_last_name = data.body.last_name;
                    data.body.billing_address = data.body.service_address;
                    data.body.billing_zip_code = data.body.service_zip;
                    data.body.billing_phone_number = data.body.phone_number;
                    data.body.billing_state = data.body.service_state;
                    data.body.billing_city = data.body.service_city;
                    data.body.billing_info_different = 0;
                } else {
                    data.body.billing_info_different = 1;
                }
                $.when(saveLeadInfo(data)).then(function (response) {

                    if (response.meta.success) {

                        var data = response.data;

                        $('#leadId').data('leadid', data._id);
                        $('#newSms').data('phonenumber', data.phone_number);
                        $.each(data, function (key, value) {

                            $('*[data-field-key=' + key + '].dynamic-field').text(value);
                            $('*[name=' + key + ']').val(value);
                        });
                        $('*[data-field-key="internet_supplier_text"].dynamic-field').text($('select[name="internet_supplier"]').find(':selected').text());
                        $('*[data-field-key="gas_supplier_text"].dynamic-field').text($('select[name="gas_supplier"]').find(':selected').text());
                        $('*[data-field-key="electric_supplier_text"].dynamic-field').text($('select[name="electric_supplier"]').find(':selected').text());
                        $('*[data-field-key="internet_supply_product_text"].dynamic-field').text($('select[name="internet_supply_product"]').find(':selected').text());
                        $('*[data-field-key="gas_supply_product_text"].dynamic-field').text($('select[name="gas_supply_product"]').find(':selected').text());
                        $('*[data-field-key="electric_supply_product_text"].dynamic-field').text($('select[name="electric_supply_product"]').find(':selected').text());
                        $('#personalInfoModal').modal('hide');
                        window.location.hash = '#lead/edit/' + data._id + '?popup=closed&ts=<?= time(); ?>';
                        toastr.success('Save Successful', 'Server Response');
                    }
                });
            }
        });

        $('body').off('click', 'input[name="billing_info_different"]').on('click', 'input[name="billing_info_different"]', function () {


            if ($(this).is(':checked') == true) {

                $('.billingInfoBox').show();
            } else {

                $('.billingInfoBox').hide();
            }
        });
        $('.phone_us').mask('(000) 000-0000');
<?php if (!empty($result['emails'][0])) { ?>

            $.ajax({
                url: "<?php echo $settings['base_uri']; ?>api/mail/customer/<?php echo trim($result['emails'][0]['email']); ?>",
                            success: function (data) {

                                $("#foundEmails").html(data);

                            }

                        });

<?php } else { ?>

    <?php if (!empty($result['emails'][1])) { ?>

                            $.ajax({
                                url: "<?php echo $settings['base_uri']; ?>api/mail/customer/<?php echo trim($result['emails'][1]['email']); ?>",
                                            success: function (data) {

                                                $("#foundEmails").html(data);

                                            }

                                        });

    <?php } ?>

<?php } ?>

                                $('.newSms').on('click', function () {

                                    newSMSModal(this);

                                });

                                $('#newAppointment').on('click', function () {

                                    newAppointmentModal(this);

                                });
                                initMapsAutocomplete('input[name="service_address"]', 'input[name="service_zip"]', 'input[name="service_state"]', 'input[name="service_city"]');
                                initMapsAutocomplete('input[name="billing_address"]', 'input[name="billing_zip_code"]', 'input[name="billing_state"]', 'input[name="billing_city"]');

                            });

</script>
