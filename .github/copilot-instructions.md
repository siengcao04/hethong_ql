ĐỀ TÀI
**Hệ thống Quản lý Sinh viên

Dự đoán kết quả học tập bằng AI có giám sát**

👉 Mức độ: Trung cấp
👉 Công nghệ: Laravel, MySQL, Python (Machine Learning – Supervised)

🎯 Mục tiêu đề tài

Xây dựng hệ thống quản lý sinh viên cho khoa/trường.

Quản lý điểm, môn học, lớp học, giảng viên.

Ứng dụng AI có giám sát để:

Dự đoán kết quả học tập (Đậu / Rớt hoặc Giỏi / Khá / Trung bình).

Hỗ trợ giảng viên phát hiện sớm sinh viên có nguy cơ rớt môn.

🧱 I. CHỨC NĂNG HỆ THỐNG (LARAVEL + MYSQL)
1. Phân quyền
👤 Admin

Quản lý tài khoản (Admin, Giảng viên, Sinh viên).

Quản lý khoa, lớp, môn học.

👨‍🏫 Giảng viên

Nhập điểm sinh viên.

Xem thống kê lớp học.

Xem kết quả dự đoán học tập.

👩‍🎓 Sinh viên

Xem thông tin cá nhân.

Xem điểm học tập.

Xem kết quả dự đoán (chỉ bản thân).

2. Quản lý sinh viên

Thêm / sửa / xóa sinh viên.

Quản lý theo:

Lớp

Khoa

Khóa học

3. Quản lý môn học & điểm

Danh sách môn học.

Nhập điểm:

Điểm chuyên cần

Điểm giữa kỳ

Điểm cuối kỳ

Tự động tính điểm trung bình.

🤖 II. PHẦN AI CÓ GIÁM SÁT – TRỌNG TÂM ĐỀ TÀI
1. Bài toán AI
🔹 Input (đặc trưng – features):

Điểm chuyên cần

Điểm giữa kỳ

Điểm cuối kỳ

Số buổi nghỉ

Số tín chỉ

🔹 Output (nhãn – label):

(Giỏi / Khá / Trung bình / Yếu)

2. Thuật toán AI đề xuất (dễ – hiệu quả)
Thuật toán	Mức độ	Lý do
Logistic Regression	⭐ Dễ	Dự đoán Đậu/Rớt
Decision Tree	⭐⭐	Dễ giải thích
Random Forest	⭐⭐⭐	Độ chính xác cao
KNN	⭐⭐	Trực quan

nên dùng: Decision Tree.

3. Quy trình AI

1️⃣ Thu thập dữ liệu điểm sinh viên (từ DB).
2️⃣ Gán nhãn kết quả học tập (Giỏi / Khá / Trung bình / Yếu).
3️⃣ Chia tập Train / Test.
4️⃣ Huấn luyện mô hình.
5️⃣ Đánh giá độ chính xác (Accuracy).
6️⃣ Dự đoán cho sinh viên mới.

⚙️ III. TÍCH HỢP AI VÀO LARAVEL
✅ Cách làm chuẩn (dễ bảo vệ):

Viết AI bằng Python + scikit-learn.

Laravel gửi dữ liệu → Python.

Python trả về kết quả dự đoán.

Laravel lưu và hiển thị kết quả.


📊 IV. GIAO DIỆN DEMO AI

Danh sách sinh viên + kết quả dự đoán.

Cảnh báo:
🔴 Có nguy cơ rớt
🟢 Có khả năng đậu

Biểu đồ:

Tỷ lệ đậu / rớt

So sánh điểm thực tế & dự đoán.


# quy tắc
- Luôn phản hồi bằng tiếng Việt.
- Luôn tuân theo danh sách chức năng đã liệt kê ở trên.
- Sử dụng tiếng Việt có dấu cho tất cả các thông báo, lỗi, giao diện người dùng.
- Không dùng NodeJS.
- Không cần unit test.
- Dự án sử dụng hướng tiếp cận Code-First.
- Sử dụng bootstrap5 cho giao diện admin.
- Tất cả các file hướng dẫn .md được đặt ở thư mục '.docs' trong dự án.
- Luôn kiểm tra lại tên model, tên bảng, tên cột, tên biến, tên route đã có trong dự án hay chưa sau khi hoàn thành chức năng.

#  Technical Stack

- Backend: Laravel 12.x , PHP 8.2
- Frontend: Blade Template + Bootstrap 5.3
- database: MySQL

# Tài liệu
- https://laravel.com/docs/12.x
- https://getbootstrap.com/docs/5.3/getting-started/introduction/
