<?php
class Authentication extends Controller
{
    protected $_data = [], $_authModel;
    public function __construct()
    {
        $this->_authModel = $this->model('AuthModel');
    }
    public function register()
    {
        $this->_data['sub_content'][''] = '';
        $this->_data['content'] = 'auth/register';
        $this->_data['sub_content']['msg'] = Session::flash('msg');
        $this->render('layouts/client_layout', $this->_data);
    }

    public function register_action()
    {
        $request = new Request();
        if ($request->isPost()) {
            $request->rules([
                'username' => 'required|min:5|max:30|unique:users:username',
                'password' => 'required|min:3',
                'email' => 'required|email|min:6|unique:users:email',
                'confirm_password' => 'required|match:password',
            ]);

            $request->message([
                'username.required' => 'Họ và tên không được để trống',
                'username.min' => 'Họ và tên không được nhỏ hơn 5 ký tự',
                'username.max' => 'Họ và tên không được lớn hơn 30 ký tự',
                'username.unique' => 'Họ và tên đã được đăng ký trước đó',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu không được nhỏ hơn 3 ký tự',
                'email.required' => 'Email không được để trống.',
                'email.min' => 'Email không được nhỏ hơn 6 ký tự',
                'email.unique' => 'Email này đã được đăng ký',
                'email.email' => 'Email không đúng định dạng',
                'confirm_password.required' => 'Xác nhận mật khẩu không được để trống',
                'confirm_password.match' => 'Xác nhận mật khẩu không khớp',
            ]);

            $validate = $request->validate();
            $response = new Response();
            if (!$validate) {
                Session::flash('msg', "Đã có lỗi xảy ra vui lòng kiểm tra lại");
                $response->redirect('authentication/register');
            } else {
                $data = $request->getFields();
                $data['password'] = md5($data['password']);

                if (!empty($data["confirm_password"])) {
                    unset($data["confirm_password"]);
                }

                $data['role_id'] = 2;
                $result = $this->_authModel->register($data);
                if ($result) {
                    Session::flash('register_success', true);
                    $response->redirect('authentication/login');
                }
            }
        }
    }

    public function login()
    {
        $register_success = Session::flash('register_success');
        $msg = Session::flash('msg');
        $this->_data['sub_content']['register_success'] = $register_success;
        $this->_data['sub_content']['msg'] = $msg;
        $this->_data['content'] = 'auth/login';
        $this->render('layouts/client_layout', $this->_data);
    }

    public function login_action()
    {
        $request = new Request();
        if ($request->isPost()) {
            $request->rules([
                'username' => 'required|min:5|max:30',
                'password' => 'required',
            ]);
            $request->message([
                'username.required' => 'Tên đăng nhập không được đế trống.',
                'username.min' => 'Tên đăng nhập không được nhỏ hơn 5',
                'username.max' => 'Tên đăng nhập không được lớn hơn 30',
                'password.required' => 'Mật khẩu không được để trống',
            ]);
            $validate = $request->validate();
            $response = new Response();
            if (!$validate) {
                $response->redirect('authentication/login');
            } else {
                $data = $request->getFields();
                $result = $this->_authModel->login($data);

                if (count($result) > 0) {
                    Session::flash("login_success", true);
                    if ($result[0]['role_id'] == 2) {
                        Session::data("userID", $result[0]['ID']);
                        $response->redirect('home/index');
                    } else if ($result[0]['role_id'] == 1) { // role_id : 1 (admin)
                        Session::data("adminID", $result[0]['ID']);
                        $response->redirect('admin/Dashboard/index');
                    }
                } else {
                    Session::flash('msg', 'Tài khoản hoặc mật khẩu không đúng');
                    $response->redirect('authentication/login');
                }
            }
        }
    }

    public function logout()
    {
        if (!empty(Session::data('userID'))) {
            Session::delete("userID");
        }

        $response = new Response();
        $response->redirect('home/index');
    }
}
