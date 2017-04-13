<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-lg-10">
            <h2>Create a Customer</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#clients">Customer</a></li>
                <li class="active">
                    <span>Create</span>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
</div>
<div class="row margin-l-r-0 m-20-15 animated fadeInRight">
    <div id="leadId" style="display:none" data-leadid="<?= !empty($result['lead']['_id']) ? $result['lead']['_id'] : ''; ?>"></div>
    <form id="personalInfoForm" data-parsley-validate>

        <div class="col-md-<?= (!empty($result['active_script'])) ? '8' : '12'; ?>" id="assurantDirectLinkModalList">

            <div class="row">
                <div class="col-md-12">
                    <div class="ibox ">
                        <div class="ibox-title"><h5>Customer Information</h5></div>
                        <div class="ibox-content hgreen">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class=" col-sm-12 col-md-4">
                                        <div class="form-group ">
                                            <label>
                                                First Name * 
                                            </label>
                                            <div class="input-group col-xs-12">
                                                <input type="text" name="first_name" data-parsley-maxlength="50" value="<?= $result['lead']['first_name']; ?>" class="form-control " required placeholder="">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-sm-12 col-md-4">
                                        <div class="form-group ">
                                            <label>
                                                Last name *
                                            </label>
                                            <div class="input-group col-xs-12">
                                                <input type="text" name="last_name" data-parsley-maxlength="50" value="<?= $result['lead']['last_name']; ?>" class="form-control " required placeholder="">  
                                            </div>
                                        </div>
                                    </div> 
                                    <div class=" col-sm-12 col-md-4">
                                        <div class="form-group ">
                                            <label>
                                                Phone Number *
                                            </label>
                                            <div class="input-group col-xs-12">
                                                <input type="tel" name="phone_number" data-parsley-maxlength="10" value="<?= $result['lead']['phone_number']; ?>" class="phone_us form-control " required placeholder="">  
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
                                                <input type="email" name="email_address" data-parsley-maxlength="100" value="<?= $result['lead']['email_address']; ?>" class="form-control " required placeholder="">  
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
                                                <input type="text" id="service_address" name="service_address" value="<?= $result['lead']['service_address']; ?>" class="form-control "  placeholder="">  
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

                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="pull-left">Billing Information</h5> <div class="pull-right" style="margin-top: 10px;margin-bottom: 10px;"><input type="checkbox" name="billing_info_different" value="1" <?= ($result['lead']['billing_info_different'] == 1) ? 'checked' : ''; ?>> <label id="billing_info_different">Different from above</label></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="billingInfoBox" style="<?php if ($result['lead']['billing_info_different'] != 1): ?>display:none<?php endif; ?>" >
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
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class=" col-sm-12 col-md-12">
                                            <div class="form-group ">
                                                <label>
                                                    Notes
                                                </label>
                                                <div class="input-group col-md-12">
                                                    <textarea style="width:100%" name="notes" class="form-control "><?= $result['lead']['notes']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="pull-right"><button type="button" class="btn btn-white" onclick="window.location.hash = '#clients'">Cancel</button> <button type="submit" class="btn btn-success">Submit</button></div>
                </div>
            </div>

        </div>
        <?php if (!empty($result['active_script'])): ?>
            <div class="col-md-4">

                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox ">
                            <div class="ibox-title"><h5>Customer Information</h5></div>
                            <div class="ibox-content hgreen">
                                <?php
                                $beforeStr = $result['active_script']['template'];
                                $user_full_name = $lead_agent_full_name = $_SESSION['api']['user']['firstname'] . ' ' . $_SESSION['api']['user']['lastname'];
                                $day_of_week = date('l');
                                $date = date('jS');
                                $month = date('F');
                                $time = date('h:ia');
                                if (!empty($result['lead']['_id'])) {

                                    $lead_customer_full_name = $result['lead']['first_name'] . ' ' . $result['lead']['last_name'];
                                    if(!empty($result['lead']['phone_number'])) {
                                        
                                        $customer_phone_number = $result['lead']['phone_number'];
                                    }
                                    
                                    if (!empty($result['lead']['electric_supply_product'])) {

                                        $products[] = 'electric';
                                        $suppliers[] = $result['lead']['electric_supplier_text'];
                                        $accountNumbers[] = $result['lead']['electric_supply_account_number'];
                                    } 
                                    
                                    if (!empty($result['lead']['gas_supply_product'])) {
                                        
                                        $products[] = 'gas';
                                        $suppliers[] = $result['lead']['gas_supplier_text'];
                                        $accountNumbers[] = $result['lead']['gas_supply_account_number'];
                                    } 
                                    
                                    if (!empty($result['lead']['internet_supply_product'])) {
                                        
                                        $products[] = 'internet';
                                        $suppliers[] = $result['lead']['internet_supplier_text']; 
                                        $accountNumbers[] = $result['lead']['internet_supply_account_number'];
                                    }
                                    
                                    if(!empty($products)) $products = implode(', ', $products);
                                    
                                    if(!empty($product_suppliers)) $product_suppliers = implode(', ', $suppliers);
                                    if(!empty($supply_account_numbers)) $supply_account_numbers = implode(', ', $accountNumbers);
                                }

                                preg_match_all('/{{(\w+)}}/', $beforeStr, $matches);
                                $afterStr = $beforeStr;
                                foreach ($matches[0] as $index => $var_name) {
                                    if (isset(${$matches[1][$index]})) {
                                        $afterStr = str_replace($var_name, ${$matches[1][$index]}, $afterStr);
                                    }
                                }

                                echo $afterStr;



                                ;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>  
        <?php endif; ?>


    </form>
</div>
<script>

    var saveLeadInfo = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/leads/saveLead',
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
    $(document).ready(function () {
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
        $('.phone_us').mask('(000) 000-0000');
<?php if ($result['lead']['_id']): ?>
            $('select[name="electric_supplier"]').trigger('change');
            $('select[name="gas_supplier"]').trigger('change');
            $('select[name="internet_supplier"]').trigger('change');
<?php endif; ?>
        $('body').off('submit', '#personalInfoForm').on('submit', '#personalInfoForm', function (e) {

            e.preventDefault()
            var form = $(this);
            form.parsley().destroy();
            form.parsley().validate();
            if (form.parsley().isValid()) {
                var data = {};
                var formData = form.serializeObject();
                formData._id = $('#leadId').data('leadid');
                data.body = formData;
                data.body.type = 'client';
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

                        $.each(data, function (key, value) {

                            $('*[data-field-key=' + key + '].dynamic-field').text(value);
                            $('*[name=' + key + ']').val(value);
                        });

                        $('#personalInfoModal').modal('hide');
                        <?php if($result['lead']['_id']): ?>
                            window.location.reload(true);
                        <?php else: ?>
                        window.location.hash = '#clients/edit/' + data._id;
                        <?php endif; ?>
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
        initMapsAutocomplete('input[name="service_address"]', 'input[name="service_zip"]', 'input[name="service_state"]', 'input[name="service_city"]');
        initMapsAutocomplete('input[name="billing_address"]', 'input[name="billing_zip_code"]', 'input[name="billing_state"]', 'input[name="billing_city"]');

    });

    var setStateCity = function (autocom, zip_code, state, city) {

        $(autocom).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "http://maps.googleapis.com/maps/api/geocode/json",
                    dataType: "json",
                    data: {address: request.term, sensor: 'true'},
                    success: function (data) {
                        response($.map(data.results, function (item) {

                            return {
                                label: item.formatted_address,
                                value: request.term,
                                address: item.address_components
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {

                $.each(ui.item.address, function (i, item) {

                    if ($.inArray('administrative_area_level_1', item.types) !== -1) {

                        $(state).val(item.long_name);
                    }
                    if ($.inArray('locality', item.types) !== -1) {

                        $(city).val(item.long_name);
                    }
                    if ($.inArray('postal_code', item.types) !== -1) {

                        $(zip_code).val(item.long_name);
                    }
                });
            }
        });
    }


</script>