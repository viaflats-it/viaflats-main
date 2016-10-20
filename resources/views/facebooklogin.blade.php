<?php
     
        $fb = new Facebook\Facebook([
        'app_id' => '220761998341263',
        'app_secret' => 'ed4cb1999a7d9ff37b4054c7befb282f',
        'default_graph_version' => 'v2.5',
        ]); 


        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile']; // optional

        $loginUrl = $helper->getLoginUrl('http://localhost:8000/fbsignup', $permissions);
        echo '<a href="' . $loginUrl . '"><button class="btn-info" style="border-radius:20px;">Log in with Facebook !</button></a>';

        //$helper = $fb->getCanvasHelper();

        /*try {
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

        if (! isset($accessToken)) {
          echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
          exit;
        }*/

        /*
        $response = $fb->get('/me');
        $userNode = $response->getGraphUser();

        echo $userNode->getName();*/

        
  