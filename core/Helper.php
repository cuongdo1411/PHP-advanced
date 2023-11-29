<?php
// Helper là một hàm giúp xử lí các câu lệnh lặp đi lặp lại.
// Ví dụ: tại file add.html có những câu lệnh
// <?php echo (!empty($errors) && array_key_exists('email', $errors)) ? '<span style="color:red;">' . $errors['email'] . '</span>' : false;

$sessionKey = Session::isInvalid(); // gọi hàm isInvalid (unicode_session)
$errors = Session::flash($sessionKey . '_errors'); // Lấy session errors
$old = Session::flash($sessionKey . '_old'); // Lấy session old

$currentPage = Session::flash('currentPage');

if (!function_exists('form_error')) { // Kiểm tra hàm form_error có tồn tại hay không?
    function form_error($fieldName, $before = '', $after = '') // $fieldName: tên field (fullname, pass, ...), $before: HTML, $after: HTML
    {
        global $errors; // tạo biến toàn cục
        if (!empty($errors) && array_key_exists($fieldName, $errors)) { // Kiểm tra tồn tại của tên field và errors
            return $before . $errors[$fieldName] . $after; // Dựa vào ví dụ ở trên mà trả ra kết quả
        }
        return false;
    }
}

if (!function_exists('old')) {
    function old($fieldName, $default = '')
    {
        global $old;
        if (!empty($old[$fieldName])) {
            return $old[$fieldName];
        }
        return $default;
    }
}

if (!function_exists('paginate')) {
    function paginate($data, $itemPerPage)
    {
        global $currentPage;

        // Tổng số items
        $totalItems = count($data);

        // Tổng số trang.
        $totalPages = ceil($totalItems / $itemPerPage);

        // Lấy vị trí hiện tại
        $currentPage = !empty($currentPage) ? $currentPage : 1;

        // Vị trí bắt đầu từng trang.
        $startIndex = ($currentPage - 1) * $itemPerPage;

        // Vị trí kết thúc của 1 trang.
        $lastIndex = $itemPerPage * $currentPage;
        if ($lastIndex > $totalItems) {
            $lastIndex = $totalItems;
        }

        return [
            'startIndex' => $startIndex,
            'lastIndex' => $lastIndex,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ];
    }
}

if (!function_exists('navPaginate')) {
    function navPaginate($totalPages, $currentPage)
    {
        $html = '
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>';

        for ($page = 1; $page <= $totalPages; $page++) {
            $activeClass = ($page == $currentPage) ? 'active' : '';
            $html .= '
                <li class="page-item" aria-current="page">
                    <a class="page-link ' . $activeClass . '" href="' . WEB_ROOT . '/pagination/index/' . $page . '">' . $page . '</a>
                </li>';
        }

        $html .= '
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>';

        echo $html;
    }
}
