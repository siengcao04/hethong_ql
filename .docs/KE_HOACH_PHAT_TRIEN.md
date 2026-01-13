# KẾ HOẠCH PHÁT TRIỂN DỰ ÁN

## 📋 Tổng Quan Dự Án
**Tên dự án:** Hệ thống Quản lý Sinh viên - Dự đoán kết quả học tập bằng AI có giám sát

**Công nghệ:**
- Backend: Laravel 12.x, PHP 8.2
- Frontend: Blade Templates + Bootstrap 5.3
- Database: MySQL
- AI/ML: Python (scikit-learn)

---

## 🎯 Mục Tiêu Chính
1. Xây dựng hệ thống quản lý sinh viên đầy đủ
2. Quản lý điểm, môn học, lớp học, giảng viên
3. Ứng dụng AI có giám sát để dự đoán kết quả học tập
4. Hỗ trợ giảng viên phát hiện sinh viên có nguy cơ học yếu

---

## 📅 KẾ HOẠCH CHI TIẾT

### GIAI ĐOẠN 1: THIẾT LẬP CƠ SỞ DỮ LIỆU (Tuần 1)

#### 1.1. Thiết kế Database Schema
**Các bảng cần tạo:**
- `users` (đã có - cần mở rộng)
- `roles` - Vai trò (Admin, Giảng viên, Sinh viên)
- `khoas` - Khoa
- `lops` - Lớp học
- `mon_hocs` - Môn học
- `giang_viens` - Thông tin giảng viên
- `sinh_viens` - Thông tin sinh viên
- `dang_ky_mon_hocs` - Đăng ký môn học
- `diems` - Điểm số
- `du_doan_hoc_taps` - Kết quả dự đoán AI

**Relations:**
- User belongsTo Role
- SinhVien belongsTo User, Lop
- Lop belongsTo Khoa
- GiangVien belongsTo User
- MonHoc belongsToMany GiangVien
- Diem belongsTo SinhVien, MonHoc

#### 1.2. Tạo Migrations
```bash
php artisan make:migration create_roles_table
php artisan make:migration create_khoas_table
php artisan make:migration create_lops_table
php artisan make:migration create_mon_hocs_table
php artisan make:migration create_giang_viens_table
php artisan make:migration create_sinh_viens_table
php artisan make:migration create_dang_ky_mon_hocs_table
php artisan make:migration create_diems_table
php artisan make:migration create_du_doan_hoc_taps_table
```

**Cấu trúc chi tiết:**

**roles:**
- id, name, description, timestamps

**khoas:**
- id, ma_khoa, ten_khoa, mo_ta, timestamps

**lops:**
- id, ma_lop, ten_lop, khoa_id, khoa_hoc, timestamps

**mon_hocs:**
- id, ma_mon, ten_mon, so_tin_chi, mo_ta, timestamps

**giang_viens:**
- id, user_id, ma_giang_vien, ho_ten, ngay_sinh, gioi_tinh, sdt, dia_chi, khoa_id, timestamps

**sinh_viens:**
- id, user_id, ma_sinh_vien, ho_ten, ngay_sinh, gioi_tinh, sdt, dia_chi, lop_id, khoa_hoc, timestamps

**dang_ky_mon_hocs:**
- id, sinh_vien_id, mon_hoc_id, giang_vien_id, hoc_ky, nam_hoc, timestamps

**diems:**
- id, dang_ky_mon_hoc_id, diem_chuyen_can, diem_giua_ky, diem_cuoi_ky, diem_trung_binh, so_buoi_nghi, trang_thai (Giỏi/Khá/TB/Yếu), timestamps

**du_doan_hoc_taps:**
- id, sinh_vien_id, mon_hoc_id, du_doan, do_tin_cay, thoi_gian_du_doan, timestamps

---

### GIAI ĐOẠN 2: XÂY DỰNG MODELS (Tuần 1)

#### 2.1. Tạo Models với Relations
```bash
php artisan make:model Role
php artisan make:model Khoa
php artisan make:model Lop
php artisan make:model MonHoc
php artisan make:model GiangVien
php artisan make:model SinhVien
php artisan make:model DangKyMonHoc
php artisan make:model Diem
php artisan make:model DuDoanHocTap
```

#### 2.2. Định nghĩa Relations trong Models
- User: hasOne SinhVien/GiangVien, belongsTo Role
- Role: hasMany Users
- Khoa: hasMany Lops, hasMany GiangViens
- Lop: belongsTo Khoa, hasMany SinhViens
- MonHoc: hasMany DangKyMonHocs
- SinhVien: belongsTo User, belongsTo Lop, hasMany DangKyMonHocs
- GiangVien: belongsTo User, belongsTo Khoa
- DangKyMonHoc: belongsTo SinhVien, MonHoc, GiangVien, hasOne Diem
- Diem: belongsTo DangKyMonHoc

---

### GIAI ĐOẠN 3: AUTHENTICATION & PHÂN QUYỀN (Tuần 2)

#### 3.1. Xây dựng hệ thống đăng nhập
- Tạo LoginController
- Tạo views login
- Middleware kiểm tra role

#### 3.2. Phân quyền theo vai trò
**Admin:**
- Quản lý tất cả
- Dashboard tổng quan

**Giảng viên:**
- Xem lớp được phân công
- Nhập điểm sinh viên
- Xem thống kê và dự đoán

**Sinh viên:**
- Xem thông tin cá nhân
- Xem điểm số
- Xem kết quả dự đoán bản thân

#### 3.3. Tạo Middleware
```bash
php artisan make:middleware CheckRole
```

---

### GIAI ĐOẠN 4: MODULE QUẢN LÝ CƠ BẢN (Tuần 2-3)

#### 4.1. Module Quản lý Khoa
- Controller: KhoaController (CRUD)
- Routes: admin/khoas/*
- Views: khoas/index, create, edit

#### 4.2. Module Quản lý Lớp
- Controller: LopController (CRUD)
- Routes: admin/lops/*
- Views: lops/index, create, edit
- Filter theo khoa

#### 4.3. Module Quản lý Môn học
- Controller: MonHocController (CRUD)
- Routes: admin/mon-hocs/*
- Views: mon-hocs/index, create, edit

#### 4.4. Module Quản lý Giảng viên
- Controller: GiangVienController (CRUD)
- Routes: admin/giang-viens/*
- Views: giang-viens/index, create, edit
- Tự động tạo User khi thêm giảng viên

#### 4.5. Module Quản lý Sinh viên
- Controller: SinhVienController (CRUD)
- Routes: admin/sinh-viens/*
- Views: sinh-viens/index, create, edit, show
- Tự động tạo User khi thêm sinh viên
- Import từ Excel

---

### GIAI ĐOẠN 5: MODULE QUẢN LÝ ĐIỂM (Tuần 3-4)

#### 5.1. Đăng ký môn học
- Controller: DangKyMonHocController
- Phân công giảng viên cho môn
- Đăng ký sinh viên vào môn

#### 5.2. Nhập điểm
- Controller: DiemController
- Views: diems/nhap-diem (form theo lớp)
- Tính toán tự động:
  - Điểm trung bình = (CC*0.1 + GK*0.3 + CK*0.6)
  - Trạng thái: Giỏi (>=8), Khá (>=6.5), TB (>=5), Yếu (<5)

#### 5.3. Xem điểm
- Giảng viên: xem điểm lớp mình dạy
- Sinh viên: xem điểm bản thân
- Export Excel/PDF

---

### GIAI ĐOẠN 6: GIAO DIỆN NGƯỜI DÙNG (Tuần 4-5)

#### 6.1. Layout chính với Bootstrap 5
- Admin layout: Sidebar + Header
- Responsive design
- Dark/Light mode (optional)

#### 6.2. Dashboard cho từng role
**Admin Dashboard:**
- Tổng số sinh viên, giảng viên, môn học
- Biểu đồ phân bố điểm
- Thống kê kết quả học tập

**Giảng viên Dashboard:**
- Danh sách lớp đang dạy
- Thống kê điểm lớp
- Cảnh báo sinh viên yếu

**Sinh viên Dashboard:**
- Thông tin cá nhân
- Bảng điểm
- Kết quả dự đoán

#### 6.3. Components Bootstrap
- Tables với DataTables
- Forms validation
- Modals
- Alerts & Notifications
- Charts (Chart.js)

---

### GIAI ĐOẠN 7: PHÁT TRIỂN MODULE AI (Tuần 5-6)

#### 7.1. Thu thập và chuẩn bị dữ liệu
**Input Features:**
- diem_chuyen_can (0-10)
- diem_giua_ky (0-10)
- diem_cuoi_ky (0-10)
- so_buoi_nghi (0-20)
- so_tin_chi (1-4)

**Output Label:**
- Giỏi / Khá / Trung bình / Yếu

**Tạo dataset:**
```php
// Command để export dữ liệu huấn luyện
php artisan ai:export-training-data
```

#### 7.2. Xây dựng mô hình AI (Python)
**File structure:**
```
ai_model/
├── data/
│   └── training_data.csv
├── models/
│   └── model.pkl
├── train.py
├── predict.py
└── requirements.txt
```

**requirements.txt:**
```
pandas
numpy
scikit-learn
joblib
```

**train.py:** Huấn luyện Decision Tree
```python
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score, classification_report
import joblib

# Load data
data = pd.read_csv('data/training_data.csv')

# Features và Label
X = data[['diem_chuyen_can', 'diem_giua_ky', 'diem_cuoi_ky', 
          'so_buoi_nghi', 'so_tin_chi']]
y = data['trang_thai']

# Chia train/test (80/20)
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

# Huấn luyện Decision Tree
model = DecisionTreeClassifier(max_depth=5, random_state=42)
model.fit(X_train, y_train)

# Đánh giá
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f'Accuracy: {accuracy:.2f}')
print(classification_report(y_test, y_pred))

# Lưu model
joblib.dump(model, 'models/model.pkl')
```

**predict.py:** API dự đoán
```python
import sys
import json
import joblib
import numpy as np

# Load model
model = joblib.load('models/model.pkl')

# Nhận input từ Laravel (JSON)
input_data = json.loads(sys.argv[1])

# Chuẩn bị features
features = np.array([[
    input_data['diem_chuyen_can'],
    input_data['diem_giua_ky'],
    input_data['diem_cuoi_ky'],
    input_data['so_buoi_nghi'],
    input_data['so_tin_chi']
]])

# Dự đoán
prediction = model.predict(features)[0]
proba = model.predict_proba(features)[0]
confidence = max(proba)

# Trả về kết quả
result = {
    'du_doan': prediction,
    'do_tin_cay': float(confidence)
}

print(json.dumps(result))
```

---

### GIAI ĐOẠN 8: TÍCH HỢP AI VÀO LARAVEL (Tuần 6-7)

#### 8.1. Tạo Service để gọi Python
```php
// app/Services/AIPredictionService.php
class AIPredictionService
{
    public function predict($data)
    {
        $pythonPath = 'python'; // hoặc python3
        $scriptPath = base_path('ai_model/predict.py');
        $input = json_encode($data);
        
        $command = "$pythonPath $scriptPath '$input'";
        $output = shell_exec($command);
        
        return json_decode($output, true);
    }
}
```

#### 8.2. Tạo Command để dự đoán hàng loạt
```bash
php artisan make:command PredictResults
```

#### 8.3. Controller xử lý dự đoán
- DuDoanController
- Dự đoán cho 1 sinh viên
- Dự đoán cho toàn lớp
- Lưu kết quả vào bảng du_doan_hoc_taps

---

### GIAI ĐOẠN 9: MODULE CẢNH BÁO VÀ THỐNG KÊ (Tuần 7)

#### 9.1. Hệ thống cảnh báo
- Cảnh báo sinh viên có nguy cơ yếu (dự đoán = "Yếu")
- Badge màu đỏ/xanh
- Danh sách ưu tiên theo độ tin cậy

#### 9.2. Thống kê và Biểu đồ
**Chart.js:**
- Biểu đồ phân bố điểm
- So sánh điểm thực tế vs dự đoán
- Tỷ lệ đậu/rớt theo lớp, khoa
- Xu hướng học tập qua các học kỳ

#### 9.3. Báo cáo
- Export PDF báo cáo lớp
- Export Excel danh sách sinh viên yếu

---

### GIAI ĐOẠN 10: DỮ LIỆU MẪU VÀ TESTING (Tuần 8)

#### 10.1. Tạo Seeders
```bash
php artisan make:seeder RoleSeeder
php artisan make:seeder KhoaSeeder
php artisan make:seeder LopSeeder
php artisan make:seeder MonHocSeeder
php artisan make:seeder UserSeeder
php artisan make:seeder SinhVienSeeder
php artisan make:seeder DiemSeeder
```

**Dữ liệu mẫu:**
- 3 roles: Admin, Giảng viên, Sinh viên
- 3 khoa: CNTT, Kinh tế, Ngoại ngữ
- 10 lớp
- 20 môn học
- 50 sinh viên
- Điểm cho 100+ bản ghi

#### 10.2. Testing thủ công
- Test tất cả chức năng CRUD
- Test phân quyền
- Test nhập điểm
- Test dự đoán AI

---

## 📁 CẤU TRÚC ROUTES

```php
// routes/web.php

// Public
Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::resource('khoas', KhoaController::class);
    Route::resource('lops', LopController::class);
    Route::resource('mon-hocs', MonHocController::class);
    Route::resource('giang-viens', GiangVienController::class);
    Route::resource('sinh-viens', SinhVienController::class);
    Route::get('/thong-ke', [ThongKeController::class, 'index']);
});

// Giảng viên
Route::middleware(['auth', 'role:giang-vien'])->prefix('giang-vien')->group(function () {
    Route::get('/dashboard', [GiangVienController::class, 'dashboard']);
    Route::get('/lop-hoc', [GiangVienController::class, 'lopHoc']);
    Route::get('/nhap-diem/{id}', [DiemController::class, 'nhapDiem']);
    Route::post('/luu-diem', [DiemController::class, 'luuDiem']);
    Route::get('/du-doan/{lop_id}', [DuDoanController::class, 'duDoanLop']);
});

// Sinh viên
Route::middleware(['auth', 'role:sinh-vien'])->prefix('sinh-vien')->group(function () {
    Route::get('/dashboard', [SinhVienController::class, 'dashboard']);
    Route::get('/diem', [SinhVienController::class, 'xemDiem']);
    Route::get('/du-doan', [SinhVienController::class, 'xemDuDoan']);
});
```

---

## 🎨 THIẾT KẾ GIAO DIỆN

### Layout cơ bản (Bootstrap 5)
```
┌─────────────────────────────────────┐
│  Navbar (Logo, User, Logout)       │
├──────┬──────────────────────────────┤
│      │                              │
│ Side │  Content Area               │
│ bar  │  - Breadcrumb               │
│      │  - Page Title               │
│ Menu │  - Main Content             │
│      │                              │
│      │                              │
└──────┴──────────────────────────────┘
```

### Màu sắc chủ đạo
- Primary: #007bff (Blue)
- Success: #28a745 (Green) - Giỏi/Khá
- Warning: #ffc107 (Yellow) - Trung bình
- Danger: #dc3545 (Red) - Yếu

---

## ✅ CHECKLIST HOÀN THÀNH

### Database
- [ ] Tất cả migrations
- [ ] Tất cả models
- [ ] Relations đầy đủ

### Authentication
- [ ] Login/Logout
- [ ] Phân quyền 3 roles
- [ ] Middleware

### Modules
- [ ] Quản lý Khoa ✓
- [ ] Quản lý Lớp ✓
- [ ] Quản lý Môn học ✓
- [ ] Quản lý Giảng viên ✓
- [ ] Quản lý Sinh viên ✓
- [ ] Quản lý Điểm ✓
- [ ] Dashboard cho 3 roles ✓

### AI
- [ ] Thu thập dữ liệu training
- [ ] Xây dựng model Python
- [ ] Tích hợp vào Laravel
- [ ] Module dự đoán
- [ ] Hệ thống cảnh báo

### UI/UX
- [ ] Layout Bootstrap 5
- [ ] Responsive
- [ ] Forms validation
- [ ] DataTables
- [ ] Charts
- [ ] Notifications

### Testing
- [ ] Seeders đầy đủ
- [ ] Test thủ công tất cả chức năng
- [ ] Dữ liệu mẫu

---

## 📝 GHI CHÚ QUAN TRỌNG

1. **Code-First Approach:** Tất cả thay đổi database phải thông qua migrations
2. **Tiếng Việt:** Tất cả UI, thông báo, validation phải bằng tiếng Việt có dấu
3. **Không NodeJS:** Không sử dụng npm scripts phức tạp, chỉ compile assets cơ bản
4. **Bootstrap 5.3:** Sử dụng components có sẵn, không custom CSS quá nhiều
5. **AI đơn giản:** Decision Tree là đủ, không cần deep learning
6. **Documentation:** Mọi file .md đặt trong thư mục `.docs`

---

## 🚀 CÁC LỆNH QUAN TRỌNG

```bash
# Tạo migration
php artisan make:migration create_table_name

# Chạy migration
php artisan migrate

# Tạo model
php artisan make:model ModelName

# Tạo controller
php artisan make:controller ControllerName

# Tạo seeder
php artisan make:seeder SeederName

# Chạy seeder
php artisan db:seed

# Tạo command
php artisan make:command CommandName

# Cache clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề trong quá trình phát triển:
1. Kiểm tra logs: `storage/logs/laravel.log`
2. Debug với `dd()` và `dump()`
3. Sử dụng `php artisan tinker` để test
4. Kiểm tra documentation Laravel 12.x

---

**Ngày tạo:** 10/01/2026
**Version:** 1.0
**Trạng thái:** Kế hoạch chi tiết - Sẵn sàng triển khai
