<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Lead Sources</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">
                    <span>Lead Sources</span>
                </li>
            </ol>
        </div>
        <!-- <div class="col-sm-8">
            <div class="title-action">
               <a  href="#admin/user/create" class="btn btn-primary btn-sm">Create A Lead Source</a>
            </div>
        </div> -->
        <div class="col-sm-8">
            <!--                    <div class="title-action">
                                    <a  href="#admin/usergroups/create" class="btn btn-primary btn-sm">Create Lead Source</a> 
                                   <button id="saveButton" class="btn btn-success" type="submit">Create Lead Source</button>
                                </div>-->
        </div>
    </div>
</div>
<div class="row margin-l-r-0 m-20-15 animated fadeInRight">

    <div>
        <div class="row margin-l-r-0">
            <div class="col-lg-12 col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div>
                            <h4>Create A Lead Source</h4>
                        </div>
                    </div>
                    <form id="leadsourceform" class="form-horizontal ">

                        <div class="ibox-content hgreen">
                            <div class="row margin-l-r-0">
                                <div class="col-md-6">
                                    <label>
                                        Name
                                    </label>
                                    <input class="form-control" name="name" type="text" >
                                </div>
                                <div class="col-md-6">
                                    <label>Sort</label>
                                    <select required class="form-control" name="sort" >
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
                        </div>
                        <div style="padding-top:30px; padding-bottom: 30px;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a class="btn btn-white" onClick="backToDash()">Cancel</a>
                                    <button id="saveButton" class="btn btn-success" type="submit">Save Lead Source</button>
                                </div>
                            </div>
                        </div> 
                    </form>

                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="col-sm-4">
                                <h5>Lead Source List</h5>
                            </div>

                        </div>
                        <div class="ibox-content">
                                <div class="row margin-l-r-0 ">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped" id="leadsourcelist">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Sort</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
<?php
if (!empty($result)) {
    ?>
                                                <?php
                                                foreach ($result as $leadsource) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $leadsource['name']; ?></td>
                                                        <td><?php echo $leadsource['sort']; ?></td>
                                                        <td><a data-leadsourceid="<?php echo $leadsource['_id']; ?>" class="remove-lead-source btn btn-danger"> Delete</a></td>
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
        var saveLeadSource = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/saveLeadSource',
                verb: 'POST',
                data: JSON.stringify(data.body)
            });
        }
        var deleteLeadSource = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/deleteLeadSource/' + data.leadsource_id,
                verb: 'get',
                data: JSON.stringify(data.body)
            });
        }
        $(document).ready(function () {
            $('body').off('click', '.remove-lead-source').on('click', '.remove-lead-source', function () {
                var elm = $(this);
                var confirmDelete = confirm('Do you want to delete this lead source?');

                if (confirmDelete) {

                    var data = {};
                    data.leadsource_id = $(this).data('leadsourceid');

                    $.when(deleteLeadSource(data)).then(function (response) {

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

            $('body').off('submit', '#leadsourceform').on('submit', '#leadsourceform', function (e) {

                e.preventDefault()
                var form = $(this);

                form.parsley().validate();

                if (form.parsley().isValid()) {
                    var data = {};
                    var formData = form.serializeObject();
                    data.body = formData;

                    $.when(saveLeadSource(data)).then(function (response) {

                        if (response.meta.success) {

                            var data = response.data
                            
                            resetForm();
                            $('#leadsourcelist').append('<tr>'
                                    + '<td>' + data.name + '</td>'
                                    + '<td>' + data.sort + '</td>'
                                    + '<td><a data-leadsourceid="' + data._id + '" class="remove-lead-source btn btn-danger"> Delete</a></td>'
                                    + '</tr>');
                            
                            var lastSortValue = $('select[name="sort"]').find('option:last').val();
                            
                            form.find('select').append('<option value="'+(++lastSortValue)+'">'+lastSortValue+'</option>')
                            toastr.success('Save Successful', 'Server Response');
                        }
                    });
                }
            });
        });
        var resetForm = function () {

            $('#leadsourceform input').val('');
        }
</script>