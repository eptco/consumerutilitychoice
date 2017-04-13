<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-lg-10">
            <h2>Create a Product</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#lead/products/list">Products</a></li>
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
    <div id="productId" style="display:none" data-productid="<?= !empty($result['product']['_id']) ? $result['product']['_id'] : ''; ?>"></div>
    <form id="productform" class="form-horizontal " data-parsley-validate>
        <div>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div>
                                <h4>Product Information</h4>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Agent ID</label>
                                        <div class="col-sm-8">
                                            <input name="AgentId" type="text" class="form-control" required maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Vendor</label>
                                        <div class="col-sm-8">
                                            <input name="VendorNumber" type="text" class="form-control" required maxlength="10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email </label>
                                        <div class="col-sm-8">
                                            <input name="Email" type="email" class="form-control"  maxlength="100">
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Record Locator</label>
                                        <div class="col-sm-8">
                                            <input name="RecordLocator" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Sales State</label>
                                        <div class="col-sm-8">
                                            <input name="SalesState" type="text" class="form-control"  maxlength="2">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Authorization First Name</label>
                                        <div class="col-sm-8">
                                            <input name="AuthorizationFirstName" type="text" class="form-control" required maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Authorization Middle</label>
                                        <div class="col-sm-8">
                                            <input name="AuthorizationMiddle" type="text" class="form-control"  maxlength="1">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Authorization Last Name</label>
                                        <div class="col-sm-8">
                                            <input name="AuthorizationLastName" type="text" class="form-control" required maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Billing Telephone Number</label>
                                        <div class="col-sm-8">
                                            <input name="Btn" type="text" class="form-control phone_us" required maxlength="10">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Company Name</label>
                                        <div class="col-sm-8">
                                            <input name="CompanyName" type="text" class="form-control"  maxlength="100">
                                        </div>
                                    </div>                                                                        
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Company Contact Last Name</label>
                                        <div class="col-sm-8">
                                            <input name="CompanyContactLastName" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Company Contact Title</label>
                                        <div class="col-sm-8">
                                            <input name="CompanyContactTitle" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Territory</label>
                                        <div class="col-sm-8">
                                            <input name="Territory" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Lead Type</label>
                                        <div class="col-sm-8">
                                            <input name="LeadType" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Relation</label>
                                        <div class="col-sm-8">
                                            <input name="Relation" type="text" class="form-control" required maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Number Of Accounts</label>
                                        <div class="col-sm-8">
                                            <input name="NumberOfAccounts" type="number" class="form-control" required max="5">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Account First Name </label>
                                        <div class="col-sm-8">
                                            <input name="AccountFirstName" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Account Last Name</label>
                                        <div class="col-sm-8">
                                            <input name="AccountLastName" type="text" class="form-control"  maxlength="50">
                                        </div>
                                    </div>
                                </div>                                                            
                            </div>
                            <div style="padding-top:30px; padding-bottom: 30px;">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="btn btn-white" onClick="cancelProductInfo()">Cancel</a>
                                        <button id="saveButton" class="btn btn-success" type="submit">Save Product</button>
                                    </div>
                                </div>
                            </div>                                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function cancelProductInfo() {
        window.location.hash = '#lead/products/list';
    }

    $('#productform').submit(function (e) {

        e.preventDefault()
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()) {
            var data = {};
            var formData = form.serializeObject();
            formData._id = $('#productId').data('productid');
            data.body = formData;

            $.when(saveProductInfo(data)).then(function (response) {

                if (response.meta.success) {

                    var data = response.data;

                    $('#productId').data('productid', data._id);

//                    $.each(data, function(key, value){
//                        
//                        $('*[data-field-key='+key+'].dynamic-field').text(value);
//                        $('*[name='+key+']').val(value);
//                    });

                    cancelProductInfo();
                    toastr.success('Save Successful', 'Server Response');
                }
            });
        }
    });
    var saveProductInfo = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/leads/products',
            verb: 'POST',
            data: JSON.stringify(data.body)
        });
    }
    
    $(document).ready(function(){
    
        $('.phone_us').mask('(000) 000-0000');
    });

</script>