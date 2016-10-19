<?php

        //A connection to the app via facebook is needed
        //Change these values if the used app changes
     
        $fb = new Facebook\Facebook([
        'app_id' => '220761998341263',
        'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
        'default_graph_version' => 'v2.5',
        ]); 


        //Get the URL to redirect the user to
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile']; // optional

        //Get the domain name 
        //Allows the code to work even if the domain name changes
        $url=Request::root();

        //Create the link and the button
        $loginUrl = $helper->getLoginUrl($url.'/fbsignup', $permissions);
        echo '<a href="' . $loginUrl . '"><button class="btn-info" style="border-radius:20px;">'.trans('auth.button_facebook').'</button></a>';
        
  