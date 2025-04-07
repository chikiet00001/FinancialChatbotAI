<?php
// app\Http\Controllers\ControllerAdmin.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;


class ControllerAdmin extends Controller
{
    //
    public function admin(){
        return view('chatbotai.manager.admin');
    }

    // Phương thức truy xuất tất cả người dùng
    public function getAllUsers(){
        $users = DB::table('users')->get(); // Lấy tất cả các bản ghi từ bảng users
        // dd($users);
        return view('/chatbotai/manager/admin', compact('users')); // Truyền dữ liệu vào view
    }

    // Phương thức thêm người dùng vào cơ sở dữ liệu
    public function userstore(Request $request){
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Kiểm tra mật khẩu và xác nhận mật khẩu
            'role' => 'required|in:user,admin', // Kiểm tra giá trị role
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Chèn dữ liệu vào bảng users
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        $users = DB::table('users')->get();
        // Redirect và truyền dữ liệu vào view
        return redirect()->route('chatbotai.manager.admin')
        ->with('success', 'User created successfully!')
        ->with('users', $users);  // Truyền $users vào session
    }
    
    // Phương thức sửa người dùng vào cơ sở dữ liệu
    public function updateUser(Request $request){
        // Validate dữ liệu đầu vào (có thể tùy chỉnh thêm)
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:user,admin',
        ]);

        // Tìm người dùng dựa trên ID và username
        $user = User::where('id', $request->userid)
                    ->where('username', $request->username)
                    ->first();
        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Cập nhật thông tin người dùng
        $user->email = $request->email;
        $user->password = bcrypt($request->password);; // Mã hóa mật khẩu
        $user->role = $request->role;
        $user->save(); // Lưu vào cơ sở dữ liệu

        $users = DB::table('users')->get();
        // Redirect và truyền dữ liệu vào view
        return redirect()->route('chatbotai.manager.admin')
        ->with('success', 'User update successfully!');
    }

    // Phương thức xóa người dùng
    public function destroyUser($id)
    {
        // Tìm người dùng theo ID
        $user = User::find($id);

        if ($user) {
            $user->delete();  // Xóa người dùng
            return redirect()->route('chatbotai.manager.admin')
            ->with('success', 'success: Người dùng đã bị xóa');
        } else {
            return redirect()->route('chatbotai.manager.admin')
            ->with('success', 'error: Người dùng không tồn tại');
        }
    }

    public function UpdateStarted(Request $request) {
    // Lấy dữ liệu message từ form
    $message = $request->input('message');

    $client = new Client();

    $fastApiUrl = 'http://127.0.0.1:8000/start_task';

    try {
        // Gửi yêu cầu POST đến FastAPI với dữ liệu JSON
        $response = $client->post($fastApiUrl, [
            'json' => ['question' => $message],
            'timeout' => 60, // thời gian timeout (giây)
        ]);

        // Giải mã phản hồi JSON từ FastAPI
        $result = json_decode($response->getBody(), true);

        // Kiểm tra giá trị trả về là true hoặc false
        $status = isset($result['result']) ? $result['result'] : false;

        // Trả về kết quả
        if ($status === true) {
            $message = "Tác vụ đã hoàn thành thành công!";
        } else {
            $message = "Tác vụ không thành công!";
        }

    } catch (\Exception $e) {
        // Nếu có lỗi xảy ra, trả về thông báo lỗi
        $message = "Có lỗi xảy ra: " . $e->getMessage();
    }

    // Trả về kết quả dưới dạng JSON
    return response()->json(['message' => $message]);
}
}
