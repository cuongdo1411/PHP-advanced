<?php
class Product extends Controller
{
    protected $_data = [], $_productModel, $_brands, $_categories, $_switch_categories;

    public function __construct()
    {
        $this->_productModel = $this->model('ProductModel');
        $this->_brands = $this->_productModel->getBrand();
        $this->_categories = $this->_productModel->getCategories();
        $this->_switch_categories = $this->_productModel->getSwitchCategories();
    }

    public function add()
    {
        $this->_data['sub_content']['brands'] = $this->_brands;
        $this->_data['sub_content']['categories'] = $this->_categories;
        $this->_data['sub_content']['switch_categories'] = $this->_switch_categories;
        $this->_data['sub_content']['title'] = 'Thêm sản phẩm';
        $this->_data['content'] = 'products/add';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function add_products()
    {
        $request = new Request();
        $request->rules($this->getRule());
        $request->message($this->getMessage());
        $validate = $request->validate();
        $response = new Response;
        if ($validate) {
            $postData = $request->getFields();

            // Image Handle
            $imgName = $this->getImageName($postData['image']);

            unset($postData['image']);

            $postData['image'] = $imgName; // Set image name

            // Select Property Handle
            $brandID = $this->getIdByCol($this->_brands, 'name', $postData['brand']);
            $categoryID = $this->getIdByCol($this->_categories, 'name', $postData['category']);
            $switchID = $this->getIdByCol($this->_switch_categories, 'category', $postData['switch']);

            unset($postData['brand']);
            unset($postData['category']);
            unset($postData['switch']);

            $postData['brand'] = $brandID;
            $postData['product_type_id'] = $categoryID;
            $postData['switch'] = $switchID;

            // Database
            if(!empty($_FILES)){
                $this->saveImage($_FILES);
            }
            $result = $this->_productModel->insertProduct($postData);
            if ($result) {
                Session::flash('add_success', "Thêm dữ liệu thành công");
                $response->redirect('admin/dashboard/index');
            }
        } else {
            $response->redirect('admin/product/add');
        }
    }

    public function edit($id)
    {
        $productById = $this->_productModel->getProductById($id);
        $this->_data['sub_content']['brands'] = $this->_brands;
        $this->_data['sub_content']['categories'] = $this->_categories;
        $this->_data['sub_content']['switch_categories'] = $this->_switch_categories;
        $this->_data['sub_content']['productById'] = $productById[0];
        $this->_data['content'] = 'products/edit';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function edit_product($id)
    {
        $request = new Request();

        $request->rules($this->getRule());
        $request->message($this->getMessage());

        $validate = $request->validate();
        $response = new Response;
        if ($validate) {
            // Get Data
            $postData = $request->getFields();

            // Image Handle
            $imgName = $this->getImageName($postData['image']);
            unset($postData['image']);
            $postData['image'] = $imgName; // Set image name

            // Select Property Handle
            $brandID = $this->getIdByCol($this->_brands, 'name', $postData['brand']);
            $categoryID = $this->getIdByCol($this->_categories, 'name', $postData['category']);
            $switchID = $this->getIdByCol($this->_switch_categories, 'category', $postData['switch']);
            unset($postData['brand']);
            unset($postData['category']);
            unset($postData['switch']);
            unset($postData['current_image']);
            $postData['brand'] = $brandID;
            $postData['product_type_id'] = $categoryID;
            $postData['switch'] = $switchID;

            // Database
            $this->saveImage($postData); // Upload Image
            $result = $this->_productModel->editProduct($id, $postData);
            if ($result) {
                Session::flash('edit_success', "Cập nhật dữ liệu thành công");
                $response->redirect('admin/dashboard/index');
            }
        } else {
            $response->redirect('admin/product/edit/' . $id);
        }
    }

    public function add_brand()
    {
        $this->_data['sub_content']['brands'] = $this->_brands;
        $this->_data['sub_content']['title'] = 'Sửa sản phẩm';
        $this->_data['content'] = 'brands/add';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function add_brand_action()
    {
        $request = new Request();
        $response = new Response();
        $request->rules([
            'mainBrand' => 'required|unique:brand:name',
        ]);
        $request->message([
            'mainBrand.required' => 'Tên thương hiệu không được để trống',
            'mainBrand.unique' => 'Tên thương hiệu này đã tồn tại trong hệ thống',
        ]);
        $validate = $request->validate();
        if ($validate) {
            $brands = $request->getFields();

            // Change property.
            foreach ($brands as $key => $brandValue) {
                if ($key == 'mainBrand') {
                    $newKey = 'name';
                    $brandData[$newKey] = $brandValue;
                }
            }

            $this->_productModel->insertBrand($brandData);
            Session::flash('add_brand_success', 'Thêm dữ liệu thành công');
            $response->redirect('admin/dashboard/index');
        } else {
            $response->redirect('admin/product/add_brand');
        }
    }

    public function edit_brand($id)
    {
        $brandsById = $this->_productModel->getBrandById($id);
        $this->_data['sub_content']['brandsById'] = $brandsById[0];
        $this->_data['content'] = 'brands/edit';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function edit_brand_action($id)
    {
        $request = new Request();
        $response = new Response();
        $request->rules([
            'mainBrand' => 'required',
        ]);
        $request->message([
            'mainBrand.required' => 'Tên thương hiệu không được để trống',
        ]);
        $validate = $request->validate();
        if ($validate) {
            $brands = $request->getFields();
            // Change property.
            foreach ($brands as $key => $brandValue) {
                if ($key == 'mainBrand') {
                    $newKey = 'name';
                    $brandData[$newKey] = $brandValue;
                }
            }
            $this->_productModel->editBrand($id, $brandData);
            Session::flash('edit_brand_success', 'Cập nhật dữ liệu thành công');
            $response->redirect('admin/dashboard/index');
        } else {
            $response->redirect('admin/product/edit_brand/' . $id);
        }
    }

    public function add_category()
    {
        $this->_data['sub_content']['categories'] = $this->_categories;
        $this->_data['content'] = 'categories/add';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function add_category_action()
    {
        $request = new Request();
        $response = new Response();
        $request->rules([
            'category' => 'required|unique:categories:name',
        ]);
        $request->message([
            'category.required' => 'Danh mục không được để trống',
            'category.unique' => 'Danh mục này đã tồn tại trong hệ thống',
        ]);
        $validate = $request->validate();
        if ($validate) {
            $categories = $request->getFields();
            foreach ($categories as $key => $value) {
                if ($key == 'category') {
                    $newKey = 'name';
                    $newCategories[$newKey] = $value;
                }
            }
            $this->_productModel->insertCategory($newCategories);
            Session::flash('add_category_success', 'Thêm dữ liệu thành công');
            $response->redirect('admin/dashboard/index');
        } else {
            $response->redirect('admin/product/add_category');
        }
    }

    public function edit_category($id)
    {
        $categoriesById = $this->_productModel->getCategoryById($id);
        $this->_data['sub_content']['categoriesById'] = $categoriesById[0];
        $this->_data['content'] = 'categories/edit';
        $this->render('layouts/admin_layout', $this->_data);
    }

    public function edit_category_action($id)
    {
        $request = new Request();
        $response = new Response();
        $request->rules([
            'category' => 'required|unique:categories:name',
        ]);
        $request->message([
            'category.required' => 'Danh mục không được để trống',
            'category.unique' => 'Danh mục này đã tồn tại trong hệ thống',
        ]);
        $validate = $request->validate();
        if ($validate) {
            $categories = $request->getFields();
            foreach ($categories as $key => $value) {
                if ($key == 'category') {
                    $newKey = 'name';
                    $newCategories[$newKey] = $value;
                }
            }
            $this->_productModel->editCategory($id, $newCategories);
            Session::flash('edit_category_success', 'Cập nhật dữ liệu thành công');
            $response->redirect('admin/dashboard/index');
        } else {
            $response->redirect('admin/product/edit_category/' . $id);
        }
    }

    // Support Function

    public function setRule()
    {
        return [
            'name' => 'required|min:5|max:100',
            'price' => 'required|number',
            'brand' => 'required',
            'connect' => 'required|min:5|max:50',
            'layout' => 'required|min:5|max:50',
            'switch' => 'required',
            'warranty' => 'required|min:5|max:50',
            'discount' => 'required|number',
            'category' => 'required',
            'description' => 'required',
            'inventory' => 'required|number',
            'image' => 'imgRequired|imgName|imgType|imgSize',
        ];
    }

    public function getRule()
    {
        return $this->setRule();
    }

    public function setMessage()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.min' => 'Tên sản phẩm phải lớn hơn 5 ký tự.',
            'name.max' => 'Tên sản phẩm phải nhỏ hơn 100 ký tự.',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.number' => 'Giá sản phẩm không được nhỏ hơn 0',
            'brand.required' => 'Vui lòng chọn thương hiệu sản phẩm',
            'connect.required' => 'Kết nối không được để trống',
            'connect.min' => 'Kết nối phải lớn hơn 5',
            'connect.min' => 'Kết nối phải nhỏ hơn 50',
            'layout.required' => 'Layout không được để trống',
            'layout.min' => 'Layout phải lớn hơn 5',
            'layout.max' => 'Layout phải nhỏ hơn 50',
            'switch.required' => 'Switch không được để trống',
            'warranty.required' => 'Bảo hành không được để trống',
            'warranty.min' => 'Bảo hành phải lớn hơn 5',
            'warranty.max' => 'Bảo hành phải nhỏ hơn 50',
            'discount.required' => 'Giảm giá không được để trống',
            'discount.number' => 'Giảm giá không được nhỏ hơn 0',
            'category.required' => 'Danh mục không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'inventory.required' => 'Tồn kho không được để trống',
            'inventory.number' => 'Tồn kho không được nhỏ hơn 0',
            'image.imgRequired' => 'Hình ảnh không được để trống',
            'image.imgName' => 'Có hình ảnh tồn tại trong hệ thống',
            'image.imgType' => 'Chỉ cho phép các định dạng jpg, jpeg, png',
            'image.imgSize' => 'Mỗi một hình ảnh chỉ được phép tối đa 1 MB',
        ];
    }

    public function getMessage()
    {
        return $this->setMessage();
    }

    public function getImageName($imgArr)
    {
        $nameStr = '';
        foreach ($imgArr['name'] as $name) {
            $nameStr .= ', ' . $name;
            $nameStr = trim($nameStr, ', ');
        }
        return $nameStr;
    }

    public function getIdByCol($arr, $col, $valCompare)
    {
        foreach ($arr as $arr1) {
            if ($arr1[$col] == $valCompare) {
                $proID = $arr1['ID'];
            }
        }
        return $proID;
    }

    public function saveImage($arr)
    {
        foreach ($arr['image']['name'] as $key => $name) {
            $tmp_name = $arr['image']['tmp_name'][$key];
            move_uploaded_file($tmp_name, _DIR_ROOT_ . '/public/assets/admin/images/' . $name);
        }
    }
}
