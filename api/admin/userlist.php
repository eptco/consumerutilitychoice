<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Users</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">
                    <span>Users</span>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a  href="#admin/user/create" class="btn btn-success btn-sm">Create A User</a>
            </div>
        </div>
    </div>
</div>
<div class="row margin-l-r-0 m-20-15 animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-4">
                <h5>User List</h5>
            </div>
        </div>
        <div class="ibox-content hgreen">
            <div class="title-action">
                <a href="#admin/user/list/INACTIVE" class="btn btn-info btn-sm">Inactive Users</a>
                <a href="#admin/user/list" class="btn btn-primary btn-sm">Active Users</a>
            </div>
            <?php
            echo "<table class='table data-table table-bordered table-striped'>";
            echo "<thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th></thead>";
            if (!empty($result['users'])) {
                foreach ($result['users'] as $key => $value) {
                    echo "<tr><td><a href='#admin/user/edit/" . $value['_id'] . "'>" . $value['firstname'] . " " . $value['lastname'] . "</td><td>" . $value['email'] . "</td><td>" . $value['phone'] . "</td><td>" . strtoupper($value['status']) . "</td><td><a href='#admin/user/edit/" . $value['_id'] . "' ><i class='fa fa-pencil'></i></a> <a class='delete-user' href='#' data-userid='" . $value['_id'] . "' ><i class='fa fa-trash'></i></a></td></tr>";
                }
            }
            echo "</table>";
            ?>
        </div>
    </div>
</div>
<script>
    var deleteUser = function (data) {

        return requestApi({
            url: '<?php echo $settings['base_uri']; ?>api/admin/user/delete/' + data.user_id,
            verb: 'get',
            data: JSON.stringify(data.body)
        });
    }
    $(document).ready(function () {
        $('.data-table').DataTable();
        $('body').off('click', '.delete-user').on('click', '.delete-user', function (e) {
            e.preventDefault();
            var elm = $(this);
            var confirmDelete = confirm('Do you want to delete this user?');

            if (confirmDelete) {

                var data = {};
                data.user_id = $(this).data('userid');

                $.when(deleteUser(data)).then(function (response) {

                    if (response.meta.success) {

                        elm.closest('tr').remove();
                        toastr.success('Delete Successful', 'Server Response');
                    }
                });
            }
        });
    });

</script>