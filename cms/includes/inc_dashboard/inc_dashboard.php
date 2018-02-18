<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_faq.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage Dashboard
##
##
## ----------------------------------------------------------------------------------------------------------------------

function do_main(){

    global $message,$valid,$item_select,$testm_id,$testm_rank,$htmladmin, $main_heading, $rootfull, $date_start_obj, $date_end_obj;

    // include_once 'inc_dashboard_ga.php';
    // $ga_data =  render_ga_data();
   
    $main_heading = 'Dashboard';
    
    $new_page = fetch_row("SELECT pmd.`name`, pmd.`date_updated`
        FROM `general_pages` gp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = gp.`page_meta_data_id`)
        WHERE pmd.`status` != 'D' 
        ORDER BY pmd.`date_updated` DESC
        LIMIT 1");

    $old_page = fetch_row("SELECT pmd.`name`, pmd.`date_updated`
        FROM `general_pages` gp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = gp.`page_meta_data_id`)
        WHERE pmd.`status` != 'D' 
        ORDER BY pmd.`date_updated` ASC
        LIMIT 1");

    $new_date = new DateTime($new_page['date_updated']);
    $old_date = new DateTime($old_page['date_updated']);

    include_once 'classes/disk_status.php';
    $ds = new DiskStatus($rootfull);
    
    $total_space = $ds->totalSpace();
    $free_space  = $ds->freeSpace();
    $used_space  = $ds->usedSpace();

    $progress_bg = 'info';
    if($used_space >= 75)
    {
        $progress_bg = 'warning';
    }
    if($used_space >= 90)
    {
        $progress_bg = 'danger';
    }
    
    // display last logged in user info
    $last_user_view = '';
    if(isset($_SESSION['last_user_loggedin']))
    {
        $last_user = $_SESSION['last_user_loggedin'];
        $las_login_date = new DateTime($last_user['last_login_date']);
        $last_user_view = <<< H

        <div class="col-xs-6 col-md-4">
            <div class="dashboard-item">
                <header class="dheader">
                    <span class="icon-holder">
                        <span class="circle"></span>
                        <i class="glyphicon glyphicon-user" style="margin-left:-13px"></i>
                    </span>
                    <h1>Last logged in user</h1>
                    <div class="clear"></div>
                </header>
                <div class="row">
                    <div class="col-xs-12 ditem-body" style="min-height:117px;">
                        <p class="label-pair"><strong>Username:</strong> {$last_user['name']}</p>
                        <p class="label-pair"><strong>Date:</strong> {$las_login_date->format('d F Y')}</p>
                        <p class="label-pair"><strong>Time:</strong> {$las_login_date->format('h:i A')}</p>
                        <p class="label-pair"><strong><a href="$htmladmin/index.php?do=users&action=edit&id={$last_user['user_id']}">View profile</a></strong></p>
                    </div>
                </div>
            </div>
        </div>
H;
    }

    // enquiry info
    $enquiry = fetch_row("SELECT `id`, CONCAT(`fname`, ' ', `lname`) AS name, `date_of_enquiry`
        FROM `enquiry` 
        WHERE `status` = 'A' 
        ORDER BY `date_of_enquiry` DESC 
        LIMIT 1");

    $enquiry_view = '<h3>No enquiry has been made yet</h3>';
    if($enquiry)
    {
        $date_enq = $time_enq = 'N/A';

        if($enquiry['date_of_enquiry'])
        {
            $date_enquired = new DateTime($enquiry['date_of_enquiry']);
            $date_enq = $date_enquired->format('d F Y');
            $time_enq = $date_enquired->format('h:i A');
        }

        $enquiry_view = <<< H
        <p class="label-pair"><strong>Name:</strong> {$enquiry['name']}</p>
        <p class="label-pair"><strong>Date:</strong> {$date_enq}</p>
        <p class="label-pair"><strong>Time:</strong> {$time_enq}</p>
        <p class="label-pair"><strong><a href="$htmladmin/index.php?do=enquiries&action=edit&id={$enquiry['id']}">View enquiry details</a></strong></p>
H;
    }



    $page_contents.= <<< HTML
    <div class="row dashboard" style="margin-top:-20px;">
        <div class="col-xs-6 col-md-4">
            <div class="dashboard-item">
                <header class="dheader">
                    <span class="icon-holder">
                        <span class="circle"></span>
                        <i class="glyphicon glyphicon-file"></i>
                    </span>
                    <h1>General pages</h1>
                    <div class="clear"></div>
                </header>
                <div class="row">
                    <div class="col-xs-12 ditem-body">
                        
                        <h2>Recently updated page</h2>
                        <p><strong>{$new_page['name']}:</strong> {$new_date->format('d F Y H:i:s')}</p>
                        <h2>Oldest page on website</h2>
                        <p><strong>{$old_page['name']}:</strong> {$old_date->format('d F Y H:i:s')}</p>
                    </div>
                </div>
            </div>
        </div>
        {$last_user_view}
        <!--<div class="col-xs-6">
            <div class="dashboard-item">
                <header class="dheader">
                    <span class="icon-holder">
                        <span class="circle"></span>
                        <i class="glyphicon glyphicon-hdd"></i>
                    </span>
                    <h1>Disk space used</h1>
                    <div class="clear"></div>
                </header>
                <div class="row">
                    <div class="col-xs-12 ditem-body">
                        
                        <div class="progress">
                          <div class="progress-bar progress-bar-{$progress_bg}" role="progressbar" aria-valuenow="{$used_space}" aria-valuemin="0" aria-valuemax="100" style="width: {$used_space}%">
                        </div>
                        </div>
                        <div class="clear"></div>
                        <div class="pstate"><strong>{$free_space} free of {$total_space} ({$used_space}% used)</strong></div>
                    </div>
                </div>
            </div>
        </div>-->
        
        <div class="col-xs-6 col-md-4">
            <div class="dashboard-item">
                <header class="dheader">
                    <span class="icon-holder">
                        <span class="circle"></span>
                        <i style="margin-left:-13px" class="glyphicon glyphicon-envelope"></i>
                    </span>
                    <h1>Latest enquiry</h1>
                    <div class="clear"></div>
                </header>
                <div class="row">
                    <div class="col-xs-12 ditem-body">
                        $enquiry_view
                    </div>
                </div>
            </div>
        </div>

        <!-- analytics goes here -->

    </div>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}

// <div class="col-xs-12 ga-row">
//             <div class="dashboard-item">
//                 <header class="dheader">
//                     <span class="icon-holder">
//                         <span class="circle"></span>
//                         <i class="fa fa-bar-chart-o" style="margin-left:-14px;"></i>
//                     </span>
                    
//                     <form action="$htmladmin/index.php?do=dashboard" method="post" accept-charset="utf-8" class="form-inline pull-right ga-search-form" role="form">
//                         <div class="form-group">
//                             <label class="" for="ga-date-from">Start Date:</label>
//                             <input type="text" name="ga-date-from" id="ga-date-from" value="{$date_start_obj->format('d/m/Y')}" class="ga-date form-control" data-min-field="#ga-date-to">
//                         </div>
//                         <div class="form-group">
//                             <label class="" for="ga-date-to">End Date:</label>
//                             <input type="text" name="ga-date-to" id="ga-date-to" value="{$date_end_obj->format('d/m/Y')}" class="ga-date form-control" data-max-field="#ga-date-from">
//                         </div>
//                         <input type="submit"  class="btn btn-default" name="get-ga" value="Submit">
//                     </form> 
//                     <h1>Google Analytics</h1>
//                     <div class="clear"></div>
//                 </header>
//                 {$ga_data}
//             </div>
//         </div>


?>