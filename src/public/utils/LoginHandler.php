<?php

  require_once 'utils/ApiClient.php';
  require_once 'utils/Cookie.php';

  class LoginHandler {

    public $username;
    public $password;
    public $client_id;
    public $scope;
    public $api_uri;
    public $redirect_url;


    public function __construct() {
      require 'utils/Config.php';
      $this->config = $config;
      $this->username = '';
      $this->password = '';
      $this->client_id = '';
      $this->scope = '';
      $this->redirect_url = '';
      $this->api_uri= '/oauth_admin/authorize';
    }

    public function handle(){
      $this->get_params();
      $this->check_login();
      //$this->redirect_to_authorize();
    }


    public function get_params(){
        if( isset($_POST['username']) && isset($_POST['password']) 
            && isset($_POST['client_id']) && isset($_POST['scope'])
            && isset($_POST['redirect_url']) ){
          $this->username = $_POST['username'];
          $this->password = $_POST['password'];
          $this->client_id = $_POST['client_id'];
          $this->scope = $_POST['scope'];
          $this->redirect_url = $_POST['redirect_url'];
        } else {
          redirect_to_login();
        }
    }


    public function check_login(){
        $api = new ApiClient();

        $model = array(
          'username' => $this->username,
          'password' => $this->password,
          'scope' => $this->scope,
          'redirect_url' => $this->redirect_url,
          'client_id' => $this->client_id
        );

        $header = array(
          'Content-Type' => 'application/json',
          'OAuth-Secret' => $this->config['oauth_secret']
        );
        //echo(json_encode($model));
        $api->post( $this->api_uri , $model , $header );

        if($api->get_response_code()==200){
          $this->redirect_to_authorize(http_build_query($api->get_response()));
        }
    }

    public function create_session(){
      $_SESSION['manager_id'] = $this->id;
    }


    public function redirect_to_login(){
      redirect('/authorize');
    }


    public function redirect_to_authorize(string $data){
      redirect('/authorize?authorize=&'.$data);
    }


  }

 ?>
