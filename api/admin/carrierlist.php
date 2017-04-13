<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-lg-10">
            <h2>Create Supplier</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#admin/settings">Settings</a></li>
                <li class="active">
                    <span>Create</span>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="row margin-l-r-0  m-20-15 animated fadeInRight">
    <div>
        <div class="row margin-l-r-0 ">
            <div class="col-lg-12 col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div>
                            <h4>Supplier List</h4>
                        </div>
                    </div>
                    <form id="supplierform"  class="form-horizontal" data-parsley-validate>
                        <div class="ibox-content hgreen">
                            <div class="row margin-l-r-0 ">
                                <div class="col-md-4">
                                    <label>
                                        Supplier Name
                                    </label>
                                    <input required class="form-control" name="supplier_name" type="text" >
                                </div>
                                <div class="col-md-4">
                                    <label>Supplier Type</label>
                                    <select required class="form-control" name="supplier_type" >
                                        <option value="electric">Electric</option>
                                        <option value="gas">Gas</option>
                                        <option value="internet">Internet</option>
                                    </select>
                                </div>                                                            
                                <div class="col-md-4">
                                    <label>Sort</label>
                                    <select required class="form-control" name="supplier_sort" >
                                        <?php if(empty($result)): ?>
                                        <option value="1">1</option>
                                        <?php else: ?>
                                        <?php for ($i = 1; $i <= count($result); $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row margin-l-r-0" style="margin-top: 20px">
                                <div class="ibox">
                                    <div class="col-md-12">
                                        <label>Products</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="ibox-content" id="products">
                                            <div class="row">
                                                <div class="col-md-8"><input required class="form-control" name="product_names[]" type="text" ></div>
                                                <div class="col-md-4"><button type="button" class="btn btn-success add-product"><i class="fa fa-plus"></i></button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top:30px; padding-bottom: 30px;">
                            <div class="row margin-l-r-0 ">
                                <div class="col-xs-12">
                                    <a class="btn btn-white" onClick="backToDash()">Cancel</a>
                                    <button class="btn btn-success" type="submit">Save Supplier</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="col-sm-12">
                                <h5>Current Suppliers</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row margin-l-r-0 ">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped" id="supplierlist">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Sort</th>
                                                    <th>Products</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
<?php
if (!empty($result)) {
    ?>
                                                <?php
                                                foreach ($result as $carrier) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $carrier['supplier_name']; ?></td>
                                                        <td><?php echo $carrier['supplier_type']; ?></td>
                                                        <td><?php echo $carrier['supplier_sort']; ?></td>
                                                        <td>
                                                            <ul>
                                                            <?php foreach($carrier['products'] as $product): ?>
                                                                <li><?= $product['name']; ?></li>
                                                            <?php endforeach; ?>
                                                                
                                                            </ul>
                                                        </td>
                                                        <td><a data-supplierid="<?php echo $carrier['_id']; ?>" class="remove-supplier btn btn-danger"> Delete</a></td>
                                                    </tr>
        <?php
    }
    ?>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var index = 0;
        function backToDash() {
            window.location.hash = '#';
        }
        var saveSupplier = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/createSupplier',
                verb: 'POST',
                data: JSON.stringify(data.body)
            });
        }
        var deleteSupplier = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/deleteSupplier/' + data.supplier_id,
                verb: 'get',
                data: JSON.stringify(data.body)
            });
        }
        $(document).ready(function () {
            $('body').off('click', '.remove-supplier').on('click', '.remove-supplier', function () {
                var elm = $(this);
                var confirmDelete = confirm('Do you want to delete this supplier?');

                if (confirmDelete) {

                    var data = {};
                    data.supplier_id = $(this).data('supplierid');

                    $.when(deleteSupplier(data)).then(function (response) {

                        if (response.meta.success) {

                            elm.closest('tr').remove();
                            toastr.success('Delete Successful', 'Server Response');
                        }
                    });
                }
            });
            <?php if(!empty($result)): ?>
            $(".table").tablesorter({sortList: [[0, 0]]});
            <?php endif; ?>
            $('body').off('click', '.add-product').on('click', '.add-product', function () {
                $('.add-product').remove();
                var row = '<div class="row">'
                        + '<div class="col-md-8"><input required class="form-control" name="product_names[]" type="text" ></div>'
                        + '<div class="col-md-4"><button type="button" class="btn btn-success add-product"><i class="fa fa-plus"></i></button> <button type="button" class="btn btn-danger remove-product"><i class="fa fa-trash"></i></button></div>'
                        + '</div>';
                $('#products').append(row);
            });
            $('body').off('click', '.remove-product').on('click', '.remove-product', function () {
                $(this).closest('.row').prev('.row').find('.col-md-4').prepend('<button type="button" class="btn btn-success add-product"><i class="fa fa-plus"></i></button></div>');
                $(this).closest('.row').remove();
            });
            $('body').off('submit', '#supplierform').on('submit', '#supplierform', function (e) {

                e.preventDefault()
                var form = $(this);

                form.parsley().validate();

                if (form.parsley().isValid()) {
                    var data = {};
                    var formData = form.serializeObject();
                    formData._id = $('#supplierId').data('supplierId');
                    data.body = formData;

                    $.when(saveSupplier(data)).then(function (response) {

                        if (response.meta.success) {

                            var data = response.data;

                            $('#supplierId').data('supplierId', data._id);
                            var products = '';
                            
                            $.each(data.products, function(index, product){
                                
                                products += '<li>'+product.name+'</li>';
                            });
                            
                            resetForm();
                            $('#supplierlist').append('<tr>'
                                    + '<td>' + data.supplier_name + '</td>'
                                    + '<td>' + data.supplier_type + '</td>'
                                    + '<td>' + data.supplier_sort + '</td>'
                                    + '<td><ul>' + products + '</ul></td>'
                                    + '<td><a data-supplierid="' + data._id + '" class="remove-supplier btn btn-danger"> Delete</a></td>'
                                    + '</tr>');
                            
                            var lastSortValue = $('select[name="supplier_sort"]').find('option:last').val();
                            
                            form.find('select').append('<option value="'+(++lastSortValue)+'">'+lastSortValue+'</option>')
                            toastr.success('Save Successful', 'Server Response');
                        }
                    });
                }
            });
        });
        var resetForm = function () {

            $('#supplierform input').val('');
            $('#products').html('<div class="row">'
                    + '<div class="col-md-8"><input required class="form-control" name="product_names[]" type="text" ></div>'
                    + '<div class="col-md-4"><button type="button" class="btn btn-success add-product"><i class="fa fa-plus"></i></button></div>'
                    + '</div>');
        }
    </script>