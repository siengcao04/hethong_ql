"""
Script dự đoán kết quả học tập từ command line
Sử dụng: python predict.py <diem_cc> <diem_gk> <diem_ck> <so_buoi_nghi> <so_tin_chi>
"""

import sys
import io
import json
import os
from pathlib import Path
from train_model import StudentGradePredictor

# Force UTF-8 encoding for stdout on Windows
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def main():
    if len(sys.argv) != 6:
        print("Usage: python predict.py <diem_cc> <diem_gk> <diem_ck> <so_buoi_nghi> <so_tin_chi>")
        sys.exit(1)
    
    try:
        # Parse arguments
        diem_cc = float(sys.argv[1])
        diem_gk = float(sys.argv[2])
        diem_ck = float(sys.argv[3])
        so_buoi_nghi = int(sys.argv[4])
        so_tin_chi = int(sys.argv[5])
        
        # Tìm đường dẫn model (tuyệt đối)
        script_dir = Path(__file__).parent
        model_path = script_dir / 'models' / 'grade_predictor.pkl'
        
        # Load model và predict
        predictor = StudentGradePredictor()
        if not predictor.load_model(str(model_path)):
            print(json.dumps({'error': 'Khong the load model'}, ensure_ascii=True))
            sys.exit(1)
        
        features = {
            'diem_chuyen_can': diem_cc,
            'diem_giua_ky': diem_gk,
            'diem_cuoi_ky': diem_ck,
            'so_buoi_nghi': so_buoi_nghi,
            'so_tin_chi': so_tin_chi
        }
        
        result = predictor.predict(features)
        
        if result:
            # Output JSON với encoding UTF-8
            print(json.dumps(result, ensure_ascii=False))
        else:
            print(json.dumps({'error': 'Du doan that bai'}, ensure_ascii=True))
            sys.exit(1)
            
    except Exception as e:
        print(json.dumps({'error': str(e)}, ensure_ascii=True))
        sys.exit(1)

if __name__ == '__main__':
    main()
