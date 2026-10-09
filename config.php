<?php
declare(strict_types=1);
session_start();

const DB_HOST='localhost'; const DB_NAME='shivam_portfolio'; const DB_USER='root'; const DB_PASS='';
const SITE_URL='http://localhost/shivam-portfolio';
const ADMIN_EMAIL='guptashiavmkumar884@gmail.com';
const UPLOAD_MAX=5242880;
function db():PDO{static $p; if(!$p)$p=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);return $p;}
function e(mixed $v):string{return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function slugify(string $s):string{$s=strtolower(trim($s));$s=preg_replace('/[^a-z0-9]+/','-',$s);return trim($s,'-')?:'item-'.time();}
function csrf():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function check_csrf():void{if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??($_GET['csrf']??''))){http_response_code(419);exit('Invalid request');}}
function admin():bool{return !empty($_SESSION['admin_id']);}
function require_admin():void{if(!admin()){header('Location: login.php');exit;}}
function settings():array{static $s;if($s===null){$s=[];try{$s=db()->query('SELECT setting_key,setting_value FROM settings')->fetchAll();foreach($s as $r)$out[$r['setting_key']]=$r['setting_value'];$s=$out??[];}catch(Throwable $e){}}return $s;}
function setting(string $k,string $d=''):string{$s=settings();return $s[$k]??$d;}
function upload_image(string $field,string $dir):?string{if(empty($_FILES[$field])||$_FILES[$field]['error']===UPLOAD_ERR_NO_FILE)return null;if($_FILES[$field]['error']!==UPLOAD_ERR_OK||$_FILES[$field]['size']>UPLOAD_MAX)throw new RuntimeException('Invalid or oversized upload. Max 5MB.');$finfo=new finfo(FILEINFO_MIME_TYPE);$mime=$finfo->file($_FILES[$field]['tmp_name']);$map=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];if(!isset($map[$mime]))throw new RuntimeException('Only JPG, PNG, WEBP or GIF images are allowed.');$name=bin2hex(random_bytes(12)).'.'.$map[$mime];$root=__DIR__.'/'.$dir;if(!is_dir($root))mkdir($root,0755,true);if(!move_uploaded_file($_FILES[$field]['tmp_name'],$root.'/'.$name))throw new RuntimeException('Upload failed.');return rtrim($dir,'/').'/'.$name;}
function upload_file(string $field,string $dir,array $allowed):?string{if(empty($_FILES[$field])||$_FILES[$field]['error']===UPLOAD_ERR_NO_FILE)return null;if($_FILES[$field]['error']!==UPLOAD_ERR_OK||$_FILES[$field]['size']>UPLOAD_MAX)throw new RuntimeException('Invalid or oversized file.');$finfo=new finfo(FILEINFO_MIME_TYPE);$mime=$finfo->file($_FILES[$field]['tmp_name']);if(!isset($allowed[$mime]))throw new RuntimeException('Unsupported file type.');$name=bin2hex(random_bytes(12)).'.'.$allowed[$mime];$root=__DIR__.'/'.$dir;if(!is_dir($root))mkdir($root,0755,true);if(!move_uploaded_file($_FILES[$field]['tmp_name'],$root.'/'.$name))throw new RuntimeException('Upload failed.');return rtrim($dir,'/').'/'.$name;}
function delete_upload(?string $path):void{if($path&&str_starts_with($path,'uploads/')&&is_file(__DIR__.'/'.$path))@unlink(__DIR__.'/'.$path);}
