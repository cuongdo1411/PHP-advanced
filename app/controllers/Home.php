<?php
class Home extends Controller
{

    protected $homeModel, $data = [];

    public function __construct()
    {
        $this->homeModel = $this->model('HomeModel');
    }

    public function index()
    {
        $productData = $this->homeModel->getAllProduct();

        // Handle image
        foreach ($productData as $key => $product) {
            $productData[$key]['image'] = explode(', ', $product['image']);
        }
        $this->data['sub_content']['products'] = $productData;

        $brand = $this->homeModel->getBrandData();
        $this->data['sub_content']['brand'] = $brand;

        $login_success = Session::flash('login_success');
        $this->data['sub_content']['login_success'] = $login_success;

        $this->data['sub_content']['title'] = 'Trang Home';
        $this->data['content'] = 'home/page';

        $this->render('layouts/client_layout', $this->data);
    }

    public function get_user()
    {
        $this->data['msg'] = Session::flash('msg');
        $this->render('users/add', $this->data);
    }

    public function post_user()
    {
        $request = new Request();
        if ($request->isPost()) {
            /*Set Rules */
            $request->rules([
                'fullname' => 'required|min:5|max:30',
                'email' => 'required|email|min:6|unique:infouser:email', // unique: điều kiện kiểm tra sự tồn tại, infouser: tên bảng, email: tên cột
                'password' => 'required|min:3',
                'confirm_password' => 'required|match:password',
                'age' => 'required|callback_check_age'
            ]);

            /*Set Message */
            $request->message([
                'fullname.required' => 'Họ tên không được để trống.',
                'fullname.min' => 'Họ tên lớn hơn 5 ký tự',
                'fullname.max' => 'Họ tên phải nhỏ hơn 30 ký tự',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Định dạng email không hợp lệ',
                'email.min' => 'Email phải lớn hơn 6 ký tự',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật không phải lớn hơn 3 ký tự',
                'confirm_password.required' => 'Nhập lại mật khẩu không được để trống',
                'confirm_password.match' => 'Nhập lại mật khẩu không trùng khớp',
                'age.required' => 'Tuổi không được để trống',
                'age.callback_check_age' => 'Tuổi không được nhỏ hơn 20',
            ]);

            /*Set Validate */
            $validate = $request->validate(); // Phương thức này trả ra giá trị boolean.
            if (!$validate) { // Nếu tồn tại validate
                Session::flash('msg', "Đã có lỗi xảy ra. Vui lòng kiểm tra lại.");
                // Mục đích comment: do đã làm qua bước SESSION nên chúng ta sẽ lưu tất cả những lỗi này vào SESSION.
                // $this->data['errors'] = $request->errors(); 
                // $this->data['msg'] = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại.";
                // $this->data['old'] = $request->getFields();
            }

            // $this->render('users/add', $this->data); => Mục đích comment: do đã làm qua bước SESSION nên chúng ta sẽ lưu tất cả những lỗi này vào SESSION.
        }
        $response = new Response();
        $response->redirect('home/get_user');
    }

    public function check_age($age)
    {
        if ($age >= 20) {
            return true;
        }
        return false;
    }
}
