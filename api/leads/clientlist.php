<div class=" animated fadeInRight">

    <div class="small-header margin-l-r-0 row wrapper border-bottom white-bg page-heading ng-scope">

        <div class="col-xs-4">

            <h2><?php echo $result['page_label']; ?></h2>

            <ol class="breadcrumb">

                <li><a href="#">Home</a></li>

                <li class="active">

                    <span><?php echo $result['page_label']; ?></span>

                </li>

            </ol>

        </div>

        <div class="col-xs-8">

            <div class="title-action">
                <a href="#client/create" class="btn btn-success btn-sm">Create a Client</a>
                <?php if ((strtoupper($_SESSION['api']['user']['permissionLevel']) == "ADMINISTRATOR")) : ?>
                    <a href="api/leads/export-clients" target="_blank" class="btn btn-sm btn-primary ">Export</a>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php

function getValues($var, $arr) {

    if (!empty($arr[$var])) {

        return $arr[$var];
    }

    return false;
}

if ($result['page_label'] == "Customers") {

    $linkPage = "clients";

    $linkType = "clients";

    $searchURI = "clients";
} else {

    $linkPage = "lead";

    $linkType = "leads";

    $searchURI = "";
}
?>

<script>

    $(document).ready(function () {
    var url = window.location.href;
    var segments = url.split('/');
    var params = '';
    if (segments.length == 6) {
    params = "&" + segments[5];
    }
    // alert(params);
    // Attach a submit handler to the form

    $("#searchForm").submit(function (event) {

    // Stop form from submitting normally

    event.preventDefault();
    $.ajax({
    url: $(this).attr("action"),
            type: 'GET',
            data: $(this).serialize() + params,
            success: function (result) {

            $("#results").empty().append(result);
            console.log("done");
            }

    });
    });
    });</script>

<div class="m-20-15 row  animated fadeInRight">

    <div class="ibox float-e-margins">
        <div class="ibox-title">

            <div>

                <h4>Leads</h4>

            </div>

        </div>
        <div class="ibox-content hblue">

            <?php
            echo "<table class='table data-table table-bordered table-striped'>";

            echo '<thead><th >Name</th>

<th >Created</th>

<th >Assigned</th>

<th >Lead Source</th>

<th >City, State</th>

<th >Products</th>

<th >Actions</th>

</th></thead>';

            echo "</table>";
            ?>

        </div>

    </div>

</div>
<div class="modal inmodal in" id="assignAgentModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content animated bounceInRight">
            <form id="assignAgenForm" data-parsley-validate>

                <div class="modal-body" id="assurantDirectLinkModalList">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <div class="">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-12 col-md-12">
                                                <div class="form-group ">
                                                    <label>
                                                        Select  Agent 
                                                    </label>
                                                    <div class="input-group col-xs-12">
                                                        <select name="agents" multiple class="chosen-select form-control">
                                                            <?php if(!empty($result['users'])): foreach ($result['users'] as $user): ?>
                                                                <option value="<?= $user['_id']; ?>"><?= $user['firstname'] . ' ' . $user['lastname']; ?></option>
                                                            <?php endforeach; endif;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="pull-right"><button type="button" class="btn btn-white" data-dismiss="modal">Close</button> <button type="submit" class="btn btn-success">Submit</button></div>

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

    </div>

</div>
<script>

    var deleteLead = function (data) {

    return requestApi({
    url: '<?php echo $settings['base_uri']; ?>api/leads/delete/' + data.lead_id,
            verb: 'get',
            data: JSON.stringify(data.body)
    });
    }
    var assignLeads = function (data) {
    return requestApi({
    url: '<?php echo $settings['base_uri']; ?>api/leads/assign',
            verb: 'post',
            data: JSON.stringify(data.body)
    });
    }
    $(document).ready(function () {
    $(".chosen-select").chosen({width:'100%', placeholder_text_multiple:'Select Agents'});
    $('.data-table').DataTable({
        "initComplete" : function() {
        var input = $('.dataTables_filter input').unbind(),
            self = this.api(),
            $searchButton = $('<button class="btn btn-success">')
                       .text('search')
                       .click(function() {
                          self.search(input.val()).draw();
                       })
        $('.dataTables_filter').append($searchButton);
        input.keypress(function(e) {
                if (e.which == 13) {
                    self.search(input.val()).draw();
                }
           });
    },
            "oLanguage": {
            "sProcessing": "<img src='<?php echo $settings['base_uri']; ?>img/loading.gif'>" 
        },
        "order": [[ 1, "desc" ]],
        "processing" : true,
        "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"<?php echo $settings['base_uri']; ?>api/leads/data/", // json datasource 
            type: "post",  // type of method  , by default would be get
            error: function(){  // error handling code
              $("#employee_grid_processing").css("display","none");
            }, 
            data: function(d) {
                    d.start_date = '<?= $_GET['start_date']; ?>';
                    d.end_date = '<?= $_GET['end_date']; ?>';
                    d.user_id = '<?= $_GET['user_id']; ?>';
                    d.client = 'true';
                }
          },
<?php if ($_SESSION['api']['user']['permissionLevel'] == 'ADMINISTRATOR' || $_SESSION['api']['user']['permissionLevel'] == 'MANAGER'): ?>
        dom: 'lBfrtip',
                buttons: [
                <?php
                if(!empty($_GET['start_date'])||!empty($_GET['end_date'])||!empty($_GET['user_id'])): ?>
                
                {
                text: 'Reset Filter',
                        action: function (e, dt, node, config) {
                        window.location.hash = '#client';

                        },
                        className: 'btn btn-danger m-l-10 submissionErrors'
                }
                <?php endif; ?>                
                ],
                "lengthMenu": [[10, 25, 50], [10, 25, 50]]
<?php endif; ?>
    });

    $('body').off('click', '.delete-lead').on('click', '.delete-lead', function (e) {
    e.preventDefault();
    var elm = $(this);
    var confirmDelete = confirm('Do you want to delete this lead?');
    if (confirmDelete) {

    var data = {};
    data.lead_id = $(this).data('leadid');
    $.when(deleteLead(data)).then(function (response) {

    if (response.meta.success) {

    elm.closest('tr').remove();
    toastr.success('Delete Successful', 'Server Response');
    }
    });
    }
    });
    $('body').off('submit', '#assignAgenForm').on('submit', '#assignAgenForm', function (e) {

    e.preventDefault()

    if ($('*[name="agents"]').val() == null){
    toastr.error('Please select an agent to assign leads.');
    }
    else {
    var form = $(this);
    form.parsley().validate();
    if (form.parsley().isValid()) {
    var data = {};
    var formData = form.serializeObject();
    formData.leadIds = [];
    $('.assignLead').each(function () {

    if ($(this).is(':checked')) {

    formData.leadIds.push($(this).data('leadid'));
    }
    });
    data.body = formData;
    $.when(assignLeads(data)).then(function (response) {

    if (response.meta.success) {

    $('#assignAgentModal').modal('hide');
    window.location.reload(true);
    toastr.success('Save Successful', 'Server Response');
    }
    });
    }
    }

    });
    });

</script>