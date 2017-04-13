<?php

function widget($widget, $label_color = "success") {
    $return_string = '';
    $return_string .= '<div class="hpanel">';
    $return_string .= '<div class="panel-body">';
    //$return_string .= '<span class="label label-'.$label_color.' pull-right">'.$widget['time'].'</span>';
    $return_string .= '<h3><b>' . $widget['label'] . '</b></h5>';
    $return_string .= '<hr color="#666666">';
    $return_string .= '<h1 class="m-xs">' . $widget['amount'] . '</h1>';
    $return_string .= '<small class="text-left">' . $widget['note'] . '</small>';
    $return_string .= '<small style="color:#FF0000; margin-left:60px;">' . $widget['percent'] . '</small>';
    $return_string .= '</div>';
    $return_string .= '<div class="panel-footer">&nbsp;</div>';
    $return_string .= '</div>';
    return $return_string;
}

$result['duration'] = (!empty($result['duration'])) ? $result['duration'] : '1';
$duration_label = array('1' => 'Today', 'week' => 'Week', 'preweek' => 'Last Week', '30' => 'Month', '60' => '60 Days');
?>
<div class="container">
    <div class=" animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            Dashboard information and statistics
                        </div>
                        <div class="panel-tools">
                            <div class="pull-right">

                                <a href="#dashboard/1" class="btn btn-xs btn-default <?= ($result['duration'] == '1' || $result['duration'] === null) ? 'active' : ''; ?>">Today</a>
                                <a href="#dashboard/week" class="btn btn-xs btn-default <?= ($result['duration'] == 'week') ? 'active' : ''; ?>">This Week</a>
                                <a href="#dashboard/preweek" class="btn btn-xs btn-default <?= ($result['duration'] == 'preweek') ? 'active' : ''; ?>">Last Week</a>
                                <a href="#dashboard/30" class="btn btn-xs btn-default <?= ($result['duration'] == '30') ? 'active' : ''; ?>">Month</a>
                                <a href="#dashboard/60" class="btn btn-xs btn-default <?= ($result['duration'] == '60') ? 'active' : ''; ?>">60 Days</a>
                                <!-- <a href="javascript:void(0)" onclick="show_data('ytd')" class="btn btn-xs btn-default">YTD</a> -->

                            </div>
                            <div class="col-md-12 pull-right" id="year_to_time" style="display:none; margin-top:5px; margin-bottom:5px;">
                                <div class="col-md-7 text-right"></div>
                                <div class="col-md-5 text-right">
                                    <div class="col-md-5 text-right">
                                        <input type="text" name="start_date_manual" id="start_date_manual" class="form-control datepicker picker__input" placeholder="Start Date" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="start_date_manual_root"><div class="picker" id="start_date_manual_root" aria-hidden="true"><div class="picker__holder" tabindex="-1"><div class="picker__frame"><div class="picker__wrap"><div class="picker__box"><div class="picker__header"><select class="picker__select--year" disabled="" aria-controls="start_date_manual_table" title="Select a year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017" selected="">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option></select><select class="picker__select--month" disabled="" aria-controls="start_date_manual_table" title="Select a month"><option value="0">January</option><option value="1">February</option><option value="2" selected="">March</option><option value="3">April</option><option value="4">May</option><option value="5">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select><div class="picker__nav--prev" data-nav="-1" role="button" aria-controls="start_date_manual_table" title="Previous month"> </div><div class="picker__nav--next" data-nav="1" role="button" aria-controls="start_date_manual_table" title="Next month"> </div></div><table class="picker__table" id="start_date_manual_table" role="grid" aria-controls="start_date_manual" aria-readonly="true"><thead><tr><th class="picker__weekday" scope="col" title="Sunday">Sun</th><th class="picker__weekday" scope="col" title="Monday">Mon</th><th class="picker__weekday" scope="col" title="Tuesday">Tue</th><th class="picker__weekday" scope="col" title="Wednesday">Wed</th><th class="picker__weekday" scope="col" title="Thursday">Thu</th><th class="picker__weekday" scope="col" title="Friday">Fri</th><th class="picker__weekday" scope="col" title="Saturday">Sat</th></tr></thead><tbody><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488047400000" role="gridcell" aria-label="02/26/2017">26</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488133800000" role="gridcell" aria-label="02/27/2017">27</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488220200000" role="gridcell" aria-label="02/28/2017">28</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488306600000" role="gridcell" aria-label="03/01/2017">1</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488393000000" role="gridcell" aria-label="03/02/2017">2</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488479400000" role="gridcell" aria-label="03/03/2017">3</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488565800000" role="gridcell" aria-label="03/04/2017">4</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488652200000" role="gridcell" aria-label="03/05/2017">5</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488738600000" role="gridcell" aria-label="03/06/2017">6</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488825000000" role="gridcell" aria-label="03/07/2017">7</div></td><td role="presentation"><div class="picker__day picker__day--infocus picker__day--today picker__day--highlighted" data-pick="1488911400000" role="gridcell" aria-label="03/08/2017" aria-activedescendant="true">8</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488997800000" role="gridcell" aria-label="03/09/2017">9</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489084200000" role="gridcell" aria-label="03/10/2017">10</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489170600000" role="gridcell" aria-label="03/11/2017">11</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489257000000" role="gridcell" aria-label="03/12/2017">12</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489343400000" role="gridcell" aria-label="03/13/2017">13</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489429800000" role="gridcell" aria-label="03/14/2017">14</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489516200000" role="gridcell" aria-label="03/15/2017">15</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489602600000" role="gridcell" aria-label="03/16/2017">16</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489689000000" role="gridcell" aria-label="03/17/2017">17</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489775400000" role="gridcell" aria-label="03/18/2017">18</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489861800000" role="gridcell" aria-label="03/19/2017">19</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489948200000" role="gridcell" aria-label="03/20/2017">20</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490034600000" role="gridcell" aria-label="03/21/2017">21</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490121000000" role="gridcell" aria-label="03/22/2017">22</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490207400000" role="gridcell" aria-label="03/23/2017">23</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490293800000" role="gridcell" aria-label="03/24/2017">24</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490380200000" role="gridcell" aria-label="03/25/2017">25</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490466600000" role="gridcell" aria-label="03/26/2017">26</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490553000000" role="gridcell" aria-label="03/27/2017">27</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490639400000" role="gridcell" aria-label="03/28/2017">28</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490725800000" role="gridcell" aria-label="03/29/2017">29</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490812200000" role="gridcell" aria-label="03/30/2017">30</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490898600000" role="gridcell" aria-label="03/31/2017">31</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1490985000000" role="gridcell" aria-label="04/01/2017">1</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491071400000" role="gridcell" aria-label="04/02/2017">2</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491157800000" role="gridcell" aria-label="04/03/2017">3</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491244200000" role="gridcell" aria-label="04/04/2017">4</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491330600000" role="gridcell" aria-label="04/05/2017">5</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491417000000" role="gridcell" aria-label="04/06/2017">6</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491503400000" role="gridcell" aria-label="04/07/2017">7</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491589800000" role="gridcell" aria-label="04/08/2017">8</div></td></tr></tbody></table><div class="picker__footer"><button class="picker__button--today" type="button" data-pick="1488911400000" disabled="" aria-controls="start_date_manual">Today</button><button class="picker__button--clear" type="button" data-clear="1" disabled="" aria-controls="start_date_manual">Clear</button><button class="picker__button--close" type="button" data-close="true" disabled="" aria-controls="start_date_manual">Close</button></div></div></div></div></div></div>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        <input type="text" name="end_date_manual" id="end_date_manual" class="form-control datepicker picker__input" placeholder="End Date" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="end_date_manual_root"><div class="picker" id="end_date_manual_root" aria-hidden="true"><div class="picker__holder" tabindex="-1"><div class="picker__frame"><div class="picker__wrap"><div class="picker__box"><div class="picker__header"><select class="picker__select--year" disabled="" aria-controls="end_date_manual_table" title="Select a year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017" selected="">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option></select><select class="picker__select--month" disabled="" aria-controls="end_date_manual_table" title="Select a month"><option value="0">January</option><option value="1">February</option><option value="2" selected="">March</option><option value="3">April</option><option value="4">May</option><option value="5">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select><div class="picker__nav--prev" data-nav="-1" role="button" aria-controls="end_date_manual_table" title="Previous month"> </div><div class="picker__nav--next" data-nav="1" role="button" aria-controls="end_date_manual_table" title="Next month"> </div></div><table class="picker__table" id="end_date_manual_table" role="grid" aria-controls="end_date_manual" aria-readonly="true"><thead><tr><th class="picker__weekday" scope="col" title="Sunday">Sun</th><th class="picker__weekday" scope="col" title="Monday">Mon</th><th class="picker__weekday" scope="col" title="Tuesday">Tue</th><th class="picker__weekday" scope="col" title="Wednesday">Wed</th><th class="picker__weekday" scope="col" title="Thursday">Thu</th><th class="picker__weekday" scope="col" title="Friday">Fri</th><th class="picker__weekday" scope="col" title="Saturday">Sat</th></tr></thead><tbody><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488047400000" role="gridcell" aria-label="02/26/2017">26</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488133800000" role="gridcell" aria-label="02/27/2017">27</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1488220200000" role="gridcell" aria-label="02/28/2017">28</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488306600000" role="gridcell" aria-label="03/01/2017">1</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488393000000" role="gridcell" aria-label="03/02/2017">2</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488479400000" role="gridcell" aria-label="03/03/2017">3</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488565800000" role="gridcell" aria-label="03/04/2017">4</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488652200000" role="gridcell" aria-label="03/05/2017">5</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488738600000" role="gridcell" aria-label="03/06/2017">6</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488825000000" role="gridcell" aria-label="03/07/2017">7</div></td><td role="presentation"><div class="picker__day picker__day--infocus picker__day--today picker__day--highlighted" data-pick="1488911400000" role="gridcell" aria-label="03/08/2017" aria-activedescendant="true">8</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1488997800000" role="gridcell" aria-label="03/09/2017">9</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489084200000" role="gridcell" aria-label="03/10/2017">10</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489170600000" role="gridcell" aria-label="03/11/2017">11</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489257000000" role="gridcell" aria-label="03/12/2017">12</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489343400000" role="gridcell" aria-label="03/13/2017">13</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489429800000" role="gridcell" aria-label="03/14/2017">14</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489516200000" role="gridcell" aria-label="03/15/2017">15</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489602600000" role="gridcell" aria-label="03/16/2017">16</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489689000000" role="gridcell" aria-label="03/17/2017">17</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489775400000" role="gridcell" aria-label="03/18/2017">18</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489861800000" role="gridcell" aria-label="03/19/2017">19</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1489948200000" role="gridcell" aria-label="03/20/2017">20</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490034600000" role="gridcell" aria-label="03/21/2017">21</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490121000000" role="gridcell" aria-label="03/22/2017">22</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490207400000" role="gridcell" aria-label="03/23/2017">23</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490293800000" role="gridcell" aria-label="03/24/2017">24</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490380200000" role="gridcell" aria-label="03/25/2017">25</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490466600000" role="gridcell" aria-label="03/26/2017">26</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490553000000" role="gridcell" aria-label="03/27/2017">27</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490639400000" role="gridcell" aria-label="03/28/2017">28</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490725800000" role="gridcell" aria-label="03/29/2017">29</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490812200000" role="gridcell" aria-label="03/30/2017">30</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1490898600000" role="gridcell" aria-label="03/31/2017">31</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1490985000000" role="gridcell" aria-label="04/01/2017">1</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491071400000" role="gridcell" aria-label="04/02/2017">2</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491157800000" role="gridcell" aria-label="04/03/2017">3</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491244200000" role="gridcell" aria-label="04/04/2017">4</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491330600000" role="gridcell" aria-label="04/05/2017">5</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491417000000" role="gridcell" aria-label="04/06/2017">6</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491503400000" role="gridcell" aria-label="04/07/2017">7</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1491589800000" role="gridcell" aria-label="04/08/2017">8</div></td></tr></tbody></table><div class="picker__footer"><button class="picker__button--today" type="button" data-pick="1488911400000" disabled="" aria-controls="end_date_manual">Today</button><button class="picker__button--clear" type="button" data-clear="1" disabled="" aria-controls="end_date_manual">Clear</button><button class="picker__button--close" type="button" data-close="true" disabled="" aria-controls="end_date_manual">Close</button></div></div></div></div></div></div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <input type="button" class="btn btn-success" name="search" id="search" value="search" onclick="get_filter_search()">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <?php echo widget($result['widgets']['leads'], 'info'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo widget($result['widgets']['clients'], 'danger'); ?>
            </div>
            <div class="col-lg-4">
            <?php echo widget($result['widgets']['policies'], 'primary'); ?>
            </div>
            <!--            <div class="col-lg-3">
<?php echo widget($result['widgets']['premiums'], 'success'); ?>
                        </div>-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-bolt"></i> <b>Total Products Sold Till Today</b><br><br>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="small">
                                <i class="fa fa-bolt"></i> Products Sold
                            </div>
                            <div>
                                <h1 class="font-extra-bold m-t-xl m-b-xs"><?=$result['product_count']; ?><!--226,802--></h1>
                                <small>Total Sold to Customers</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center small">
                                <i class="fa fa-laptop"></i> Number of Products Sold/Submitted by customer
                            </div>
                            <div class="flot-chart" style="height: 160px">
                                <div style="width:100%;height:160px" class="flot-chart-content" id="flot-line-chart"></div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="small">
                                <i class="fa fa-clock-o"></i> Products Submitted
                            </div>
                            <div>
                                <h1 class="font-extra-bold m-t-xl m-b-xs"><?php if ($total_premium_data[0]['total_premium'] > 0) {
    echo $total_premium_data[0]['total_premium'];
} else {
    echo "0.00";
} ?></h1>
                                <small>Submitted to Suppliers</small>
                            </div>
                            <div class="small m-t-xl"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel stats">
                <div class="panel-heading">

                    <h5 class="pull-left">Top Agents for <?php echo $duration_label[$result['duration']]; ?></h5>
                    <div class="pull-right margin-t-b-10">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-white dataButton" dataTable="fronterTable">Update</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>



                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="fronterTable" class="table table-striped">
                                <thead>
                                <th class="text-left">Name</th>
                                <th class="text-center">Leads</th>
                                </thead>
                                <tbody>
                                    <?php if($result['agents']): foreach($result['agents'] as $user): ?>
                                    <tr>
                                        <td class="text-left"><a href="#lead/start_date=<?= $result['date']['start'];?>&end_date=<?= $result['date']['end']; ?>&user_id=<?= $user['_id']; ?>"><?= $user['name']; ?></a></td>
                                        <td class="text-center"><?= $user['lead_count']; ?></td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr><td colspan="2">No data available.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hpanel stats">
                <div class="panel-heading">
                    <h5 class="pull-left">Top Managers For <?php echo $duration_label[$result['duration']]; ?></h5>
                    <div class="pull-right margin-t-b-10">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-white dataButton" dataTable="closerTable">Update</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="closerTable" class="table table-striped">
                                <thead>
                                <th class="text-left">Name</th>
                                <th class="text-center">Leads</th>
                                </thead>
                                <tbody>
                                    <?php if(!empty($result['managers'])): foreach($result['managers'] as $user): ?>
                                    <tr>
                                        <td class="text-left"><a href="#lead/start_date=<?= $result['date']['start'];?>&end_date=<?= $result['date']['end']; ?>&user_id=<?= $user['_id']; ?>"><?= $user['name']; ?></a></td>
                                        <td class="text-center"><?= $user['lead_count']; ?></td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr><td colspan="2">No data available.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12" id="viciTable">

    </div>
</div>      
<script>
    $(document).ready(function () {
        vicidialerLoad();
    });


    // var myVar = setInterval(myTimer, 60000);
    function myTimer() {
        dataTableLoad("fronterTable");
        dataTableLoad("closerTable");
        toastr.success('Tables Auto Updated', 'Server Response');
    }

    $(".confirmation").click(function () {
        //    clearInterval(myVar);
    });

//    $(".dataButton").click(function () {
//        var tableId = $(this).attr("dataTable");
//        dataTableLoad(tableId);
//        toastr.success('Table Updated', 'Server Response');
//    });

    function dataTableLoad(tableId) {
        $.ajax({
            url: '<?php echo $settings['base_uri']; ?>api/dashboard/info/' + tableId,
            type: "post",
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                // since we are using jQuery, you don't need to parse response
                drawTable(data, tableId);
            }
        });
    }

    $(".dataSalesGroup").click(function () {
        var tableId = $(this).attr("dataTable");
        dataGroupTableLoad(tableId);
        toastr.success('Table Updated', 'Server Response');
    });

    function dataGroupTableLoad(tableId) {
        $.ajax({
            url: '<?php echo $settings['base_uri']; ?>api/dashboard/grouptables',
            type: "post",
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                // since we are using jQuery, you don't need to parse response
                drawTable(data, tableId);
            }
        });
    }


    function vicidialerLoad() {
        $.ajax({
            url: '<?php echo $settings['base_uri']; ?>api/vicidialer',
            type: "post",
            success: function (result) {
                $("#viciTable").html(result);
            }
        });
    }


    function drawTable(data, tableId) {
        $("#" + tableId).empty();
        drawHeader(data.headers, tableId);
        for (var i = 0; i < data.rows.length; i++) {
            drawRow(data.rows[i], tableId);
        }
    }

    function drawHeader(rowData, tableId) {
        var row = $("<thead />")
        $("#" + tableId).append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
        for (var i = 0; i < rowData.length; i++) {
            if (i == 0) {
                row.append($("<th class='text-left'>" + rowData[i] + "</th>"));
            } else {
                row.append($("<th class='text-center'>" + rowData[i] + "</th>"));
            }

        }
    }



    function drawRow(rowData, tableId) {
        var row = $("<tr />")
        $("#" + tableId).append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
        var i = 0;
        for (var k in rowData) {
            if (rowData.hasOwnProperty(k)) {
                if (i == 0) {
                    row.append($("<td class='text-left'>" + rowData[k] + "</td>"));
                } else {
                    row.append($("<td class='text-center'>" + rowData[k] + "</td>"));
                }
                i = i + 1;
            }
        }
    }


    $(document).ready(function () {

        var DashboardData1 = <?= json_encode($result['graph']); ?>
//        var DashboardData2 = [[0, 55], [1, 3]];
        var chartUsersOptions = {
            series: {
                lines: {
                    show: true
                },
            },
            grid: {
                tickColor: "#f0f0f0",
                borderWidth: 1,
                borderColor: 'f0f0f0',
                color: '#6a6c6f'
            },
            colors: ["#62cb31", "#efefef"],
        };
        $.plot($("#flot-line-chart"), [DashboardData1], chartUsersOptions);

    });
</script>