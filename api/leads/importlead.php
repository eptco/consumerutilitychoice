<div class=" animated fadeInRight">

    <div class="small-header margin-l-r-0 row wrapper border-bottom white-bg page-heading ng-scope">

        <div class="col-xs-4">

            <h2><?php echo $result['page_label']; ?></h2>

            <ol class="breadcrumb">

                <li><a href="#">Home</a></li>

                <li><a href="#lead">Leads</a></li>

                <li class="active">

                    <span>Import lead</span>

                </li>

            </ol>

        </div>

        <div class="col-xs-8">



        </div>

    </div>

</div>
<div class="m-20-15 row  animated fadeInRight">

    <div class="ibox float-e-margins">
        <div class="ibox-title">

            <div>

                <h4>Import Leads</h4>

            </div>

        </div>
        <div class="ibox-content hblue">
            <form id="importLeadsForm">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Lead File *</label>
                        <input required="" type="file" id="file" name="file"><br>                                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="#leads" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </form>

        </div>

    </div>

</div>

<script>

    var importLeads = function (data) {

        return $.ajax({
            url: '<?php echo $settings['base_uri']; ?>api/leads/uploadLeadFile', // point to server-side PHP script 
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function (jsonObj) {

                if (!jsonObj.meta.success) {

                    if (jsonObj.data.errors.type == 'validation') {

                        var errors = '';
                        for (var key in jsonObj.data.errors.array) {

                            if (jsonObj.data.errors.array.hasOwnProperty(key)) {

                                $(jsonObj.data.errors.array[key]).each(function (index, item) {

                                    errors += item + '<br \>';
                                });
                            }
                        }
                        toastr.error(errors);
                    } else {

                        toastr.error(jsonObj.data.errors.message);
                    }


                }
            },
            error: function () {


                toastr.error('Server error: Try again later.');
            }
        });
    }
    $(document).ready(function () {


        $('body').off('submit', '#importLeadsForm').on('submit', '#importLeadsForm', function (e) {

            e.preventDefault()
            var data = {};
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append("file", file_data)
            var form = $(this);
            form.parsley().validate();
            if (form.parsley().isValid()) {

                $.when(importLeads(form_data)).then(function (response) {

                    if (response.meta.success) {

                        toastr.success('Save Successful', 'Server Response');
                        window.location.hash = '#leads';
                    }
                });
            }


        });
    });

</script>