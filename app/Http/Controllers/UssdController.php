<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UssdController extends Controller
{
    public static function onlineUssdMenu(Request $request) {
        //variables from Africa's Talking gateway

        //sessionId: a unique value generated by Africa’s talking every time a user dials your USSD code
        $sessionId      = $request->get('sessionId');
        //serviceCode: your USSD code
        $serviceCode    = $request->get('serviceCode');
        $phoneNumber    = $request->get('phoneNumber');
        //text: user input in form of a string
        $text           = $request->get('text');

        //split the string text response from Africa's talking gateway into an array
        $ussd_string_exploded = explode("*", $text);

        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if($text == "") {
            // first response when a user dials our ussd code
            $response   = "CON Welcome to free online RSVPing at TICKIT \n";
            $response  .= "1. Register \n";
            $response  .= "2. About TICKIT";

        } elseif ($text == "1") {
            // when user respond with option one to register
            $response  = "CON Choose which recent tickets from the list: \n";
            $response .= "1. Progate Meetup #3 at AUCA on April the 3rd \n";
            $response .= "2. Entrepreneurship Session at Westerwelle on 1st June";

        } elseif ($text == "1*1") {
            // when user responds with option progate
            $response = "CON Please enter your first name:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 3) {
            $response = "CON Please enter your second name:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 4) {
            $response = "CON Please enter your your email:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 5) {
            // save data in the database
            $response = "END Your information has been recorded!
                        Thank you for RSVPing on Progate Meetup #3 on TICKIT.";
        }
        //Entrepreneurship option
        elseif ($text == "1*2") {
            // when user responds with option entrepreneurship session
            $response = "CON Please enter your first name:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 3) {
            $response = "CON Please enter your second name:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 4) {
            $response = "CON Please enter your your email:";

        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 5) {
            // save data in the database
            $response = "END Your information has been recorded!
                        Thank you for RSVPing on Entrepreneurship session at Westerwelle on TICKIT.";
        }

        //About sessio(on *2)
        elseif ($text == "2") {
            // Our response once a user responds with input 2 from our first level
            $response = "END At TICKIT we provide you with free tickets
                        on recent events using!.";
        }

        //send your response back to the API
        header('Content-type: text/plain');
        echo $response;
    }


    
}   

