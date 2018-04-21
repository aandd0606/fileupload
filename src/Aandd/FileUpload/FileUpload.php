<?php

namespace Aandd\FileUpload;

use http\Env\Request;

class FileUpload{

    public $type = "book";
    public $path = "public/files";

    public function __construct($type="",$path="")
    {
        if(!empty($type)){
            $this->type = $type;
        }
        if(!empty($path)) {
            $this->path = $path;
        }
    }

    public function testinfo(){
        echo $this->type;
        echo $this->path;
    }

    protected static function fileupload(Request $request,$book_id=""){
        //執行圖檔上傳
        if($request->has('files')) {
            foreach ($request->file("files") as $file) {
                $fileModel = new File();
                $fileModel->fileName=$file->getClientOriginalName();
                $fileModel->fileRealName=$file->hashName();
                $fileModel->fileType=$file->getMimeType();
                $fileModel->fileSize=$file->getClientSize();
                $fileModel->fileCounter=0;
                $fileModel->book_id=$book_id;
                $fileModel->filetable_id=$book_id;
                $fileModel->filetable_type = $this->type;
                $fileModel->save();
                //php artisan storage:link
                //public 資料夾用來儲存可以被公開瀏覽的文件，
                //預設情况下， public 資料夾使用 local 驅動將檔案儲存在storage/app/public ，
                //要讓這些檔案可以通過web瀏覽，需要建立一個軟連結 public/storage 指向 storage/app/public 。
                //可以使用Artisan命令 storage:link建立軟連結
                $file->store($this->path);
            }
        }
    }

    protected static function fileDelete($id){
        $file = File::findOrFail($id);
        Storage::delete("{$this->path}/{$file->fileRealName}");
        File::destroy($id);
        return redirect("{$this->type}/{$file->book_id}/edit");
    }

    public function render(){
        return "產生刪除檔案的表單";
    }

}