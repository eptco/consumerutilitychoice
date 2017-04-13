<?php
//echo "<span style='color:white'>".date("m-d-Y H:i:s")."</span>";
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $settings['site_name'];?></title>
		<script>
			var base_uri = "<?php echo $settings['base_uri'];?>";
		</script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="css/animate.css" rel="stylesheet">
		<link href="css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="css/plugins/fullcalendar/classic.css" rel="stylesheet">
		<link href="css/plugins/fullcalendar/classic.date.css" rel="stylesheet">
		<link href="css/plugins/fullcalendar/classic.time.css" rel="stylesheet">
		<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
		<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="css/plugins/summernote/bootstrap-tagsinput.css" rel="stylesheet">
		<link href="css/plugins/chosen/chosen.css" rel="stylesheet">
		<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
		<link href="js/jqueryui/jquery-ui.min.css" rel="stylesheet">
		<!-- Morris -->
		<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
		<!-- Gritter -->
		<link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
		<!-- Summernote -->
		<link href="css/plugins/summernote/summernote.css" rel="stylesheet">
		<link href="css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

        <script src="js/plugins/html5media/html5media.min.js"></script>

		<link href="css/style.css" rel="stylesheet">
		<link href="assets/vendor/metisMenu/dist/metisMenu.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/vendor/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
		<link rel="stylesheet" href="assets/vendor/pe-icon-7-stroke/css/helper.css" />
		
		<link href="assets/custom.css" rel="stylesheet">
		<script src="js/handlebars.js"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=<?= $settings['google_maps_api_key']; ?>&libraries=places"></script>
	</head>
	<body class="top-navigation" >
		<div id="wrapper">
			<div id="page-wrapper" class="gray-bg">
				<div class="modal inmodal" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div id="uniMod" class="modal-content animated bounceIn">
						</div>
					</div>
				</div>
				<div class="row border-bottom white-bg" >
					<nav class="navbar navbar-fixed-top" role="navigation">
						<div class="color-line">
						</div>
						<div class="navbar-header">
							<a class="navbar-toggle tab-4Icon">
								<i class="fa fa-question"></i>
							</a>
							<a class="navbar-toggle tab-3Icon">
								<i class="fa fa-calendar-o"></i>
							</a>
							<a class="navbar-toggle tab-2Icon">
								<i class="fa fa-envelope"></i>
							</a>
							<a class="navbar-toggle tab-1Icon">
								<i class="fa fa-comments"></i>
							</a>
							<span class="navbar-brand"><img src="img/logo.png" alt="Logo"></span>
<div class="header-link hide-menu mobile-only"><i class="fa fa-bars"></i></div>
						</div>
						<div class="" id="navbar">
							<ul class="nav navbar-nav block-1">
								<li>
									<div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
								</li>
								<li>
									<div id="leads-search" role="search" class="navbar-form-custom"  _lpchecked="1">
					<div class="form-group"><input type="text" placeholder="Search something special" class="form-control" name="search"></div>
				</div>
								</li>
							</ul>
							<ul class="nav navbar-top-links navbar-right hidden-sm hidden-xs">
                                 <li >

									<a id="tab-Phone" class="tab-Phone count-info">
		    							<i id="phoneStatusIcon" class="pe-7s-call"></i>
	    							</a>
								</li>
								<li >
									<a class="count-info dropdown-toggle" data-toggle="dropdown">
										<i class="pe-7s-attention" style="margin-right:0;"></i>
									</a>
                                                                    <ul id="tracker" class="dropdown-menu hdropdown notification animated flipInX">
                                                                        <li class="summary"><a href="#" id="tab-4Icon" class="tab-4Icon">View All</a></li>
                                                                        <li class="summary"><a class="createIssue ">Create A Ticket</a></li>
                                                                    </ul>
								</li>
								<li >
                                                                    <a href="#calendar" class=" count-info">
										<i class="pe-7s-date" style="margin-right:0;"></i>
									<span id="appointmentCounter" class="label label-warning bounce animated"></span>
									</a>
								</li>
								<li >
									<a id="tab-2Icon" class="tab-2Icon count-info" data-toggle="tooltip" data-placement="top" title="Mail">
										<i class="pe-7s-mail" style="margin-right:0;"></i>
									<span id="mailCounter" class="label label-warning bounce animated"></span>
									</a>
								</li>																								
								<li >
									<a id="tab-1Icon" class="tab-1Icon count-info" data-toggle="tooltip" data-placement="top" title="Chat">
										<i class="pe-7s-upload pe-7s-chat" style="margin-right:0;"></i>
									<span id="chatCounter" class="label label-warning bounce animated"></span>
									</a>
								</li>
								<li>
									<a href="<?php echo $settings['base_uri'];?>api/auth/logout">
										<i class="pe-7s-upload pe-rotate-90"></i>
									</a>
								</li>
							</ul>
						</div>
					</nav>
					<div id="toastr"></div>
				</div>
		<aside id="menu">
			<div id="navigation">
				<div class="profile-picture">
					<div class="stats-label text-color">
						<div class="dropdown">
							<span class="font-extra-bold font-uppercase">Consumer utility CRM</span>
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">
								<small class="text-muted"> <b class="caret"></b></small>
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
                            	<li><a href="#">Contacts</a></li>
								<li><a href="#admin/user/edit/<?= $_SESSION['api']['user']['_id']; ?>">Profile</a></li>
								<li><a href="#admin/user/edit/<?= $_SESSION['api']['user']['_id']; ?>">Change Password</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo $settings['base_uri'];?>api/auth/logout">Logout</a></li>
							</ul>
						</div>
						<div id="sparkline1" class="small-chart m-t-sm"></div>
						<div>
							<h4 class="font-extra-bold m-b-xs">
								$260 104,200
							</h4>
							<small class="text-muted">Your income from the last year in sales product X.</small>
						</div>
					</div>
				</div>
                                <ul class="nav" id="side-menu">
		            <li class="active">
		                <a href="#"> <span class="nav-label">Dashboard</span> <span class="label label-success pull-right">v.1</span> </a>
		            </li>
<!--                    <li>
						<a href="#news"><span class="nav-label">News</span></a>
					</li> -->
                   	<li>
                        <a href="#"><span class="nav-label">Leads</span><span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                                                        <li><a href="#lead">All Leads</a></li>
                                                        <li><a href="#lead/create">Create</a></li>
                                                        <li><a href="#lead/import">Import Leads</a></li>
                                                    </ul>
                    </li>
                                        <li>
                        <a href="#">Customers<span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                                                        <li><a href="#clients">All Customers</a></li>
                                                        <li><a href="#clients/create">Create</a></li>
                                                        <li><a href="#">Follow Up</a></li>
                                                    </ul>
                    </li>
                                        <li>
                        <a href="#"><span class="nav-label">Products</span><span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                        <li><a href="#products">All Products</a></li>
                                                        <li><a href="#products/create">Create</a></li>
                                                    </ul>
                    </li>
                                       
                    <li>
                        <a href="#reports"><span class="nav-label">Reports</span> </a>

                    </li>
							    <?php
                                  if((!empty($_SESSION['api']['user']['permissionLevel'])) && ((strtoupper($_SESSION['api']['user']['permissionLevel']) == "ADMINISTRATOR")) ){
                                ?>
                                    <li>
                                        <a href="#" class="confirmation">Settings<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                <li><a href="#">Dropdowns<span class="fa arrow"></span></a>
                                                    <ul class="nav nav-third-level">
                                                        <li><a href="#admin/leadsources">Lead Sources</a></li>
                                                        <li><a href="#admin/statuslist">Status List</a></li>
                                                        <li><a href="#admin/carriers/list">Supplier List</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#admin/scripts/list">Scripts</a></li>                                                
                                                <li><a href="#admin/usergroups">User Groups</a></li>
                                                <li><a href="#admin/user/list">User List</a></li>
                                                <li><a href="#sms/templates">SMS Manager</a></li>
                                                <li><a href="#admin/sendinblue/templates">Sendinblue Email</a></li>
                                                <li><a href="#admin/sendinblue/sms/templates">Sendinblue SMS</a></li>
                                                
                                                
                                                
                                            </ul>
                                    </li>
                                <?php } ?>
								<li>
									<a href="docs" target='_blank' class="confirmation">Docs</a>
								</li>
                    		        </ul>
                			</div>
		</aside>

				<div class="wrapper wrapper-content" style="top: 21px;">
						<!-- Load API INFO HERE-->
						<div id="results"></div>
				</div>
			</div>
<!-- 			<div class="footer">
				<div class="pull-right">
					<?php echo date("l F j, Y");?>
				</div>
				<div>
					<strong>Copyright</strong> EBrokerCenter &copy; <?php echo date("Y");?>
				</div>
			</div> -->
		</div>
		<!-- Mainly scripts -->
		<script src="js/jquery-2.1.1.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jqueryui/jquery-ui.min.js"></script>
		<script src="js/jqueryui/jquery.ui.datepicker.js"></script>
		<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<!-- Routes -->
		<script src="js/routie.js"></script>
		<script src="js/routes.js"></script>
		<!-- Custom and plugin javascript -->
		<script src="js/inspinia.js"></script>
		<script src="js/plugins/pace/pace.min.js"></script>
		<!-- Flot -->
		<script src="js/plugins/flot/jquery.flot.js"></script>
		<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
		<script src="js/plugins/flot/jquery.flot.spline.js"></script>
		<script src="js/plugins/flot/jquery.flot.resize.js"></script>
		<script src="js/plugins/flot/jquery.flot.pie.js"></script>
		<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
		<script src="js/plugins/flot/jquery.flot.time.js"></script>
		<!-- Jvectormap -->
		<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
		<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- EayPIE -->
		<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>
		<!-- Summernote -->
		<script src="js/plugins/summernote/summernote.min.js"></script>
		<script src="js/plugins/summernote/bootstrap-tagsinput.min.js"></script>
		<!-- Calendar -->
		<script src="js/plugins/fullcalendar/moment.min.js"></script>
		<script src="js/plugins/fullcalendar/picker.js"></script>
		<script src="js/plugins/fullcalendar/picker.date.js"></script>
		<script src="js/plugins/fullcalendar/picker.time.js"></script>
		<script src="js/plugins/chosen/chosen.jquery.js"></script>
		<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
		<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
		<script src="js/plugins/idle-timer/idle-timer.min.js"></script>
		<script src="js/plugins/toastr/toastr.min.js"></script>
		<script src="api/calendar/notificationsApi.js"></script>

		<!-- Table Sorter -->
		<script type="text/javascript" src="js/plugins/tablesorter/tablesorter.js"></script>
		<!-- Chat -->
		<script src="js/plugins/chat/firebase.js"></script>
		<!-- Calendar -->
		<script src="api/calendar/calendarApi.js"></script>
		<!-- Twilio -->
		<script src="api/twilio/twilioApi.js"></script>
		<!-- iCheck -->
		<script src="js/plugins/iCheck/icheck.min.js"></script>
		<script src="assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
		<script src="assets/vendor/sparkline/index.js"></script>
                <script src="assets/vendor/parsley.min.js"></script>
                <script src="assets/vendor/jquery.mask.min.js"></script>
                <script src="assets/vendor/jquery.dataTables.min.js"></script>
                <script src="assets/vendor/dataTables.buttons.min.js"></script>
		<script src="assets/helpers.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
                $.ajax({
        			url: "<?php echo $settings['base_uri'];?>api/vicidialer/getagentstatus/<?php echo trim($_SESSION['api']['user']['extension']);?>",
        			success: function(data) {
console.log(data[0]);
                    console.log(data);
        				if(data['response'] == "PAUSED"){
                            console.log("PAUSED!");
                        }
        			}
        		});
				$(document).tooltip();
				//$.get(base_uri + 'api/chat',function(data){$(data).appendTo('#wrapper');});
				$.get(base_uri + 'api/sidebar',function(data){$(data).appendTo('#wrapper');});
				$(document).idleTimer({
					timeout: 2400000 * 55,
				});
				$(document).on("idle.idleTimer", function(event, elem, obj) {
					var count = 10;
					event.stopImmediatePropagation();
					var counter = setInterval(function() {
						count = count - 1;
						if (count <= 0) {
							clearInterval(counter);
							toastr.clear();
							window.location = 'api/auth/logout';
							toastr.info('Logged Out');
							toastr.options = {
								'timeOut': 10000,
								"showDuration": 1000,
								"hideDuration": 1000,
								"progressBar": true,
								'debug': false,
								"preventDuplicates": true,
							};
							return;
						}
						document.getElementById("timer").innerHTML = count;
						$(document).on("active.idleTimer", function(event, elem, obj, triggerevent) {
							clearInterval(counter);
							toastr.clear();
						});
					}, 1000);
					toastr.error('Logout in <span id="timer">10</span> seconds!!', 'Idle Detected', {
						'timeOut': 10000,
						"showDuration": 1000,
						"hideDuration": 1000,
						"progressBar": true,
						'debug': false,
						"preventDuplicates": true,
					});
				});
				$(".chosen-select").chosen({
					width: '100%'
				});
				$(".datepicker").pickadate({
					format: 'mm-dd-yyyy',
					min: '01-01-1920',
					max: '01-01-2020',
					selectYears: 100,
					selectMonths: true,
				});
				$(".timepicker").pickatime({
					format: 'h:i A'
				});

    // Initialize metsiMenu plugin to sidebar menu
    $('#side-menu').metisMenu();
    	$('.header-link').click(function(){

    		if($('#menu').hasClass('menu-close')) {

    			$('#menu, .navbar-brand, .wrapper-content').removeClass('menu-close');
    			$('#menu, .navbar-brand, .wrapper-content').addClass('menu-open');
    		} else {

    			$('#menu, .navbar-brand, .wrapper-content').removeClass('menu-open');
    			$('#menu, .navbar-brand, .wrapper-content').addClass('menu-close');
    		}
		
	});
    $("#sparkline1").sparkline([5, 6, 7, 2, 0, 4, 2, 4, 5, 7, 2, 4, 12, 11, 4], {
        type: 'bar',
        barWidth: 7,
        height: '30px',
        barColor: '#62cb31',
        negBarColor: '#53ac2a'
    });

    $("#leads-search input").keypress(function(e) {
	    if(e.which == 13) {
	        window.location.href = '#lead';
	        
	    }
    }); 
			});

		</script>
	</body>
</html>