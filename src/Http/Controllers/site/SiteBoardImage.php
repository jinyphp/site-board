<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteBoardImage extends Controller
{
    // protected $fillable = ['filename', 'path', 'mime_type', 'size'];

    // public function store($image)
    // {

    //     try {
    //         // 원본 파일명 추출
    //         $originalName = $image->getClientOriginalName();

    //         // 파일 확장자 추출
    //         $extension = $image->getClientOriginalExtension();

    //         // 유니크한 파일명 생성 (timestamp + random string)
    //         $filename = time() . '_' . Str::random(10) . '.' . $extension;

    //         // 저장 경로 설정 (storage/app/public/board/images)
    //         $path = $image->storeAs('public/board/images', $filename);

    //         // DB에 저장
    //         $imageRecord = $this->create([
    //             'filename' => $filename,
    //             'path' => $path,
    //             'mime_type' => $image->getMimeType(),
    //             'size' => $image->getSize()
    //         ]);

    //         return [
    //             'success' => true,
    //             'data' => $imageRecord,
    //             'url' => Storage::url($path)
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'success' => false,
    //             'message' => '이미지 저장 중 오류가 발생했습니다: ' . $e->getMessage()
    //         ];
    //     }
    // }


    public function store(Request $request)
    {
        // 게시판 코드 확인
        // $code = $request->input('code');
        // if (!$code) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => '게시판 코드가 없습니다.'
        //     ]);
        // }

        // 글번호 확인
        // $id = $request->input('id');
        // if (!$id) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => '글번호가 없습니다.'
        //     ]);
        // }

        $path = $request->input('path');
        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => '업로드 경로가 없습니다.'
            ]);
        }


        $image = $request->file('image');
        try {
            // 원본 파일명 추출
            $originalName = $image->getClientOriginalName();

            // 파일 확장자 추출
            $extension = $image->getClientOriginalExtension();

            // 유니크한 파일명 생성
            $filename = time() . '_' . Str::random(10) . '.' . $extension;

            // 저장 경로 설정
            //$path = $request->input('path');
            //$uploadPath = public_path('board/'.$code.'/'.$id);
            $uploadPath = public_path($path);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 파일 저장
            $image->move($uploadPath, $filename);

            return response()->json([
                'success' => true,
                'message' => '이미지 업로드 성공',
                //'code' => $code,
                'filename' => $filename,
                //'id' => $id,
                'originalName' => $originalName,
                'extension' => $extension,
                'url' => $path.'/'.$filename
            ]);

            return response()->json([
                'success' => true,
                'message' => '이미지 업로드 성공',
                'code' => $request->input('code'),
                'id' => $request->input('id'),
                //'filename' => $originalName,
                // 'url' => $request->file('image')->store('images', 'public'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '이미지 저장 중 오류가 발생했습니다: ' . $e->getMessage()
            ]);
        }


    }
}
