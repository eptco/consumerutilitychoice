<div class=" animated fadeInRight">
    <div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
        <div class="col-lg-10">
            <h2>Create Script</h2>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#admin/scripts/list">Settings</a></li>
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
                    <form id="scriptform"  class="form-horizontal" data-parsley-validate>
                        <div id="scriptId" style="display:none" data-scriptid="<?= !empty($result['script']['_id']) ? $result['script']['_id'] : ''; ?>"></div>
                        <div class="ibox-content">
                            <div class="row margin-l-r-0 ">
                                <div class="col-md-6">
                                    <label>
                                        Title
                                    </label>
                                    <input required class="form-control" name="title" type="text" value="<?= $result['script']['title']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select required class="form-control" name="status" >
                                        <option value="active" <?= $result['script']['status'] == 'active'? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?= $result['script']['status'] == 'inactive'? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>   
                            </div>
                            <div class="row margin-l-r-0 ">
                                <div class="col-md-12">
                                    <label>Template</label>
                                    <textarea id="scriptTemplate" name="template"><?= $result['script']['template']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top:30px; padding-bottom: 30px;">
                            <div class="row margin-l-r-0 ">
                                <div class="col-xs-12">
                                    <a class="btn btn-white" onClick="backToScriptList()">Cancel</a>
                                    <button class="btn btn-success" type="submit">Save Script</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        var index = 0;
        function backToScriptList() {
            window.location.hash = '#admin/scripts/list';
        }
        var saveScript = function (data) {

            return requestApi({
                url: '<?php echo $settings['base_uri']; ?>api/admin/scripts/save',
                verb: 'POST',
                data: JSON.stringify(data.body)
            });
        }
        
        $(document).ready(function () {

        tinymce.init({
            selector: '#scriptTemplate',
            height : 500,
            theme: 'modern',
          plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
          ],
          toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
          toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
          image_advtab: true,   
          });

            $('body').off('submit', '#scriptform').on('submit', '#scriptform', function (e) {

                e.preventDefault()
                var form = $(this);

                form.parsley().validate();

                if (form.parsley().isValid()) {
                    var data = {};
                    var formData = form.serializeObject();
                    formData._id = $('#scriptId').data('scriptid');
                    data.body = formData;

                    $.when(saveScript(data)).then(function (response) {

                        if (response.meta.success) {

                            var data = response.data;

                            $('#scriptId').data('scriptid', data._id);

                            toastr.success('Save Successful', 'Server Response');
                        }
                    });
                }
                
                backToScriptList();
            });
        });
    </script>