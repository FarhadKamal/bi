<?php


$fyear=2022;

$oYear=$fyear-1;

$nxtYear=$fyear+1;

$nyear=date('Y');

$ndatesegment= date('-m-d');

$today= date('Y-m-d');



$olastday=$fyear."-06-30";

$flastday=$nxtYear."-06-30";


$osdate=$oYear."-07-01";

$oedate=$fyear.$ndatesegment;

if($fyear==$nyear)
$oedate=$oYear.$ndatesegment;

if($today>$flastday)
$oedate=$olastday;


$csdate=$fyear."-07-01";

$cedate=$nyear.$ndatesegment;

if($today>$flastday)
$cedate=$flastday;


//echo $osdate;


function lakh($amt)
{
 
	return 	sprintf("%.2f", round($amt/100000,2));
}	

include_once("db.php");
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_POST['logout'])) {

	session_destroy();

	if ($_POST['logout'] == "yes")
		header("Location: index.php?msg=logout");
	else if ($_POST['logout'] == "fail")
		header("Location: index.php?msg=failLog");
	else if ($_POST['logout'] == "relog")
		header("Location: login.php?msg=relog");
}

if (empty($_POST["year"])) {
    $selected_year = date("Y");
}else{
    $year = $_POST["year"];
    $selected_year = $year;
}

if (empty($_POST["quater"])) {
    $selected_quater_array = array(Q1,Q2,Q3,Q4);
}else{
    $quater_array = $_POST["quater"];
    $selected_quater_array = $quater_array;
}


if(isset($selected_year, $selected_quater_array)){
    // Fiscal Year Start Date 
    $start_date_for_selected_fiscal_year = date('Y-m-d', strtotime($selected_year.'-07-01'));
    $end_date_for_selected_fiscal_year = date('Y-m-d', strtotime(($selected_year+1).'-06-30'));

    // echo "<pre>";
    // var_dump($start_date_for_selected_fiscal_year);
    // var_dump($end_date_for_selected_fiscal_year);
    // echo "</pre>";

    $current_date = date('Y-m-d');
    $current_date_previous_year = date("Y-m-d", strtotime("-1 year", strtotime($current_date)));

    if (($current_date >= $start_date_for_selected_fiscal_year) && ($current_date <= $end_date_for_selected_fiscal_year)){
        $previous_year = $selected_year-1;
        $quater_title = "";
        $quarter_month_list = "";
        $searching_parameters_for_achivements = "";
        $searching_parameters_for_last_years = "";
        $check_achivements = 0;
        $check_last_year = 0;

        $selected_q1_term_start_date_s = '';
        $selected_q1_term_end_date_e = '';
        $selected_q2_term_start_date_s = '';
        $selected_q2_term_end_date_e = '';
        $selected_q3_term_start_date_s = '';
        $selected_q3_term_end_date_e = '';
        $selected_q4_term_start_date_s = '';
        $selected_q4_term_end_date_e = '';

        // Selected Fiscal Year date Range list
        if(in_array("Q1", $selected_quater_array)){
            $selected_q1_term_start_date = date('Y-m-d', strtotime($selected_year.'-07-01'));
            $selected_q1_term_end_date = date('Y-m-d', strtotime($selected_year.'-09-30'));
			$quarter_month_list .= " july+august+september";

            if($check_achivements == 0){
                $os_date = $selected_q1_term_start_date;
                $oe_date = ($current_date >= $selected_q1_term_start_date) && ($current_date <= $selected_q1_term_end_date)?$current_date:$selected_q1_term_end_date;

                $quater_title .= " Q1";
                $check_achivements = ($current_date >= $selected_q1_term_start_date) && ($current_date <= $selected_q1_term_end_date)?"1":"0";
                // $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q1_term_start_date' and  FKDAT<= '$selected_q1_term_end_date') OR ";
                $searching_parameters_for_achivements .= ($current_date >= $selected_q1_term_start_date) && ($current_date <= $selected_q1_term_end_date)?"(FKDAT >= '$selected_q1_term_start_date' and  FKDAT<= '$current_date') OR ":"(FKDAT >= '$selected_q1_term_start_date' and  FKDAT<= '$selected_q1_term_end_date') OR ";

                $selected_q1_term_start_date_s = $selected_q1_term_start_date;
                $selected_q1_term_end_date_e = ($current_date >= $selected_q1_term_start_date) && ($current_date <= $selected_q1_term_end_date)?$current_date:$selected_q1_term_end_date;

            }
        }

        if(in_array("Q2", $selected_quater_array)){
            $selected_q2_term_start_date = date('Y-m-d', strtotime($selected_year.'-10-01'));
            $selected_q2_term_end_date = date('Y-m-d', strtotime($selected_year.'-12-31'));
			$quarter_month_list .= " october+november+december";

            if($check_achivements == 0){
                $os_date = isset($os_date)? $os_date: $selected_q2_term_start_date;
                $oe_date = ($current_date >= $selected_q2_term_start_date) && ($current_date <= $selected_q2_term_end_date)?$current_date:$selected_q2_term_end_date;
                
                $quater_title .= " Q2";
                $check_achivements = ($current_date >= $selected_q2_term_start_date) && ($current_date <= $selected_q2_term_end_date)?"1":"0";
                // $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q2_term_start_date' and  FKDAT<= '$selected_q2_term_end_date') OR ";
                $searching_parameters_for_achivements .= ($current_date >= $selected_q2_term_start_date) && ($current_date <= $selected_q2_term_end_date)?"(FKDAT >= '$selected_q2_term_start_date' and  FKDAT<= '$current_date') OR ":"(FKDAT >= '$selected_q2_term_start_date' and  FKDAT<= '$selected_q2_term_end_date') OR ";
                $selected_q2_term_start_date_s = $selected_q2_term_start_date;
                $selected_q2_term_end_date_e = ($current_date >= $selected_q2_term_start_date) && ($current_date <= $selected_q2_term_end_date)?$current_date:$selected_q2_term_end_date;
            }
        }

        if(in_array("Q3", $selected_quater_array)){
            $selected_q3_term_start_date = date('Y-m-d', strtotime(($selected_year+1).'-01-01'));
            $selected_q3_term_end_date = date('Y-m-d', strtotime(($selected_year+1).'-03-31'));
			$quarter_month_list .= " january+february+march";

            if($check_achivements == 0){
                $os_date = isset($os_date)? $os_date: $selected_q3_term_start_date;
                $oe_date = ($current_date >= $selected_q3_term_start_date) && ($current_date <= $selected_q3_term_end_date)?$current_date:$selected_q3_term_end_date;
                
                $quater_title .= " Q3";
                $check_achivements = ($current_date >= $selected_q3_term_start_date) && ($current_date <= $selected_q3_term_end_date)?"1":"0";
                // $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q3_term_start_date' and  FKDAT<= '$selected_q3_term_end_date') OR ";
                $searching_parameters_for_achivements .= ($current_date >= $selected_q3_term_start_date) && ($current_date <= $selected_q3_term_end_date)?"(FKDAT >= '$selected_q3_term_start_date' and  FKDAT<= '$current_date') OR ":"(FKDAT >= '$selected_q3_term_start_date' and  FKDAT<= '$selected_q3_term_end_date') OR ";
                $selected_q3_term_start_date_s = $selected_q3_term_start_date;
                $selected_q3_term_end_date_e = ($current_date >= $selected_q3_term_start_date) && ($current_date <= $selected_q3_term_end_date)?$current_date:$selected_q3_term_end_date;
            }
        }

        if(in_array("Q4", $selected_quater_array)){
            $selected_q4_term_start_date = date('Y-m-d', strtotime(($selected_year+1).'-04-01'));
            $selected_q4_term_end_date = date('Y-m-d', strtotime(($selected_year+1).'-06-30'));
			$quarter_month_list .= " april+may+june";

            if($check_achivements == 0){
                $os_date = isset($os_date)? $os_date: $selected_q4_term_start_date;
                $oe_date = ($current_date >= $selected_q4_term_start_date) && ($current_date <= $selected_q4_term_end_date)?$current_date:$selected_q4_term_end_date;
                
                $quater_title .= " Q4";
                $check_achivements = ($current_date >= $selected_q4_term_start_date) && ($current_date <= $selected_q4_term_end_date)?"1":"0";
                // $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q4_term_start_date' and  FKDAT<= '$selected_q4_term_end_date')  ";
                $searching_parameters_for_achivements .= ($current_date >= $selected_q4_term_start_date) && ($current_date <= $selected_q4_term_end_date)?"(FKDAT >= '$selected_q4_term_start_date' and  FKDAT<= '$current_date') OR ":"(FKDAT >= '$selected_q4_term_start_date' and  FKDAT<= '$selected_q4_term_end_date') OR ";
                $selected_q4_term_start_date_s = $selected_q4_term_start_date;
                $selected_q4_term_end_date_e = ($current_date >= $selected_q4_term_start_date) && ($current_date <= $selected_q4_term_end_date)?$current_date:$selected_q4_term_end_date;
            }
        }

        // Previous Fiscal Year date Range list
        if(in_array("Q1", $selected_quater_array)){
            $selected_last_year_q1_term_start_date = date('Y-m-d', strtotime(($selected_year-1).'-07-01'));
            $selected_last_year_q1_term_end_date = date('Y-m-d', strtotime(($selected_year-1).'-09-30'));

            if($check_last_year == 0){
                $cs_date = $selected_last_year_q1_term_start_date;
                $ce_date = ($current_date_previous_year >= $selected_last_year_q1_term_start_date) && ($current_date_previous_year <= $selected_last_year_q1_term_end_date)?$current_date_previous_year:$selected_last_year_q1_term_end_date;

                $check_last_year = ($current_date_previous_year >= $selected_last_year_q1_term_start_date) && ($current_date_previous_year <= $selected_last_year_q1_term_end_date)?"1":"0";
                // $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q1_term_start_date' and  FKDAT<= '$selected_last_year_q1_term_end_date') OR ";
                $searching_parameters_for_last_years .= ($current_date_previous_year >= $selected_last_year_q1_term_start_date) && ($current_date_previous_year <= $selected_last_year_q1_term_end_date)?"(FKDAT >= '$selected_last_year_q1_term_start_date' and  FKDAT<= '$current_date_previous_year') OR ":"(FKDAT >= '$selected_last_year_q1_term_start_date' and  FKDAT<= '$selected_last_year_q1_term_end_date') OR ";

            }
        }

        if(in_array("Q2", $selected_quater_array)){
            $selected_last_year_q2_term_start_date = date('Y-m-d', strtotime(($selected_year-1).'-10-01'));
            $selected_last_year_q2_term_end_date = date('Y-m-d', strtotime(($selected_year-1).'-12-31'));

            if($check_last_year == 0){
                $cs_date = isset($cs_date)? $cs_date: $selected_last_year_q2_term_start_date;
                $ce_date = ($current_date_previous_year >= $selected_last_year_q2_term_start_date) && ($current_date_previous_year <= $selected_last_year_q2_term_end_date)?$current_date_previous_year:$selected_last_year_q2_term_end_date;

                $check_last_year = ($current_date_previous_year >= $selected_last_year_q2_term_start_date) && ($current_date_previous_year <= $selected_last_year_q2_term_end_date)?"1":"0";
                // $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q2_term_start_date' and  FKDAT<= '$selected_last_year_q2_term_end_date') OR ";
                $searching_parameters_for_last_years .= ($current_date_previous_year >= $selected_last_year_q2_term_start_date) && ($current_date_previous_year <= $selected_last_year_q2_term_end_date)?"(FKDAT >= '$selected_last_year_q2_term_start_date' and  FKDAT<= '$current_date_previous_year') OR ":"(FKDAT >= '$selected_last_year_q2_term_start_date' and  FKDAT<= '$selected_last_year_q2_term_end_date') OR ";

            }
        
        }

        if(in_array("Q3", $selected_quater_array)){
            $selected_last_year_q3_term_start_date = date('Y-m-d', strtotime(($selected_year).'-01-01'));
            $selected_last_year_q3_term_end_date = date('Y-m-d', strtotime(($selected_year).'-03-31'));

            if($check_last_year == 0){
                $cs_date = isset($cs_date)? $cs_date: $selected_last_year_q3_term_start_date;
                $ce_date = ($current_date_previous_year >= $selected_last_year_q3_term_start_date) && ($current_date_previous_year <= $selected_last_year_q3_term_end_date)?$current_date_previous_year:$selected_last_year_q3_term_end_date;

                $check_last_year = ($current_date_previous_year >= $selected_last_year_q3_term_start_date) && ($current_date_previous_year <= $selected_last_year_q3_term_end_date)?"1":"0";
                // $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q3_term_start_date' and  FKDAT<= '$selected_last_year_q3_term_end_date') OR ";
                $searching_parameters_for_last_years .= ($current_date_previous_year >= $selected_last_year_q3_term_start_date) && ($current_date_previous_year <= $selected_last_year_q3_term_end_date)?"(FKDAT >= '$selected_last_year_q3_term_start_date' and  FKDAT<= '$current_date_previous_year') OR ":"(FKDAT >= '$selected_last_year_q3_term_start_date' and  FKDAT<= '$selected_last_year_q3_term_end_date') OR ";

            }
        
        }

        if(in_array("Q4", $selected_quater_array)){
            $selected_last_year_q4_term_start_date = date('Y-m-d', strtotime(($selected_year).'-04-01'));
            $selected_last_year_q4_term_end_date = date('Y-m-d', strtotime(($selected_year).'-06-30'));

            if($check_last_year == 0){
                $cs_date = isset($cs_date)? $cs_date: $selected_last_year_q4_term_start_date;
                $ce_date = ($current_date_previous_year >= $selected_last_year_q4_term_start_date) && ($current_date_previous_year <= $selected_last_year_q4_term_end_date)?$current_date_previous_year:$selected_last_year_q4_term_end_date;

                $check_last_year = ($current_date_previous_year >= $selected_last_year_q4_term_start_date) && ($current_date_previous_year <= $selected_last_year_q4_term_end_date)?"1":"0";
                // $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q4_term_start_date' and  FKDAT<= '$selected_last_year_q4_term_end_date')  ";
                $searching_parameters_for_last_years .= ($current_date_previous_year >= $selected_last_year_q4_term_start_date) && ($current_date_previous_year <= $selected_last_year_q4_term_end_date)?"(FKDAT >= '$selected_last_year_q4_term_start_date' and  FKDAT<= '$current_date_previous_year') OR ":"(FKDAT >= '$selected_last_year_q4_term_start_date' and  FKDAT<= '$selected_last_year_q4_term_end_date') OR ";

            }
        
        }

    }else{

        $previous_year = $selected_year-1;
        $quater_title = "";
        $quarter_month_list = "";
        $searching_parameters_for_achivements = "";
        $searching_parameters_for_last_years = "";
        
        // Selected Fiscal Year date Range list
        if(in_array("Q1", $selected_quater_array)){
            $quarter_month_list .= " july+august+september";
            $quater_title .= " Q1";

            $selected_q1_term_start_date = date('Y-m-d', strtotime($selected_year.'-07-01'));
            $selected_q1_term_end_date = date('Y-m-d', strtotime($selected_year.'-09-30'));

            $os_date = $selected_q1_term_start_date ;
            $oe_date = $selected_q1_term_end_date ;

            $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q1_term_start_date' and  FKDAT<= '$selected_q1_term_end_date') OR ";

            $selected_q1_term_start_date_s = $selected_q1_term_start_date;
            $selected_q1_term_end_date_e = $selected_q1_term_end_date;
        }

        if(in_array("Q2", $selected_quater_array)){
            $quarter_month_list .= " october+november+december";
            $quater_title .= " Q2";

            $selected_q2_term_start_date = date('Y-m-d', strtotime($selected_year.'-10-01'));
            $selected_q2_term_end_date = date('Y-m-d', strtotime($selected_year.'-12-31'));
            
            $os_date = isset($os_date)? $os_date : $selected_q2_term_start_date ;
            $oe_date = $selected_q2_term_end_date ;

            $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q2_term_start_date' and  FKDAT<= '$selected_q2_term_end_date') OR ";

            $selected_q2_term_start_date_s = $selected_q2_term_start_date;
            $selected_q2_term_end_date_e = $selected_q2_term_end_date;
        }

        if(in_array("Q3", $selected_quater_array)){
            $quarter_month_list .= " january+february+march";
            $quater_title .= " Q3";

            $selected_q3_term_start_date = date('Y-m-d', strtotime(($selected_year+1).'-01-01'));
            $selected_q3_term_end_date = date('Y-m-d', strtotime(($selected_year+1).'-03-31'));

            $os_date = isset($os_date)? $os_date : $selected_q3_term_start_date ;
            $oe_date = $selected_q3_term_end_date ;

            $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q3_term_start_date' and  FKDAT<= '$selected_q3_term_end_date') OR ";

            $selected_q3_term_start_date_s = $selected_q3_term_start_date;
            $selected_q3_term_end_date_e = $selected_q3_term_end_date;
        }

        if(in_array("Q4", $selected_quater_array)){
            $quarter_month_list .= " april+may+june";
            $quater_title .= " Q4";

            $selected_q4_term_start_date = date('Y-m-d', strtotime(($selected_year+1).'-04-01'));
            $selected_q4_term_end_date = date('Y-m-d', strtotime(($selected_year+1).'-06-30'));

            $os_date = isset($os_date)? $os_date : $selected_q4_term_start_date ;
            $oe_date = $selected_q4_term_end_date ;

            $searching_parameters_for_achivements .= "(FKDAT >= '$selected_q4_term_start_date' and  FKDAT<= '$selected_q4_term_end_date')  t";

            $selected_q4_term_start_date_s = $selected_q4_term_start_date;
            $selected_q4_term_end_date_e = $selected_q4_term_end_date;
        }


        // Previous Fiscal Year date Range list
        if(in_array("Q1", $selected_quater_array)){

            $selected_last_year_q1_term_start_date = date('Y-m-d', strtotime(($selected_year-1).'-07-01'));
            $selected_last_year_q1_term_end_date = date('Y-m-d', strtotime(($selected_year-1).'-09-30'));

            $cs_date = isset($cs_date)? $cs_date : $selected_last_year_q1_term_start_date ;
            $ce_date = $selected_last_year_q1_term_end_date ;

            $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q1_term_start_date' and  FKDAT<= '$selected_last_year_q1_term_end_date') OR ";
        }

        if(in_array("Q2", $selected_quater_array)){

            $selected_last_year_q2_term_start_date = date('Y-m-d', strtotime(($selected_year-1).'-10-01'));
            $selected_last_year_q2_term_end_date = date('Y-m-d', strtotime(($selected_year-1).'-12-31'));

            $cs_date = isset($cs_date)? $cs_date : $selected_last_year_q2_term_start_date ;
            $ce_date = $selected_last_year_q2_term_end_date ;

            $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q2_term_start_date' and  FKDAT<= '$selected_last_year_q2_term_end_date') OR ";
        }

        if(in_array("Q3", $selected_quater_array)){

            $selected_last_year_q3_term_start_date = date('Y-m-d', strtotime(($selected_year).'-01-01'));
            $selected_last_year_q3_term_end_date = date('Y-m-d', strtotime(($selected_year).'-03-31'));

            $cs_date = isset($cs_date)? $cs_date : $selected_last_year_q3_term_start_date ;
            $ce_date = $selected_last_year_q3_term_end_date ;
            
            $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q3_term_start_date' and  FKDAT<= '$selected_last_year_q3_term_end_date') OR ";
        }

        if(in_array("Q4", $selected_quater_array)){

            $selected_last_year_q4_term_start_date = date('Y-m-d', strtotime(($selected_year).'-04-01'));
            $selected_last_year_q4_term_end_date = date('Y-m-d', strtotime(($selected_year).'-06-30'));

            $cs_date = isset($cs_date)? $cs_date : $selected_last_year_q4_term_start_date ;
            $ce_date = $selected_last_year_q4_term_end_date ;
		
            $searching_parameters_for_last_years .= "(FKDAT >= '$selected_last_year_q4_term_start_date' and  FKDAT<= '$selected_last_year_q4_term_end_date')  t";
			//echo $searching_parameters_for_last_years;
		}

    }

    // Adding Plus Symbol and Triming The First Plus
    $all_month_list = str_replace(' ', '+', $quarter_month_list);
    $all_month_list = ltrim($all_month_list, '+');

    $title = str_replace(' ', '+', $quater_title);
    $title = ltrim($title, '+');

    // Triming Where clause of searched paratmeters text line for last word
    $searching_parameters_for_achivements_trimed_edition = preg_replace('/\W\w+\s*(\W*)$/', '$1', $searching_parameters_for_achivements);
    $searching_parameters_for_last_year_trimed_edition = preg_replace('/\W\w+\s*(\W*)$/', '$1', $searching_parameters_for_last_years);
    //echo $searching_parameters_for_last_year_trimed_edition;

    // Sales Target of selected fiscal year
    $query_cr_pedrollo_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='CR' and product_division in (20,30)";
    $query_cr_bgflow_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='CR' and product_division in (50)";
    $query_cr_itap_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='CR' and product_division in (60)";
    $query_cr_total_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='CR' and product_division in (20,30,50,60)";
    $query_cr_showroom_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='SR'";
    $query_cr_bd_target  = "SELECT round(sum($all_month_list),2) AS total from sales_target where fyear='$selected_year' and group_tag='BD'";

    //echo $query_cr_pedrollo_target ;

    $sql_cr_pedrollo_target =mysqli_query( $GLOBALS['con'] ,$query_cr_pedrollo_target);
    $sql_cr_bgflow_target =mysqli_query( $GLOBALS['con'] ,$query_cr_bgflow_target);
    $sql_cr_itap_target =mysqli_query( $GLOBALS['con'] ,$query_cr_itap_target);
    $sql_cr_total_target =mysqli_query( $GLOBALS['con'] ,$query_cr_total_target);
    $sql_showroom_total_target =mysqli_query( $GLOBALS['con'] ,$query_cr_showroom_target);
    $sql_bd_total_target =mysqli_query( $GLOBALS['con'] ,$query_cr_bd_target);

    $result_cr_pedrollo_target =mysqli_fetch_object($sql_cr_pedrollo_target);
    $result_cr_bgflow_target =mysqli_fetch_object($sql_cr_bgflow_target);
    $result_cr_itap_target =mysqli_fetch_object($sql_cr_itap_target);
    $result_cr_total_target =mysqli_fetch_object($sql_cr_total_target);
    $result_showroom_target =mysqli_fetch_object($sql_showroom_total_target);
    $result_bd_target =mysqli_fetch_object($sql_bd_total_target);

    // var_dump($title);
    // var_dump($result_cr_pedrollo_target->total);
    // var_dump($result_cr_bgflow_target->total);
    // var_dump($result_cr_itap_target->total);
    // var_dump($result_cr_total_target->total);
    // var_dump($result_showroom_target->total);
    // var_dump($result_bd_target->total);
    // /.Sales Target of selected fiscal year

    // Achivements of selected fiscal year

    $query_for_achivements = "SELECT 
            sum(if(SPART in(20,30) and CTAG='CR',NETWR,0)) as cr_ped,
            sum(if(SPART in(50)  and CTAG='CR',NETWR,0)) as cr_bg,
            sum(if(SPART in(60)  and CTAG='CR',NETWR,0)) as cr_itap,
            sum(if(SPART in(20,30,50,60)  and CTAG='CR',NETWR,0)) as cr_total,
            sum(if( CTAG='SR',NETWR,0)) as sr,
            sum(if( CTAG='BD',NETWR,0)) as bd
            
            from sap_sales_process 
            where FYEAR = '$selected_year'
            and (
            $searching_parameters_for_achivements_trimed_edition
            )";

    
    // echo "<pre>";
    // var_dump ($query_for_achivements);
    // echo "</pre>";
    
    

    $sql_for_achivements =mysqli_query( $GLOBALS['con'] ,$query_for_achivements);
    $result_for_achivements =mysqli_fetch_object($sql_for_achivements);

    $query_for_last_year = "SELECT 
            sum(if(SPART in(20,30) and CTAG='CR',NETWR,0)) as cr_ped,
            sum(if(SPART in(50)  and CTAG='CR',NETWR,0)) as cr_bg,
            sum(if(SPART in(60)  and CTAG='CR',NETWR,0)) as cr_itap,
            sum(if(SPART in(20,30,50,60)  and CTAG='CR',NETWR,0)) as cr_total,
            sum(if( CTAG='SR',NETWR,0)) as sr,
            sum(if( CTAG='BD',NETWR,0)) as bd

            from sap_sales_process 
            where FYEAR = '$previous_year'
            and (
            $searching_parameters_for_last_year_trimed_edition
            )";

    $sql_for_last_year =mysqli_query( $GLOBALS['con'] ,$query_for_last_year);
    $result_for_last_year =mysqli_fetch_object($sql_for_last_year);


    $query_for_brandwise_sell_current_year = "SELECT 
                                    sum(if(sap_sales_process.SPART in(20,30) and CTAG='BD',round(FKIMG,0),0)) as bd_ped,
                                    sum(if(sap_sales_process.SPART in(50) and CTAG='BD',round(FKIMG,0),0)) as bd_bg,
                                    sum(if(sap_sales_process.SPART in(60) and CTAG='BD',round(FKIMG,0),0)) as bd_itap,
                                    sum(if(sap_sales_process.SPART in(95) and CTAG='BD',round(FKIMG,0),0)) as bd_maxwell,
                                    sum(if(sap_sales_process.SPART in(52) and CTAG='BD',round(FKIMG,0),0)) as bd_paneli,
                                    sum(if(sap_sales_process.SPART in(20,30) and CTAG='CR',round(FKIMG,0),0)) as cr_ped,
                                    sum(if(sap_sales_process.SPART in(50) and CTAG='CR',round(FKIMG,0),0)) as cr_bg,
                                    sum(if(sap_sales_process.SPART in(60) and CTAG='CR',round(FKIMG,0),0)) as cr_itap,
                                    sum(if(sap_sales_process.SPART in(95) and CTAG='CR',round(FKIMG,0),0)) as cr_maxwell,
                                    sum(if(sap_sales_process.SPART in(52) and CTAG='CR',round(FKIMG,0),0)) as cr_paneli,
                                    sum(if(sap_sales_process.SPART in(20,30) and CTAG='SR',round(FKIMG,0),0)) as sr_ped,
                                    sum(if(sap_sales_process.SPART in(50) and CTAG='SR',round(FKIMG,0),0)) as sr_bg,
                                    sum(if(sap_sales_process.SPART in(60) and CTAG='SR',round(FKIMG,0),0)) as sr_itap,
                                    sum(if(sap_sales_process.SPART in(95) and CTAG='SR',round(FKIMG,0),0)) as sr_maxwell,
                                    sum(if(sap_sales_process.SPART in(52) and CTAG='SR',round(FKIMG,0),0)) as sr_paneli
            
                                FROM sap_sales_process 
                                inner join material_data on sap_sales_process.MATNR=material_data.MATNR
                                WHERE FYEAR = '$selected_year' AND material_data.MTART='HAWA'
                                AND (
                                $searching_parameters_for_achivements_trimed_edition
                                )";
    //echo $query_for_brandwise_sell_current_year;							

    $sql_for_brandwise_sell_current_year =mysqli_query( $GLOBALS['con'] ,$query_for_brandwise_sell_current_year);
    $result_for_brandwise_sell_current_year =mysqli_fetch_object($sql_for_brandwise_sell_current_year);

    $query_for_brandwise_sell_last_year = "SELECT 
                                                sum(if(sap_sales_process.SPART in(20,30) and CTAG='BD',round(FKIMG,0),0)) as bd_ped,
                                                sum(if(sap_sales_process.SPART in(50) and CTAG='BD',round(FKIMG,0),0)) as bd_bg,
                                                sum(if(sap_sales_process.SPART in(60) and CTAG='BD',round(FKIMG,0),0)) as bd_itap,
                                                sum(if(sap_sales_process.SPART in(95) and CTAG='BD',round(FKIMG,0),0)) as bd_maxwell,
                                                sum(if(sap_sales_process.SPART in(52) and CTAG='BD',round(FKIMG,0),0)) as bd_paneli,
                                                sum(if(sap_sales_process.SPART in(20,30) and CTAG='CR',round(FKIMG,0),0)) as cr_ped,
                                                sum(if(sap_sales_process.SPART in(50) and CTAG='CR',round(FKIMG,0),0)) as cr_bg,
                                                sum(if(sap_sales_process.SPART in(60) and CTAG='CR',round(FKIMG,0),0)) as cr_itap,
                                                sum(if(sap_sales_process.SPART in(95) and CTAG='CR',round(FKIMG,0),0)) as cr_maxwell,
                                                sum(if(sap_sales_process.SPART in(52) and CTAG='CR',round(FKIMG,0),0)) as cr_paneli,
                                                sum(if(sap_sales_process.SPART in(20,30) and CTAG='SR',round(FKIMG,0),0)) as sr_ped,
                                                sum(if(sap_sales_process.SPART in(50) and CTAG='SR',round(FKIMG,0),0)) as sr_bg,
                                                sum(if(sap_sales_process.SPART in(60) and CTAG='SR',round(FKIMG,0),0)) as sr_itap,
                                                sum(if(sap_sales_process.SPART in(95) and CTAG='SR',round(FKIMG,0),0)) as sr_maxwell,
                                                sum(if(sap_sales_process.SPART in(52) and CTAG='SR',round(FKIMG,0),0)) as sr_paneli

                                            FROM sap_sales_process 
                                            inner join material_data on sap_sales_process.MATNR=material_data.MATNR
                                            WHERE FYEAR = '$previous_year' AND material_data.MTART='HAWA'
                                            
                                            AND (
                                            $searching_parameters_for_last_year_trimed_edition
                                            )";
	
    $sql_for_brandwise_sell_last_year =mysqli_query( $GLOBALS['con'] ,$query_for_brandwise_sell_last_year);
    $result_for_brandwise_sell_last_year =mysqli_fetch_object($sql_for_brandwise_sell_last_year);
	//echo  $searching_parameters_for_last_year_trimed_edition;
    
    // echo "<pre>";
    // print_r ($query_for_achivements);
    // print_r ($query_for_last_year);
    // print_r ($query_for_brandwise_sell_current_year);
    // print_r ($query_for_brandwise_sell_last_year);
    // echo "</pre>";
    
    // /.Achivements of selected fiscal year
}

        $dateList = $selected_q1_term_start_date_s.'/'.$selected_q1_term_end_date_e.'/'.$selected_q2_term_start_date_s.'/'.$selected_q2_term_end_date_e.'/'.$selected_q3_term_start_date_s.'/'.$selected_q3_term_end_date_e.'/'.$selected_q4_term_start_date_s.'/'.$selected_q4_term_end_date_e;

?>

<?php
if (isset($_SESSION['logged'])) {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="pic/icon.png" />
		<title>BI</title>
		<link rel="stylesheet" href="script/bootstrap.min.css">
		<link rel="stylesheet" href="script/bootstrap-theme.css">
		<link rel="stylesheet" href="script/bootstrap-theme.min.css">
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
		<script src="script/Chart.min.js" type="text/javascript"></script>
		<script src="script/jquery-1.11.2.min.js"></script>
		<script src="script/bootstrap.min.js"></script>
		<link rel="stylesheet" href="script/flexselect.css" type="text/css" media="screen" />
		<script src="script/liquidmetal.js" type="text/javascript"></script>
		<script src="script/jquery.flexselect.js" type="text/javascript"></script>

	</head>

	<body>
		<?php
		// include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">

					<label class="control-label">Target Vs Achivement (Values)</label>
                    <table class="table table-striped" id="print_hidden">
                        <tr>
                            <td>
                                <table class="table table-striped">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <tr>
                                        <td><label for="year">Financial Year</label></td>
                                        <td>
                                            <select name="year" id="year" required="">
												
												<option value='2021' <?php if ($selected_year == 2021) echo "selected"; ?>>2021</option>	
                                                <option value='2020' <?php if ($selected_year == 2020) echo "selected"; ?>>2020</option>													
                                                <option value='2019' <?php if ($selected_year == 2019) echo "selected"; ?>>2019</option>
                                                <option value='2018' <?php if ($selected_year == 2018) echo "selected"; ?>>2018</option>
                                                <option value='2017' <?php if ($selected_year == 2017) echo "selected"; ?>>2017</option>
                                                <option value='2016' <?php if ($selected_year == 2016) echo "selected"; ?>>2016</option>
                                                <option value='2015' <?php if ($selected_year == 2015) echo "selected"; ?>>2015</option>
                                                <option value='2014' <?php if ($selected_year == 2014) echo "selected"; ?>>2014</option>
                                                <option value='2013' <?php if ($selected_year == 2013) echo "selected"; ?>>2013</option>
                                                <option value='2012' <?php if ($selected_year == 2012) echo "selected"; ?>>2012</option>
                                                <option value='2011' <?php if ($selected_year == 2011) echo "selected"; ?>>2011</option>
                                                <option value='2010' <?php if ($selected_year == 2010) echo "selected"; ?>>2010</option>
                                            </select>
                                        </td>
                                        <td><label for="quater">Quater Term</label></td>
                                        <td><input type="checkbox" name="quater[]" value="Q1" <?php echo (isset($selected_quater_array) AND in_array("Q1", $selected_quater_array))?"checked":""; ?>><label>Q1</label></td>
                                        <td><input type="checkbox" name="quater[]" value="Q2" <?php echo (isset($selected_quater_array) AND in_array("Q2", $selected_quater_array))?"checked":""; ?>><label>Q2</label></td>
                                        <td><input type="checkbox" name="quater[]" value="Q3" <?php echo (isset($selected_quater_array) AND in_array("Q3", $selected_quater_array))?"checked":""; ?>><label>Q3</label></td>
                                        <td><input type="checkbox" name="quater[]" value="Q4" <?php echo (isset($selected_quater_array) AND in_array("Q4", $selected_quater_array))?"checked":""; ?>><label>Q4</label></td>
                                        <td><input type="submit" class="btn btn-sm btn-info" id="sub" value=">>" /></td>
                                    </tr>
                                    </form>
                                </table>
					        </td>
					    </tr>
					</table>
					
                    <?php 
                        if (!empty($selected_year) AND !empty($selected_quater_array)){
                    ?>
                    <div class="bs-example container" data-example-id="striped-table">
                        <table class="table table-striped table-bordered table-hover" style="width: 90%;">
                            <thead>
                                <tr>
									 
                                    <th colspan="6" class="text-center text-info"> Financial Year <?php echo $year; ?> Quarter (<?php echo $title; ?>) <span class="text-warning"> <?php echo (isset($check_achivements) AND $check_achivements == 1)?"The Result Is Being Seen Till ".date('d-m-Y', strtotime($current_date)):""; ?></span><span class="text-info"> All Monetary value is Lakh</span></th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Achievment</th>
                                    <th class="text-center">Achievment (%)</th>
                                    <th class="text-center">Last Year</th>
                                    <th class="text-center">Growth(%)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td> <p>CR-Pedrollo</p> </td>
                                    <td><?php echo lakh($result_cr_pedrollo_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_cr_pedrollo_target->total > $result_for_achivements->cr_ped)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->cr_ped); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->cr_ped > $result_for_achivements->cr_ped)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <a href="achivement_report.php?year='<?php echo $selected_year; ?>'&SPART='20,30'&searching_parameters_for_achivements_trimed_edition='<?php echo $dateList; ?>'" target="_blank">
                                        <?php 
                                            echo ROUND((lakh($result_for_achivements->cr_ped) * 100)/lakh($result_cr_pedrollo_target->total),2).'%';
                                        ?>
                                        </span>
                                        </a>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->cr_ped); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->cr_ped) - lakh($result_for_last_year->cr_ped)) / lakh($result_for_achivements->cr_ped))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth,2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <p>Cr-BGFlow</p> </td>
                                    <td><?php echo lakh($result_cr_bgflow_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_cr_bgflow_target->total > $result_for_achivements->cr_bg)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->cr_bg); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->cr_bg > $result_for_achivements->cr_bg)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <a href="achivement_report.php?year='<?php echo $selected_year; ?>'&SPART='50'&searching_parameters_for_achivements_trimed_edition='<?php echo $dateList; ?>'" target="_blank">
                                        <?php 
                                            echo ROUND((lakh($result_for_achivements->cr_bg) * 100)/lakh($result_cr_bgflow_target->total),2).'%';
                                        ?>
                                        </a>
                                        </span>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->cr_bg); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->cr_bg) - lakh($result_for_last_year->cr_bg)) / lakh($result_for_achivements->cr_bg))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth,2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <p>CR-ITAP</p> </td>
                                    <td><?php echo lakh($result_cr_itap_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_cr_itap_target->total > $result_for_achivements->cr_itap)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->cr_itap); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->cr_itap > $result_for_achivements->cr_itap)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <a href="achivement_report.php?year='<?php echo $selected_year; ?>'&SPART='60'&searching_parameters_for_achivements_trimed_edition='<?php echo $dateList; ?>'" target="_blank">
                                        <?php 
                                            echo ROUND((lakh($result_for_achivements->cr_itap) * 100)/lakh($result_cr_itap_target->total),2).'%';
                                        ?>
                                        </a>
                                        </span>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->cr_itap); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->cr_itap) - lakh($result_for_last_year->cr_itap)) / lakh($result_for_achivements->cr_itap))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth,2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <p>CR-Total</p> </td>
                                    <td><?php echo lakh($result_cr_total_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_cr_total_target->total > $result_for_achivements->cr_total)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->cr_total); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->cr_total > $result_for_achivements->cr_total)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <a href="achivement_report.php?year='<?php echo $selected_year; ?>'&SPART='20,30,50,60'&searching_parameters_for_achivements_trimed_edition='<?php echo $dateList; ?>'" target="_blank">
                                        <?php 
                                            echo ROUND((lakh($result_for_achivements->cr_total) * 100)/lakh($result_cr_total_target->total),2).'%';
                                        ?>
                                        </a>
                                        </span>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->cr_total); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->cr_total) - lakh($result_for_last_year->cr_total)) / lakh($result_for_achivements->cr_total))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth, 2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <p>SR</p> </td>
                                    <td><?php echo lakh($result_showroom_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_showroom_target->total > $result_for_achivements->sr)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->sr); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->sr > $result_for_achivements->sr)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <?php 
                                            echo ROUND((lakh($result_for_achivements->sr) * 100)/lakh($result_showroom_target->total),2).'%';
                                        ?>
                                        </span>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->sr); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->sr) - lakh($result_for_last_year->sr)) / lakh($result_for_achivements->sr))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth,2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <p>BD</p> </td>
                                    <td><?php echo lakh($result_bd_target->total); ?></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_bd_target->total > $result_for_achivements->bd)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo lakh($result_for_achivements->bd); ?>
                                        </span>
                                        <i class="<?php echo ($result_for_last_year->bd > $result_for_achivements->bd)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                    <td>
                                        <span>
                                        <!-- %information -->
                                        <?php 
											if($result_bd_target->total>0)
                                            echo ROUND((lakh($result_for_achivements->bd) * 100)/lakh($result_bd_target->total),2).'%';
                                        ?>
                                        </span>
                                    </td>
                                    <td><?php echo lakh($result_for_last_year->bd); ?></td>
                                    <td>
                                        <!-- Growth Calculation -->
                                        <?php 
                                            $Growth = 0;
                                            $Growth = ((lakh($result_for_achivements->bd) - lakh($result_for_last_year->bd)) / lakh($result_for_achivements->bd))*100; 
                                        ?>
                                        <span class="<?php echo ($Growth <= 0)?'text-danger':'text-success'; ?>"><?php echo ROUND($Growth,2).'%'; ?></span>
                                        <i class="<?php echo ($Growth <= 0)?"fa fa-arrow-down text-danger":"fa fa-arrow-up text-success"; ?>"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-striped table-bordered table-hover" style="width: 90%;">
                            <thead>
                                <tr>
                                    <th colspan="7" class="text-center text-success">Brandwise Sales (Qty)</th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-center text-info">Financial Year <?php echo $year; ?> Quarter (<?php echo $title; ?>) <span class="text-warning"> <?php echo (isset($check_achivements) AND $check_achivements == 1)?"The Result Is Being Seen Till ".date('d-m-Y', strtotime($current_date)):""; ?></span></th>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th class="text-center" colspan="2">BD</th>
                                    <th class="text-center" colspan="2">CR</th>
                                    <th class="text-center" colspan="2">SR</th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">BD (CY)</th>
                                    <th class="text-center">BD (LY)</th>
                                    <th class="text-center">CR (CY)</th>
                                    <th class="text-center">CR (LY)</th>
                                    <th class="text-center">SR (CY)</th>
                                    <th class="text-center">SR (LY)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>    
                                    <td><p>Pedrollo</p></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->bd_ped >= $result_for_brandwise_sell_current_year->bd_ped)?"text-danger":"text-success"; ?>
                                        ">
                                        
										<?php echo $result_for_brandwise_sell_current_year->bd_ped; ?>
										
										
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=20&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=BD" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->bd_ped; ?></a></td>
									
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->cr_ped >= $result_for_brandwise_sell_current_year->cr_ped)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->cr_ped; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=20&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=CR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->cr_ped; ?>
									</a>
									</td>
									
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->sr_ped >= $result_for_brandwise_sell_current_year->sr_ped)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->sr_ped; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=20&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=SR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->sr_ped; ?>
									</a>
									</td>
                                </tr>
                                <tr>    
                                    <td><p>BG Flow</p></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->bd_bg >= $result_for_brandwise_sell_current_year->bd_bg)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->bd_bg; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=50&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=BD" target="_blank" rel="noopener noreferrer">

									<?php echo $result_for_brandwise_sell_last_year->bd_bg; ?></a></td>
							
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->cr_bg >= $result_for_brandwise_sell_current_year->cr_bg)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->cr_bg; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=50&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=CR" target="_blank" rel="noopener noreferrer">

									<?php echo $result_for_brandwise_sell_last_year->cr_bg; ?>
									</a>
									</td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->sr_bg >= $result_for_brandwise_sell_current_year->sr_bg)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->sr_bg; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=50&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=SR" target="_blank" rel="noopener noreferrer">

									<?php echo $result_for_brandwise_sell_last_year->sr_bg; ?></a>
									</td>
                                </tr>
                                <tr>    
                                    <td><p>ITAP</p></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->bd_itap >= $result_for_brandwise_sell_current_year->bd_itap)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->bd_itap; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=60&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=BD" target="_blank" rel="noopener noreferrer">

									<?php echo $result_for_brandwise_sell_last_year->bd_itap; ?>
									</a>
									</td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->cr_itap >= $result_for_brandwise_sell_current_year->cr_itap)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->cr_itap; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=60&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=CR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->cr_itap; ?>
									</a>
									</td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->sr_itap >= $result_for_brandwise_sell_current_year->sr_itap)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->sr_itap; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=60&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=SR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->sr_itap; ?>
									</a>
									</td>
                                </tr>
                                <tr>    
                                    <td><p>Maxwell</p></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->bd_maxwell >= $result_for_brandwise_sell_current_year->bd_maxwell)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->bd_maxwell; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=95&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=BD" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->bd_maxwell; ?></a>
									</td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->cr_maxwell >= $result_for_brandwise_sell_current_year->cr_maxwell)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->cr_maxwell; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=95&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=CR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->cr_maxwell; ?></a></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->sr_maxwell >= $result_for_brandwise_sell_current_year->sr_maxwell)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->sr_maxwell; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=95&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=SR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->sr_maxwell; ?></a></td>
                                </tr>
                                <tr>    
                                    <td><p>Panelli</p></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->bd_paneli >= $result_for_brandwise_sell_current_year->bd_paneli)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->bd_paneli; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=52&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=BD" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->bd_paneli; ?></a></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->cr_paneli >= $result_for_brandwise_sell_current_year->cr_paneli)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->cr_paneli; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=52&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=CR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->cr_paneli; ?></a></td>
                                    <td>
                                        <span class="
                                        <?php echo ($result_for_brandwise_sell_last_year->sr_paneli >= $result_for_brandwise_sell_current_year->sr_paneli)?"text-danger":"text-success"; ?>
                                        ">
                                        <?php echo $result_for_brandwise_sell_current_year->sr_paneli; ?>
                                        </span>
                                    </td>
                                    <td>
									<a href="comparesSalesGroupQty.php?spart=52&osdate=<?php echo $cs_date; ?>&oedate=<?php echo $ce_date; ?>&csdate=<?php echo $os_date; ?>&cedate=<?php echo $oe_date; ?>&group=SR" target="_blank" rel="noopener noreferrer">
									<?php echo $result_for_brandwise_sell_last_year->sr_paneli; ?>
									</a>
									</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>




				</div>
			</div>
		</div>



		<script>
			$(document).ready(function() {
				$("select.flexselect").flexselect();

			});
		</script>





	</body>

	</html>
<?php

	// include_once("footer.php");

} 
else {
	include_once("login.php");
} ?>



<script>
    // Ajax Select Function List By Selecting a Controller
    $(document).ready(function() {});
</script>

<script>
	function tab4(){
		var curr_year = new Date().getFullYear();
		document.getElementById('year').value = curr_year;
		var curr_month = new Date().getMonth();
		if(curr_month >= 0 && curr_month <= 2){
			document.getElementsByName('quater[]')[2].checked = true;
		}else if(curr_month >= 3 && curr_month <= 5){
			document.getElementsByName('quater[]')[3].checked = true;
		}else if(curr_month >= 6 && curr_month <= 8){
			document.getElementsByName('quater[]')[0].checked = true;
		}else if(curr_month >= 9 && curr_month <= 11){
			document.getElementsByName('quater[]')[1].checked = true;
		}
		
		// document.getElementById('sub').click();
		// window.onbeforeunload = null;
	}
	window.onload = tab4;
</script>