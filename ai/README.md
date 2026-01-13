# Hệ thống Dự đoán Kết quả Học tập

## Yêu cầu

- Python 3.8+
- pandas
- numpy
- scikit-learn
- joblib

## Cài đặt

```bash
pip install pandas numpy scikit-learn joblib
```

## Sử dụng

### 1. Training Model

```bash
cd C:\xampp\htdocs\test\hethong_ql
python ai/train_model.py
```

### 2. Dự đoán từ Command Line

```bash
python ai/predict.py <diem_cc> <diem_gk> <diem_ck> <so_buoi_nghi> <so_tin_chi>
```

Ví dụ:
```bash
python ai/predict.py 8.5 7.0 8.0 1 3
```

Output (JSON):
```json
{
  "prediction": "Khá",
  "confidence": 85.5,
  "probabilities": {
    "Giỏi": 10.2,
    "Khá": 85.5,
    "Trung bình": 4.3,
    "Yếu": 0.0
  }
}
```

## Cấu trúc thư mục

```
ai/
├── data/
│   ├── training_data.csv      # Dữ liệu training
│   └── metadata.json           # Metadata
├── models/
│   ├── grade_predictor.pkl    # Model đã train
│   └── grade_predictor_info.json  # Thông tin model
├── train_model.py              # Script training
├── predict.py                  # Script dự đoán
└── README.md
```

## Features

- `diem_chuyen_can`: Điểm chuyên cần (0-10)
- `diem_giua_ky`: Điểm giữa kỳ (0-10)
- `diem_cuoi_ky`: Điểm cuối kỳ (0-10)
- `so_buoi_nghi`: Số buổi nghỉ (0+)
- `so_tin_chi`: Số tín chỉ môn học (1-6)

## Target

- `Giỏi`: Điểm >= 8.0
- `Khá`: Điểm >= 6.5 và < 8.0
- `Trung bình`: Điểm >= 5.0 và < 6.5
- `Yếu`: Điểm < 5.0

## Thuật toán

**Decision Tree Classifier**
- max_depth: 5
- min_samples_split: 5
- min_samples_leaf: 2
