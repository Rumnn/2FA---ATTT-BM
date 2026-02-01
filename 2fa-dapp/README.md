# 🛡️ 2-Layer Security System (PHP + MetaMask)

Dự án này triển khai hệ thống xác thực hai yếu tố (2FA) sử dụng mật khẩu truyền thống và chữ ký số trên Blockchain thông qua ví MetaMask.

## 🚀 Công nghệ sử dụng
- **Backend**: PHP (XAMPP).
- **Database**: MySQL.
- **Frontend**: HTML5, Vanilla CSS (Premium UI), JavaScript.
- **Web3 Library**: [ethers.js v5](https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.umd.min.js) (CDN).
- **Wallet**: MetaMask Extension.

## 🏗️ Cấu trúc dự án
- `db.php`: Kết nối và tự động khởi tạo database.
- `register.php`: Giao diện đăng ký người dùng + kết nối ví.
- `login.php`: Lớp bảo mật 1 (Username/Password).
- `verify_signature.php`: Lớp bảo mật 2 (Ký xác thực MetaMask).
- `verify_server.php`: Xử lý xác minh địa chỉ ví từ Server.
- `dashboard.php`: Trang quản trị sau khi đăng nhập thành công.
- `style.css`: Hệ thống thiết kế UI/UX cao cấp.

## ⚙️ Cách thức hoạt động
1. **Lớp 1 (Knowledge)**: Người dùng nhập Username và Password. Hệ thống kiểm tra trong database MySQL.
2. **Lớp 2 (Possession)**: Sau khi qua Bước 1, hệ thống yêu cầu người dùng ký một thông điệp (Signature) bằng ví MetaMask.
3. **Verification**: Server so sánh địa chỉ ví vừa ký với địa chỉ ví đã đăng ký trong tài khoản. Nếu khớp, người dùng mới được phép truy cập vào Dashboard.

## 🧪 Cách test chức năng

### 1. Chuẩn bị
- Đảm bảo đã bật **Apache** và **MySQL** trong XAMPP Control Panel.
- Cài đặt extension **MetaMask** trên trình duyệt (Chrome/Edge).

### 2. Kịch bản Test Thành công ✅
1. Truy cập `http://localhost/attt/2fa-dapp/register.php`.
2. Điền thông tin, nhấn **"🔗 Kết nối MetaMask"** để lấy địa chỉ ví, sau đó nhấn **Register**.
3. Chuyển sang `login.php`, nhập đúng tài khoản vừa tạo.
4. Tại trang xác thực, nhấn **"Ký xác thực ngay"**. MetaMask sẽ hiện thông báo ký.
5. Sau khi ký thành công, bạn sẽ được tự động chuyển vào **Dashboard**.

### 3. Kịch bản Test Thất bại ❌
- **Sai mật khẩu**: Nhập sai ở trang login -> Hệ thống báo lỗi "Sai Username hoặc Password".
- **Sai ví MetaMask**: Đăng ký bằng Ví A nhưng lúc ký ở Bước 2 lại dùng Ví B -> Hệ thống báo lỗi "Ví MetaMask không khớp với tài khoản".
- **Truy cập trái phép**: Cố gắng vào trực tiếp `dashboard.php` khi chưa đăng nhập -> Hệ thống tự động đá về `login.php`.

---

