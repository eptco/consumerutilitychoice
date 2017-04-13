<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-lg-10">
            <h2>Create a User</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#admin/user/list">Users</a></li>
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
    <form id="userform" name="userForm" method="post" class="form-horizontal ">

        <div id="userId" style="display:none" data-userid="<?= !empty($result['user']['_id']) ? $result['user']['_id'] : ''; ?>"></div>
        <div>
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="first_name">First Name</label>
                                            <input type="text" id="first_name" class="form-control" name="firstname" required aria-required="true" placeholder="First Name" value="<?= $result['user']['firstname']; ?>" >
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" id="last_name" class="form-control" name="lastname" required placeholder="Last Name" value="<?= $result['user']['lastname']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="password">Password</label>
                                            <input type="password" name="" id="password_fake" class="hidden" autocomplete="off" style="display: none;">
                                            <input type="password" id="password" class="form-control" name="password" autocomplete="off" <?= empty($result['user']['_id'])? 'required' : ''; ?>>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="passwordConf">Repeat Password</label>
                                            <input type="password" id="passwordConf" class="form-control" name="passwordConf" <?= empty($result['user']['_id'])? 'required' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">				
                                        <div class="col-lg-6">
                                            <label for="email_id">Email-Id</label>
                                            <input type="email" id="email_id" class="form-control" name="email" autocomplete="off" placeholder="name@domain.com" required value="<?= $result['user']['email']; ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="phone">Phone</label>
                                            <input type="tel" id="phone" class="form-control" name="phone" placeholder="(555) 555-5555" value="<?= $result['user']['phone']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="address">Address Line-1</label>
                                            <input type="text" name="address1" id="address1" class="form-control" value="<?= $result['user']['address1']; ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="address">Address Line-2</label>
                                            <input type="text" name="address2" id="address2" class="form-control" value="<?= $result['user']['address2']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="zip_code">Zip</label>
                                            <input type="text" id="zipcode" class="form-control" name="zipcode" placeholder="Zip Code" value="<?= $result['user']['zipcode']; ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="user_role">User Role</label>
                                            <select class="form-control" name="permissionLevel" id="user_role" required <?= ($_SESSION['api']['user']['permissionLevel'] != 'ADMINISTRATOR')? 'disabled' : ''; ?>>
                                                <option value="">Select</option>
                                                <option value="MANAGER" <?= ($result['user']['permissionLevel'] == 'MANAGER')? 'selected' : ''; ?>>Manager</option>
                                                <option value="AGENT" <?= ($result['user']['permissionLevel'] == 'AGENT')? 'selected' : ''; ?>>Agent</option>
                                                <option value="ADMINISTRATOR" <?= ($result['user']['permissionLevel'] == 'ADMINISTRATOR')? 'selected' : ''; ?>>Administrator</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6" id="commision_rate_div" style="display:none">
                                            <label for="department_id">Commission Rate</label>
                                            <select class="form-control" name="commision_rate" id="commision_rate">
                                                <option value="">Select</option>
                                                <option value="1">8.00</option>
                                                <option value="2">0.50</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top:30px; padding-bottom: 30px;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a class="btn btn-white" onClick="cancelUserInfo()">Cancel</a>
                                    <button id="saveButton" class="btn btn-success" type="submit">Save User</button>
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
    function cancelUserInfo() {
        window.location.hash = '#admin/user/list';
    }

        var saveUser = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/user/save',
                verb: 'POST',
                data: JSON.stringify(data.body)
            });
        }
    $(document).ready(function () {

        // Attach a submit handler to the form
            $('body').off('submit', '#userform').on('submit', '#userform', function (e) {

                e.preventDefault()
                var form = $(this);

                form.parsley().validate();

                if (form.parsley().isValid()) {
                    var data = {};
                    var formData = form.serializeObject();
                    formData._id = $('#userId').data('userid');
                    data.body = formData;

                    $.when(saveUser(data)).then(function (response) {

                        if (response.meta.success) {

                            var data = response.data;

                            $('#userId').data('userid', data._id);
                            cancelUserInfo();
                            toastr.success('Save Successful', 'Server Response');
                            cancelUserInfo();
                        }
                    });
                }
                
                
            });
    });
</script>