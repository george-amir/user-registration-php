<?php

require('vendor/autoload.php');

use Rakit\Validation\Validator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Noodlehaus\Config;
use Noodlehaus\Parser\Php;

Class Register {

    public function start(){
        // validate data
        $this->validate();
        // create user
        return $this->create();
    }

    public function getInputs($obj = false){
        // get form data
        $data = $_POST;
        // check if there is no form data try to get json data
        if(!count($data)){
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
        }
        // return array or object
        return ($obj)?(object)$data:$data;
    }

    public function dbConnection(){
        // get configuration file
        $conf = Config::load('config.php');
        // init capsule manager
        $capsule = new Capsule;
        // database configuration
        $capsule->addConnection([
            'driver'    => $conf->get('driver'),
            'host'      => $conf->get('host'),
            'database'  => $conf->get('database'),
            'username'  => $conf->get('username'),
            'password'  => $conf->get('password'),
            'charset'   => $conf->get('charset'),
            'collation' => $conf->get('collation'),
            'prefix'    => $conf->get('prefix'),
        ]);

        $capsule->setAsGlobal();
        return $capsule;
    }

    public function validate(){
        $validator = new Validator;
        // get input as form data or json
        $inputs = $this->getInputs();
        // init connection to database for email check
        $capsule = $this->dbConnection();
        // validate input
        $validation = $validator->validate($inputs, [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => ['required','email','unique' => function($value) use($capsule){
                                            return !!!$capsule->table('users')->where('email', $value)->first();
                                        }],
            'password'              => 'required|min:6',
            'confirm_password'      => 'required|same:password'
        ]);
        // check validation and return errors if exist
        if ($validation->fails()) {
            return $this->response($validation->errors()->toArray(), 'failed', 403);
        } 
    }

    public function create(){
        // get inputs
        $inputs = $this->getInputs(true);
        // init db connection
        $capsule = $this->dbConnection();
        // insert data into db
        $user = $capsule->table('users')->insert([
            'first_name' => $inputs->first_name,
            'last_name' => $inputs->last_name,
            'email' => $inputs->email,
            'password' => password_hash($inputs->password, PASSWORD_DEFAULT)
        ]);
        
        return $this->response(['message' => 'user registered successfully', 'user' => $user], 'success', 200);

    }
    
    public function response($data, $status, $code){
        // return response data and die
        die(json_encode(['data' => $data, 'status' => $status, 'code' => $code]));
    }
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$register = new Register();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    return $register->response(['message' => 'Method not allowed'],'failed', 403);
}

echo $register->start();