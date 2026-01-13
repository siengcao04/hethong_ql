"""
Hệ thống Dự đoán Kết quả Học tập bằng Machine Learning
Sử dụng Decision Tree Classifier
"""

import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix
import joblib
import json
import sys
import os

class StudentGradePredictor:
    def __init__(self):
        self.model = None
        self.label_mapping = {
            'Giỏi': 0,
            'Khá': 1,
            'Trung bình': 2,
            'Yếu': 3
        }
        self.reverse_mapping = {v: k for k, v in self.label_mapping.items()}
        
    def load_data(self, csv_path):
        """Load dữ liệu từ CSV"""
        try:
            df = pd.read_csv(csv_path)
            print(f"✅ Đã load {len(df)} bản ghi từ {csv_path}")
            return df
        except Exception as e:
            print(f"❌ Lỗi khi load dữ liệu: {e}")
            return None
    
    def prepare_data(self, df):
        """Chuẩn bị dữ liệu cho training"""
        # Features (X)
        X = df[['diem_chuyen_can', 'diem_giua_ky', 'diem_cuoi_ky', 'so_buoi_nghi', 'so_tin_chi']]
        
        # Target (y) - chuyển label thành số
        y = df['trang_thai'].map(self.label_mapping)
        
        return X, y
    
    def train(self, csv_path, test_size=0.2, random_state=42):
        """Training model"""
        print("\n🔄 Bắt đầu training model...")
        
        # Load và prepare data
        df = self.load_data(csv_path)
        if df is None:
            return False
        
        X, y = self.prepare_data(df)
        
        # Chia train/test
        X_train, X_test, y_train, y_test = train_test_split(
            X, y, test_size=test_size, random_state=random_state, stratify=y
        )
        
        print(f"Training set: {len(X_train)} samples")
        print(f"Test set: {len(X_test)} samples")
        
        # Train Decision Tree
        self.model = DecisionTreeClassifier(
            max_depth=5,
            min_samples_split=5,
            min_samples_leaf=2,
            random_state=random_state
        )
        
        self.model.fit(X_train, y_train)
        
        # Evaluate
        y_pred = self.model.predict(X_test)
        accuracy = accuracy_score(y_test, y_pred)
        
        print(f"\nTraining completed!")
        print(f"🎯 Độ chính xác: {accuracy * 100:.2f}%")
        
        # Classification report
        print("\n📈 Chi tiết đánh giá:")
        target_names = ['Giỏi', 'Khá', 'Trung bình', 'Yếu']
        print(classification_report(y_test, y_pred, target_names=target_names, zero_division=0))
        
        # Lưu để dùng trong save_model
        self.y_test = y_test
        self.y_pred = y_pred
        self.accuracy = accuracy
        
        return True
    
    def save_model(self, model_path='ai/models/grade_predictor.pkl'):
        """Lưu model"""
        try:
            # Tạo thư mục nếu chưa có
            os.makedirs(os.path.dirname(model_path), exist_ok=True)
            
            joblib.dump(self.model, model_path)
            print(f"Saved model to: {model_path}")
            
            # Lưu thông tin model
            model_info = {
                'accuracy': float(self.accuracy) if hasattr(self, 'accuracy') else 0.0,
                'trained_at': pd.Timestamp.now().strftime('%Y-%m-%d %H:%M:%S'),
                'features': ['diem_chuyen_can', 'diem_giua_ky', 'diem_cuoi_ky', 'so_buoi_nghi', 'so_tin_chi'],
                'labels': list(self.label_mapping.keys()),
                'samples_trained': len(self.y_test) + len(y_train) if hasattr(self, 'y_test') else 0,
                'algorithm': 'Decision Tree Classifier'
            }
            
            info_path = model_path.replace('.pkl', '_info.json')
            with open(info_path, 'w', encoding='utf-8') as f:
                json.dump(model_info, f, ensure_ascii=False, indent=2)
            
            print(f"Saved model info to: {info_path}")
            return True
        except Exception as e:
            print(f"Error saving model: {e}")
            return False
    
    def load_model(self, model_path='ai/models/grade_predictor.pkl'):
        """Load model đã train"""
        try:
            self.model = joblib.load(model_path)
            # Không print để tránh lỗi encoding khi gọi từ Laravel
            return True
        except Exception as e:
            # Không print để tránh lỗi encoding khi gọi từ Laravel
            return False
    
    def predict(self, features):
        """
        Dự đoán kết quả học tập
        features: dict hoặc list với keys/indices:
            - diem_chuyen_can (0-10)
            - diem_giua_ky (0-10)
            - diem_cuoi_ky (0-10)
            - so_buoi_nghi (0+)
            - so_tin_chi (1-6)
        """
        if self.model is None:
            print("❌ Model chưa được load!")
            return None
        
        try:
            # Chuyển dict thành array
            if isinstance(features, dict):
                X = [[
                    features['diem_chuyen_can'],
                    features['diem_giua_ky'],
                    features['diem_cuoi_ky'],
                    features['so_buoi_nghi'],
                    features['so_tin_chi']
                ]]
            else:
                X = [features]
            
            # Dự đoán
            prediction = self.model.predict(X)[0]
            probability = self.model.predict_proba(X)[0]
            
            result = {
                'prediction': self.reverse_mapping[prediction],
                'confidence': float(max(probability) * 100),
                'probabilities': {
                    self.reverse_mapping[i]: float(prob * 100)
                    for i, prob in enumerate(probability)
                }
            }
            
            return result
        except Exception as e:
            print(f"❌ Lỗi khi dự đoán: {e}")
            return None

def main():
    """Main function"""
    predictor = StudentGradePredictor()
    
    # Training
    csv_path = 'ai/data/training_data.csv'
    if predictor.train(csv_path):
        # Lưu model
        predictor.save_model()
        print("\n🎉 Hoàn thành training và lưu model!")
    else:
        print("\n❌ Training thất bại!")
        sys.exit(1)

if __name__ == '__main__':
    main()
