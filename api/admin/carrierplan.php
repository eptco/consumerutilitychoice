<div class=" animated fadeInRight">
	<div class="row margin-l-r-0 small-header wrapper border-bottom white-bg page-heading ng-scope">
		<div class="col-lg-10">
			<h2>Create Carrier</h2>
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
<div class="row margin-l-r-0 m-20-15 animated fadeInRight">
	<form id="carrierPlanform" name="saveTemplateData" method="post" action="<?php echo $settings['base_uri'];?>api/admin/createCarrierPlan" class="form-horizontal ">
		<div>
			<div class="row margin-l-r-0 ">
				<div class="col-lg-12 col-xs-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<div>
								<h4>Carrier Plans</h4>
							</div>
						</div>
						<div class="ibox-content hgreen">
							<div class="row margin-l-r-0 ">
								<div class="col-md-4">
									<label>
										Plans
									</label>
									<input style="display:none" name="carrierPlan_0_createThing" value="Y">
									<input class="form-control" name="carrierPlan_0_name" type="text" >
								</div>
								<div class="col-md-4">
									<label>Sort</label>
									<select class="form-control" name="carrierPlan_0_sort" >
										<?php for($i=1; $i<=count($result); $i++){?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<div style="padding-top:30px; padding-bottom: 30px;">
							<div class="row margin-l-r-0 ">
								<div class="col-xs-12">
									<a class="btn btn-white" onClick="cancelUserInfo()">Cancel</a>
									<button id="saveButton" class="btn btn-success" type="submit">Save Carrier</button>
								</div>
							</div>
						</div>
						<?php
						if(!empty($result)){
						?>
                                                                                           <div class="ibox float-e-margins">
           <div class="ibox-title">
               <div class="col-sm-12">
						<h5>Current Plans</h5>
                                                            </div>
        <div class="ibox-content">
						<div class="row margin-l-r-0 ">
							<div class="col-md-12">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Name</th>
											<th>Sort</th>
											<th>Delete</th>
										</tr>
									</thead>
									<?php
							foreach($result as $carrier){
									?>
									<tr>
										<td><?php echo $carrier['name'];?></td>
										<td><?php echo $carrier['sort'];?></td>
										<td><a userId="<?php echo $carrier['_id'];?>" class="carrierPlanRemove btn btn-danger"> Delete</a></td>
									</tr>
									<?php
							}
									?>
								</table>
							</div>
						</div>
        </div>
						<?php
						}
						?>
					</div>
                                                                                           </div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function cancelUserInfo(){
		window.location.hash = '#admin/settings';   
	}
	$(document).ready(function() {
		var serialize = function(obj) {
			var str = [];
			for(var p in obj)
				if (obj.hasOwnProperty(p)) {
					str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
				}
			return str.join("&");
		};
		$('.carrierPlanRemove').on('click', function(){
			var usrInfo = [];
			usrInfo['carrierPlan_0_createThing']='Y';
			usrInfo['carrierPlan_0_status']='INACTIVE';
			usrInfo['carrierPlan_0_id']=$(this).attr('userId');
			$.ajax({
				url: 'api/thing/create',
				type: 'POST',
				data: serialize(usrInfo),
				success: function(result) {
					console.log(result);
					$('#results').load(base_uri + 'api/admin/plans');
				}
			});
		});
		$(".table").tablesorter({sortList:[[0,0]]});
		$('input').focus(function() {
			$(this).parent().removeClass("has-error");
		});
		$(".chosen-select").chosen({width:'100%', placeholder_text_multiple:'Select People'});
		// Attach a submit handler to the form
		$("#carrierPlanform").submit(function(event) {
			// Stop form from submitting normally
			event.preventDefault();
			console.log( $(this).serialize());
			$.post($(this).attr("action"), $(this).serialize(), function(response){
				console.log(response);
				$('#results').load(base_uri + 'api/admin/plans');
			});
		});
	});
</script>