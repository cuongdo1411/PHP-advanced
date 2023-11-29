// Lấy phần tử ảnh lớn và các ảnh nhỏ
const mainImg = document.getElementById('main-img');
const thumbnailImgs = document.querySelectorAll('.thumbnail-img');

// Lặp qua từng ảnh nhỏ và thêm sự kiện "mouseenter" để thay đổi ảnh lớn
thumbnailImgs.forEach((thumbnailImg) => {
    thumbnailImg.addEventListener('mouseenter', () => {
        mainImg.src = thumbnailImg.src;
    });
});