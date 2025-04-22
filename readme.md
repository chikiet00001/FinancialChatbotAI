# Ứng dụng trả lời Câu Hỏi liên quan Tài Chính

## I. Giới thiệu

Dự án này ứng dụng trí tuệ nhân tạo (AI) để tự động trả lời câu hỏi của người dùng, giúp người dùng có nắm bắt được thông tin tài chính sớm nhất.

Hệ thống có khả năng:
- Đặt câu hỏi: trả lời theo bộ dữ liệu có sẳn và luôn được cập nhật theo thời gian.
- Trả lời câu hỏi: trả lời câu hỏi phù hợp với nội dung câu hỏi được đặt ra súc tích và đầy đủ.

## II. Cấu trúc thư mục

```bash
root/
├── laravel-app/         # Giao diện người dùng và kết nối với cơ sở dữ liệu
└── api_public_base/     # API hỗ trợ tạo câu hỏi
```
## III. Cấu hình

### 1. Cơ sở dữ liệu
- File `Database.sql` chứa cấu trúc và dữ liệu mẫu cho hệ thống.
- Chỉ cần import file này vào hệ quản trị cơ sở dữ liệu (MySQL hoặc tương đương) để sử dụng ngay.

---
### 2. Thiết lập `laravel-app`
#### 2.1. Di chuyển vào thư mục dự án
```bash
cd laravel-app
```
#### 2.2. Tải các package
```bash
npm install
composer install
npm run build
```
#### 2.3. Cấu hình file môi trường
```bash
cp .env.example .env
```
Sau đó, thêm dòng sau vào file .env:
<pre><code>
PYTHON_API_KEY= # trùng với API_KEY trong file .env của thư mục api_public_base
</code></pre>
#### 2.4. Khởi chạy ứng dụng Laravel
```bash
php artisan serve
php artisan reverb:start
php artisan queue:work
```
### 3. Thiết lập `FinancialChatbotSystemAI_rag_llm_base`

#### 3.1. Di chuyển vào thư mục dự án
```bash
cd FinancialChatbotSystemAI_rag_llm_base
```
#### 3.2. Cài đặt các thư viện cần thiết
```bash
pip install -r requirements.txt
```
#### 3.3. Cấu hình file `.env`

Tạo file `.env` trong thư mục `FinancialChatbotSystemAI_rag_llm_base` và thêm các dòng sau:

<pre><code>
API_KEY=                    # trùng với PYTHON_API_KEY trong laravel-app

KEY_API_GEMINI=            # API key của Gemini
GEMINI_LLM_MODEL=          # Tên model của Gemini

KEY_API_GPT=               # API key của OpenAI
OPENAI_LLM_MODEL=          # Tên model của OpenAI
LLM_NAME=openai

KEY_API_GROK=xai-          # API key của Grok
GROK_LLM_MODEL=            # Tên model của Grok

KEYWORD_REMEMBER=          # Từ khóa cho cấp độ Nhớ
KEYWORD_UNDERSTAND=        # Từ khóa cho cấp độ Hiểu
KEYWORD_APPLY=             # Từ khóa cho cấp độ Áp dụng
KEYWORD_ANALYZE=           # Từ khóa cho cấp độ Phân tích
KEYWORD_EVALUATE=          # Từ khóa cho cấp độ Đánh giá
KEYWORD_CREATE=            # Từ khóa cho cấp độ Sáng tạo
</code></pre>

#### 3.4. Khởi chạy API
```bash
python main.py
```
