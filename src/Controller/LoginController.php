<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class LoginController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow();
    }   

    public function index()
    {
        $session = $this->request->session();
        if ($session->check('User.id')) {
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }
    }

    public function role($rol){
        if($rol == 'admin' ||$rol == 'encargado' ||$rol == "voluntario") 
            $session = $this->request->session();
            $session->write('User.rol',$rol);

        return $this->redirect(["controller"=>"Home","action"=>"index"]);
    }

    public function login(){
        $session = $this->request->session();
        if ($session->check('User')) {
            return $this->redirect(['controller' => 'Login', 'action' => 'logout']);
        }

        $formData = $this->request->data;
        if ($this->request->is('post')) {
            $this->loadModel('Users');
            $user = $this->Users->login($formData['username'],$formData['password']);
            if ($user){
                $session->write('User',$user->toArray());
                $session->write('User.isEncargado',$user->hasMissions());
                $session->write('User.Entity',$user);

                $rol = "voluntario";
                if($user->admin==1){
                    $rol="admin";
                }elseif($user->hasMissions()){
                    $rol="encargado";
                }
                $session->write('User.rol',$rol);


                return $this->redirect(['controller' => 'Home', 'action' => 'index']);
            }else{
                $this->Flash->set('Nombre de usuario o contraseña incorrecta');
            }
        }

        return $this->redirect(['controller' => 'Login', 'action' => 'index']);
    }

    public function logout(){
        $this->request->session()->destroy();
        return $this->redirect(['controller' => 'Login', 'action' => 'index']);
    }

    public function register(){
        $this->loadModel('Communes');
        $this->loadModel('Users');

        $communes = $this->Communes->find('all');
        $this->set(compact('communes'));

        /*Aquí se "agarran" los datos del formulario*/
        if ($this->request->is('post')) 
        {
            $datosUsuario   = $this->request->data;
            $exists = $this->Users->getUserByData($datosUsuario['user_rut'], $datosUsuario['user_nickname']); 
            if($exists == 1)
            {
                $this->Flash->error('El rut ingresado ya existe en la base de datos.');
            }
            else if($exists == 2)
            {
                $this->Flash->error('El nombre de usuario ingresado ya existe en la base de datos.');
            }
            else
            {
                $rut = explode('-', $datosUsuario['user_rut']);
                
                if(count($rut) == 2 && is_numeric($rut[0]))
                {
                    if(strlen($rut[1]) && (is_numeric($rut[1]) || $rut[1] == 'k'))
                    {
                        $this->Users->registerUser($datosUsuario);
                        $this->redirect(['controller' => 'Login', 'action' => 'index']);
                        $this->Flash->success('Se ha registrado con éxito!');
                    }
                    else
                    {
                        $this->Flash->error('Formato de rut incorrecto');
                    }
                }
                else
                {
                        $this->Flash->error('Formato de rut incorrecto');
                }
            }
        }
    }
}