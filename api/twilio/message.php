
<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
			<form id="smsform" role="form" name="smsform">
				<input style="display:none" name="lead_id" value="<?php echo $leadId;?>">
				<div class="row">
					<div class="col-md-12">
						<label>
							Phone Number
						</label>
                                            <input class="form-control" id="toNumber" value="" name="to_number">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>
							Message
						</label>
						<select  class="chosen-select form-control">
                                                        <option value="">Custom</option>
							<?php
							foreach($templates as $template){
							?>
							<option value="<?php echo $template['template'];?>"><?php echo trimText($template['template'], $limit = 70);?></option>
							<?php
							}
                                                        
							?>
						</select>
                                            <textarea name="message" class="form-control"></textarea>
					</div>
				</div>
				<br>
				<div>
					<button id="smsSubmit" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit">Send</button>
				</div>
			</form>
		</div>
	</div>
</div>