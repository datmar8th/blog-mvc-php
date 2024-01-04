<?php
class vendor_aws {

  private $s3;
  private $bucket_name = 'vieclamdanang';
  private $region = 'ap-southeast-1';

  public function __construct() {
    require 'aws/aws-autoloader.php';
    $this->s3 = new Aws\S3\S3Client([
      'region'  => $this->region,
      'version' => 'latest',
      'credentials' => [
        'key' => 'AKIAJ7SXOLC6WPTG7CVA',
        'secret' => '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'
      ]
    ]);
  }
  
  public function create($file_name, $temp_file_location, $folder = null){
    $result = $this->s3->putObject([
      'Bucket' => $this->bucket_name,
      'Key'    => ($folder?$folder.'/'.$file_name:"").$file_name,
      'SourceFile' => $temp_file_location			
    ]);
    return $result->get('ObjectURL');
  }

  public function createWithDate($file_name, $temp_file_location, $folder = null, $isOrigin = null, $randomStr = ""){
    $result = $this->s3->putObject([
      'Bucket' => $this->bucket_name,
      'Key'    => ($folder?$folder.'/':"").date("Y/m/d").'/'.($isOrigin?'origin_':"").str_replace('/','-',date("Y/m/d")).'-'.$randomStr.$file_name,
      'SourceFile' => $temp_file_location			
    ]);
    $full_url = $result->get('ObjectURL');
    if(preg_match('/(\d{0,4}\/\d{0,2}\/\d{0,2})\/(.*)/', $full_url, $matches)){
      return $matches[1].'/'.$matches[2];
    }
    return "";
  }

  public function delete($name, $folder){
    $result = $this->s3->deleteObject([
      'Bucket' => $this->bucket_name,
      'Key'    => $folder.'/'.$name
    ]);

    if($result) return true;
    return false;
  }

  public function getBaseUrl(){
    return 'https://'.$this->bucket_name.'.s3-'.$this->region.'.amazonaws.com/';
  }

  public function createBase64($dataBase64, $folder = null){
    list($type, $imageData) = explode(';', $dataBase64);
    list(,$extension) = explode('/',$type);
    list(,$imageData)      = explode(',', $imageData);
    $fileName = uniqid().'.'.$extension;
    $link = self::createWithDate($fileName, $dataBase64, $folder);
    return $link;
  }

  public function createBase64ResizeImage($dataBase64, $folder = null, $width = 200){

    list($type, $imageData) = explode(';', $dataBase64);
    list(,$extension) = explode('/',$type);
    list(,$imageData)      = explode(',', $imageData);

    $fileName = uniqid().'.'.$extension;
    $ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
    $nameDate = date("Y-m-d");
    $fullUrl = $ulfd.$nameDate.'-'.$fileName;
    if (!file_exists($ulfd))
    mkdir($ulfd, 0777, true);  //create directory if not exist

    $imageData = base64_decode($imageData);
    file_put_contents($fullUrl, $imageData);
    $companyData['image'] = date("Y/m/d").'/'.$nameDate.'-'.$fileName;

    $simpleImg = new vendor_simpleImage_component($fullUrl);
    copy($fullUrl,$ulfd.'origin_'.$nameDate.'-'.$fileName);
    $newW = $width;
    $simpleImg->resizeToWidth($newW);
    $simpleImg->saveResize($fullUrl);
    $randomStr = time().rand(10000,99999);
    $link = self::createWithDate($fileName, $fullUrl, $folder, false, $randomStr);
    $linkOrigin = self::createWithDate($fileName, $ulfd.'origin_'.$nameDate.'-'.$fileName, $folder, true, $randomStr);
    unlink($fullUrl);
    unlink($ulfd.'origin_'.$nameDate.'-'.$fileName);

    return $link;
  }

  public function createResizeImage($file_name, $temp_file_location, $folder = null, $width = 200){
      if (!file_exists(RootURI.UploadREL .$folder)) {
        mkdir(RootURI.UploadREL .$folder, 0777, true);
      }
		    
			$ulfd = RootURI.UploadREL .$folder.'/'.date("Y/m/d").'/';
			if (!file_exists($ulfd)) {
				mkdir($ulfd, 0777, true);
			}
			$newfn = date("Y-m-d").'-'.time().rand(10000,99999).'.'.$file_name;

			$newSize = (isset($options['newSize']))? $options['newSize']: [];
      if (!file_exists($ulfd . $newfn)) {
        move_uploaded_file($temp_file_location, $ulfd.$newfn);
        $simpleImg = new vendor_simpleImage_component($ulfd.$newfn);
        copy($ulfd.$newfn,$ulfd."origin_".$newfn);

        if(isset($newSize['height']) && !isset($newSize['width'])) {
          $simpleImg->resizeToHeight($newSize['height']);
        } else {
          $newW = $width ? $width : DefaultImgW;
          if(isset($newSize['width'])) {
            $newW = $newSize['width'];
          }
          $simpleImg->resizeToWidth($newW);
        }
        $simpleImg->saveResize($ulfd.$newfn);
      }
      $randomStr = time().rand(10000,99999);
      $link = self::createWithDate($file_name, $ulfd.$newfn, $folder, false, $randomStr);
      $linkOrigin = self::createWithDate($file_name, $ulfd.'origin_'.$newfn, $folder, true, $randomStr);
      unlink($ulfd.$newfn);
      unlink($ulfd."origin_".$newfn);
      return $link;
  }
}
?>