<?php 
require_once 'taobao_sdk/TopSdk.php';
error_reporting(E_ALL ^ E_DEPRECATED);
require_once './config.php';

$c = new AliyunClient;
$c->accessKeyId = $config_accessKeyId;
$c->accessKeySecret = $config_accessKeySecret;
$c->serverUrl=$config_serverUrl;//根据不同产品选择相应域名，例如：ECS  http://cdn.aliyuncs.com/

echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CDN刷新</title>
</head>
<body>
  <p><a href="?">Home</a> <a href="?q=domainlist">CDN域名列表</a> <a href="?q=renew">刷新缓存</a></p>
EOT;

$q=isset($_GET['q']) ? $_GET['q'] : '';
//---- domainlist ----------------------------------------
if($q=='domainlist'){
	//域名列表
	$req=new Cdn20141111DescribeUserDomainsRequest();
	$req->setPageSize(50);
	$req->setPageNumber(1);
	try{
		$resp=$c->execute($req);
		//var_dump($resp);
		echo '<h3><strong>'.$resp->TotalCount.'</strong> Domains</h3>';
		echo '<ol>';
		foreach ($resp->Domains->PageData as $key => $value) {
			$buff= '<li><strong>'.$value->DomainName.'</strong> ('.$value->DomainStatus.') ';
			if(isset($_GET['ext'])){
				$buff.= ' [CNAME] '.$value->Cname;
				$buff.= '&nbsp;&nbsp; Created:<i>'.$value->GmtCreated.'</i>';
				$buff.= ' Modified:<i>'.$value->GmtModified.'</i>';
				$buff.= ' Type:<i>'.$value->CdnType.'</i>';
			}
			$buff.='<a href="?q=domaindetail&domain='.$value->DomainName.'">detail</a></li>';
			echo $buff;
		}
		echo '</ol>';
	}catch(Exception $e){
		echo "someting error";
		var_dump($e);
	}
}


//--------------------------------------------
if($q=='renew'){
	//刷新缓存
	$urls_raw=isset($_POST['urls']) ? $_POST['urls'] : '';
	$isDirectory=isset($_POST['isDirectory']) ? (int)$_POST['isDirectory'] : 0;
	$urls=explode("\n",$urls_raw);

	if($urls_raw==''){
		//form
		echo <<<EOT
<form id="form1" name="form1" method="post" action="">
  <p>待刷新的文件url，如 http://cache1.bioon.com/css/test_150213.js ；每行一条 </p>
  <p>
    <textarea name="urls" cols="120" rows="10" id="urls"></textarea>
  </p>
  <p>
    <label><input type="checkbox" name="isDirectory" value="1" /> 目录级刷新**</label></p>
  <p>  
    <input type="submit" name="Submit" value="刷新" />
  </p>
  <p>说明：</p>
  <p>** 对整个目录的刷新，如http://cache1.bioon.com/css/，表示刷新该目录下所有文件，服务商有严格限制，每天限50个目录</p>
  <p>-- 刷新生效需要一定时间，服务商声称刷新后5分钟内生效</p>
</form>
EOT;
	}else{
		$req = new Cdn20141111RefreshObjectCachesRequest();
		if($isDirectory){
			$req->setObjectType("Directory");
		}else{
			$req->setObjectType("File"); // or Directory
		}
		$i=0;
        echo "<ul>";
		foreach ($urls as $key => $url) {
			# code...
			$url=str_replace('http://','',$url);
			if(!$url){
				continue;
			}
			$req->setObjectPath($url);
			try {
				$resp = $c->execute($req);
				//var_dump($resp);
				$i++;
				if(!isset($resp->Code))
				{	
					//刷新成功
					//echo("<li>[$i] $url: done (".$resp->RequestId.")</li>");
					echo("<li>[$i] $url: done <a href='http://$url' target='_blank'>Test</a> </li>");
					//print_r($resp);
				}
				else 
				{
					//刷新失败
					$code = $resp->Code;
					$message = $resp->Message;
					echo("<li>[$i] $url: <span color='red'>Failed</span> (".$code.": ".$message.")</li>");
				}
			}
			catch (Exception $e)
			{
				// TODO: handle exception
				echo "<li>renew <strong>$url</strong> error</li>";
				var_dump($e);
			}
		}
        echo "</ul>";
        echo "  <p>刷新生效需要一定时间，服务商声称刷新后5分钟内生效，可以点Test测试</p>
        <p>如还是旧页面，则可能是浏览器缓存，按Ctrl+F5强制浏览器刷新；如是Squid异常页面，按F5刷新重试。";
	}
}

//--------------------------------------------
if($q=='domaindetail'){
	//域名详情
	$domain=isset($_GET['domain']) ? $_GET['domain'] : '';
	
	$req = new Cdn20141111DescribeCdnDomainDetailRequest();
	$req->setDomainName($domain);
	$resp=$c->execute($req);
	//var_dump($resp);
	if(isset($resp->Code) && $resp->Code ){
		echo "<h2>".$resp->Code."</h2>";
		echo "<h2>".$resp->Message."</h2>";
	}else{
		$detail=$resp->GetDomainDetailModel;
?>
	<ul>
		<li><strong>CDN域名:</strong><?php echo $detail->DomainName;?></li>
		<li><strong>当前状态:</strong><?php echo $detail->DomainStatus;?></li>
		<li><strong>CNAME:</strong><?php echo $detail->Cname;?></li>
		<li><strong>创建时间:</strong><?php echo $detail->GmtCreated;?></li>
		<li><strong>最近修改时间:</strong><?php echo $detail->GmtModified;?></li>
		<li><strong>源类型:</strong><?php echo $detail->SourceType;?></li>
		<li><strong>源:</strong>
			<ol><?php
				foreach($detail->Sources->Source as $key => $source){
				?>
				<li><?php echo $source;?></li>
				<?php 
				} 
			?>
			</ol>
		</li>
	</ul>
<?php
	}
}

