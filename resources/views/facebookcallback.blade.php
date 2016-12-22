<?php


        $fb = new Facebook\Facebook(['app_id' => '220761998341263',
        'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
        'default_graph_version' => 'v2.5',]);
        
        if(!isset($_SESSION['facebook_access_token']))
        {
          $helper = $fb->getRedirectLoginHelper();
          try {
            $accessToken = $helper->getAccessToken();
           } catch(Facebook\Exceptions\FacebookResponseException $e) {
             // When Graph returns an error
             echo 'Graph returned an error: ' . $e->getMessage();
             exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }

          if (isset($accessToken)) {
            // Logged in!
            $_SESSION['facebook_access_token'] = (string) $accessToken;

            // Now you can redirect to another page and use the
            // access token from $_SESSION['facebook_access_token']
          }
        }

        if(isset($_SESSION['facebook_access_token']))
        {
          $response = $fb->get('/me?fields=id,first_name, last_name,link,email,age_range', $_SESSION['facebook_access_token']);
          $userNode = $response->getGraphUser();

          var_dump($userNode);

          echo "<img src='http://graph.facebook.com/".$userNode['id']."/picture'/>";
        }
