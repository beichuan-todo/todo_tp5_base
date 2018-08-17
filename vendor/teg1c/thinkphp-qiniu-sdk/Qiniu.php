<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/25
 * Time: 17:14
 */

namespace gmars\qiniu;


use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Cache;
use think\Config;
use think\Exception;

require 'qiniu_driver/autoload.php';

class Qiniu
{
    private $_accessKey;
    private $_secretKey;
    private $_bucket;

    private $_error;

    /**
     * Qiniu constructor.
     * @param string $accessKey
     * @param string $secretKey
     * @param string $bucketName
     * 初始化参数可以直接配置到tp的配置中
     */
    public function __construct($accessKey = "", $secretKey = "", $bucketName = "")
    {
        if (empty($accessKey) || empty($secretKey) || empty($bucketName)) {
            $qiniuConfig = Config::get('qiniu');
            if (empty($qiniuConfig['accesskey']) || empty($qiniuConfig['secretkey'])) {
                $this->_error = '你的配置信息不完整！';
                return false;
            }
            $this->_accessKey = $qiniuConfig['accesskey'];
            $this->_secretKey = $qiniuConfig['secretkey'];
        }else{
            $this->_accessKey = $accessKey;
            $this->_secretKey = $secretKey;
        }

        if (!empty($bucketName)) {
            $this->_bucket = $bucketName;
        }
    }

    /**
     * @return bool|string
     * 获取bucket
     */
    private function _getBucket()
    {
        if (!empty($this->_bucket)) {
            return $this->_bucket;
        }
        $bucket = Config::get('qiniu.bucket');
        if (empty($bucket)) {
            return false;
        }
        return $bucket;
    }

    /**
     * @param string $saveName
     * @param string $bucket
     * @return mixed
     * @throws Exception
     * @throws \Exception
     * 单文件上传，如果添加多个文件则只上传第一个
     */
    public function upload($saveName = '', $bucket = '')
    {
        $token = $this->_getUploadToken($bucket);

        $files = $_FILES;
        if (empty($files)) {
            throw new Exception('没有文件被上传', 10002);
        }
        $values = array_values($files);

        $uploadManager = new UploadManager();
        if (empty($saveName)) {
            $saveName = hash_file('sha1', $values[0]['tmp_name']).time();
        }
        $infoArr = explode('.', $values[0]['name']);
        $extension = array_pop($infoArr);
        $fileInfo = $saveName . '.' . $extension;
        list($ret, $err) = $uploadManager->putFile($token, $saveName, $values[0]['tmp_name']);
        if ($err !== null) {
            throw new Exception('上传出错'.serialize($err));
        }
        return $ret['key'];
    }

    /**
     * @param string $str base64编码,只要逗号后面的
     * @param string $bucket 七牛云存储空间
     * @return mixed
     */

    public function baseUplod($str, $bucket = '')
    {
        $token = $this->_getUploadToken($bucket);
        $ret = $this->request_by_curl('http://up-z2.qiniu.com/putb64/-1', $str, $token);
        $ret = json_decode($ret, true);
        if ($ret) {
            return $ret['key'];
        } else {
            return false;
        }
    }
    private function request_by_curl($remote_server, $post_string, $upToken)
    {

        $headers = array();
        $headers[] = 'Content-Type:image/png';
        $headers[] = 'Authorization:UpToken ' . $upToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }


    /**
     * @param $bucketName
     * @return mixed|string
     * @throws Exception
     * 只有设置到配置的bucket才会使用缓存功能
     */
    private function _getUploadToken($bucketName)
    {
//        $upToken = Cache::get('qiniu_upload_token');
//        if (!empty($upToken) && empty($bucketName)) {
//            return $upToken;
//        }else{
//            $auth = new Auth($this->_accessKey, $this->_secretKey);
//            $bucket = empty($bucketName)? $this->_getBucket():$bucketName;
//            if ($bucket === false) {
//                throw new Exception('你还没有设置或者传入bucket', 100001);
//            }
//            $upToken = $auth->uploadToken($bucket);
//            Cache::set('qiniu_upload_token', $upToken);
//            return $upToken;
//        }
        $auth = new Auth($this->_accessKey, $this->_secretKey);
        $bucket = empty($bucketName)? $this->_getBucket():$bucketName;
        if ($bucket === false) {
            throw new Exception('你还没有设置或者传入bucket', 100001);
        }
        $upToken = $auth->uploadToken($bucket);
        Cache::set('qiniu_upload_token', $upToken);
        return $upToken;
    }


}