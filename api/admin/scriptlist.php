<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading">
                 <div class="col-sm-4">
                    <h2>Sales Scripts</h2>
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">
                            <span>Scripts</span>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                       <a  href="#admin/scripts/create" class="btn btn-success btn-sm">Create A Script</a>
                    </div>
                </div>
</div>
</div>
<div class="row margin-l-r-0 m-20-15 animated fadeInRight">
    <div class="ibox float-e-margins">
           <div class="ibox-title">
               <div class="col-sm-4">
                <h5>Script List</h5>
                </div>
            </div>
        <div class="ibox-content hgreen">
<!--                <div class="title-action">
                		<a href="#admin/scripts/list/INACTIVE" class="btn btn-info btn-sm">Inactive Scripts</a>
                		<a href="#admin/scripts/list" class="btn btn-primary btn-sm">Active Scripts</a>
                </div>-->
            <?php
echo "<table class='table table-bordered table-striped'>";
echo "<thead><tr><th>Title</th><th>Summary</th><th>Status</th><th>Actions</th></thead>";
if(!empty($result['scripts'])){
    foreach ($result['scripts'] as $key => $value){        
         echo "<tr><td><a href='#admin/scripts/edit/".$value['_id']."'>".$value['title']."</td><td>".trimText($value['template'])."</td><td>".$value['status']."</td><td><a href='#admin/scripts/edit/".$value['_id']."' ><i class='fa fa-pencil'></i></a> <a class='delete-script' href='#' data-scriptid='".$value['_id']."' ><i class='fa fa-trash'></i></a></td></tr>";
    }
}
echo "</table>";
?>
        </div>
    </div>
</div>
<script>

        var deleteScript = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/scripts/delete/' + data.script_id,
                verb: 'get',
                data: JSON.stringify(data.body)
            });
        }
    $(document).ready(function() {

        $(".table").tablesorter();
        
            $('body').off('click', '.delete-script').on('click', '.delete-script', function (e) {
                e.preventDefault();
                var elm = $(this);
                var confirmDelete = confirm('Do you want to delete this script?');
                
                if (confirmDelete) {

                    var data = {};
                    data.script_id = $(this).data('scriptid');

                    $.when(deleteScript(data)).then(function (response) {

                        if (response.meta.success) {

                            elm.closest('tr').remove();
                            toastr.success('Delete Successful', 'Server Response');
                        }
                    });
                }
            });        

    });

    </script>