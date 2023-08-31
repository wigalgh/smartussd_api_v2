<?php
include('include/connect.php');
include('functions.php');

$TIME=date("Y/m/d h:i:s");
$today=date("Y-m-d");
$mobile_moneyApi="https://api.reddeonline.com/v1/receive";
$nickname="bakesidev2";
$welcome="Welcome to Bakeside Campaign Version 2\n Select your Option:\n^1. Donate ^2. Volunteer";


$data =  @file_get_contents('php://input');
$dataobj = json_decode($data);
$DATA = $dataobj->userdata;

if(!empty($data) && is_object($dataobj))
{
    //STEP ONE CHECK IF ITS START OF SESSION
    if(strtolower($dataobj->mode) == 'start')
    {
        // var_dump($dataobj);
        deleteTracking($dataobj->phonenumber);
        insertTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,'1','1');

        $dataobj->mode = "more";
        $dataobj->userdata = $welcome;
        deleteProgress($dataobj->phonenumber);
        insertProgress($dataobj->phonenumber,$dataobj->sessionid,'','','',$dataobj->network,'','','','');
    }
    else
    {
        $row =getTracking($dataobj->phonenumber);
        $userData=$row['userData'];
        $track=$row['track'];
        $rowopt = getProgress($dataobj->phonenumber);
        $option=$rowopt['option'];
        $donor_name=$rowopt['donor_name'];
        $amount=$rowopt['amount'];
        $network=$rowopt['network'];
        $walletno=$rowopt['walletno'];
        $volunteer_name=$rowopt['volunteer_name'];
        $age=$rowopt['age'];
        $email=$rowopt['email'];
        switch ($track)
            {
            case "1":
                    if($dataobj->userdata == '1'){
                                updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'2');
                                $dataobj->mode = "more";
                                $dataobj->userdata = "Enter your Full Name (First - Middle - Surname) to donate:";
                                updateProgress($dataobj->phonenumber,$dataobj->sessionid,"option","Donate");
                            }
                        elseif ($dataobj->userdata == '2') {
                                updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'2');
                                $dataobj->mode = "more";
                                $dataobj->userdata = "Enter your Full Name (First - Middle - Surname) to Volunteer:";
                                updateProgress($dataobj->phonenumber,$dataobj->sessionid,"option","Volunteer");
                              }
                          else{
                             updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'1');
                             $dataobj->mode = "more";
                             $dataobj->userdata = $welcome;
                           }
                break;

            case "2":
                    if ($option == 'Donate') {
                             updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$dataobj->userdata,'3');
                             $dataobj->mode = "more";
                             $dataobj->userdata = "Enter Amount to Donate: ";
                            updateProgress($dataobj->phonenumber,$dataobj->sessionid,"donor_name",$DATA);
                            }
                          elseif($option == 'Volunteer') {

                             updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$dataobj->userdata,'3');
                             $dataobj->mode = "more";
                             $dataobj->userdata = "Enter Age: ";
                             updateProgress($dataobj->phonenumber,$dataobj->sessionid,"volunteer_name",$DATA);
                            }
                break;

            case "3":
                    if ($option == 'Donate') {
                          if(is_numeric($DATA)) {
                            $fetchdis = getProgress($dataobj->phonenumber);
                            $walletno=$fetchdis['ID'];
                            $donor_name=$fetchdis['donor_name'];
                            $network=$fetchdis['network'];
                               updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$dataobj->userdata,'4');
                               $dataobj->mode = "more";
                               $dataobj->userdata = "Confirm Donation Summary^Name: $donor_name ^Amount: GHS $DATA^$network Wallet Num: $walletno ^^1. Yes^2. No ";
                              updateProgress($dataobj->phonenumber,$dataobj->sessionid,"amount",$DATA);
                          }
                            else {
                                
                              updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$dataobj->userdata,'3');
                               $dataobj->mode = "more";
                               $dataobj->userdata = "Invalid Amount inputted, Kindly ensure you enter a valid numeric amount. ";
                              updateProgress($dataobj->phonenumber,$dataobj->sessionid,"amount",$DATA);
                            }
                      }
                    elseif($option == 'Volunteer') {
                        if (is_numeric($DATA)) {
                        
                             updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'4');
                             $dataobj->mode = "more";
                             $dataobj->userdata = "Enter your Email Address: ";
                             updateProgress($dataobj->phonenumber,$dataobj->sessionid,"age",$DATA);
                           }
                           else{
                            updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'3');
                             $dataobj->mode = "more";
                             $dataobj->userdata = "Invalid Age inputted, Kindly ensure you enter a valid Age. ";
                            updateProgress($dataobj->phonenumber,$dataobj->sessionid,"age",$DATA);
                          }
                      }
                break;
                    
            case "4":
                    if ($option == 'Donate') {
                                if($DATA=='1'){
                                  $fetchdis = getProgress($dataobj->phonenumber);
                                  $walletno=$fetchdis['ID'];
                                  $donor_name=$fetchdis['donor_name'];
                                  $network=$fetchdis['network'];
                                  $amount=$fetchdis['amount'];
                                  updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'5');
                                    $dataobj->mode = "END";
                                    $dataobj->userdata = "Your payment request has been initiated. Kindly approve the payment prompt from $network.";
                                    echo json_encode($dataobj);
                                    session_write_close();  //close the USSD seesion 
                                    fastcgi_finish_request();    //close the USSD seesion
                                    sleep(5); //wait for 3 seconds to iniate the payment request
                                    insertTransaction($amount,$donor_name,$walletno,$network,$dataobj->trafficid);
                                }

                                else{
                                  updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'5');
                                  $dataobj->mode = "end";
                                  $dataobj->userdata = "Payment Cancelled. Thanks for using our system ";
                                }
                                
                            }
                          elseif($option== 'Volunteer') {
                                                                 
                               if (filter_var($DATA, FILTER_VALIDATE_EMAIL)) {

                               $fetchdis = getProgress($dataobj->phonenumber);
                               $volunteer_name=$fetchdis['volunteer_name'];
                               $age=$fetchdis['age'];

                                  updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'5');
                                  $dataobj->mode = "more";
                                  $dataobj->userdata = "Confirm Summary^Name: $volunteer_name ^Age: $age^Email: $DATA ^^1. Yes^2. No ";
                                 updateProgress($dataobj->phonenumber,$dataobj->sessionid,"email",$DATA);
                               }
                               else{
                                updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'4');
                                 $dataobj->mode = "more";
                                 $dataobj->userdata = "Invalid Email inputted, Kindly ensure you enter a valid Email. ";
                                updateProgress($dataobj->phonenumber,$dataobj->sessionid,"email",$DATA);
                               }
                          }
                break;

            case "5":
                    if ($option=='Volunteer') {
                                  if($DATA=="1"){
                                    $fetchdis = getProgress($dataobj->phonenumber);
                                    $full_name=$fetchdis['volunteer_name'];
                                    $mobile_number=$fetchdis['ID'];
                                    $age=$fetchdis['age'];
                                    $email=$fetchdis['email'];
                                    $message= "Thank you $full_name with the email address $email for voluntering with Bakeside.";

                                    updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'6');
                                    insertvolunteer($full_name,$mobile_number,$age,$email);
                                    sendSMS($mobile_number,$message);
                                    sendEmai($email,$message);
                                    sendVoice($mobile_number,$message);
                                     $dataobj->mode = "end";
                                     $dataobj->userdata = "Thank you for Volunteering with Bakeside. ";

                                    }else{
                                       updateTracking($dataobj->phonenumber,$dataobj->sessionid,$dataobj->mode,$dataobj->username,$TIME,$DATA,'6');
                                       $dataobj->mode = "end";
                                       $dataobj->userdata = "Request Cancelled. Thanks for using our system. ";
                                    }
                                }
                break;
                }
        }
    }
    echo json_encode($dataobj); 
?>